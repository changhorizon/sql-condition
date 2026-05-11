<?php

declare(strict_types=1);

namespace Hizpark\SqlCondition;

use Hizpark\SqlCondition\Interfaces\ExpressionInterface;

/**
 * SQL 条件表达式的静态工厂类
 * 提供快捷方法生成各种表达式实例
 */
final class Expression
{
    // 禁止实例化
    private function __construct()
    {
    }

    /*
     * --------------------------------------------------------------------------
     * 比较操作
     * --------------------------------------------------------------------------
     */

    /**
     * 创建一个等于条件表达式
     *
     * @param string $column 列名
     * @param string $value  比较的值
     *
     * @return ExpressionInterface 返回 Equal 表达式
     */
    public static function EQ(string $column, string $value): ExpressionInterface
    {
        return new Expressions\Equal($column, $value);
    }

    /**
     * 创建一个不等于条件表达式
     *
     * @param string $column 列名
     * @param string $value  比较的值
     *
     * @return ExpressionInterface 返回 NotEqual 表达式
     */
    public static function NEQ(string $column, string $value): ExpressionInterface
    {
        return new Expressions\NotEqual($column, $value);
    }

    /**
     * 创建一个大于条件表达式
     *
     * @param string $column 列名
     * @param string $value  比较的值
     *
     * @return ExpressionInterface 返回 GreaterThan 表达式
     */
    public static function GT(string $column, string $value): ExpressionInterface
    {
        return new Expressions\GreaterThan($column, $value);
    }

    /**
     * 创建一个大于或等于条件表达式
     *
     * @param string $column 列名
     * @param string $value  比较的值
     *
     * @return ExpressionInterface 返回 GreaterThanOrEqual 表达式
     */
    public static function GTE(string $column, string $value): ExpressionInterface
    {
        return new Expressions\GreaterThanOrEqual($column, $value);
    }

    /**
     * 创建一个小于条件表达式
     *
     * @param string $column 列名
     * @param string $value  比较的值
     *
     * @return ExpressionInterface 返回 LessThan 表达式
     */
    public static function LT(string $column, string $value): ExpressionInterface
    {
        return new Expressions\LessThan($column, $value);
    }

    /**
     * 创建一个小于或等于条件表达式
     *
     * @param string $column 列名
     * @param string $value  比较的值
     *
     * @return ExpressionInterface 返回 LessThanOrEqual 表达式
     */
    public static function LTE(string $column, string $value): ExpressionInterface
    {
        return new Expressions\LessThanOrEqual($column, $value);
    }

    /*
     * --------------------------------------------------------------------------
     * 空值/布尔检查
     * --------------------------------------------------------------------------
     */

    /**
     * 创建一个 IS NULL 条件表达式
     *
     * @param string $column 列名
     *
     * @return ExpressionInterface 返回 IsNull 表达式
     */
    public static function IS_NULL(string $column): ExpressionInterface
    {
        return new Expressions\IsNull($column);
    }

    /**
     * 创建一个 IS NOT NULL 条件表达式
     *
     * @param string $column 列名
     *
     * @return ExpressionInterface 返回 IsNotNull 表达式
     */
    public static function IS_NOT_NULL(string $column): ExpressionInterface
    {
        return new Expressions\IsNotNull($column);
    }

    /**
     * 创建一个 IS TRUE 条件表达式
     *
     * @param string $column 列名
     *
     * @return ExpressionInterface 返回 IsTrue 表达式
     */
    public static function IS_TRUE(string $column): ExpressionInterface
    {
        return new Expressions\IsTrue($column);
    }

    /**
     * 创建一个 IS FALSE 条件表达式
     *
     * @param string $column 列名
     *
     * @return ExpressionInterface 返回 IsFalse 表达式
     */
    public static function IS_FALSE(string $column): ExpressionInterface
    {
        return new Expressions\IsFalse($column);
    }

    /*
     * --------------------------------------------------------------------------
     * 集合操作
     * --------------------------------------------------------------------------
     */

    /**
     * 创建一个 IN 条件表达式
     *
     * @param string   $column 列名
     * @param string[] $values 值的数组
     *
     * @return ExpressionInterface 返回 In 表达式
     */
    public static function IN(string $column, array $values): ExpressionInterface
    {
        return new Expressions\In($column, $values);
    }

    /**
     * 创建一个 NOT IN 条件表达式
     *
     * @param string   $column 列名
     * @param string[] $values 值的数组
     *
     * @return ExpressionInterface 返回 NotIn 表达式
     */
    public static function NOT_IN(string $column, array $values): ExpressionInterface
    {
        return new Expressions\NotIn($column, $values);
    }

    /*
     * --------------------------------------------------------------------------
     * 范围操作
     * --------------------------------------------------------------------------
     */

    /**
     * 创建一个 BETWEEN 条件表达式
     *
     * @param string $column 列名
     * @param string $min    最小值
     * @param string $max    最大值
     *
     * @return ExpressionInterface 返回 Between 表达式
     */
    public static function BT(string $column, string $min, string $max): ExpressionInterface
    {
        return new Expressions\Between($column, $min, $max);
    }

    /**
     * 创建一个 NOT BETWEEN 条件表达式
     *
     * @param string $column 列名
     * @param string $min    最小值
     * @param string $max    最大值
     *
     * @return ExpressionInterface 返回 NotBetween 表达式
     */
    public static function NOT_BT(string $column, string $min, string $max): ExpressionInterface
    {
        return new Expressions\NotBetween($column, $min, $max);
    }

    /*
     * --------------------------------------------------------------------------
     * 字符串匹配
     * --------------------------------------------------------------------------
     */

    /**
     * 创建一个 LIKE 条件表达式
     *
     * @param string $column  列名
     * @param string $pattern 模糊匹配模式
     *
     * @return ExpressionInterface 返回 Like 表达式
     */
    public static function LIKE(string $column, string $pattern): ExpressionInterface
    {
        return new Expressions\Like($column, $pattern);
    }

    /**
     * 创建一个 NOT LIKE 条件表达式
     *
     * @param string $column  列名
     * @param string $pattern 模糊匹配模式
     *
     * @return ExpressionInterface 返回 NotLike 表达式
     */
    public static function NOT_LIKE(string $column, string $pattern): ExpressionInterface
    {
        return new Expressions\NotLike($column, $pattern);
    }
}
