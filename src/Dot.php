<?php

namespace Ryanwhowe\Dot;

use InvalidArgumentException;

/**
 * Get and set and check values in an array using dot notation or any other optional key separator.
 *
 */
class Dot {

    const DEFAULT_DELIMITER = '.';

    /**
     * This class is a static class and should not be instantiated
     */
    private function __construct() {}

    /**
     * Return the value that the array has for the dot notation key, if there is no value to return the default is returned
     *
     * @param mixed[] $array
     * @param non-empty-string $key
     * @param mixed|null $default
     * @param non-empty-string $delimiter
     * @return array|mixed|null
     * @throws InvalidArgumentException if an invalid deliminator is used
     */
    public static function get(array $array, $key, $default = null, $delimiter = self::DEFAULT_DELIMITER) {
        self::validateDelimiter($delimiter);
        $keys = explode($delimiter, $key);
        $key_pos = array_shift($keys);

        if (array_key_exists($key_pos, $array)) {
            if (is_array($array[$key_pos]) && count($keys)) {
                return self::get($array[$key_pos], implode($delimiter, $keys), $default, $delimiter);
            } else {
                if (count($keys)) return $default;
                return $array[$key_pos];
            }
        } else {
            return $default;
        }
    }

    /**
     * Set the value in the array dictated by the dot notation key, if the path of the key does not exist it will be
     * created in the array.
     *
     * @param mixed[] &$array
     * @param non-empty-string $key
     * @param array|mixed|null $value
     * @param non-empty-string $delimiter
     * @return void
     * @throws InvalidArgumentException if an invalid deliminator is used
     */
    public static function set(array &$array, $key, $value, $delimiter = self::DEFAULT_DELIMITER) {
        self::validateDelimiter($delimiter);
        $keys = explode($delimiter, $key);
        $key_pos = array_shift($keys);

        if (count($keys)) {
            if (!array_key_exists($key_pos, $array) || !is_array($array[$key_pos])) $array[$key_pos] = [];
            self::set($array[$key_pos], implode($delimiter, $keys), $value, $delimiter);
        } else {
            $array[$key_pos] = $value;
        }

    }

    /**
     * Does the array have the passed dot notation key
     *
     * @param mixed[] $array
     * @param non-empty-string $key Dot notation key
     * @param non-empty-string $delimiter
     * @return bool
     * @throws InvalidArgumentException if an invalid deliminator is used
     */
    public static function has(array $array, $key, $delimiter = self::DEFAULT_DELIMITER) {
        self::validateDelimiter($delimiter);
        $v = self::get($array, $key, "\0\0", $delimiter);
        return ($v !== "\0\0"); // if the default value is returned then the key was not found
    }

    /**
     * Flatten a multidimensional array to a single dimension with dot keys => value
     *
     * @param mixed[] $array The source array to flatten
     * @param non-empty-string $delimiter The delimiter to use between keys
     * @param string $prepend if there is any prepend string to the key sequence to use
     * @return array<string, mixed> flattened single dimension array of the source array
     * @throws InvalidArgumentException if an invalid deliminator is used
     */
    public static function flatten(array $array, $delimiter = self::DEFAULT_DELIMITER, $prepend = '') {
        self::validateDelimiter($delimiter);
        $flattened = [];
        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $flattened = array_merge($flattened, self::flatten($value, $delimiter, $prepend . $key . $delimiter));
            } else {
                $flattened[$prepend . $key] = $value;
            }
        }
        return $flattened;
    }

    /**
     * Validate that the deliminator provided is valid
     *
     * @param mixed $delimiter
     * @return void
     * @throws InvalidArgumentException if an invalid deliminator is used
     */
    private static function validateDelimiter($delimiter) {
        if (is_null($delimiter)) self::InvalidDelimiterException('A Null');
        if (is_array($delimiter)) self::InvalidDelimiterException('An Array');
        if ($delimiter === '') self::InvalidDelimiterException('A string of length 0');
    }

    /**
     * Common exception throwing for invalid deliminators
     *
     * @param string $message
     * @return void
     * @throws InvalidArgumentException
     */
    private static function InvalidDelimiterException($message) {
        throw new InvalidArgumentException($message . ' Delimiter is not valid');
    }

}