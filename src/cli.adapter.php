<?php

if (PHP_SAPI === 'cli') {
    $_SERVER['QUERY_STRING'] = parse_url($argv[2])['query'] ?? '';
    $_SERVER['REQUEST_URI'] = str_replace(
        "?{$_SERVER['QUERY_STRING']}",
        '',
        $argv[2]
    );
    parse_str($_SERVER['QUERY_STRING'] ?? '', $_GET);
    $_SERVER['REQUEST_METHOD'] = $argv[1] ?? 'GET';
}