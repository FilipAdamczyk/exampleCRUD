<?php

namespace Messages;

interface InterfaceMessageHandler {

    public static function save(string $message, string $message_type = 'success'): void;

    public static function get(): ?InterfaceMessage;
}