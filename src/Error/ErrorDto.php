<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\AppUtil\Error;

use CarlosChininin\AppUtil\Message\MessageDto;
use CarlosChininin\AppUtil\Message\MessageType;

class ErrorDto extends MessageDto
{
    public function __construct(
        protected readonly string $message,
        protected readonly int $code = 0,
        protected readonly MessageType $type = MessageType::ERROR,
        protected readonly ?string $detail = null
    ) {
        parent::__construct($message, $type);
    }
    public function code(): int
    {
        return $this->code;
    }

    public function detail(): ?string
    {
        return $this->detail;
    }
}
