<?php

declare(strict_types=1);

namespace CarlosChininin\AppUtil\Test\Pagination;

use CarlosChininin\AppUtil\Pagination\PaginatedData;
use CarlosChininin\AppUtil\Pagination\PaginationDto;
use CarlosChininin\AppUtil\Pagination\PaginationInterface;

class InMemoryPagination implements PaginationInterface
{
    public function paginate(mixed $data, PaginationDto $pagination): PaginatedData
    {
        $currentPage = max(1, $pagination->page());
        $firstResult = ($currentPage - 1) * $pagination->limit();
        $lastResult = $firstResult + $pagination->limit();

        $paginated = [];
        $index = 0;
        $count = 0;
        foreach ($data as $item) {
            if ($index >= $firstResult && $index < $lastResult) {
                $paginated[] = $item;
                ++$count;
            }
            ++$index;
        }

        return PaginatedData::create($paginated, $count, $pagination);
    }
}
