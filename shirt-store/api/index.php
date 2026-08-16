<?php

// Ensure /tmp directories exist for Vercel's ephemeral serverless filesystem
$dirs = [
    '/tmp/storage',
    '/tmp/storage/app',
    '/tmp/storage/app/public',
    '/tmp/storage/framework',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/testing',
    '/tmp/storage/logs',
    '/tmp/views',
    '/tmp/cache',
    '/tmp/bootstrap/cache',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Copy pre-seeded SQLite database to /tmp if it doesn't exist or is empty
$tmpDb = '/tmp/database.sqlite';
$sourceDb = __DIR__ . '/../database/database.sqlite';

if (!file_exists($tmpDb) || filesize($tmpDb) === 0) {
    if (file_exists($sourceDb)) {
        @copy($sourceDb, $tmpDb);
    } else {
        @touch($tmpDb);
    }
}

$_ENV['DB_DATABASE'] = $tmpDb;
$_SERVER['DB_DATABASE'] = $tmpDb;
putenv("DB_DATABASE={$tmpDb}");

// Forward the request to the Laravel application
require __DIR__ . '/../public/index.php';
