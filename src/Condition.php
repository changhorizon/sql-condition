<?php

declare(strict_types=1);

namespace Hizpark\SqlCondition;

use Hizpark\SqlCondition\Enums\Logic;
use Hizpark\SqlCondition\Interfaces\ExpressionInterface;
use Override;

class Condition implements ExpressionInterface
{
    /** @var ExpressionInterface[] */
    private array $items;

    private Logic $logic;

    /**
     * @param ExpressionInterface[] $items
     */
    public function __construct(array $items, Logic $logic = Logic::AND)
    {
        $this->items = $items;
        $this->logic = $logic;
    }

    /**
     */
    #[Override]
    public function getString(): string
    {
        // 获取每个条件表达式的字符串
        $strings = array_map(function ($item) {
            // 如果是 OR 逻辑，需要给表达式加括号
            return $item->getLogic() === Logic::OR
                ? sprintf('(%s)', $item->getString())
                : $item->getString();
        }, $this->items);

        // 使用指定的逻辑运算符连接所有条件
        return implode(" {$this->logic->value} ", $strings);
    }

    /**
     */
    #[Override]
    public function getParams(): array
    {
        $params = [];

        foreach ($this->items as $item) {
            $params = array_merge($params, $item->getParams());
        }

        return $params;
    }

    /**
     */
    public function getLogic(): ?Logic
    {
        return $this->logic;
    }

    /**
     * @param self[] $conditions
     */
    public static function build(array $conditions, Logic $logic): string
    {
        $conditions = array_map(function ($item) {
            return $item->getLogic() === Logic::OR
                ? sprintf('(%s)', $item->getString())
                : $item->getString();
        }, $conditions);

        // 使用指定的逻辑运算符连接所有条件
        return implode(" $logic->value ", $conditions);
    }
}
