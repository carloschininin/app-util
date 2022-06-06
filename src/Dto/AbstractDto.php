<?php

declare(strict_types=1);

namespace CarlosChininin\AppUtil\Dto;

abstract class AbstractDto implements \JsonSerializable
{
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
