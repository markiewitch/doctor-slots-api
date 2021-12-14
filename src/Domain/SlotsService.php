<?php
declare(strict_types=1);

namespace App\Domain;

interface SlotsService
{
    public function queryBy(string $cursor, string $orderBy, \DateTimeImmutable $from, \DateTimeImmutable $to): iterable;
}
