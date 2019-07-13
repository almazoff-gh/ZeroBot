<?php

class VK_API
{

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function __call($method, $args = [])
    {
        $method = str_ireplace("_", ".", $method);
        while (true) {

            if (isset($args[0])) $args = $args[0];
            $args['v'] = '5.100';
            if (!isset($args['access_token'])) $args['access_token'] = $this->token;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.vk.com/method/' . $method);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));

            $result = json_decode(curl_exec($ch), true);

            if (!is_array($result)) continue;
            return $result;
        }
    }

}

