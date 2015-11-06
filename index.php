<?php
mb_internal_encoding("UTF-8");
session_start();

require_once "oop/database_class.php";
require_once "oop/manage_class.php";
require_once "oop/dictionary_classes.php";


$db = new DataBase();
$manager = new Manage($db);

//print_r($department->getDepartmentOnName('Служба ЭНергетик1а'));
//$manager->department->deleteAll();
//$d = $manager->department->checkRecord('Технологи311');
//print_r($d);
//echo $d['name'];
//print_r($manager->units);


exit;

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

$last_login = $_COOKIE["last_login"];
if (!$last_login)
    $last_login = $manager->user_info["login"];
$last_login = trim($last_login);
$hdelta = 3600*6*0;
$hdays = 3600 * 24 * 7;
setcookie("last_login", $last_login, time() + $hdelta + $hdays);
//echo date('H:i:s', time());

$password = $manager->user_info["password"];
?>
<?php if(!$manager->user_info) { ?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Авторизация | Статистика неисправностей оборудования</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
<?php if($error_auth) { ?>
           $("#alert").fadeOut(0).fadeIn(100, function(){
                $(this).effect('bounce');
                $("#b_close_alert").focus();
           });
<?php } else { ?>
           $("body").fadeOut(0).fadeIn(1000);
<?php } ?>

            if ($("input[name=login]").val().trim() == "") $("input[name=login]").focus().select();
            else $("input[name=password]").focus().select();

            $("#b_close_alert").on("click", function(){
                $("#blackout").fadeOut(100);
                $("#alert").fadeOut(250);
                if ($("input[name=login]").val().trim() == "") $("input[name=login]").focus().select();
                else $("input[name=password]").focus().select();
            });

            $("#fauth").submit(function(e){
                //e.preventDefault();
                //$.cookie('last_login', $("input[name=login]").val().trim());
                $.cookie('last_login', $("input[name=login]").val().trim(), { expires: 7 });
            });

            $("#alert").draggable({ containment: 'document' });
            $( ".login" ).draggable({ handle: 'h1' });
            $( ".login h1" ).disableSelection().css({ cursor: 'move'});

            function clearCookies(){
                $.cookie('PHPSESSID', null);
                //$.cookie('last_login', null);
                //$.cookie('last_login', $.cookie('last_login'), { expires: 7 });
            }
            $(window).on("onunload", clearCookies);
            //$(window).beforeunload = clearCookies;
        });
    </script>
</head>
<body>
<div id="logo"></div>
<div id="designer_info"><p>&copy; Разработчик:<br>инженер-системотехник цеха №1 АО «УК ТМК»<br><b>Худяков Ал.П., тел.: 35-84</b></p></div>
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
        <div>
            <h1>Авторизация</h1>
            <form id="fauth" name="form_auth" method="post" action="/" enctype="application/x-www-form-urlencoded">
                <p><input type="text" name="login" value="<?=$last_login?>" list="dl_logins" placeholder="Имя пользователя" pattern="[а-яА-Яa-zA-Z0-9\. ]+" autocomplete="off" required ></p>
                <datalist id="dl_logins">
<?php if(is_array($manager->users)) foreach($manager->users as $key => $value)
                            echo "<option label=\"$value[login]\" value=\"$value[login]\" \/>";
?>
                </datalist>
                <p><input type="password" name="password" value="<?=$password?>" placeholder="Пароль" required></p>
                <p class="submit"><input type="submit" value="Войти"><a href="#" onclick="window.close()" title="Закрыть окно">Отмена</a></p>
                <input type="hidden" name="auth" value="1">
            </form>
        </div>
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
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <!--<script type="text/javascript" src="js/jquery.damnUploader.min.js"></script>-->

    <script type="text/javascript">
        $(document).ready(function() {

            $('#form-with-files').submit(function(e) {
                if ($.support.fileSending) {
                    // if browser supports, start uploading by plugin
                    $fileInput.duStart();
                    e.preventDefault();
                }
                // else - form will be sended on default handler, defined in it's "action" attribute
            });

            function rowSelect(row, rows){
                var elems = $("#rowNum span");
                elems.eq(0).text(rows.index(row)+1);
                elems.eq(1).text(rows.size());
            }

            $(".tdata tbody tr").click(function(){
                rowSelect($(this), $(".tdata tbody tr"));
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
            function funcB(){
                alert("before");
            }
            $(document).ajaxStart(function(){
                alert('start');
            });

            $(document).ajaxComplete(function(){
                alert('complete');
            });

            $("#updRow").click(function(e){
                $.ajax({
                    url: "add1.php",
                    type: "POST",
                    data: ({a: 5, b: "str"}),
                    dataType: "json",
                    beforeSend: funcB,
                    success: function (data){
                        $.each(data, function(key, val) {
                            alert(key+'='+val);
                        });
                        //alert(data.a+data.b);
                    },
                    error: function(msg) {
                        alert('Ошибка!'+msg);
                    },
                });
                return false;
                $("input[name=method]").val("upd");
                $("#add_dialog .add_dialog h2").text("Изменение неисправности");
                $("#add_dialog").fadeIn(100);
                e.preventDefault();
            });

            $("form[name=form_add] .cancel").click(function(e){
                $("#add_dialog").fadeOut(100);
                e.preventDefault();
            });

            function clearCookies(){
                $.cookie('PHPSESSID', null);
                //$.cookie('last_login', null);
                //$.cookie('last_login', $.cookie('last_login'), { expires: 7 });
            }

            $(window).on("onunload", clearCookies);

        });
    </script>
</head>
<body>
<div id="container">
    <div id="header">
        <div id="logo"></div>
        <div id="top">
            <a href="/?logout=1">Выход</a>
            <button id="insRow">Добавить</button>
            <button id="updRow">Изменить</button>
        </div>

        <table class="theader">
            <caption><b>Статистика неисправностей оборудования.</b> Цех №1. АО «УК ТМК»</caption>
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
            <tbody>
            <tr>
                <td></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td class="tdr"><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
                <td><input type="text"></td>
            </tr>
            </tbody>
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
                    <td colspan="10">Нет данных</td>
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
        <!--<video src="/uploads/1.mp4" controls></video>-->
        <div id="rowNum">Запись: <b><span>0</span></b> из <span>0</span></div>
        <div id="designer_info"><p>&copy; Разработчик:<br>инженер-системотехник цеха №1 АО «УК ТМК»<br><b>Худяков Ал.П., тел.: 35-84</b></p></div>
    </div>
    <div id="add_dialog">
        <div class="add_dialog">
            <h2>Добавление неисправности</h2>
        <form name="form_add" action="/" method="post">
            <table class="tform">
                <tr>
                    <td><label for="fdate">Дата1: </label></td>
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