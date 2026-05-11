<?php

declare(strict_types=1);

namespace ChangHorizon\SqlCondition\Expressions;

use ChangHorizon\SqlCondition\Enums\Operator;

class NotIn extends In
{
    public const Operator OP = Operator::NOT_IN;
}
