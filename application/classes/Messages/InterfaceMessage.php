<?php

namespace Messages;

interface InterfaceMessage {
    public function __construct(string $message, string $message_type);

    public function __toString(): string ;
}