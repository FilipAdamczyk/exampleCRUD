<?php

/**
 * Class dedicated to managing storage and retrieval of messages for the user.
 */

namespace Messages;

use \Session;
use \View\BS;

class MessageHandler implements InterfaceMessageHandler {

    private const MESSAGE_SESSION_KEY = 'message';

    public static function save(string $message, string $message_type = BS::SUCCESS): void
    {
        Session::instance()->set(self::MESSAGE_SESSION_KEY, new Message($message, $message_type));
    }

    public static  function get(): ?InterfaceMessage
    {
        return Session::instance()->get_once(self::MESSAGE_SESSION_KEY);
    }
}