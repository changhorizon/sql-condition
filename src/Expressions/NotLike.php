<?php

declare(strict_types=1);

namespace ChangHorizon\SqlCondition\Expressions;

use ChangHorizon\SqlCondition\Enums\Operator;

class NotLike extends Like
{
    public const Operator OP = Operator::NOT_LIKE;
}
