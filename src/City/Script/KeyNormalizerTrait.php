<?php

namespace City\Script;

trait KeyNormalizerTrait
{
    /**
     * The cache of snake-cased words.
     *
     * @var array
     */
    protected static $snakeCache = [];

    /**
     * The cache of camel-cased words.
     *
     * @var array
     */
    protected static $camelCache = [];

    /**
     * Convert a value to camel case.
     *
     * @param string $value The value to convert.
     * @return string
     */
    public static function camel($value)
    {
        $key = $value;

        if (isset(static::$camelCache[$key])) {
            return static::$camelCache[$key];
        }

        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        $value = str_replace(' ', '', $value);
        $value = lcfirst($value);

        static::$camelCache[$key] = $value;

        return $value;
    }

    /**
     * Convert a string to snake case.
     *
     * @param  string $value     The value to convert.
     * @param  string $delimiter The word delimiter.
     * @return string
     */
    public static function snake($value, $delimiter = '_')
    {
        $key = $value;
        if (isset(static::$snakeCache[$key][$delimiter])) {
            return static::$snakeCache[$key][$delimiter];
        }
        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', $value);
            $value = mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value), 'UTF-8');
        }
        static::$snakeCache[$key][$delimiter] = $value;

        return $value;
    }
}
