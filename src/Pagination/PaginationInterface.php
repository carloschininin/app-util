<?php

declare(strict_types=1);

namespace CarlosChininin\AppUtil\Pagination;

interface PaginationInterface
{
    public function paginate(mixed $data, PaginationDto $pagination): PaginatedData;
}
