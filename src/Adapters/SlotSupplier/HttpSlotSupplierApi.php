<?php
declare(strict_types=1);

namespace App\Adapters\SlotSupplier;

use App\Domain\Ports\SlotSupplierApi;
use App\Exception\SlotSupplierException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpSlotSupplierApi implements SlotSupplierApi
{

    public function __construct(private HttpClientInterface $slotsClient)
    {
    }

    public function getDoctors(): iterable
    {
        try {
            $doctors = $this->slotsClient->request('GET', '/api/doctors')->toArray();
            foreach ($doctors as $doctor) {
                yield new ExternalDoctor($doctor['id'], $doctor['name']);
            }
        } catch (TransportExceptionInterface|ClientExceptionInterface $e) {
            throw new SlotSupplierException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getSlots(int $externalDoctorId): iterable
    {
        try {
            $slots = $this->slotsClient->request('GET', "/api/doctors/$externalDoctorId/slots");
            if ($slots->getStatusCode() !== 200) {
                return [];
            }
            foreach ($slots->toArray() as $slot) {
                yield new ExternalSlot(new \DateTimeImmutable($slot['start']), new \DateTimeImmutable($slot['end']));
            }
        } catch (TransportExceptionInterface|ClientExceptionInterface $e) {
            throw new SlotSupplierException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
