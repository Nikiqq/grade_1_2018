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
    <form action="" class="form form-entity" method="POST">
        <p class="form-entity__item">
            <label for="numbers">Количество сущностей</label>
            <input class="form-entity__input" type="number" id="numbers" name="numbers">
        </p>
        <input type="submit" value="Создать" class="form-entity__submit">
    </form>

    <form action="" class="form form-text" method="POST">
        <p class="form-text__item">
            <label for="numbers_text_field">Добавить текстовое поле к сущности (id)</label>
            <input class="form-text__input" type="number" id="numbers_text_field" name="numbers_text_field">
        </p>
        <input type="submit" value="Добавить" class="form-text__submit">
    </form>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
