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
        <table>
            <tr>
                <td>Набор данных </td>
                <td>Состояние анализа </td>
                <td></td>
            </tr>
            <?php 
                if (isset($_SESSION['userEmail'])){
                    $dbHandler = new DBHandler();
                    $resultArray = $dbHandler->GetResults($_SESSION['userEmail']);
                    foreach ($resultArray as $resRow){
                        echo "<tr>";
                            echo "<td>".$resRow['data_set_name']."</td>";
                            echo "<td>".$resRow['state_analysis_name']."</td>";
                            if ($resRow['state_analysis_id'] == 2){
                                echo "<td><a href='result.php?dsId=".$resRow['data_set_id']."'>Посмотреть результат</a></td>";
                            }
                    }
                } else {
                    header("Location:../web/login.php");
                }
                
            ?>
        </table>
        
    </body>
</html>
