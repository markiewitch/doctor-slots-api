<?php

declare(strict_types=1);

namespace App\Domain\Ports;

use App\Adapters\SlotSupplier\ExternalDoctor;
use App\Adapters\SlotSupplier\ExternalSlot;
use App\Exception\SlotSupplierException;

interface SlotSupplierApi
{
    /**
     * @return iterable|ExternalDoctor[]
     * @throws SlotSupplierException
     */
    public function getDoctors(): iterable;

    /**
     * @return iterable|ExternalSlot[]
     * @throws SlotSupplierException
     */
    public function getSlots(int $externalDoctorId): iterable;
}
