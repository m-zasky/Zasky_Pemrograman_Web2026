<?php
// Fungsi pembungkus htmlspecialchars untuk Mencegah XSS
if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}