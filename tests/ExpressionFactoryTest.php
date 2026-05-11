<?php

declare(strict_types=1);

namespace ChangHorizon\SqlCondition\Tests;

use ChangHorizon\SqlCondition\Expression;
use ChangHorizon\SqlCondition\Expressions\Between;
use ChangHorizon\SqlCondition\Expressions\Equal;
use ChangHorizon\SqlCondition\Expressions\GreaterThan;
use ChangHorizon\SqlCondition\Expressions\GreaterThanOrEqual;
use ChangHorizon\SqlCondition\Expressions\In;
use ChangHorizon\SqlCondition\Expressions\IsFalse;
use ChangHorizon\SqlCondition\Expressions\IsNotNull;
use ChangHorizon\SqlCondition\Expressions\IsNull;
use ChangHorizon\SqlCondition\Expressions\IsTrue;
use ChangHorizon\SqlCondition\Expressions\LessThan;
use ChangHorizon\SqlCondition\Expressions\LessThanOrEqual;
use ChangHorizon\SqlCondition\Expressions\Like;
use ChangHorizon\SqlCondition\Expressions\NotBetween;
use ChangHorizon\SqlCondition\Expressions\NotEqual;
use ChangHorizon\SqlCondition\Expressions\NotIn;
use ChangHorizon\SqlCondition\Expressions\NotLike;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ExpressionFactoryTest extends TestCase
{
    public function testEqCreatesEqualExpression(): void
    {
        $e = Expression::EQ('name', 'foo');
        $this->assertInstanceOf(Equal::class, $e);
    }

    public function testNeqCreatesNotEqualExpression(): void
    {
        $e = Expression::NEQ('name', 'foo');
        $this->assertInstanceOf(NotEqual::class, $e);
    }

    public function testGtCreatesGreaterThanExpression(): void
    {
        $e = Expression::GT('age', '18');
        $this->assertInstanceOf(GreaterThan::class, $e);
    }

    public function testGteCreatesGreaterThanOrEqualExpression(): void
    {
        $e = Expression::GTE('age', '18');
        $this->assertInstanceOf(GreaterThanOrEqual::class, $e);
    }

    public function testLtCreatesLessThanExpression(): void
    {
        $e = Expression::LT('age', '60');
        $this->assertInstanceOf(LessThan::class, $e);
    }

    public function testLteCreatesLessThanOrEqualExpression(): void
    {
        $e = Expression::LTE('age', '60');
        $this->assertInstanceOf(LessThanOrEqual::class, $e);
    }

    public function testIsNullCreatesIsNullExpression(): void
    {
        $e = Expression::IS_NULL('deleted_at');
        $this->assertInstanceOf(IsNull::class, $e);
    }

    public function testIsNotNullCreatesIsNotNullExpression(): void
    {
        $e = Expression::IS_NOT_NULL('email');
        $this->assertInstanceOf(IsNotNull::class, $e);
    }

    public function testIsTrueCreatesIsTrueExpression(): void
    {
        $e = Expression::IS_TRUE('is_active');
        $this->assertInstanceOf(IsTrue::class, $e);
    }

    public function testIsFalseCreatesIsFalseExpression(): void
    {
        $e = Expression::IS_FALSE('is_deleted');
        $this->assertInstanceOf(IsFalse::class, $e);
    }

    public function testInCreatesInExpression(): void
    {
        $e = Expression::IN('status', ['active', 'pending']);
        $this->assertInstanceOf(In::class, $e);
    }

    public function testNotInCreatesNotInExpression(): void
    {
        $e = Expression::NOT_IN('status', ['banned']);
        $this->assertInstanceOf(NotIn::class, $e);
    }

    public function testBtCreatesBetweenExpression(): void
    {
        $e = Expression::BT('price', '10', '100');
        $this->assertInstanceOf(Between::class, $e);
    }

    public function testNotBtCreatesNotBetweenExpression(): void
    {
        $e = Expression::NOT_BT('price', '10', '100');
        $this->assertInstanceOf(NotBetween::class, $e);
    }

    public function testLikeCreatesLikeExpression(): void
    {
        $e = Expression::LIKE('title', 'hello');
        $this->assertInstanceOf(Like::class, $e);
    }

    public function testNotLikeCreatesNotLikeExpression(): void
    {
        $e = Expression::NOT_LIKE('title', 'world');
        $this->assertInstanceOf(NotLike::class, $e);
    }

    public function testPrivateConstructorCannotBeInstantiated(): void
    {
        $ref  = new ReflectionClass(Expression::class);
        $ctor = $ref->getConstructor();
        $this->assertNotNull($ctor);
        $this->assertTrue($ctor->isPrivate());
    }
}
