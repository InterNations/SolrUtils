<?php
namespace InterNations\Component\Solr;

final class Util
{
    /**
     * @var array
     */
    private static $search = array(
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
    );

     /**
     * @var array
     */
    private static $replace = array(
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
    );

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
            } else {
                return $value;
            }

        } elseif ($type === 'integer') {
            return (string) $value;

        } elseif ($type === 'double') {
            static $precision;
            if (!$precision) {
                $precision = substr(PHP_VERSION, -6) === 'hiphop' ? 14 : ini_get('precision');
            }

            return number_format($value, $precision, '.', '');

        } elseif ($value instanceof ExpressionInterface) {
            return $value;

        } elseif (empty($value)) {
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
