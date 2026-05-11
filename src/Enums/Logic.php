<?php

declare(strict_types=1);

namespace ChangHorizon\SqlCondition\Enums;

enum Logic: string
{
    case AND = 'AND';
    case OR  = 'OR';
}
