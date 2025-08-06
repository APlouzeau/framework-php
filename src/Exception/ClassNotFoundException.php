<?php

namespace EyoPHP\Framework\Exception;

use Exception;
use Throwable;

/**
 * Exception thrown when a class cannot be found by the autoloader
 *
 * @package EyoPHP\Framework\Exception
 * @author  Alexandre PLOUZEAU
 * @version 2.0.0
 */
class ClassNotFoundException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
