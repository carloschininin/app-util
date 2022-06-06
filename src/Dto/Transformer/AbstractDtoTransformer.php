<?php

declare(strict_types=1);

namespace CarlosChininin\AppUtil\Dto\Transformer;

abstract class AbstractDtoTransformer implements DtoTransformerInterface
{
    public function transformFromObjects(iterable $objects): iterable
    {
        $dto = [];

        foreach ($objects as $object) {
            $dto[] = $this->transformFromObject($object);
        }

        return $dto;
    }
}
