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
    global $array_contacts_id;
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

    if($ent === "contacts") {
        foreach($result["_embedded"]["items"] as $val) {
            $array_contacts_id[] = $val["id"];
        }
    }
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

function set_multi_select($selector_id, $number, $array_key_selector, $array_contacts, $number_pack, $max_count) {
    $data = array (
        'update' =>
            array (

            ),
    );

    for($i = 0; $i < $number; $i++) {
        $ind_ent = $number_pack * $max_count + $i;
        $data["update"][$i]["id"] = $array_contacts[$ind_ent];
        $data["update"][$i]["updated_at"] = (time() + $i + 100000);
        $data["update"][$i]["custom_fields"][0]["id"] = $selector_id;
        $count = mt_rand (0 , 9);
        $values = array();
        for($j = 0; $j < $count; $j ++) {
            $values[] = $array_key_selector[mt_rand(0, 9)];
        }
        $data["update"][$i]["custom_fields"][0]["values"] = $values;
    }


    $link = "https://nkirillov.amocrm.ru/api/v2/contacts";
    $out = get_post_query($link, $data);
    $result = json_decode($out,TRUE);
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

//обработка 1 пункта
if(isset($_POST["numbers"]) && !empty($_POST["numbers"])) {
    //макс число на пакет
    $max_count = 500;

    //массив для хранения id контактов
    $array_contacts_id = array();

    //массив сущностей
    $entities = ["contacts", "companies", "leads", "customers"];

    //число в инпуте
    $number = $_POST["numbers"];
    if ($number > 0) {

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

    //создаем поле, или просто получаем его id
    $multi_select_id = add_fields("test", "5", "1", "12345");

    //берем id значение в мультиселекте
    $link = 'https://nkirillov.amocrm.ru/api/v2/account?with=custom_fields';
    $out = get_post_query($link);
    $result = json_decode($out,TRUE);
    $array_multi_select = ($result["_embedded"]["custom_fields"]["contacts"][$multi_select_id]["enums"]);
    $array_key_multi_select = array();
    foreach($array_multi_select as $key => $val) {
        $array_key_multi_select[] = $key;
    }

    //число контактов (хотя конечно лучше написать функцию, потому что контакты уже могут быть и число будет неверное..)
    $num_contacts = count($array_contacts_id);

    //число целых пакетов
    $pack_count = intdiv($num_contacts, $max_count);

    //число оставшихся элементов
    $pack_mod_count = $num_contacts % $max_count;

    for ($i = 0; $i < $pack_count + 1; $i++) {
        //если целый пакет, то передаем макс возможное число данных
        $num_ent = $max_count;
        //если последняя итерация, то передаем остаток пакета
        if($i === $pack_count && $pack_mod_count > 0) {
            $num_ent = $pack_mod_count;
        }
        set_multi_select($multi_select_id, $num_ent, $array_key_multi_select, $array_contacts_id, $i, $max_count);
    }
}

//обработка 2 пункта
if(isset($_POST["numbers_text_field"]) && !empty($_POST["numbers_text_field"])) {
    $ent_id = $_POST["numbers_text_field"];
    $name = 'my_text_field';
    $field_type = 1; //TEXT FIELD
    $field_id = 'my_text_field'; // id my_text_field
}
