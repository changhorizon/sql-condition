<?php

declare(strict_types=1);

namespace Hizpark\SqlCondition\Tests;

use Hizpark\SqlCondition\Condition;
use Hizpark\SqlCondition\Enums\Logic;
use Hizpark\SqlCondition\Expression;
use PHPUnit\Framework\TestCase;

class ConditionTest extends TestCase
{
    public function testAndConditionJoinsWithAnd(): void
    {
        $cond = new Condition([
            Expression::EQ('name', 'foo'),
            Expression::GT('age', '18'),
        ]);

        $this->assertSame('name = :value_name AND age > :value_age', $cond->getString());
        $this->assertSame([':value_name' => 'foo', ':value_age' => '18'], $cond->getParams());
    }

    public function testOrConditionJoinsWithOr(): void
    {
        $cond = new Condition([
            Expression::EQ('status', 'active'),
            Expression::EQ('role', 'admin'),
        ], Logic::OR);

        $this->assertSame('status = :value_status OR role = :value_role', $cond->getString());
        $this->assertSame([':value_status' => 'active', ':value_role' => 'admin'], $cond->getParams());
    }

    public function testNestedConditionWrapsOrSubConditionInParens(): void
    {
        $inner = new Condition([
            Expression::EQ('role', 'admin'),
            Expression::IS_TRUE('is_active'),
        ], Logic::OR);

        $outer = new Condition([
            $inner,
            Expression::GT('login_count', '5'),
        ]);

        $this->assertSame(
            '(role = :value_role OR is_active IS TRUE) AND login_count > :value_login_count',
            $outer->getString()
        );
    }

    public function testNestedAndConditionDoesNotWrap(): void
    {
        $inner = new Condition([
            Expression::EQ('a', '1'),
            Expression::EQ('b', '2'),
        ], Logic::AND);

        $outer = new Condition([
            $inner,
            Expression::EQ('c', '3'),
        ], Logic::AND);

        $this->assertSame('a = :value_a AND b = :value_b AND c = :value_c', $outer->getString());
    }

    public function testEmptyCondition(): void
    {
        $cond = new Condition([]);
        $this->assertSame('', $cond->getString());
        $this->assertSame([], $cond->getParams());
    }

    public function testSingleExpression(): void
    {
        $cond = new Condition([Expression::EQ('name', 'foo')]);
        $this->assertSame('name = :value_name', $cond->getString());
    }

    public function testGetLogic(): void
    {
        $cond = new Condition([Expression::EQ('a', '1')], Logic::OR);
        $this->assertSame(Logic::OR, $cond->getLogic());

        $cond2 = new Condition([Expression::EQ('a', '1')], Logic::AND);
        $this->assertSame(Logic::AND, $cond2->getLogic());
    }

    public function testDefaultLogicIsAnd(): void
    {
        $cond = new Condition([Expression::EQ('a', '1')]);
        $this->assertSame(Logic::AND, $cond->getLogic());
    }

    public function testBuildWithOr(): void
    {
        $conditions = [
            new Condition([Expression::EQ('name', 'foo')]),
            new Condition([Expression::EQ('role', 'admin')]),
        ];

        $result = Condition::build($conditions, Logic::OR);

        $this->assertSame('name = :value_name OR role = :value_role', $result);
    }

    public function testBuildWithAnd(): void
    {
        $conditions = [
            new Condition([Expression::EQ('a', '1')]),
            new Condition([Expression::EQ('b', '2')]),
        ];

        $result = Condition::build($conditions, Logic::AND);

        $this->assertSame('a = :value_a AND b = :value_b', $result);
    }

    public function testDeeplyNestedConditions(): void
    {
        $a = new Condition([Expression::EQ('x', '1')]);
        $b = new Condition([Expression::EQ('y', '2')], Logic::OR);
        $c = new Condition([Expression::EQ('z', '3')]);

        $middle = new Condition([$a, $b, $c], Logic::OR);
        $this->assertSame('x = :value_x OR (y = :value_y) OR z = :value_z', $middle->getString());
    }
}
