<?php

declare(strict_types=1);

namespace Hizpark\SqlCondition\Expressions;

use Hizpark\SqlCondition\Enums\Operator;

class IsNotNull extends IsNull
{
    public const Operator OP = Operator::IS_NOT_NULL;
}
