<?php

namespace app\helpers;

use yii\base\Controller;

Class MyHelper extends Controller 
{
    public static function checkLink($url) 
    {
        $ch = curl_init();

        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_MAXREDIRS      => 10,
        );
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            $httpCode = curl_error($ch);
        }
        
        curl_close($ch);
        return [
            'httpCode' => $httpCode,
            'response' => $response
        ];
    }
}