<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".tdata tr").click(function(){
                $(".tdata tr").removeClass("rsel");
                var $tr = $(this);

                if ($tr.hasClass('rsel')) $tr.removeClass('rsel');
                else $tr.addClass('rsel');

                var $d = $(".rsel td:first+td").text();
                $d = $d.substr(-4) + "-" + $d.substr(3,2) +"-"+$d.substr(0,2);
                $("#fdate").val($d);
            });

        });
    </script>
</head>
<body>
<div id="container">
    <div id="header">
        <div id="top">

        </div>

        <table class="theader">
            <caption>История неисправностей оборудования</caption>
            <col span="1" width="2.5%">
            <col span="1" width="5%">
            <col span="1" width="10%">
            <col span="3" width="10%">
            <col span="2" width="2.5%">
            <col span="2" width="20%">
            <thead>
            <tr>
                <th rowspan="2">№ пп</th>
                <th rowspan="2">Дата</th>
                <th rowspan="2">Служба / отдел</th>
                <th colspan="3">Оборудование</th>
                <th rowspan="2">Кол-во</th>
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
                <col span="1" width="2.5%">
                <col span="1" width="5%">
                <col span="1" width="10%">
                <col span="3" width="10%">
                <col span="2" width="2.5%">
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

mb_internal_encoding("UTF-8");

require_once "oop/database_class.php";
require_once "oop/user_class.php";

$db = new DataBase();
$user = new User($db);

$view = $_GET["view"];
switch ($view) {
    case "":
        $content = new User($db);
        break;
    default: exit;
}

//echo $content->getContent();

//echo $user->isExists("admin");
//$user->addUser("user1", "qwerty123", 1);
//echo $user->isExistsUser("admin")."<br />";
//echo "<table>";
//foreach($user->getAll() as $key => $val) {
//    echo "<tr><td>".implode("</td><td>", $val)."</td></tr>";
//}
//echo "</table>";

for($i=0;$i<50;$i++) {
    $j=$i+1;
    $tr = <<<HTML
<tr>
                        <td>$j</td>
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
?>

            </table>
        </div>
    </div>
    <div id="footer">
        <div>
            <form action="" method="post">
                <label for="fdate">Дата: </label><input type="date" id="fdate" value="2015-02-12" />
                <input name="fdep" list="dep" />
                <datalist id="dep">
                    <option label="Технологи" value="Технологи" />
                    <option label="Энергетики" value="Служба энергетика" />
                    <option label="Механики" value="Служба механика" />
                    <option label="Электрики" value="Служба электрика" />
                </datalist>
            </form>
        </div>
    </div>
</div>

</body>
</html>
