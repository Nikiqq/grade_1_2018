<?php

require_once "scripts/autorization.php";

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create entities</title>
</head>
<body>
<form action="" class="form" method="POST">
    <p class="form__item">
        <label for="contacts">Количество контактов</label>
        <input class="form__input" type="number" id="contacts" name="contacts">
    </p>
    <p class="form__item">
        <label for="companies">Количество компаний</label>
        <input class="form__input" type="number" id="companies" name="companies">
    </p>
    <p class="form__item">
        <label for="deals">Количество сделок</label>
        <input class="form__input" type="number" id="deals" name="deals">
    </p>
    <p class="form__item">
        <label for="customers">Количество покупателей</label>
        <input class="form__input" type="number" id="customers" name="customers">
    </p>
    <input type="submit">
</form>

</body>
</html>
