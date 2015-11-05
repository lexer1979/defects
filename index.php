<?php
mb_internal_encoding("UTF-8");
session_start();

require_once "oop/database_class.php";
require_once "oop/manage_class.php";

$db = new DataBase();
$manager = new Manage($db);

if ($_REQUEST["logout"]){
    $manager->logout();
    header("Location: /");
    exit;

}

unset($error_auth);
if ($_SESSION["error_auth"]) {
    $error_auth = 1;
    session_destroy();
}
if ($_POST["auth"]) {
    header("Location: ".$manager->login());
    exit;
}

$login = $_COOKIE["login"];
if (!isset($login))
    $login = $manager->user_info["login"];
$login = trim($login);
$password = $manager->user_info["password"];
?>
<?php if(!$manager->user_info) { ?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Авторизация | Статистика неисправностей оборудования</title>
    <link rel="stylesheet" href="css/style.css"">
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#b_close_alert").on("click", function(){
                $("#blackout").fadeOut(100);
                $("#alert").fadeOut(250);
                var l = $("input[name=login]");
                if (l.val().trim() == "") l.focus().select();
                else $("input[name=password]").focus();
            });

            $("#fauth").submit(function(e){
                //e.preventDefault();
                $.cookie('login', $("input[name=login]").val().trim());
            });
            $(window).on("onunload", function(){
                $.cookie('PHPSESSID', null);
                //$.cookie('login', null);
            });


        });
    </script>

</head>
<body>
<div id="logo"></div>
<?php if($error_auth) { ?>
<div id="blackout"></div>
<?php } ?>
<section class="container">
<?php if($error_auth) { ?>
    <div id="alert">
        <p class="info"">Неправильное имя пользователя и/или пароль!</p>
        <p class="ok"><input id="b_close_alert" type="button" value="OK"></p>
    </div>
<?php } ?>
    <div class="login">
        <h1>Авторизация</h1>
        <form id="fauth" name="form_auth" method="post" action="/" enctype="application/x-www-form-urlencoded">
            <p><input type="text" name="login" value="<?=$login?>" placeholder="Логин" pattern="[а-яА-Яa-zA-Z0-9\. ]+" autocomplete="on" required ></p>
            <p><input type="password" name="password" value="<?=$password?>" placeholder="Пароль" required></p>
            <p class="submit"><input type="submit" value="Войти"></p>
            <input type="hidden" name="auth" value="1">
        </form>
    </div>
</section>
</body>
</html>
<?php exit; } ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Статистика неисправностей оборудования</title>
    <link rel="stylesheet" href="css/main.css">
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".tdata tr").click(function(){
                if (!$(this).hasClass('rsel')) {
                    $(".tdata tr").removeClass("rsel");
                    $(this).addClass('rsel');
                }
                var $d = $(".rsel td:first+td").text();
                $d = $d.substr(-4) + "-" + $d.substr(3,2) +"-"+$d.substr(0,2);
                $("#fdate").val($d);
            });

            $("input[type=radio]").click(function(){
                if ($(this).val()==1) {
                    $("input:not([type=radio])").prop('readonly', true);
                    $("button").prop('disabled', true);
                } else {
                    $("button").removeProp('disabled');
                }
            });
            $("#newRow").click(function(e){
                $("#add_dialog").fadeIn(100);
                e.preventDefault();
            });
            $("#insRow").click(function(e){
                $("input[name=method]").val("ins");
                $("#add_dialog .add_dialog h2").text("Добавление неисправности");
                $("#add_dialog").fadeIn(100);
                e.preventDefault();
            });
            $("#updRow").click(function(e){
                $("input[name=method]").val("upd");
                $("#add_dialog .add_dialog h2").text("Изменение неисправности");
                $("#add_dialog").fadeIn(100);
                e.preventDefault();
            });

            $("form[name=form_add] .cancel").click(function(e){
                $("#add_dialog").fadeOut(100);
                e.preventDefault();
            });

            $(window).on("onunload", function(){
                $.cookie('PHPSESSID', null);
                //$.cookie('login', null);
            });

        });
    </script>
</head>
<body>
<div id="container">
    <div id="header">
        <div id="top">
            <a href="/?logout=1">Выход</a>
            <button id="insRow">Добавить</button>
            <button id="updRow">Изменить</button>
        </div>

        <table class="theader">
            <caption>Статистика неисправностей оборудования</caption>
            <col span="1" width="2%">
            <col span="1" width="5%">
            <col span="1" width="10%">
            <col span="3" width="10%">
            <col span="1" width="5%">
            <col span="1" width="3%">
            <col span="2" width="20%">
            <thead>
            <tr>
                <th rowspan="2">№ пп</th>
                <th rowspan="2">Дата</th>
                <th rowspan="2">Служба / отдел</th>
                <th colspan="3">Оборудование</th>
                <th rowspan="2" style="word-wrap: break-word;">Кол-во</th>
                <th rowspan="2">Ед. изм.</th>
                <th rowspan="2">Описание</th>
                <th rowspan="2">Корректирующие мероприятия</th>
            </tr>
            <tr class="hrow">
                <th>Наименование</th>
                <th>Тип</th>
                <th>Установка</th>
            </tr>
            </thead>
        </table>
    </div>
    <div id="main">
        <div id="all">
            <table class="tdata">
                <col span="1" width="2%">
                <col span="1" width="5%">
                <col span="1" width="10%">
                <col span="3" width="10%">
                <col span="1" width="5%">
                <col span="1" width="3%">
                <col span="2" width="20%">

                <tfoot>
                <tr>
                    <td>Итого:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tfoot>
                <tbody>

<?php

if (isset($_SESSION["login"])) {
for($i=0;$i<100;$i++) {
    $j = $i + 1;
    $tr = <<<HTML
<tr>
                        <td title="$i">$j</td>
                        <td>07.12.2013</td>
                        <td>Служба электрика</td>
                        <td>Вышел из строя датчик вакуума</td>
                        <td>Inficon PSG-502S</td>
                        <td>ВДП-3</td>
                        <td class="tdr">1</td>
                        <td>шт.</td>
                        <td>Вышел из строя датчик вакуума</td>
                        <td>Ускорить приобретение датчиков вакуума</td>
                    </tr>
HTML;

    echo $tr;
}
}
?>

            </table>
        </div>
    </div>
    <div id="footer">
        <video src="/uploads/1.mp4" controls></video>
        <div>
            <label for="fview1">Просмотр</label><input name="fview" type="radio" value="1" id="fview1" checked>
            <label for="fview2">Редактирование</label><input name="fview" type="radio" value="2" id="fview2">
            <form action="/" method="get">
                <table class="tform">
                    <tr>
                        <td><label for="fdate">Дата: </label></td>
                        <td>
                            <input type="date" id="fdate" value="2015-02-12" />
                        </td>
                    </tr>
                    <tr>
                        <td><label for="fdep">Служба / отдел: </label></td>
                        <td>
                            <input name="fdep" list="dep" />
                            <datalist id="dep">
                                <option label="Технологи" value="Технологи" />
                                <option label="Энергетики" value="Служба энергетика" />
                                <option label="Механики" value="Служба механика" />
                                <option label="Электрики" value="Служба электрика" />
                            </datalist>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="fnaim">Наименование: </label></td>
                        <td>
                            <input type="text" id="fnaim"  />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button>Добавить</button>
                        </td>
                    </tr>
                </table>

            </form>
        </div>

    </div>
    <div id="add_dialog">
        <div class="add_dialog">
            <h2>Добавление неисправности</h2>
        <form name="form_add" action="/" method="post">
            <table class="tform">
                <tr>
                    <td><label for="fdate">Дата: </label></td>
                    <td>
                        <input type="date" id="fdate" value="2015-02-12" />
                    </td>
                </tr>
                <tr>
                    <td><label for="fdep">Служба / отдел: </label></td>
                    <td>
                        <input name="fdep" list="dep" />
                        <datalist id="dep">
                            <option label="Технологи" value="Технологи" />
                            <option label="Энергетики" value="Служба энергетика" />
                            <option label="Механики" value="Служба механика" />
                            <option label="Электрики" value="Служба электрика" />
                        </datalist>
                    </td>
                </tr>
                <tr>
                    <td><label for="fnaim">Наименование: </label></td>
                    <td>
                        <input type="text" id="fnaim"  />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button>ОК</button>
                        <button class="cancel">Отмена</button>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="method" value="ins">
        </form>
        </div>
    </div>
</div>

</body>
</html>