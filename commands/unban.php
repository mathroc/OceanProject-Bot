<?php

$unban = function ($who, $message, $type) {

    $bot = actionAPI::getBot();

    if (!isset($message[1]) || empty($message[1])) {
        if ($type == 1) {
            $type = 2;
        }
        
        return $bot->network->sendMessageAutoDetection($who, 'Usage: !unban [regname/xatid]', $type);
    }

    if (is_numeric($message[1]) && isset($bot->users[$message[1]])) {
        $user = $bot->users[$message[1]];
    } else {
        foreach ($bot->users as $id => $object) {
            if (is_object($object)) {
                if (strtolower($object->getRegname()) == strtolower($message[1])) {
                    $user = $object;
                    break;
                }
            }
        }
    }

    if (isset($user)) {
        $bot->network->unban($user->getID());
    } else {
        $bot->network->sendMessageAutoDetection($who, 'That user is not here', $type);
    }
};
