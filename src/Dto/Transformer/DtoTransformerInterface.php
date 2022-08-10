<?php

declare(strict_types=1);

namespace CarlosChininin\AppUtil\Dto\Transformer;

interface DtoTransformerInterface
{
    public function transformFromObject(mixed $object): mixed;
    public function transformFromObjects(iterable|null $objects): iterable;
}
