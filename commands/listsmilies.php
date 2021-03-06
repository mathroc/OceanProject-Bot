<?php

$listsmilies = function ($who, $message, $type) {

    $bot = actionAPI::getBot();

    if (!isset($message[1]) || empty($message[1])) {
        return $bot->network->sendMessageAutoDetection($who, 'Usage: !listsmilies [power/latest]', $type);
    }
    
    $powers = xatVariables::getPowers();
    
    if (strtolower($message[1]) == 'latest') {
        $message[1] = end($powers)['name'];
    }
    
    $message[1] = str_replace(['(', ')'], '', $message[1]);
    foreach ($powers as $id => $array) {
        if ($array['name'] == strtolower($message[1]) || $id == $message[1]) {
            $exist = true;
            break;
        }
    }
    
    if ($exist) {
        if (!empty($array['smilies'])) {
            $topsh = $array['smilies'];
            if (count($topsh) > 10) {
                $res = '('.implode('#)(', array_slice($topsh, 0, 10)).'#) ' . implode(' ', array_slice($topsh, 10));
                $bot->network->sendMessageAutoDetection($who, ucfirst($array['name']) . '\'s ' . count($topsh) . ' smilies: ' . $res . '.', $type);
            } else {
                $bot->network->sendMessageAutoDetection($who, ucfirst($array['name']) . '\'s ' . count($topsh) . ' smilies: (' . implode('#)(', $topsh) . '#).', $type);
            }
        } else {
            $bot->network->sendMessageAutoDetection($who, ucfirst($array['name']) . ' currently dosen\'t have smilies', $type);
        }
    } else {
        $bot->network->sendMessageAutoDetection($who, '_' . $message[1] . ' is not a power.', $type);
    }
};
