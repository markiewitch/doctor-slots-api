<?php
declare(strict_types=1);

namespace App\SlotSorting;

use Doctrine\ORM\QueryBuilder;

final class DurationDescendingSorter implements SlotsSorter
{

    public function apply(QueryBuilder $query): QueryBuilder
    {
        return $query->addOrderBy("s.duration", "DESC");
    }

    public static function getName(): string
    {
        return 'duration_desc';
    }
}
