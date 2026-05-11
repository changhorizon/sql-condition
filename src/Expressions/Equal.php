<?php

declare(strict_types=1);

namespace Hizpark\SqlCondition\Expressions;

use Hizpark\SqlCondition\Enums\Logic;
use Hizpark\SqlCondition\Enums\Operator;
use Hizpark\SqlCondition\Interfaces\ExpressionInterface;
use Override;

class Equal implements ExpressionInterface
{
    public const Operator OP = Operator::EQ;

    private string $field;

    private string $value;

    /**
     */
    public function __construct(string $field, string $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     */
    #[Override]
    public function getString(): string
    {
        $placeholder = $this->getPlaceholder();

        return sprintf('%s %s %s', $this->field, static::OP->value, $placeholder);
    }

    /**
     * @return string[]
     */
    #[Override]
    public function getParams(): array
    {
        $placeholder = $this->getPlaceholder();

        return [$placeholder => $this->value];
    }

    /**
     */
    private function getPlaceholder(): string
    {
        return sprintf(':value_%s', $this->field);
    }

    #[Override]
    public function getLogic(): ?Logic
    {
        return null;
    }
}
