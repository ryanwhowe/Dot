<?php declare(strict_types=1);

namespace Ryanwhowe\Dot;

use Ryanwhowe\Dot\Exception\ArrayKeyNotSetException;
use Ryanwhowe\Dot\Exception\InvalidDelimiterException;

/**
 * Get and set and check values in an array using dot notation or any other optional key separator.
 *
 */
class Dot {

    /**
     * The default delimiter for separating keys is a period character, but any string that explode() will support can be utilized
     */
    const DEFAULT_DELIMITER = '.';

    /**
     * When the :count() method runs, if the value in the searchKey location is not an array, return 0
     */
    const ZERO_ON_NON_ARRAY = 1;

    /**
     * When the :count() method runs, if the value in the searchKey location is not an array, return -1
     */
    const NEGATIVE_ON_NON_ARRAY = 2;

    /**
     * Several methods can be set to throw an ArrayKeyNotSetException if an array key is not set in the target array
     */
    const ARRAY_KEY_MISSING_EXCEPTION = 1;

    /**
     * @var string|null This stores the original search key before the recursive search traverses the array.
     */
    private static ?string $searchKey = null;

    /**
     * This class is a static class and should not be instantiated
     */
    private function __construct() { }

    /**
     * Return the value that the array has for the dot notation key, if there is no value to return the default is
     * returned
     *
     * @param mixed[]          $array
     * @param non-empty-string $key
     * @param mixed|null       $default
     * @param non-empty-string $delimiter
     * @param int              $missingKeyException if set to Dot::ARRAY_KEY_MISSING_EXCEPTION will throw an exception
     *     if key is not found
     *
     * @return array|mixed|null
     * @throws InvalidDelimiterException if an invalid delimiter is used
     * @throws ArrayKeyNotSetException if missingKeyException is set to ARRAY_KEY_MISSING_EXCEPTION and they key is not
     *     found
     */
    public static function get(array $array, string $key, mixed $default = null, string $delimiter = self::DEFAULT_DELIMITER, int $missingKeyException = 0): mixed {
        self::validateDelimiter($delimiter);
        if (null === self::$searchKey) {
            self::$searchKey = $key;
        }
        $keys = explode($delimiter, $key);
        $key_pos = array_shift($keys);

        if (array_key_exists($key_pos, $array)) {
            if (is_array($array[$key_pos]) && count($keys)) {
                return self::get($array[$key_pos], implode($delimiter, $keys), $default, $delimiter, $missingKeyException);
            } else {
                if (count($keys)) {
                    if (self::ARRAY_KEY_MISSING_EXCEPTION === $missingKeyException) {
                        $_searchKey = self::$searchKey;
                        self::$searchKey = null;
                        throw new ArrayKeyNotSetException($_searchKey);
                    }
                    self::$searchKey = null;
                    return $default;
                };
                self::$searchKey = null;
                return $array[$key_pos];
            }
        } else {
            if (self::ARRAY_KEY_MISSING_EXCEPTION === $missingKeyException) {
                $_searchKey = self::$searchKey;
                self::$searchKey = null;
                throw new ArrayKeyNotSetException($_searchKey);
            }
            self::$searchKey = null;
            return $default;
        }
    }

    /**
     * Set the value in the array dictated by the dot notation key, if the path of the key does not exist it will be
     * created in the array.
     *
     * @param mixed[]          $array
     * @param non-empty-string $key
     * @param array|mixed|null $value
     * @param non-empty-string $delimiter
     *
     * @return void
     * @throws InvalidDelimiterException if an invalid delimiter is used
     */
    public static function set(array &$array, string $key, mixed $value, string $delimiter = self::DEFAULT_DELIMITER): void {
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
     * @param mixed[]          $array
     * @param non-empty-string $key Dot notation key
     * @param non-empty-string $delimiter
     *
     * @return bool
     * @throws InvalidDelimiterException if an invalid delimiter is used
     */
    public static function has(array $array, string $key, string $delimiter = self::DEFAULT_DELIMITER): bool {
        self::validateDelimiter($delimiter);
        $default = "\0\0";
        try {
            $v = self::get($array, $key, $default, $delimiter);
        } catch (ArrayKeyNotSetException) {
            $v = $default; // this should not execute
        }
        return ($v !== $default); // if the default value is returned then the key was not found
    }

    /**
     * Return the count of the value at the provided key position.  The method will return 0 on an empty array.
     * The $return defaults to return 0 if the value is not set or the key position is not an array.
     * It $return is set to Dot::COUNT_NEGATIVE_ON_NON_ARRAY the method will return -1 if the value is not set or the
     * key position is not an array.
     *
     * @param mixed[]          $array
     * @param non-empty-string $key
     * @param non-empty-string $delimiter
     * @param int              $return defaults to returning 0 count on not set or not array, can be set to return -1
     * @param int              $missingKeyException if set to Dot::ARRAY_KEY_MISSING_EXCEPTION will throw an exception
     *     if key is not found
     *
     * @return int
     * @throws ArrayKeyNotSetException if missingKeyException is set to ARRAY_KEY_MISSING_EXCEPTION and they key is not
     *     found
     * @throws InvalidDelimiterException if an invalid delimiter is used
     */
    public static function count(array $array, string $key, string $delimiter = self::DEFAULT_DELIMITER, int $return = self::ZERO_ON_NON_ARRAY, int $missingKeyException = 0): int {
        self::validateDelimiter($delimiter);
        $default = (self::NEGATIVE_ON_NON_ARRAY === $return) ? -1 : 0;
        $position = self::get($array, $key, '', $delimiter, $missingKeyException);
        return is_array($position) ? count($position) : $default;
    }

    /**
     * Append a value to the key position, if the value at the key position is not an array the result will be an
     * array with the existing value and new value.  If the key does not exist its full path will be set to an array
     * containing the value submitted.
     *
     * @param mixed[]          $array
     * @param non-empty-string $key
     * @param array|mixed|null $value
     * @param non-empty-string $delimiter
     * @param int              $missingKeyException
     *
     * @return void
     * @throws InvalidDelimiterException if an invalid deliminator is used
     * @throws ArrayKeyNotSetException if missingKeyException is set to ARRAY_KEY_MISSING_EXCEPTION and they key is not
     *     found
     */
    public static function append(array &$array, string $key, mixed $value, string $delimiter = self::DEFAULT_DELIMITER, int $missingKeyException = 0): void {
        self::validateDelimiter($delimiter);
        $current = self::get($array, $key, [], $delimiter, $missingKeyException);
        $current = (is_array($current)) ? $current : [$current];
        $value = (is_array($value)) ? $value : [$value];
        self::set($array, $key, array_merge($current, $value), $delimiter);
    }

    /**
     * Unset the provided key position in the array if it exists.
     *
     * @param mixed[]          $array
     * @param non-empty-string $key
     * @param non-empty-string $delimiter
     * @param int              $missingKeyException
     *
     * @return void
     * @throws ArrayKeyNotSetException if missingKeyException is set to ARRAY_KEY_MISSING_EXCEPTION and they key is not
     *     found
     * @throws InvalidDelimiterException
     */
    public static function delete(array &$array, string $key, string $delimiter = self::DEFAULT_DELIMITER, int $missingKeyException = 0): void {
        self::get($array, $key, '', $delimiter, $missingKeyException);
        self::validateDelimiter($delimiter);

        if (!self::has($array, $key)) {
            return;
        }

        $keys = explode($delimiter, $key);
        $final = array_pop($keys);
        $current = &$array;
        foreach ($keys as $_key) {
            if (is_array($current[$_key])) $current = &$current[$_key];
        }

        unset($current[$final]);
    }

    /**
     * Flatten a multidimensional array to a single dimension with dot keys => value
     *
     * @param mixed[]          $array The source array to flatten
     * @param non-empty-string $delimiter The delimiter to use between keys
     * @param string           $prepend if there is any prepend string to the key sequence to use
     *
     * @return array<string, mixed> flattened single dimension array of the source array
     * @throws InvalidDelimiterException if an invalid delimiter is used
     */
    public static function flatten(array $array, string $delimiter = self::DEFAULT_DELIMITER, string $prepend = ''): array {
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
     * @param string $delimiter
     *
     * @return void
     * @throws InvalidDelimiterException if an invalid delimiter is used
     */
    private static function validateDelimiter(string $delimiter): void {
        if ($delimiter === '') throw new InvalidDelimiterException('');
    }
}