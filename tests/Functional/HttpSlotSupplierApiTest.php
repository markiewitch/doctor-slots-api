<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Adapters\SlotSupplier\ExternalDoctor;
use App\Adapters\SlotSupplier\HttpSlotSupplierApi;
use App\Exception\SlotSupplierException;
use Demyan112rv\MountebankPHP\Imposter;
use Demyan112rv\MountebankPHP\Mountebank;
use Demyan112rv\MountebankPHP\Predicate;
use Demyan112rv\MountebankPHP\Response;
use Demyan112rv\MountebankPHP\Stub;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HttpSlotSupplierApiTest extends KernelTestCase
{
    private Mountebank $mountebank;
    private Imposter $imposter;
    private HttpSlotSupplierApi $supplierApi;

    public function testErrorPropagation(): void
    {
        $this->expectException(SlotSupplierException::class);
        $doctors = $this->supplierApi->getDoctors();
        var_dump(iterator_to_array($doctors)); // todo interesting, as if PHP was not calling toArray until an item is processed in foreach
    }

    public function testDoctorDeserialization()
    {
        $this->mockDoctorsResponse([['id' => 1, 'name' => 'Derick Rethans']]);

        $doctors = iterator_to_array(self::getContainer()->get(HttpSlotSupplierApi::class)
            ->getDoctors());

        $this->assertCount(1, $doctors);
        $this->assertContainsOnly(ExternalDoctor::class, $doctors);
        $this->assertEquals("Derick Rethans", $doctors[0]->name);
    }

    private function mockDoctorsResponse(array $doctors)
    {
        $this->imposter->setStubs([
            (new Stub())
                ->addPredicate(
                    (new Predicate(Predicate::OPERATOR_EQUALS))
                        ->setConfig(['path' => '/api/doctors', 'method' => 'GET']))
                ->addResponse(
                    (new Response(Response::TYPE_IS))
                        ->setConfig([
                            'statusCode' => 200,
                            'body' => json_encode($doctors),
                            'headers' => ['Content-Type' => 'application/json']]))
        ]);
        $this->mountebank->removeImposters();
        $this->mountebank->addImposter($this->imposter);
    }

    protected function setUp(): void
    {
        static::createKernel();
        $this->supplierApi = self::getContainer()->get(HttpSlotSupplierApi::class);

        $this->mountebank = new Mountebank(new Client());
        $this->mountebank->setHost("mountebank")->setPort(2525);
        $this->mountebank->removeImposters();
        $this->imposter = (new Imposter())
            ->setName('slot_supplier')
            ->setPort(10001)
            ->setProtocol(Imposter::PROTOCOL_HTTP)
            ->setDefaultResponse(
                (new Response(Response::TYPE_IS))
                    ->setConfig([
                        'statusCode' => 404,
                        'body' => '404',
                        'headers' => ['Content-Type' => 'text/plain']]));
        $this->mountebank->addImposter($this->imposter);
    }

    protected function tearDown(): void
    {
        $this->mountebank->removeImposters();
        parent::tearDown();
    }
}
