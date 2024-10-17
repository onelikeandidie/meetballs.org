<?php

if (!function_exists('format')) {
    /**
     * Formats a string with arguments
     *
     * Example usage:
     * ```
     * format("Missing file: {}", $path);
     * // or
     * format("Button count: {}, Quota of {} not reached", $count, $required);
     * ```
     *
     * @param string $format
     * @param mixed ...$args
     * @return string
     */
    function format(string $format, $args = null) {
        $num_args = func_num_args();
        if ($num_args === 0) panic("Not enough args passed to format! {} given", $num_args);
        $args = func_get_args();
        // String to output
        $args = new ArrayObject($args);
        $args = $args->getIterator();
        $format = $args->current();
        if (!is_string($format)) panic("Output format was not a string, {} given", gettype($format));
        $args->next();
        while ($args->valid()) {
            $arg = $args->current();
            $placeholder_pos = strpos($format, "{}");
            if ($placeholder_pos !== false) {
                // If the argument is an array or object, convert it to a string
                if (is_array($arg) || is_object($arg)) {
                    $arg = json_encode($arg);
                }
                $format = substr_replace($format, $arg, $placeholder_pos, strlen("{}"));
            }
            $args->next();
        }
        return $format;
    }
}

if (!function_exists('panic')) {
    /**
     * Throws an error, with formatting
     *
     * Example usage:
     * ```
     * panic("Missing file: {}", $path);
     * // or
     * panic("Button count: {}, Quota of {} not reached", $count, $required);
     * ```
     *
     * @param string $format
     * @param mixed ...$args
     * @throws App\Libraries\Helper\Rust\PanicException
     * @return void
     */
    function panic(string $format, $args = null) {
        $func_args = func_get_args();
        $str = format(...$func_args);
        unset($func_args);
        throw new App\Libraries\Helper\Rust\PanicException($str, 1);
    }
}

if (!function_exists('todo')) {
    /**
     * Shorthand for panic("Not Implemented")
     *
     * @param string $message
     * @param mixed ...$args
     * @throws App\Libraries\Helper\Rust\TodoException
     * @return void
     */
    function todo(string $message = null) {
        if ($message !== null) {
            $func_args = func_get_args();
            // Basically, call panic to format not implemented with a formatted
            // message
            throw new App\Libraries\Helper\Rust\TodoException(
                format("Not Implemented. {}", format(...$func_args)));
        }
        throw new App\Libraries\Helper\Rust\TodoException(format("Not Implemented"));
    }
}

if (!function_exists('ok')) {
    /**
     * Creates a new Ok result
     *
     * @param mixed $value
     * @return App\Libraries\Helper\Rust\Result
     */
    function ok($value = null) {
        return App\Libraries\Helper\Rust\Result::ok($value);
    }
}

if (!function_exists('err')) {
    /**
     * Creates a new Err result
     *
     * @param \Exception|string $error
     * @return App\Libraries\Helper\Rust\Result
     */
    function err($error) {
        return App\Libraries\Helper\Rust\Result::err($error);
    }
}

if (!function_exists('println')) {
    /**
     * Prints a line to the console
     *
     * @param string $format
     * @param mixed ...$args
     * @return void
     */
    function println(string $format, $args = null) {
        $func_args = func_get_args();
        $str = format(...$func_args);
        unset($func_args);
        // Check if php is running in a web server
        if (php_sapi_name() === 'cli') {
            echo $str . PHP_EOL;
        } else {
            echo $str . "<br>";
        }
    }
}
