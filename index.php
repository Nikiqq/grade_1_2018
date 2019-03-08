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
        <p class="form__item">
            <label for="number_entities">Количество сущностей</label>
            <input class="form__input" type="number" id="number_entities" name="number_entities" required min="1" max="10000">
        </p>
        <input type="submit" value="Создать" class="form__submit">
    </form>
    <hr>

    <form action="" class="form form-text" method="POST">
        <p class="form__item">
            <label for="text_field_element_id">Элемент сущности (id)</label>
            <input class="form__input" type="number" id="text_field_element_id" name="text_field_element_id" required>
        </p>
        <p class="form__item">
            <label for="text_field_ent_id">Сущность (id)</label>
            <input class="form__input" type="number" id="text_field_ent_id" name="text_field_ent_id" required>
        </p>
        <p class="form__item">
            <label for="text_field_text">Текст</label>
            <input class="form__input" type="text" id="text_field_text" name="text_field_text" required>
        </p>
        <input type="submit" value="Добавить" class="form__submit">
    </form>
    <hr>

    <form action="" class="form form-note" method="POST">
        <p class="form__item">
            <label for="note_element_id">Элемент сущности (id)</label>
            <input class="form__input" type="number" id="note_element_id" name="note_element_id" required>
        </p>
        <p class="form__item">
            <label for="note_ent_id">Сущность (id)</label>
            <input class="form__input" type="number" id="note_ent_id" name="note_ent_id" required>
        </p>
        <p class="form__item">
            <label for="note_list">Тип примечания</label>
            <select class="form__select select" id="note_list" name="note_list" required>
                <option class="select__item" value="4">Обычное примечание</option>
                <option class="select__item" value="10">Входящий звонок</option>
            </select>
        </p>
        <p class="form__item">
            <label for="note_text">Текст примечания</label>
            <input class="form__input" type="text" id="note_text" name="note_text" required>
        </p>
        <input type="submit" value="Добавить" class="form__submit">
    </form>
    <hr>

    <form action="" class="form form-task" method="POST">
        <p class="form__item">
            <label for="task_element_id">Элемент сущности (id)</label>
            <input class="form__input" type="number" id="task_element_id" name="task_element_id" required>
        </p>
        <p class="form__item">
            <label for="task_ent_id">Сущность (id)</label>
            <input class="form__input" type="number" id="task_ent_id" name="task_ent_id" required>
        </p>
        <p class="form__item">
            <label for="task_date">Дата завершения</label>
            <input class="form__input" type="datetime-local" id="task_date" name="task_date" required>
        </p>
        <p class="form__item">
            <label for="task_text">Текст задачи</label>
            <input class="form__input" type="text" id="task_text" name="task_text" required>
        </p>
        <p class="form__item">
            <label for="task_responsible_id">ID ответственного</label>
            <input class="form__input" type="number" id="task_responsible_id" name="task_responsible_id" value="24971143" required>
        </p>
        <input type="submit" value="Добавить" class="form__submit">
    </form>
    <hr>

    <form action="" class="form form-task-end">
        <p class="form__item">
            <label for="task_end_id">ID задачи</label>
            <input class="form__input" type="number" id="task_end_id" name="task_end_id" required>
        </p>
        <input type="submit" value="Завершить задачу" class="form__submit">
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
