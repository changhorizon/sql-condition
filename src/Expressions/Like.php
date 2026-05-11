<?php

declare(strict_types=1);

namespace Hizpark\SqlCondition\Expressions;

use Hizpark\SqlCondition\Enums\Anchor;
use Hizpark\SqlCondition\Enums\Logic;
use Hizpark\SqlCondition\Enums\Operator;
use Hizpark\SqlCondition\Interfaces\ExpressionInterface;
use Override;

class Like implements ExpressionInterface
{
    public const Operator OP = Operator::LIKE;

    private string $field;

    private string $value;

    private ?Anchor $anchor;

    /**
     */
    public function __construct(string $field, string $value, ?Anchor $anchor = null)
    {
        $this->field  = $field;
        $this->value  = $value;
        $this->anchor = $anchor;
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
        $pattern     = $this->getPattern();

        return [$placeholder => $pattern];
    }

    /**
     */
    private function getPlaceholder(): string
    {
        return sprintf(':value_%s', $this->field);
    }

    /**
     */
    private function getPattern(): string
    {
        return $this->anchor === null ?
            sprintf('%%:%s%%', $this->value) :
            match ($this->anchor) {
                Anchor::LEFT  => sprintf(':%s%%', $this->value),
                Anchor::RIGHT => sprintf('%%:%s', $this->value),
            };
    }

    #[Override]
    public function getLogic(): ?Logic
    {
        return null;
    }
}
