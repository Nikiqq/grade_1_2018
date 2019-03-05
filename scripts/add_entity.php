<?php

require_once "autorization.php";

if(isset($_POST["contacts"]) && !empty($_POST["contacts"])) {
    echo "Все окей";
}
else {
    echo "Блять, кривой!";
}
