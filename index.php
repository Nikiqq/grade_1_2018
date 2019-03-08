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
    <hr>

    <form action="" class="form form-text" method="POST">
        <p class="form-text__item">
            <label for="numbers_text_field_element_id">Элемент сущности (id)</label>
            <input class="form-text__input" type="number" id="numbers_text_field_element_id" name="numbers_text_field_element_id">
        </p>
        <p class="form-text__item">
            <label for="numbers_text_field_ent_id">Сущность (id)</label>
            <input class="form-text__input" type="number" id="numbers_text_field_ent_id" name="numbers_text_field_ent_id">
        </p>
        <p class="form-text__item">
            <label for="numbers_text_field_text">Текст</label>
            <input class="form-text__input" type="text" id="numbers_text_field_text" name="numbers_text_field_text">
        </p>
        <input type="submit" value="Добавить" class="form-text__submit">
    </form>
    <hr>

    <form action="" class="form form-note" method="POST">
        <p class="form-note__item">
            <label for="add_note_field_element">Элемент сущности (id)</label>
            <input class="form-note__input" type="number" id="add_note_field_element" name="add_note_field_element">
        </p>
        <p class="form-note__item">
            <label for="add_note_field_ent_id">Сущность (id)</label>
            <input class="form-note__input" type="number" id="add_note_field_ent_id" name="add_note_field_ent_id">
        </p>
        <p class="form-note__item">
            <label for="add_note_field_list">Тип примечания</label>
            <select class="form-note__select select" id="add_note_field_list" name="add_note_field_list">
                <option class="select__item" value="4">Обычное примечание</option>
                <option class="select__item" value="10">Входящий звонок</option>
            </select>
        </p>
        <p class="form-note__item">
            <label for="add_note_field_text">Текст примечания</label>
            <input class="form-note__input" type="text" id="add_note_field_text" name="add_note_field_text">
        </p>
        <input type="submit" value="Добавить" class="form-note__submit">
    </form>
    <hr>

    <form action="" class="form form-task" method="POST">
        <p class="form-task__item">
            <label for="add_task_element">Элемент сущности (id)</label>
            <input class="form-task__input" type="number" id="add_task_element" name="add_task_element">
        </p>
        <p class="form-task__item">
            <label for="add_task_ent_id">Сущность (id)</label>
            <input class="form-task__input" type="number" id="add_task_ent_id" name="add_task_ent_id">
        </p>
        <p class="form-task__item">
            <label for="add_task_date">Дата завершения)</label>
            <input class="form-task__input" type="datetime-local" id="add_task_date" name="add_task_date">
        </p>
        <p class="form-task__item">
            <label for="add_task_text">Текст задачи</label>
            <input class="form-task__input" type="text" id="add_task_text" name="add_task_text">
        </p>
        <p class="form-task__item">
            <label for="add_task_responsible_id">ID ответственного</label>
            <input class="form-task__input" type="number" id="add_task_responsible_id" name="add_task_responsible_id">
        </p>
        <input type="submit" value="Добавить" class="form-task__submit">
    </form>
    <hr>

    <form action="" class="form form-task-end">
        <p class="form-task-end__item">
            <label for="add_task_end_id">ID задачи</label>
            <input class="form-task-end__input" type="number" id="add_task_end_id" name="add_task_end_id">
        </p>
        <input type="submit" value="Завершить задачу">
    </form>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
