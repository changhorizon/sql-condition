# SQL Condition

> A PHP library for building and managing SQL WHERE conditions with a flexible, object-oriented approach.

![License](https://img.shields.io/github/license/changhorizon/sql-condition?style=flat-square)
![Latest Version](https://img.shields.io/packagist/v/changhorizon/sql-condition?style=flat-square)
![PHP Version](https://img.shields.io/badge/php-8.3--8.4-blue?style=flat-square)
![Static Analysis](https://img.shields.io/badge/static_analysis-PHPStan-blue?style=flat-square)
![Tests](https://img.shields.io/badge/tests-PHPUnit-brightgreen?style=flat-square)
[![codecov](https://codecov.io/gh/changhorizon/sql-condition/branch/main/graph/badge.svg)](https://codecov.io/gh/changhorizon/sql-condition)
![CI](https://github.com/changhorizon/sql-condition/actions/workflows/ci.yml/badge.svg?style=flat-square)

Build SQL WHERE clauses programmatically with a clean, type-safe, and composable expression system. Supports 16 SQL operators with named parameter binding for PDO.

## ✨ 特性

- 16 SQL operators: comparison (`=`, `<>`, `>`, `>=`, `<`, `<=`), pattern matching (`LIKE`, `NOT LIKE`), set membership (`IN`, `NOT IN`), range (`BETWEEN`, `NOT BETWEEN`), null checks (`IS NULL`, `IS NOT NULL`), boolean (`IS TRUE`, `IS FALSE`)
- Named parameter (`:value_column`) output for PDO prepared statements
- Composable `Condition` class with AND/OR logic and nested grouping
- LIKE anchor support (left, right, both)
- Static factory `Expression::EQ()`, `Expression::GT()`, etc. for concise expression creation
- Zero runtime dependencies, PHP 8.3+ with strict types

## 📦 安装

```bash
composer require changhorizon/sql-condition
```

## 📂 目录结构

```txt
src/
├── Condition.php               # Expression combiner with AND/OR logic
├── Expression.php              # Static factory (EQ, NEQ, GT, ...)
├── Enums/
│   ├── Anchor.php              # LIKE anchor direction
│   ├── Logic.php               # AND / OR
│   └── Operator.php            # 16 SQL operators
├── Expressions/
│   ├── Between.php / NotBetween.php
│   ├── Equal.php (+ NEQ, GT, GTE, LT, LTE via inheritance)
│   ├── In.php / NotIn.php
│   ├── IsNull.php (+ IsNotNull, IsTrue, IsFalse via inheritance)
│   └── Like.php / NotLike.php
└── Interfaces/
    └── ExpressionInterface.php
```

## 🚀 用法示例

### Basic Expressions

```php
use ChangHorizon\SqlCondition\Expression;

// Simple conditions
$eq  = Expression::EQ('name', 'John');
$gt  = Expression::GT('age', '18');
$in  = Expression::IN('status', ['active', 'pending']);
$like = Expression::LIKE('title', 'hello');

$eq->getString();  // "name = :value_name"
$eq->getParams();  // [':value_name' => 'John']
```

### Combining with Condition (AND)

```php
use ChangHorizon\SqlCondition\Condition;
use ChangHorizon\SqlCondition\Expression;

$cond = new Condition([
    Expression::EQ('name', 'John'),
    Expression::GT('age', '18'),
    Expression::IS_NULL('deleted_at'),
]);

$cond->getString();  // "name = :value_name AND age > :value_age AND deleted_at IS NULL"
$cond->getParams();  // [':value_name' => 'John', ':value_age' => '18']
```

### Combining with Condition (OR)

```php
use ChangHorizon\SqlCondition\Condition;
use ChangHorizon\SqlCondition\Enums\Logic;

$cond = new Condition([
    Expression::EQ('role', 'admin'),
    Expression::EQ('role', 'moderator'),
], Logic::OR);

$cond->getString();  // "role = :value_role OR role = :value_role"
```

### Nested Conditions (Grouping)

```php
$adminOrMod = new Condition([
    Expression::EQ('role', 'admin'),
    Expression::EQ('role', 'moderator'),
], Logic::OR);

$cond = new Condition([
    $adminOrMod,
    Expression::IS_TRUE('is_active'),
]);

$cond->getString();  // "(role = :value_role OR role = :value_role) AND is_active IS TRUE"
```

### LIKE with Anchors

```php
use ChangHorizon\SqlCondition\Enums\Anchor;
use ChangHorizon\SqlCondition\Expressions\Like;

// Default (both sides): %value%
new Like('title', 'hello')->getParams();       // [':value_title' => '%:hello%']

// Left anchor only: value%
new Like('title', 'hello', Anchor::LEFT)->getParams();   // [':value_title' => ':hello%']

// Right anchor only: %value
new Like('title', 'hello', Anchor::RIGHT)->getParams();  // [':value_title' => '%:hello']
```

### Using with PDO

```php
$cond = new Condition([
    Expression::EQ('email', 'user@example.com'),
    Expression::IS_NOT_NULL('verified_at'),
]);

$sql  = 'SELECT * FROM users WHERE ' . $cond->getString();
$stmt = $pdo->prepare($sql);
$stmt->execute($cond->getParams());
```

## 📐 接口说明

### `ExpressionInterface`

| Method | Returns | Description |
|--------|---------|-------------|
| `getString(): string` | SQL fragment (e.g. `age > :value_age`) |
| `getParams(): array` | Named params for PDO binding |
| `getLogic(): ?Logic` | `null` for leaf expressions |

### Static Factory: `Expression::*()`

| Method | Expression | SQL Output |
|--------|-----------|------------|
| `EQ($col, $val)` | Equal | `col = :val` |
| `NEQ($col, $val)` | NotEqual | `col <> :val` |
| `GT($col, $val)` | GreaterThan | `col > :val` |
| `GTE($col, $val)` | GreaterThanOrEqual | `col >= :val` |
| `LT($col, $val)` | LessThan | `col < :val` |
| `LTE($col, $val)` | LessThanOrEqual | `col <= :val` |
| `IS_NULL($col)` | IsNull | `col IS NULL` |
| `IS_NOT_NULL($col)` | IsNotNull | `col IS NOT NULL` |
| `IS_TRUE($col)` | IsTrue | `col IS TRUE` |
| `IS_FALSE($col)` | IsFalse | `col IS FALSE` |
| `IN($col, $vals)` | In | `col IN (:v0, :v1)` |
| `NOT_IN($col, $vals)` | NotIn | `col NOT IN (:v0)` |
| `BT($col, $min, $max)` | Between | `col BETWEEN :min AND :max` |
| `NOT_BT($col, $min, $max)` | NotBetween | `col NOT BETWEEN :min AND :max` |
| `LIKE($col, $pattern)` | Like | `col LIKE :val` |
| `NOT_LIKE($col, $pattern)` | NotLike | `col NOT LIKE :val` |

## 🔍 静态分析

```bash
composer stan
```

## 🎯 代码风格

```bash
composer cs:chk    # check
composer cs:fix    # auto-fix
```

## ✅ 单元测试

```bash
composer test
composer test:coverage
```

## 📜 License

MIT License. See [LICENSE](LICENSE) for details.

## 🤝 贡献指南

欢迎 Issue 与 PR，建议遵循以下流程：

1. Fork 仓库
2. 创建新分支进行开发
3. 提交 PR 前请确保测试通过、风格一致
4. 提交详细描述
