<?php
define('COLOR_RED', 'negative');
define('COLOR_GREEN', 'positive');
define('COLOR_BLUE', 'primary');
define('COLOR_WHITE', 'secondary');

class Button{
    function sendbtn($text, $one_time, $date){
        global $vk_api, $object;
        $btn = [
            'one_time' => $one_time,
            'buttons' => $date
        ];
        $vk_api->messages_send(['peer_id' => $object['peer_id'], 'random_id' => 0, 'message' => $text, 'keyboard' => json_encode($btn)]);
    }
    function getbtn($payload, $color, $text){
        return [
            'action' => [
                'type' => 'text',
                'payload' => '{"button": "'.$payload.'"}',
                'label' => $text,
            ],
            'color' => $color
        ];
    }
    function clearbtn(){
        global $vk_api, $object;
        $btn = [
            'one_time' => true,
            'buttons' => []
        ];
        $vk_api->messages_send(['peer_id' => $object['peer_id'], 'random_id' => 0, 'keyboard' => json_encode($btn)]);
    }
}
