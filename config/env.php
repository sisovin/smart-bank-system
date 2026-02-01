<?php
/**
 * Environment Configuration Loader
 * Loads environment variables from .env file
 */

class Env {
    private static $loaded = false;

    /**
     * Load environment variables from .env file
     */
    public static function load($path = null) {
        if (self::$loaded) {
            return;
        }

        $path = $path ?: dirname(__DIR__) . '/.env';

        if (!file_exists($path)) {
            throw new Exception("Environment file not found: {$path}");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parse key=value
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);

                // Remove quotes if present
                if ((strpos($value, '"') === 0 && strrpos($value, '"') === strlen($value) - 1) ||
                    (strpos($value, "'") === 0 && strrpos($value, "'") === strlen($value) - 1)) {
                    $value = substr($value, 1, -1);
                }

                // Set environment variable
                putenv("{$key}={$value}");
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
            }
        }

        self::$loaded = true;
    }

    /**
     * Get environment variable with optional default
     */
    public static function get($key, $default = null) {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        return $value;
    }

    /**
     * Check if environment variable exists
     */
    public static function has($key) {
        return getenv($key) !== false;
    }

    /**
     * Get all environment variables
     */
    public static function all() {
        return $_ENV;
    }
}

// Auto-load environment variables
try {
    Env::load();
} catch (Exception $e) {
    // Log error but don't fail - allow manual configuration
    error_log("Failed to load environment file: " . $e->getMessage());
}
?>