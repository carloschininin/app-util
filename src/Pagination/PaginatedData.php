<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\AppUtil\Pagination;

class PaginatedData
{
    private function __construct(
        private readonly array $results,
        private readonly int $count,
        private readonly PaginationDto $pagination
    ) {
    }

    public static function create(array $results, int $count, PaginationDto $pagination): static
    {
        return new static($results, $count, $pagination);
    }

    public function results(): array
    {
        return $this->results;
    }

    public function count(): int
    {
        return $this->count;
    }

    public function numResults(): int
    {
        return \count($this->results());
    }

    public function pagination(): PaginationDto
    {
        return $this->pagination;
    }

    public function currentPage(): int
    {
        return $this->pagination->page();
    }

    public function lastPage(): int
    {
        return (int) ceil($this->count() / $this->pageSize());
    }

    public function pageSize(): int
    {
        return $this->pagination->limit();
    }

    public function hasPreviousPage(): bool
    {
        return $this->currentPage() > 1;
    }

    public function previousPage(): int
    {
        return max(1, $this->currentPage() - 1);
    }

    public function hasNextPage(): bool
    {
        return $this->currentPage() < $this->lastPage();
    }

    public function nextPage(): int
    {
        return min($this->lastPage(), $this->currentPage() + 1);
    }

    public function hasToPaginate(): bool
    {
        return $this->count() > $this->pageSize();
    }

    public function index(int $index): int
    {
        return ($this->currentPage() - 1) * $this->pageSize() + $index;
    }

    public function startIndex(): int
    {
        return ($this->currentPage() - 1) * $this->pageSize() + 1;
    }

    public function endIndex(): int
    {
        return ($this->startIndex() - 1) + $this->numResults();
    }
}
