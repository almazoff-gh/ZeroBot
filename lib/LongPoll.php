<?php
class LongPoll{
    public function init(){
        global $Zero, $vk_api, $events;
        notify("Подключения к LongPoll");
        $data = $vk_api->groups_getLongPollServer(['group_id' => $Zero->group_id]);

        $server = $data['response']['server'];
        $key = $data['response']['key'];
        $ts = $data['response']['ts'];

        notify("LongPoll, Успешно подключено!");

        while (TRUE){
            global $object;
            $request = file_get_contents("{$server}?act=a_check&key={$key}&ts={$ts}&wait=25");
            $request = json_decode($request, 1);

            if(isset($request['failed'])){
                switch($request['failed']){
                    case 1:
                        $ts = $request['ts'];
                        break;
                    case 2:
                        $data = $vk_api->messages_getLongPollServer(['group_id' => $Zero->group_id]);
                        $key = $data['response']['key'];
                        break;
                    case 3:
                        $data = $vk_api->messages_getLongPollServer(['group_id' => $Zero->group_id]);
                        $key = $data['response']['key'];
                        $ts = $data['response']['ts'];
                        break;
                }
            }else{
                $ts = $ts + 1;
                $object = $request['updates'][0]['object'];
                $type = $request['updates'][0]['type'];

                if(isset($events[$type]))
                    $events[$type]($object, $Zero);
            }
        }
    }
}