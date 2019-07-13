<?php
require("lib/Zero.php");

$token = ''; //Токен Сообщества

//Список эвентов таких как получения сообщения, отписка и подписка и тд.

$events = [
    'message_new' => function($object, $Zero){
        global $cmds;
        foreach ($cmds as $cmd){
            if(preg_match_all($cmd['r'], $object['text'], $params, PREG_SET_ORDER)){
                $cmd['f']($Zero, $Zero->user(), $params[0]);
            }
        }
    }
];

$Zero = new Zero($token);
$Zero->longpoll->init();