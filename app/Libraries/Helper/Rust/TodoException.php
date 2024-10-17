<?php
namespace App\Libraries\Helper\Rust;

class TodoException extends PanicException {
    public function __construct($message = null) {
        if ($message !== null) {
            parent::__construct($message);
        }
        parent::__construct("TODO: Implement this method");
    }
}
