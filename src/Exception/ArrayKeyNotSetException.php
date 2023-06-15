<?php

namespace Ryanwhowe\Dot\Exception;

use Throwable;

class ArrayKeyNotSetException extends DotException {

    /**
     * The arrayKey string that was requested was not found in the source array.  Missing key exceptions have to be
     * enabled in the Dot methods to have this exception be thrown.
     *
     * @param string         $arrayKey
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $arrayKey = "", int $code = 0, ?Throwable $previous = null) {
        parent::__construct("The arrayKey, '${arrayKey}' is not set in the source array.", $code, $previous);
    }
}