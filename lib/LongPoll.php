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

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "{$server}?act=a_check&key={$key}&ts={$ts}&wait=25");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $request = curl_exec($ch);
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
                if(isset($request['updates'][0]['type'])) {
                    $object = $request['updates'][0]['object'];
                    $type = $request['updates'][0]['type'];
                    if(isset($events[$type]))
                        $events[$type]($object, $Zero);
                }
            }
            curl_close($ch);
        }
    }
}