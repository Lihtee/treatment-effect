
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
        <p>Finish</p>
        <p>Send data for analysing?</p>
        <form method="GET">
            <button type="submit" name="send"> Yes, send.</button>
            <button type="submit" name="back"> No, back.</button>
        </form>
        <?php
            ini_set("display_errors",1);
            error_reporting(E_ALL);
            session_start();
    
            if (isset($_GET['send'])){
                echo "Start analysing<br>";
                require_once 'Classes\AnalisysHandler.php';
                $analysisHandler = new AnalisysHandler;
                $res = $analysisHandler->Analyse();
                echo $res;
                require_once 'Classes\DBHandler.php';
                $dbHandler = new DBHandler();
                $res = $dbHandler->SaveDataSet();
                echo "DB res: ".$res;
                "<br>";
                var_dump($_SESSION);
            }else{
                echo "Some error.";
            }
            
        ?>
    </body>
</html>
