<?php
declare(strict_types=1);

namespace App\Adapters\Database;

use App\Domain\Model\Doctor;
use App\Domain\Ports\DoctorRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Uid\Ulid;

class DoctrineDoctorRepository extends ServiceEntityRepository implements DoctorRepository
{
    public function findByExternalId(int $externalId): ?Doctor
    {
        return $this->findOneBy(['externalId' => $externalId]);
    }

    public function findById(Ulid $id): ?Doctor
    {
        return $this->find($id);
    }

    public function save(Doctor $doctor): void
    {
        $this->getEntityManager()->persist($doctor);
        $this->getEntityManager()->flush();
    }
}
