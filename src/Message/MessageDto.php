<?php

declare(strict_types=1);

namespace CarlosChininin\AppUtil\Message;

class MessageDto
{
    public function __construct(
        protected readonly string $message,
        protected readonly MessageType $type = MessageType::SUCCESS
    ) {
    }

    public function message(): string
    {
        return $this->message;
    }

    public function type(): MessageType
    {
        return $this->type;
    }
}
