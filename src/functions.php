<?php declare(strict_types=1);

/**
 * The functions are direct wrappers of the Dot class's static methods.  This allows for direct easy access to the
 * functionality without needing an additional use statement
 */

use Ryanwhowe\Dot\Dot;
use Ryanwhowe\Dot\Exception\ArrayKeyNotSetException;
use Ryanwhowe\Dot\Exception\InvalidDelimiterException;

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
 * @throws ArrayKeyNotSetException if missingKeyException is set to Dot::ARRAY_KEY_MISSING_EXCEPTION and they key is not
 *     found
 */
function dotGet(
    array  $array,
    string $key,
    mixed  $default = null,
    string $delimiter = Dot::DEFAULT_DELIMITER,
    int    $missingKeyException = 0
): mixed {
    return Dot::get($array, $key, $default, $delimiter, $missingKeyException);
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
 * @throws InvalidDelimiterException
 */
function dotSet(
    array  &$array,
    string $key,
    mixed  $value,
    string $delimiter = Dot::DEFAULT_DELIMITER
): void {
    Dot::set($array, $key, $value, $delimiter);
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
function dotHas(
    array  $array,
    string $key,
    string $delimiter = Dot::DEFAULT_DELIMITER
): bool {
    return Dot::has($array, $key, $delimiter);
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
function dotCount(
    array  $array,
    string $key,
    string $delimiter = Dot::DEFAULT_DELIMITER,
    int    $return = Dot::ZERO_ON_NON_ARRAY,
    int    $missingKeyException = 0
): int {
    return Dot::count($array, $key, $delimiter, $return, $missingKeyException);
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
function dotDelete(
    array  &$array,
    string $key,
    string $delimiter = Dot::DEFAULT_DELIMITER,
    int    $missingKeyException = 0
): void {
    Dot::delete($array, $key, $delimiter, $missingKeyException);
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
function dotAppend(
    array  &$array,
    string $key,
    mixed  $value,
    string $delimiter = Dot::DEFAULT_DELIMITER,
    int    $missingKeyException = 0
): void {
    Dot::append($array, $key, $value, $delimiter, $missingKeyException);
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
function dotFlatten(
    array  $array,
    string $delimiter = Dot::DEFAULT_DELIMITER,
    string $prepend = ''
): array {
    return Dot::flatten($array, $delimiter, $prepend);
}