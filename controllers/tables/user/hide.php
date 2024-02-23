<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

if(isset($_POST['id'])){
    $id = $_POST['id'];
    dbQuery("UPDATE users SET visible = 0 WHERE id = $id");
    header('Location:/medewerkers');
}

