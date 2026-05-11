<?php

declare(strict_types=1);

namespace ChangHorizon\SqlCondition\Expressions;

use ChangHorizon\SqlCondition\Enums\Logic;
use ChangHorizon\SqlCondition\Enums\Operator;
use ChangHorizon\SqlCondition\Interfaces\ExpressionInterface;
use Override;

class IsNull implements ExpressionInterface
{
    public const Operator OP = Operator::IS_NULL;

    private string $field;

    /**
     */
    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     */
    #[Override]
    public function getString(): string
    {
        return sprintf('%s %s', $this->field, static::OP->value);
    }

    /**
     * @return string[]
     */
    #[Override]
    public function getParams(): array
    {
        return [];
    }

    #[Override]
    public function getLogic(): ?Logic
    {
        return null;
    }
}
