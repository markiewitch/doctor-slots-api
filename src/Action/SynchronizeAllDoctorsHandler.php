<?php
declare(strict_types=1);

namespace App\Action;

use App\Domain\Model\Doctor;
use App\Domain\Ports\DoctorRepository;
use App\Domain\Ports\SlotSupplierApi;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SynchronizeAllDoctorsHandler implements MessageHandlerInterface
{
    public function __construct(private SlotSupplierApi $api, private DoctorRepository $doctors, private MessageBusInterface $bus, private LoggerInterface $logger)
    {
    }

    public function __invoke(SynchronizeAllDoctors $command)
    {
        foreach ($this->api->getDoctors() as $doctor) {
            if (!$this->doctors->findByExternalId($doctor->id) instanceof Doctor) {
                $this->logger->notice("Imported new doctor", ['doctor' => $doctor]);
                $this->doctors->save(new Doctor(externalId: $doctor->id, name: $doctor->name));
            }

            $this->bus->dispatch(SynchronizeSlots::forDoctor($doctor->id));
        }
    }
}
