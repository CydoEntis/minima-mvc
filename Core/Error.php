<?php

namespace Core;

class Error
{

  /**
   * Convert all errors to Exceptions by throwing an ErrorException.
   *
   * @param int $level
   * @param string $message
   * @param string $file
   * @param int $line
   * @return void
   */
  public static function errorHandler(int $level, string $message, string $file, int $line)
  {
    if (error_reporting() !== 0) {
      throw new \ErrorException($message, 0, $level, $file, $line);
    }
  }

  /**
   * Exception Handler
   *  
   * @param Exception $exception
   * @return void
   */
  public static function exceptionHandler($exception)
  {
    echo "<h1>Fatal Error</h1>";
    echo "<p>Uncaught exception: '" . get_class($exception) . "' </p>";
    echo "<p>Message: '" . $exception->getMessage() . "'</p>";
    echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
    echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
  }
}
