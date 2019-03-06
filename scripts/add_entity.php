<?php

require_once 'app_config.php';
require_once 'autorization.php';

function add_fields ($name, $field_type, $ent_id, $field_id) {

    //проверка на наличие уже такого поля
    $link = 'https://nkirillov.amocrm.ru/api/v2/account?with=custom_fields';
    $out = get_post_query($link);
    $result = json_decode($out,TRUE);

    foreach($result["_embedded"]["custom_fields"]["contacts"] as $key => $val) {
        if($val["name"] === $name) {
            return $val["id"];
        }
    };

    //если такого поля еще не создавали
    $enum = array();
    for($i = 0; $i < 10; $i++) {
        $enum[$i] = "Значение-$i";
    }

    $data = array (
        'add' =>
            array (
                0 =>
                    array (
                        'name' => $name,
                        'type' => $field_type,
                        'element_type' => $ent_id,
                        'origin' => $field_id,
                        'enums' => $enum,
                    ),
            ),
    );

    $link = "https://nkirillov.amocrm.ru/api/v2/fields";

    $out = get_post_query($link, $data);
    $result = json_decode($out,TRUE);
    return $result["_embedded"]["items"][0]["id"];
}

function add_entity($ent, $number, $ent_array_id, $number_pack, $max_count) {

    global $ent_array_id;
    $data = array (
        'add' =>
            array (

            )
    );

    for($i = 0; $i < $number; $i++) {
        $ind_ent = $number_pack * $max_count + $i;
        if($ent !== "customers") {
            $data["add"][] = array('name' => "{$ent}-{$ind_ent}", );
        }
        else {
            $data["add"][] = array('name' => "{$ent}-{$ind_ent}", 'next_date' => time() + $i);
        }
    }

    $link = "https://nkirillov.amocrm.ru/api/v2/$ent";

    $out = get_post_query($link, $data);
    $result = json_decode($out,TRUE);

    $ent_array_id[$ent] = $result["_embedded"]["items"];
}

function connect_entity($ent, $number, $ent_array_id, $number_pack, $max_count) {

    $data = array (
        'update' =>
            array (

            ),
    );

    for($i = 0; $i < $number; $i++) {
        $ind_ent = $number_pack * $max_count + $i;
        $data["update"][$ind_ent]["id"] =  $ent_array_id[$ent][$i]["id"];
        $data["update"][$ind_ent]["updated_at"] =  time() + $ind_ent;

        if($ent === "contacts") {
            $data["update"][$ind_ent]["company_id"] =  $ent_array_id["companies"][$i]["id"];
        }
        if($ent === "companies") {
            $data["update"][$ind_ent]["contacts_id"][] =  $ent_array_id["contacts"][$i]["id"];
        }
        $data["update"][$ind_ent]["customers_id"][] =  $ent_array_id["customers"][$i]["id"];
        $data["update"][$ind_ent]["leads_id"][] =  $ent_array_id["leads"][$i]["id"];
    }

    $link = "https://nkirillov.amocrm.ru/api/v2/$ent";

    $out = get_post_query($link, $data);
}

function get_post_query ($link, $data = 0) {

    $headers[] = "Content-Type: application/json";

    //Curl options
    $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
    #Устанавливаем необходимые опции для сеанса cURL
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client-undefined/2.0');
    curl_setopt($curl,CURLOPT_URL,$link);
    if($data) {
        curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($data));
    }
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
        $max_count = 200;

        //число целых пакетов
        $pack_count = intdiv($number, $max_count);

        //число оставшихся элементов
        $pack_mod_count = $number % $max_count;

        //массив id сущностей , которые были созданы в пакете
        $ent_array_id = array();

        for ($i = 0; $i < $pack_count + 1; $i++) {
            //если целый пакет, то передаем макс возможное число данных
            $num_ent = $max_count;
            //если последняя итерация, то передаем остаток пакета
            if($i === $pack_count && $pack_mod_count > 0) {
                $num_ent = $pack_mod_count;
            }
            //для каждой сущности создаем указанное число
            foreach($entities as $val) {
                add_entity($val, $num_ent, $ent_array_id, $i, $max_count);
            }

            //связываем контакты со всеми и компании со всеми
            connect_entity("contacts", $num_ent, $ent_array_id, $i, $max_count);
            connect_entity("companies", $num_ent, $ent_array_id, $i, $max_count);
        }

        echo "Работает!";
    }

    $multi_select_id = add_fields("test", "5", "1", "12345");

    $link = 'https://nkirillov.amocrm.ru/api/v2/account?with=custom_fields';
    $out = get_post_query($link);
    $result = json_decode($out,TRUE);
    $array_multi_select = ($result["_embedded"]["custom_fields"]["contacts"][$multi_select_id]["enums"]);
    $array_key_multi_select = array();
    foreach($array_multi_select as $key => $val) {
        $array_key_multi_select[] = $key;
    }


    $link = 'https://nkirillov.amocrm.ru/api/v2/contacts/';
    $out = get_post_query($link);
    $result = json_decode($out,TRUE);

    $data = array (
        'update' =>
            array (

            ),
    );
    $i = 0;
    foreach($result["_embedded"]["items"] as $key => $val) {
        $data["update"][$i]["id"] = $val["id"];
        $data["update"][$i]["updated_at"] = time() + $i;
        $data["update"][$i]["custom_fields"][0]["id"] = $multi_select_id;
        $count = mt_rand (0 , 9);
        $values = array();
        for($j = 0; $j < $count; $j ++) {
            $values[] = $array_key_multi_select[mt_rand(0, 9)];
        }
        $data["update"][$i]["custom_fields"][0]["values"] = $values;
        $i++;
    }

    $link = "https://nkirillov.amocrm.ru/api/v2/contacts";
    $out = get_post_query($link, $data);
    $result = json_decode($out,TRUE);
    print_r($result);

}
