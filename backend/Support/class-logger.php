<?php
namespace MiniAssessment\Support;

class Logger {
    public static function error($message, array $context = []) {
        $suffix = $context ? ' ' . wp_json_encode($context) : '';
        error_log('[mini-assessment] ' . $message . $suffix);
    }
}
