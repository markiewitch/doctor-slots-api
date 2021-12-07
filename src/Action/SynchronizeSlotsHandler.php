<?php
declare(strict_types=1);

namespace App\Action;

use App\Domain\Model\Doctor;
use App\Domain\Model\Slot;
use App\Domain\Ports\DoctorRepository;
use App\Domain\Ports\SlotRepository;
use App\Domain\Ports\SlotSupplierApi;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SynchronizeSlotsHandler implements MessageHandlerInterface
{
    public function __construct(private SlotSupplierApi $api, private DoctorRepository $doctors, private SlotRepository $slots, private LoggerInterface $logger)
    {
    }

    public function __invoke(SynchronizeSlots $command)
    {
        $doctor = $this->doctors->findByExternalId($command->getDoctorExternalId());

        if (!$doctor instanceof Doctor) {
            $this->logger->warning("Could not synchronize slots for unknown doctor", ['externalId' => $command->getDoctorExternalId()]);
            return;
        }

        foreach ($this->api->getSlots($command->getDoctorExternalId()) as $slot) {
            $internal = $this->slots->findOneBy(['doctor' => $doctor, 'dateFrom' => $slot->from, 'dateTo' => $slot->to]);
            if (!$internal instanceof Slot) {
                $this->slots->save(new Slot($doctor, $slot->from, $slot->to));
            }
        }
    }
}
