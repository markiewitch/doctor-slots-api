<?php
declare(strict_types=1);

namespace App\ValueObject;

use App\Domain\Model\Slot;

final class SlotsCollection
{
    /** @var Slot[] */
    private array $slots;

    public function addSlot(Slot $slot): void
    {
        $this->slots[] = $slot;
    }

    public function getSlots(): array
    {
        return $this->slots;
    }
}
