<?php
require('lib/Colors.php');
require('lib/functions.php');
require('lib/vk_api.php');
require('lib/LongPoll.php');
require('lib/CommandManager.php');

if(php_sapi_name() != 'cli') die('Запускай меня через консоль!');

class Zero{
    function __construct($token){
        global $vk_api, $count;
        $this->v = '0.1';
        notify("Запуск ZeroBot v{$this->v}...");
        $this->token = $token;
        $vk_api = new VK_API($token);
        $this->check_token(); //Проверка на валидацию токена
        $CommandManager = new CommandManager();
        $CommandManager->start();
        notify("CommandManager, Подключено ".$count);
        $this->longpoll = new LongPoll();
    }

    function check_token(){
        global $vk_api;
        $date = $vk_api->groups_getById();
        if($date['error']['error_code'] == 5)
            die("Неверный токен!\n");
        else
            $this->group_id = $date['response'][0]['id'];
    }

    function user(){
        global $vk_api, $object;
        $user = $vk_api->users_get(['user_ids' => $object['from_id']]);
        if(isset($user['response'][0]['id']))
            return $user['response'][0];
    }

    function reply($text){
        global $vk_api, $object;
        $vk_api->messages_send(['peer_id' => $object['peer_id'], 'random_id' => 0, 'reply_to' => $object['id'], 'message' => $text]);
    }

    function send($text){
        global $vk_api, $object;
        $vk_api->messages_send(['peer_id' => $object['peer_id'], 'random_id' => 0, 'message' => $text]);
    }
}