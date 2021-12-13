<?php
declare(strict_types=1);

namespace App\ValueObject;

final class ListSlotsRequest
{
    private string $sortType;
    private ?\DateTimeImmutable $dateFrom;
    private ?\DateTimeImmutable $dateTo;
    private int $limit;
    private ?string $cursor;

    public function __construct(string $sortType, ?\DateTimeImmutable $dateFrom = null, ?\DateTimeImmutable $dateTo = null, int $limit = 15, ?string $cursor = null)
    {
        $this->sortType = $sortType;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->limit = min(50, $limit);
        //todo decrypt cursor and deserialize ulids
        $this->cursor = $cursor;
    }

    public function getSortType(): string
    {
        return $this->sortType;
    }

    public function getDateFrom(): ?\DateTimeImmutable
    {
        return $this->dateFrom;
    }

    public function getDateTo(): ?\DateTimeImmutable
    {
        return $this->dateTo;
    }

    public function getLimit(): mixed
    {
        return $this->limit;
    }

    public function getCursor(): ?string
    {
        return $this->cursor;
    }
}
