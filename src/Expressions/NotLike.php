<?php

declare(strict_types=1);

namespace Hizpark\SqlCondition\Expressions;

use Hizpark\SqlCondition\Enums\Operator;

class NotLike extends Like
{
    public const Operator OP = Operator::NOT_LIKE;
}
