<?php
declare(strict_types=1);

namespace App\Domain\Ports;

use App\Domain\Model\Doctor;
use Symfony\Component\Uid\Ulid;

interface DoctorRepository
{
    public function findByExternalId(int $externalId): ?Doctor;

    public function findById(Ulid $id): ?Doctor;

    public function save(Doctor $doctor): void;
}
