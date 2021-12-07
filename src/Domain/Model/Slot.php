<?php

declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity]
#[ORM\UniqueConstraint(columns: ['doctor_id', 'date_from', 'date_to'])]
class Slot
{
    #[ORM\Id]
    #[ORM\Column(type: 'ulid')]
    private Ulid $id;

    #[ORM\Column(type: 'datetime_immutable', nullable: false)]
    private \DateTimeImmutable $dateFrom;

    #[ORM\Column(type: 'datetime_immutable', nullable: false)]
    private \DateTimeImmutable $dateTo;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $duration;

    #[ORM\ManyToOne(targetEntity: Doctor::class)]
    #[ORM\JoinColumn(name: "doctor_id", referencedColumnName: "id", nullable: false)]
    private Doctor $doctor;

    public function __construct(Doctor $doctor, \DateTimeImmutable $from, \DateTimeImmutable $to)
    {
        $this->id = new Ulid();
        $this->dateFrom = $from;
        $this->dateTo = $to;
        $this->duration = (int)$to->diff($from, true)->format("%i");
        $this->doctor = $doctor;
    }

    public function getId(): Ulid
    {
        return $this->id;
    }
}
