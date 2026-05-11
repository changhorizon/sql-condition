<?php

declare(strict_types=1);

namespace Hizpark\SqlCondition\Tests;

use Hizpark\SqlCondition\Enums\Anchor;
use Hizpark\SqlCondition\Expression;
use Hizpark\SqlCondition\Interfaces\ExpressionInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ExpressionTest extends TestCase
{
    /** @return array<string, array{ExpressionInterface, string, array<string, string>}> */
    public static function provideExpressions(): array
    {
        return [
            'EQ'             => [Expression::EQ('name', 'foo'), 'name = :value_name', [':value_name' => 'foo']],
            'NEQ'            => [Expression::NEQ('name', 'foo'), 'name <> :value_name', [':value_name' => 'foo']],
            'GT'             => [Expression::GT('age', '18'), 'age > :value_age', [':value_age' => '18']],
            'GTE'            => [Expression::GTE('age', '18'), 'age >= :value_age', [':value_age' => '18']],
            'LT'             => [Expression::LT('age', '60'), 'age < :value_age', [':value_age' => '60']],
            'LTE'            => [Expression::LTE('age', '60'), 'age <= :value_age', [':value_age' => '60']],
            'IS_NULL'        => [Expression::IS_NULL('deleted_at'), 'deleted_at IS NULL', []],
            'IS_NOT_NULL'    => [Expression::IS_NOT_NULL('email'), 'email IS NOT NULL', []],
            'IS_TRUE'        => [Expression::IS_TRUE('is_active'), 'is_active IS TRUE', []],
            'IS_FALSE'       => [Expression::IS_FALSE('is_deleted'), 'is_deleted IS FALSE', []],
            'IN'             => [Expression::IN('status', ['a', 'b']), 'status IN (:value_status_0, :value_status_1)', [':value_status_0' => 'a', ':value_status_1' => 'b']],
            'NOT_IN'         => [Expression::NOT_IN('status', ['x']), 'status NOT IN (:value_status_0)', [':value_status_0' => 'x']],
            'BETWEEN'        => [Expression::BT('price', '10', '100'), 'price BETWEEN :value_10_start AND :value_100_end', [':value_10_start' => '10', ':value_100_end' => '100']],
            'NOT_BETWEEN'    => [Expression::NOT_BT('price', '10', '100'), 'price NOT BETWEEN :value_10_start AND :value_100_end', [':value_10_start' => '10', ':value_100_end' => '100']],
            'LIKE'           => [Expression::LIKE('title', 'hello'), 'title LIKE :value_title', [':value_title' => '%:hello%']],
            'NOT_LIKE'       => [Expression::NOT_LIKE('title', 'world'), 'title NOT LIKE :value_title', [':value_title' => '%:world%']],
        ];
    }

    #[DataProvider('provideExpressions')]
    public function testGetString(ExpressionInterface $expr, string $expected): void
    {
        $this->assertSame($expected, $expr->getString());
    }

    /** @param array<string, string> $expected */
    #[DataProvider('provideExpressions')]
    public function testGetParams(ExpressionInterface $expr, string $_, array $expected): void
    {
        $this->assertSame($expected, $expr->getParams());
    }

    #[DataProvider('provideExpressions')]
    public function testGetLogicReturnsNull(ExpressionInterface $expr): void
    {
        $this->assertNull($expr->getLogic());
    }

    public function testLikeWithLeftAnchor(): void
    {
        $expr = new \Hizpark\SqlCondition\Expressions\Like('title', 'hello', Anchor::LEFT);
        $this->assertSame('title LIKE :value_title', $expr->getString());
        $this->assertSame([':value_title' => ':hello%'], $expr->getParams());
    }

    public function testLikeWithRightAnchor(): void
    {
        $expr = new \Hizpark\SqlCondition\Expressions\Like('title', 'world', Anchor::RIGHT);
        $this->assertSame('title LIKE :value_title', $expr->getString());
        $this->assertSame([':value_title' => '%:world'], $expr->getParams());
    }

    public function testLikeWithoutAnchor(): void
    {
        $expr = new \Hizpark\SqlCondition\Expressions\Like('title', 'test', null);
        $this->assertSame('title LIKE :value_title', $expr->getString());
        $this->assertSame([':value_title' => '%:test%'], $expr->getParams());
    }
}
