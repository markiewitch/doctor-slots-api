<?php
declare(strict_types=1);

namespace App\Adapters\SlotSupplier;

use Webmozart\Assert\Assert;

class ExternalSlot
{
    public function __construct(public \DateTimeImmutable $from, public \DateTimeImmutable $to)
    {
        Assert::true($from < $to);
    }
}
