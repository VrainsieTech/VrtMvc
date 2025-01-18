<?php

namespace Vrainsietech\Vrtmvc\Config;

class Config
{
    private static $config = [];
    private static $isCached = false;
    private static $cacheFile = 'bootstrap/cache/config.php'; // Cache file path

    static function load(string $configPath): void
    {
        if (self::$isCached && file_exists(self::$cacheFile)) {
            self::$config = require self::$cacheFile;
            return;
        }

        $configFiles = glob($configPath . '/*.php');
        foreach ($configFiles as $file) {
            $key = basename($file, '.php');
            self::$config[$key] = require $file;
        }

        if (getenv('APP_CACHE_CONFIG') === 'true') {
            self::cache();
        }
    }

    static function get(string $key, $default = null)
    {
        $keys = explode('.', $key);
        $config = self::$config;

        foreach ($keys as $k) {
            if (!isset($config[$k])) {
                return $default;
            }
            $config = $config[$k];
        }

        return $config;
    }

    static function set(string $key, $value): void
    {
        $keys = explode('.', $key);
        $config = &self::$config; // Use reference

        foreach ($keys as $k) {
            if (!isset($config[$k]) || !is_array($config[$k])) {
                $config[$k] = [];
            }
            $config = &$config[$k]; // Keep using reference
        }

        $config = $value;

        if (getenv('APP_CACHE_CONFIG') === 'true') {
            self::cache();
        }
    }

    static function cache(): void
    {
        $cacheContent = '<?php return ' . var_export(self::$config, true) . ';';
        file_put_contents(self::$cacheFile, $cacheContent);
        self::$isCached = true;
    }

    static function clearCache(): void
    {
        if (file_exists(self::$cacheFile)) {
            unlink(self::$cacheFile);
            self::$isCached = false;
        }
    }
}