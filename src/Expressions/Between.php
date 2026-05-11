<?php

declare(strict_types=1);

namespace Hizpark\SqlCondition\Expressions;

use Hizpark\SqlCondition\Enums\Logic;
use Hizpark\SqlCondition\Enums\Operator;
use Hizpark\SqlCondition\Interfaces\ExpressionInterface;
use Override;

class Between implements ExpressionInterface
{
    public const Operator OP = Operator::BETWEEN;

    private string $field;

    private string $startValue;

    private string $endValue;

    /**
     */
    public function __construct(string $field, string $startValue, string $endValue)
    {
        $this->field      = $field;
        $this->startValue = $startValue;
        $this->endValue   = $endValue;
    }

    /**
     */
    #[Override]
    public function getString(): string
    {
        $placeholderOfStart = $this->getPlaceholderOfStart();
        $placeholderOfEnd   = $this->getPlaceholderOfEnd();

        return sprintf('%s %s %s AND %s', $this->field, static::OP->value, $placeholderOfStart, $placeholderOfEnd);
    }

    /**
     */
    #[Override]
    public function getParams(): array
    {
        return [
            $this->getPlaceholderOfStart() => $this->startValue,
            $this->getPlaceholderOfEnd()   => $this->endValue,
        ];
    }

    /**
     */
    private function getPlaceholderOfStart(): string
    {
        return sprintf(':value_%s_start', $this->startValue);
    }

    /**
     */
    private function getPlaceholderOfEnd(): string
    {
        return sprintf(':value_%s_end', $this->endValue);
    }

    #[Override]
    public function getLogic(): ?Logic
    {
        return null;
    }
}
