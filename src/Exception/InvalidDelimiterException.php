<?php

namespace Ryanwhowe\Dot\Exception;

use Throwable;

class InvalidDelimiterException extends DotException {

    /**
     * Delimiters can be any string that is compatible with the explode() function.
     *
     * @param string         $delimiter
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $delimiter = "", int $code = 0, ?Throwable $previous = null) {
        parent::__construct("Invalid delimiter, ryanwhowe/Dot is unable to function with the delimiter of '{$delimiter}'", $code, $previous);
    }
}