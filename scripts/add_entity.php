<?php

require_once 'app_config.php';
require_once 'autorization.php';

function add_entity($ent) {
    $data = array (
        'add' =>
            array (
                0 =>
                    array (
                        'name' => 'new_lead',
                    ),
            ),
    );

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
    echo "<br>";
    var_dump($result);
}

//add_entity("leads");

//if(isset($_POST["contacts"]) && !empty($_POST["contacts"])) {
//    echo "Все окей";
//}
//else {
//    echo "Блять, кривой!";
//}

