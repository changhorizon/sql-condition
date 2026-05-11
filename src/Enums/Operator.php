<?php

declare(strict_types=1);

namespace ChangHorizon\SqlCondition\Enums;

/**
 * SQL 标准操作符枚举（缩写风格）
 * 注：所有值均与 SQL 语法完全一致，可直接拼接使用.
 */
enum Operator: string
{
    // 比较
    case EQ  = '=';
    case NEQ = '<>';
    case LT  = '<';
    case LTE = '<=';
    case GT  = '>';
    case GTE = '>=';

    // 匹配
    case LIKE     = 'LIKE';
    case NOT_LIKE = 'NOT LIKE';

    // 集合
    case IN     = 'IN';
    case NOT_IN = 'NOT IN';

    // 範圍
    case BETWEEN     = 'BETWEEN';
    case NOT_BETWEEN = 'NOT BETWEEN';

    // 空值
    case IS_NULL     = 'IS NULL';
    case IS_NOT_NULL = 'IS NOT NULL';

    // 布尔
    case IS_FALSE = 'IS FALSE';
    case IS_TRUE  = 'IS TRUE';
}
