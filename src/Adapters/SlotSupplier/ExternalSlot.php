<?php
declare(strict_types=1);

namespace App\Adapters\SlotSupplier;

class ExternalSlot
{
    public function __construct(public \DateTimeImmutable $from, public \DateTimeImmutable $to)
    {
    }
}
