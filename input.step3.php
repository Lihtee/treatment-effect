<?php 
    session_start();
?>
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
        <p>Step 3</p>
        <form method="GET" >
            <?php
                if (isset($_SESSION['typeArray']) 
                        || isset($_SESSION['userFileNumCol'])){
                    
                    $numCol = $_SESSION['userFileNumCol'];
                    $sessionTypeArray = $_SESSION['typeArray'];
                    
                    for ($i=0; $i<$numCol; $i++){
                        echo $sessionTypeArray[$i];
                        switch ($sessionTypeArray[$i]){
                            case 'T': 
                                echo "<select size = '5' name = 'type".$i."' required>"
                                        . "<option disabled>Select type</option>"
                                        . "<option value = 'discount'> discount </option>"
                                        . "<option value = 'advertising'> advertising </option>"
                                        . "<option value = 'bonus'> bonus </option>"
                                     ."</select>";
                                break;
                            case 'Y':
                                echo "<select size = '5' name = 'type".$i."' required>"
                                        . "<option disabled>Select type</option>"
                                        . "<option value = 'numVisit'> numVisit </option>"
                                        . "<option value = 'numSpend'> numSpend </option>"
                                        . "<option value = 'totalSpend'> totalSpend </option>"
                                     ."</select>";
                                break;
                            case 'X':
                                echo "<select size = '5' name = 'type".$i."' required>"
                                        . "<option disabled>Select type</option>"
                                        . "<option value = 'numVisit'> numVisit </option>"
                                        . "<option value = 'numSpend'> numSpend </option>"
                                        . "<option value = 'totalSpend'> totalSpend </option>"
                                     ."</select>";
                                break;
                            default: echo "Cant init selecting list.";                               
                        }
                    }
                   
                } 
                if (isset($_GET('finish'))){
                    $sessionSubtypeArray = array();
                    $numCol = $_SESSION['userFileNumCol'];
                    for ($i =0; $i<$numCol; $i++){
                        $sessionSubtypeArray[$i] = $_GET['type'.$i];
                    }
                    $_SESSION['subtypesArray'] = $sessionSubtypeArray;
                }
                
            ?>
            <button type="submit" name="finish">Finish</button>
        </form>
        <?php
            
            
        ?>
    </body>
</html>
