<?php

declare(strict_types=1);

namespace CarlosChininin\AppUtil\Message;

enum MessageType: string
{
    case INFO = 'info';
    case SUCCESS = 'success';
    case WARNING = 'warning';
    case ERROR = 'danger';
}
