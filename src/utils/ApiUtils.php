<?php

namespace Utils;

class ApiUtils
{
    public static function consumeAPI($data)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $data['URL'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'User-Agent: thiagonovaes'
            ]
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}