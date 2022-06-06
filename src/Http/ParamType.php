<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace CarlosChininin\AppUtil\Http;

enum ParamType: string
{
    case STRING = 'string';
    case INT = 'int';
    case DATE = 'date';
    case FLOAT = 'float';
    case BOOL = 'bool';
    case ARRAY = 'array';
    case OBJECT = 'object';
}
