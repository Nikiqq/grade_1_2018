<?php

require_once 'app_config.php';
require_once 'autorization.php';

function add_entity($ent, $number, $number_pack = 0) {

    $data = array (
        'add' =>
            array (

            )
    );

    for($i = 0; $i < $number; $i++) {
        $ind_ent = $number_pack * $number + $i;
        if($ent !== "customers") {
            $data["add"][] = array('name' => "{$ent}-{$ind_ent}", );
        }
        else {
            $data["add"][] = array('name' => "{$ent}-{$ind_ent}", 'next_date' => time() + $i);
        }
    }

    $link = "https://nkirillov.amocrm.ru/api/v2/$ent";

    $headers[] = "Content-Type: application/json";

    //Curl options
    $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
    #Устанавливаем необходимые опции для сеанса cURL
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client-undefined/2.0');
    curl_setopt($curl,CURLOPT_URL,$link);
    curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($data));
    curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl,CURLOPT_HEADER,false);
    curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
    $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
    $code=curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
    curl_close($curl); #Завершаем сеанс cURL
    echo "<br>";
    $result = json_decode($out,TRUE);
}

if(isset($_POST)) {
    foreach($_POST as $key => $val) {
        if($val > 0) {
            //макс число на пакет
            $max_count = 400;
            //число целых пакетов
            $pack_count = intdiv($val, $max_count);
            echo $pack_count;
            //число оставшихся элементов
            $pack_mod_count = $val % $max_count;
            echo $pack_mod_count;
            for($i = 0; $i < $pack_count; $i ++) {
                add_entity($key, $max_count, $i);
            }
            if($pack_mod_count > 0) {
                add_entity($key, $pack_mod_count);
            }
        }
    }
}


