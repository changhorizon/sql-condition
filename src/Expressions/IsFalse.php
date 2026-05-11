<?php

declare(strict_types=1);

namespace ChangHorizon\SqlCondition\Expressions;

use ChangHorizon\SqlCondition\Enums\Operator;

class IsFalse extends IsNull
{
    public const Operator OP = Operator::IS_FALSE;
}
