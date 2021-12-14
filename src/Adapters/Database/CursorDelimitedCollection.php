<?php

declare(strict_types=1);

namespace App\Adapters\Database;

class CursorDelimitedCollection
{
    public function __construct(public array $items, public string $nextCursor)
    {
    }
}
