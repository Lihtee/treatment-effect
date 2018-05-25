<?php include $_SERVER['DOCUMENT_ROOT']."/Common/common.php"; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/Classes/DBHandler.php'; ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <p>Введите e-mail:</p>
        <form method="GET">
            <input type="text" name="email" placeholder="Ваш email">
            <button type="submit" name="submit" value="submit"> Войти </button>
        </form>
        <?php
            if (isset($_GET['submit']) ){
                if (isset($_GET['email']) && $_GET['email'] != ""){
                    $_SESSION['userEmail'] = $_GET['email'];
                    $dbHandler = new DBHandler();
                    $dbHandler->Login($_GET['email']);
                    header("Location:../web/main.php");
                }else {
                    echo "<p>Поле пустое!</p>";
                }
            } 
        ?>
    </body>
</html>
