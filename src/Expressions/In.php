<?php

declare(strict_types=1);

namespace Hizpark\SqlCondition\Expressions;

use Hizpark\SqlCondition\Enums\Logic;
use Hizpark\SqlCondition\Enums\Operator;
use Hizpark\SqlCondition\Interfaces\ExpressionInterface;
use Override;

class In implements ExpressionInterface
{
    public const Operator OP = Operator::IN;

    private string $field;

    /**
     * @var string[]
     */
    private array $values;

    /**
     * @param string[] $values
     */
    public function __construct(string $field, array $values)
    {
        $this->field  = $field;
        $this->values = $values;
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
        $placeholders = $this->getPlaceholders();

        return array_combine($placeholders, array_values($this->values));
    }

    /**
     */
    private function getPlaceholder(): string
    {
        return sprintf('(%s)', implode(', ', $this->getPlaceholders()));
    }

    /**
     * @return string[]
     */
    private function getPlaceholders(): array
    {
        return array_map(fn ($index) => ":value_{$this->field}_$index", array_keys($this->values));
    }

    #[Override]
    public function getLogic(): ?Logic
    {
        return null;
    }
}
