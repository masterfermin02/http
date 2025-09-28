<?php

namespace Http;

use Exception;

class MissingRequestMetaVariableException extends Exception
{
    public function __construct($variableName, ?int $code, ?Exception $previous) {
        $message = "Request meta-variable $variableName was not set.";
        $code ??= 0;

        parent::__construct($message, $code, $previous);
    }
}
