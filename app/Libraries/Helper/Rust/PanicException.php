<?php
namespace App\Libraries\Helper\Rust;

class PanicException extends \Exception implements \JsonSerializable {
    // When this error is saved to database, instead save the message
    public function __toString() {
        return $this->message;
    }
    // When this error is json encoded, instead save the message
    public function jsonSerialize() {
        return $this->message;
    }
}
