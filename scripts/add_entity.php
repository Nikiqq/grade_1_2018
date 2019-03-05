<?php

require_once 'app_config.php';
require_once 'autorization.php';

function add_entity($ent, $number, $ent_array_id, $number_pack = 0) {

    global $ent_array_id;
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

    $out = add_update($data, $link);
    $result = json_decode($out,TRUE);

    $ent_array_id[$ent] = $result["_embedded"]["items"][0]["id"];
}

function connect_entity($ent, $ent_array_id) {

    $data = array (
        'update' =>
            array (
                0 =>
                    array (
                        'id' => $ent_array_id[$ent],
                        'updated_at' => time()
                    ),
            ),
    );

    if($ent === "contacts") {
        $data["update"][0]["company_id"] =  $ent_array_id["companies"];
    }
    if($ent === "companies") {
        $data["update"][0]["contacts_id"][] =  $ent_array_id["contacts"];
    }
    $data["update"][0]["customers_id"][] =  $ent_array_id["customers"];
    $data["update"][0]["leads_id"][] =  $ent_array_id["leads"];

    $link = "https://nkirillov.amocrm.ru/api/v2/$ent";

    $out = add_update($data, $link);
    $result = json_decode($out,TRUE);
}

function add_update ($data, $link) {

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
    return $out;
}

if(isset($_POST["numbers"])) {
    $entities = ["contacts", "companies", "leads", "customers"];
    $number = $_POST["numbers"];
    if ($number > 0) {

        //макс число на пакет
        $max_count = 400;

        //число целых пакетов
        $pack_count = intdiv($number, $max_count);

        //число оставшихся элементов
        $pack_mod_count = $number % $max_count;

        $ent_array_id = array();

        for ($i = 0; $i < $pack_count; $i++) {
            foreach($entities as $val) {
                add_entity($val, $max_count, $ent_array_id, $i);
            }

            //связываем контакты со всеми и компании со всеми
            connect_entity("contacts", $ent_array_id);
            connect_entity("companies", $ent_array_id);
        }
        if($pack_mod_count > 0) {
            foreach($entities as $val) {
                add_entity($val, $pack_mod_count, $ent_array_id);
            }

            //связываем контакты со всеми и компании со всеми
            connect_entity("contacts", $ent_array_id);
            connect_entity("companies", $ent_array_id);
        }
        echo "Работает!";
    }
}
