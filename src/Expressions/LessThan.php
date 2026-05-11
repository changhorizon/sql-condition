<?php

declare(strict_types=1);

namespace ChangHorizon\SqlCondition\Expressions;

use ChangHorizon\SqlCondition\Enums\Operator;

class LessThan extends Equal
{
    public const Operator OP = Operator::LT;
}
