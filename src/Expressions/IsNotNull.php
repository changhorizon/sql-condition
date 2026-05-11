<?php

declare(strict_types=1);

namespace ChangHorizon\SqlCondition\Expressions;

use ChangHorizon\SqlCondition\Enums\Operator;

class IsNotNull extends IsNull
{
    public const Operator OP = Operator::IS_NOT_NULL;
}
