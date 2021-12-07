<?php
declare(strict_types=1);

namespace App\Action;

class SynchronizeSlots
{
    private function __construct(private int $externalId)
    {
    }

    public static function forDoctor(int $externalId)
    {
        return new self($externalId);
    }

    public function getDoctorExternalId(): int
    {
        return $this->externalId;
    }
}
