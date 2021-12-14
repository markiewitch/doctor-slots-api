<?php

declare(strict_types=1);

namespace App\SlotSorting;

use Doctrine\ORM\QueryBuilder;

final class DateAscendingSorter implements SlotsSorter
{

    public function apply(QueryBuilder $query): QueryBuilder
    {
        return $query->addOrderBy("s.dateFrom", "ASC");
    }

    public static function getName(): string
    {
        return 'date_asc';
    }
}
