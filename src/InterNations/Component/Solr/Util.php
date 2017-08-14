<?php
namespace InterNations\Component\Solr;

final class Util
{
    /** @var array */
    private static $search = [
        '\\',
        '+',
        '-',
        '&',
        '|',
        '!',
        '(',
        ')',
        '{',
        '}',
        '[',
        ']',
        '^',
        '"',
        '~',
        '*',
        '?',
        ':',
        '/',
    ];

    /** * @var array */
    private static $replace = [
        '\\\\',
        '\+',
        '\-',
        '\&',
        '\|',
        '\!',
        '\(',
        '\)',
        '\{',
        '\}',
        '\[',
        '\]',
        '\^',
        '\"',
        '\~',
        '\*',
        '\?',
        '\:',
        '\/',
    ];

    /**
     * Quote a given string
     *
     * @param mixed $value
     * @return string|ExpressionInterface
     */
    public static function quote($value)
    {
        if ($value instanceof ExpressionInterface) {
            return $value;
        }

        return '"' . str_replace(static::$search, static::$replace, $value) . '"';
    }

    /**
     * Sanitizes a string
     *
     * Puts quotes around a string, treats everything else as a term
     *
     * @param mixed $value
     * @return string|ExpressionInterface
     */
    public static function sanitize($value)
    {
        $type = gettype($value);

        if ($type === 'string') {
            if ($value !== '') {
                return '"' . str_replace(static::$search, static::$replace, $value) . '"';
            }

            return $value;
        }

        if ($type === 'integer') {
            return (string) $value;
        }

        if ($type === 'double') {
            static $precision;

            if (!$precision) {
                $precision = defined('HHVM_VERSION') ? 14 : ini_get('precision');
            }

            return number_format($value, $precision, '.', '');
        }

        if ($type === 'boolean') {
            return $value ? 'true' : 'false';
        }

        if ($value instanceof ExpressionInterface) {
            return $value;
        }

        if (empty($value)) {
            return '';
        }
    }

    /**
     * Escape a string to be safe for Solr queries
     *
     * @param mixed $value
     * @return string|ExpressionInterface
     */
    public static function escape($value)
    {
        if ($value instanceof ExpressionInterface) {
            return $value;
        }

        return str_replace(static::$search, static::$replace, $value);
    }
}
