<?php
declare(strict_types=1);

namespace App\SlotSorting;

use Doctrine\ORM\QueryBuilder;

interface SlotsSorter
{
    public function apply(QueryBuilder $query): QueryBuilder;

    public static function getName(): string;
}
