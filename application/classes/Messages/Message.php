<?php

namespace Messages;

use \View\BS;

class Message implements InterfaceMessage {
    private $_message = '';

    private $_message_type = '';

    public function __construct(string $message, string $message_type = BS::SUCCESS)
    {
        $this->_message = $message;
        $this->_message_type = $message_type;
    }

    /**
     * Prepare user-friendly message
     * @return string
     */
    public function __toString(): string
    {
        return $this->_message ?
            "<div class='alert alert-{$this->_message_type}'>{$this->_message}</div>" :
            '';
    }
}