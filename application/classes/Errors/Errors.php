<?php

namespace Errors;

class Errors {
    private $_errors = [];

    public function __construct(array $errors = [])
    {
        $this->_errors = $errors;
    }

    /**
     * Output formatted error message
     * @param string $key
     * @return string
     */
    public function get(string $key): string
    {
        return (
            ! empty($this->_errors[$key]) ?
            "<p class='invalid-feedback'>{$this->_errors[$key]}</p>" :
            ''
        );
    }
}