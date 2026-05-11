<?php

declare(strict_types=1);

namespace Hizpark\SqlCondition\Expressions;

use Hizpark\SqlCondition\Enums\Operator;

class LessThanOrEqual extends Equal
{
    public const Operator OP = Operator::LTE;
}
