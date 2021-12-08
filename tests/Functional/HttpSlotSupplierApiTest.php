<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Adapters\SlotSupplier\HttpSlotSupplierApi;
use App\Exception\SlotSupplierException;
use Demyan112rv\MountebankPHP\Imposter;
use Demyan112rv\MountebankPHP\Mountebank;
use Demyan112rv\MountebankPHP\Response;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HttpSlotSupplierApiTest extends KernelTestCase
{
    private Mountebank $mountebank;

    public function testErrorPropagation(): void
    {
        $this->mountebank->addImposter(
            (new Imposter())
                ->setName('slot_supplier')
                ->setPort(10001)
                ->setProtocol(Imposter::PROTOCOL_HTTP)
                ->setDefaultResponse(
                    (new Response(Response::TYPE_IS))
                        ->setConfig([
                            'statusCode' => 404,
                            'body' => '404',
                            'headers' => ['Content-Type' => 'text/plain']]))
        );

        static::createKernel();
        $client = self::getContainer()->get(HttpSlotSupplierApi::class);
        $this->expectException(SlotSupplierException::class);
        var_dump(iterator_to_array($client->getDoctors()));
    }

    protected function setUp(): void
    {
        $this->mountebank = new Mountebank(new Client());
        $this->mountebank->setHost("mountebank")->setPort(2525);
    }

    protected function tearDown(): void
    {
        $this->mountebank->removeImposters();
        parent::tearDown();
    }
}
