<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\AppUtil\Pagination;

use CarlosChininin\AppUtil\Dto\AbstractDto;
use CarlosChininin\AppUtil\Validation\Assert;
use Symfony\Component\HttpFoundation\Request;

class PaginationDto extends AbstractDto
{
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_LIMIT = 10;

    public const PAGE_NAME = 'page';
    public const LIMIT_NAME = 'limit';

    private int $page;
    private int $limit;

    private function __construct(int $page, int $limit)
    {
        Assert::greaterThanEq($page, 0);
        Assert::greaterThanEq($limit, 0);

        $this->page = $page;
        $this->limit = $limit;
    }

    public static function create(?int $page = null, ?int $limit = null): self
    {
        return new self($page ?? static::DEFAULT_PAGE, $limit ?? static::DEFAULT_LIMIT);
    }

    public static function fromRequest(Request $request): self
    {
        $page = $request->get(static::PAGE_NAME, static::DEFAULT_PAGE);
        Assert::integerish($page);

        $limit = $request->get(static::LIMIT_NAME, static::DEFAULT_LIMIT);
        Assert::integerish($limit);

        return new self((int) $page, (int) $limit);
    }

    public function limit(): int
    {
        return $this->limit > 0 ? $this->limit : static::DEFAULT_LIMIT;
    }

    public function page(): int
    {
        return $this->page > 0 ? $this->page : static::DEFAULT_PAGE;
    }
}
