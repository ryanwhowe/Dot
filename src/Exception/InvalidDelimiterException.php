<?php

namespace Ryanwhowe\Dot\Exception;

use Throwable;

class InvalidDelimiterException extends DotException {

    public function __construct(string $delimiter = "", int $code = 0, ?Throwable $previous = null) {
        parent::__construct("Invalid delimiter, ryanwhowe/Dot is unable to function with the delimiter of '${delimiter}'", $code, $previous);
    }
}