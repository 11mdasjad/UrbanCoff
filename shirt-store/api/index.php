<?php

// Serve static assets directly if requested
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/'
);

$publicFile = realpath(__DIR__ . '/../public' . $uri);
$publicRoot = realpath(__DIR__ . '/../public');

if (
    $uri !== '/' &&
    $publicFile !== false &&
    $publicRoot !== false &&
    str_starts_with($publicFile, $publicRoot) &&
    file_exists($publicFile) &&
    !is_dir($publicFile)
) {
    $extension = strtolower(pathinfo($publicFile, PATHINFO_EXTENSION));
    $mimeTypes = [
        'css'   => 'text/css; charset=utf-8',
        'js'    => 'application/javascript; charset=utf-8',
        'svg'   => 'image/svg+xml',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'webp'  => 'image/webp',
        'ico'   => 'image/x-icon',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'json'  => 'application/json',
    ];

    $contentType = $mimeTypes[$extension] ?? (mime_content_type($publicFile) ?: 'application/octet-stream');
    header('Content-Type: ' . $contentType);
    header('Cache-Control: public, max-age=31536000, immutable');
    header('Content-Length: ' . filesize($publicFile));
    readfile($publicFile);
    exit;
}

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
