<?php

declare(strict_types=1);

namespace ChangHorizon\SqlCondition\Interfaces;

use ChangHorizon\SqlCondition\Enums\Logic;

interface ExpressionInterface
{
    public function getString(): string; // 用于获取表达式的SQL片段

    /**
     * @return string[]
     */
    public function getParams(): array; // 用于获取SQL的参数

    public function getLogic(): ?Logic;
}
