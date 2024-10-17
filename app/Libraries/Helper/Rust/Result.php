<?php

namespace App\Libraries\Helper\Rust;

/**
 * @template Ok
 * @template Err of \Exception
 */
class Result implements \JsonSerializable
{
    /** @var Ok */
    private $ok;
    /** @var Err */
    private $err;

    public function __construct($ok, $err)
    {
        $this->ok = $ok;
        $this->err = $err;
    }

    /**
     * Unwraps the value inside the result. Panics on err
     *
     * @return Ok
     * @throws PanicException|E if the result had an error
     */
    public function unwrap()
    {
        if ($this->err !== null) {
            if ($this->err instanceof \Exception) {
                throw $this->err;
            } else {
                panic("{}", $this->err);
            }
        }
        return $this->ok;
    }

    /**
     * Returns the value inside this result or the value from $default
     * depending on if the result contains an error
     *
     * @template T
     * @param Ok|T $default
     * @return Ok|T
     */
    public function unwrap_or($default)
    {
        $value = $this->ok;
        if ($this->err !== null) {
            $value = $default;
        }
        return $value;
    }

    /**
     * Returns the error inside this result. Panics on Ok
     *
     * @return Err
     * @throws PanicException
     */
    public function unwrap_err()
    {
        if ($this->err === null) {
            panic("Expected Err on Result::unwrap_err");
        }
        return $this->err;
    }

    /**
     * Returns the value inside this result. Panics on Err with the message given
     *
     * @param ?string $err_message Message that will show up on the panic
     * @return Ok
     * @throws PanicException
     */
    public function expect($err_message = "Expected Ok on Result::expect")
    {
        if ($this->is_err()) {
            println($err_message);
        }
        return $this->unwrap();
    }

    /**
     * @return bool
     */
    public function is_ok()
    {
        return $this->err === null;
    }

    /**
     * @return Ok|null
     */
    public function get_ok()
    {
        return $this->ok;
    }

    /**
     * @return bool
     */
    public function is_err()
    {
        return $this->err !== null;
    }

    /**
     * @return Err|null
     */
    public function get_err()
    {
        return $this->err;
    }

    public function map(callable $fn)
    {
        if ($this->is_ok()) {
            return new Result($fn($this->ok), null);
        }
        return new Result(null, $this->err);
    }

    /**
     * Wraps a function call into a Result if it does not already return a
     * Result set
     * @param callable $callable
     * @return Result<Ok,Err>
     */
    public static function wrap($callable)
    {
        $ok = null;
        $err = null;
        try {
            $ok = $callable();
            if ($ok instanceof Result) {
                return $ok;
            }
        } catch (\Exception $error) {
            $err = $error;
        }
        return new Result($ok, $err);
    }

    /**
     * @param Err|string $err
     * @return Result<null, Err>
     */
    public static function err($err)
    {
        if ($err instanceof \Exception) {
            return new Result(null, $err);
        } else {
            return new Result(null, new PanicException($err));
        }
    }

    /**
     * @param Ok $ok
     * @return Result<Ok, null>
     */
    public static function ok($ok = "ok")
    {
        return new Result($ok, null);
    }

    public function jsonSerialize(): mixed
    {
        if ($this->is_ok()) {
            return $this->ok;
        }
        return $this->err;
    }
}
