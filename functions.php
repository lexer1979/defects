<?php
session_start();
$_SESSION["login"] = 'admin';

//header("Location: /");

/*
    require_once "oop/database_class.php";
    require_once "oop/manage_class.php";

    $db = new DataBase();
    $manage = new Manage($db);
    if ($_POST["reg"]){
        $r=$manage->regUser();
    }
    elseif ($_POST["auth"]){
        $r=$manage->login();
    }
    elseif ($_GET["logout"]){
        $r=$manage->logout();
    }
    else exit;

    $manage->redirect($r);
*/

?>