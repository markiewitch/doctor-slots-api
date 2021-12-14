<?php
declare(strict_types=1);

namespace App\Adapters\SlotSupplier;

class ExternalDoctor
{
    public function __construct(public int $id, public string $name)
    {
    }
}
