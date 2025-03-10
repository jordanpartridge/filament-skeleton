<?php

namespace App\Helpers;

/**
 * System utility helper functions
 */
class SystemHelper
{
    /**
     * Format bytes to human-readable format
     *
     * @param int $bytes Raw bytes to format
     * @param int $precision Number of decimal places
     * @return string Formatted string with units (B, KB, MB, GB, TB)
     */
    public static function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
