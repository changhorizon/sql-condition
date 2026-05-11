<?php

declare(strict_types=1);

/**
 * This file contains all placeholder keys used in the scaffolding process.
 *
 * After initializing your project with the pps tool, replace these placeholders
 * throughout the codebase (composer.json, phpunit.xml, README.md, .github/workflows/ci.yml, etc.).
 *
 * You can locate placeholders by running:
 *   grep 'pps\.' -r .
 *
 * Example usage (in composer.json):
 *   "name": "changhorizon/sql-condition"
 *
 * Replace with:
 *   "name": "changhorizon/example-project"
 *
 * Note:
 * - Double backslashes (\\) are required in namespaces.
 * - PHPStan version should use numeric format: 80200 = PHP 8.2.0
 */

return [
    // ─── composer.json | README.md | .github/workflows/ci.yml ───────
    'changhorizon'               => '', // e.g., 'changhorizon'
    'sql-condition'            => '', // e.g., 'example-project'

    // ─── composer.json ──────────────────────────────────────────────
    'library'            => '', // e.g., 'library'
    'A PHP library for building and managing SQL WHERE conditions with a flexible, object-oriented approach.'     => '', // e.g., 'A PHP package for any functions...'
    '8.3'     => '', // e.g., '8.2'
    'Harper Jang'     => '', // e.g., 'Harper Jang'
    'harper.jang@outlook.com'    => '', // e.g., 'harper.jang@outlook.com'
    'Hizpark\\SqlCondition'   => '', // e.g., 'Hizpark\\ExampleProject'
    'Hizpark\\SqlCondition\\Tests' => '', // e.g., 'Hizpark\\ExampleProject\\Tests'

    // ─── phpunit.xml.dist ───────────────────────────────────────────
    'SqlCondition'       => '', // e.g., 'ExampleProject'

    // ─── phpstan.neon.dist ──────────────────────────────────────────
    'max'           => '', // e.g., 'max'
    '80300'     => '', // e.g., '80200'

    // ─── LICENSE ────────────────────────────────────────────────────
    '2025'         => '', // e.g., '2025'
    'changhorizon'        => '', // e.g., 'changhorizon'

    // ─── README.md ──────────────────────────────────────────────────
    'SQL Condition'            => '', // e.g., 'Example Project'
    'A PHP library for building and managing SQL WHERE conditions with a flexible, object-oriented approach.'          => '', // e.g., 'A very cool project'
];
