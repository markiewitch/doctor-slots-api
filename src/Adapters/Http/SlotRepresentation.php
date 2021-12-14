<?php

declare(strict_types=1);

namespace App\Adapters\Http;

use App\Domain\Model\Doctor;
use App\Domain\Model\Slot;

class SlotRepresentation implements \JsonSerializable
{
    private function __construct(private string $id, private int $duration, private string $starts_at, private Doctor $doctor)
    {
    }

    public static function of(Slot $slot)
    {
        return new self($slot->getId()->toBase32(), $slot->getDuration(), $slot->getStartDate()->format(DATE_ATOM), $slot->getDoctor());
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'duration' => $this->duration,
            'starts_at' => $this->starts_at,
            'doctor' => [
                'name' => $this->doctor->getName(),
                'id' => $this->doctor->getId(),
            ],
        ];
    }
}
