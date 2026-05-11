<?php

declare(strict_types=1);

namespace Hizpark\SqlCondition\Expressions;

use Hizpark\SqlCondition\Enums\Logic;
use Hizpark\SqlCondition\Enums\Operator;
use Hizpark\SqlCondition\Interfaces\ExpressionInterface;
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
