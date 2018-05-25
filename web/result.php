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
        <?php
            if (isset($_GET['dsId'])){
                $dbHandler = new DBHandler();
                $res = $dbHandler->GetSpecificResult($_GET['dsId']);
                echo "<p>ATE:  ".$res['ate']."</p>";
                echo "<p>TTE:  ".$res['tte']."</p>";
                foreach ($res['vars'] as $var){
                    echo "<p>".$var['var_name']." ".$var['operator']." ".$var['var_value']."  </p>";
                }
            }
        ?>
    </body>
</html>
