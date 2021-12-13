<?php

declare(strict_types=1);

namespace App\Domain\Ports;

use App\Adapters\Database\CursorDelimitedCollection;
use App\Domain\Model\Doctor;
use App\Domain\Model\Slot;

interface SlotRepository
{
    public function save(Slot $slot): void;

    public function findByDoctorTimeslot(Doctor $doctor, \DateTimeImmutable $from, \DateTimeImmutable $to): ?Slot;

    public function queryBy(?string $cursor = null, string $orderBy = null, ?\DateTimeImmutable $from = null, ?\DateTimeImmutable $to = null, int $limit): CursorDelimitedCollection;
}
