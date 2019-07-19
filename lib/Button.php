<?php
define('COLOR_RED', 'negative');
define('COLOR_GREEN', 'positive');
define('COLOR_BLUE', 'primary');
define('COLOR_WHITE', 'secondary');

class Button{
    function btn_send($text, $one_time, $date){
        global $vk_api, $object;
        $btn = [
            'one_time' => $one_time,
            'buttons' => $date
        ];
        $vk_api->messages_send(['peer_id' => $object['peer_id'], 'random_id' => 0, 'message' => $text, 'keyboard' => json_encode($btn)]);
    }
    function btn($payload, $text, $color){
        return [
            'action' => [
                'type' => 'text',
                'payload' => '{"button": "'.$payload.'"}',
                'label' => $text,
            ],
            'color' => $color
        ];
    }
    function btn_app($payload, $app_id, $owner_id, $text){
        return [
            'action' => [
                'type' => 'open_app',
                'app_id' => $app_id,
                'owner_id' => $owner_id,
                'hash' => 'sendKeyboard',
                'label' => $text,
                'payload' => '{"button": "'.$payload.'"}',
            ]
        ];
    }
    function btn_loc($payload){
        return [
            'action' => [
                'type' => 'location',
                'payload' => '{"button": "'.$payload.'"}',
            ]
        ];
    }
    function btn_pay($payload, $hash){
        return [
            'action' => [
                'type' => 'vkpay',
                'payload' => '{"button": "'.$payload.'"}',
                'hash' => $hash
            ]
        ];
    }
    function btn_clear(){
        global $vk_api, $object;
        $btn = [
            'one_time' => true,
            'buttons' => []
        ];
        $vk_api->messages_send(['peer_id' => $object['peer_id'], 'random_id' => 0, 'keyboard' => json_encode($btn)]);
    }
}
