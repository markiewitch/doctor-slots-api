<?php

declare(strict_types=1);

namespace App\Adapters\Database;

use App\Domain\Model\Doctor;
use App\Domain\Model\Slot;
use App\Domain\Ports\SlotRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class DoctrineSlotRepository extends ServiceEntityRepository implements SlotRepository
{
    public function save(Slot $slot): void
    {
        $this->getEntityManager()->persist($slot);
        $this->getEntityManager()->flush();
    }

    public function findByDoctorTimeslot(Doctor $doctor, \DateTimeImmutable $from, \DateTimeImmutable $to): ?Slot
    {
        return $this->findOneBy(['doctor' => $doctor, 'dateFrom' => $from, 'dateTo' => $to]);
    }

    public function queryBy(?string $cursor = null, ?string $orderBy = null, ?\DateTimeImmutable $from = null, ?\DateTimeImmutable $to = null): iterable
    {
        return [];
    }
}
