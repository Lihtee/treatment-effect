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
        <p>Step 2</p>
        <form method="GET">
            <?php
            session_start();
            if (isset($_SESSION['userFileNumCol'])){
                $numCol = $_SESSION['userFileNumCol'];
                $sessionTypeArray = array();
                echo $numCol;
                for ($i=0; $i<$numCol; $i++){
                    echo "<select size = '5' name = 'type".$i."' required>"
                            . "<option disabled>Select type</option>"
                            . "<option value = 'Y'> Y </option>"
                            . "<option value = 'T'> T </option>"
                            . "<option value = 'X'> X </option>"
                         ."</select>";
                }
                if (isset($_GET['next']) || isset($_GET['finish'])){
                    $_SESSION['typeArray'] = array();
                    for ($i = 0; $i < $numCol; $i++){
                        $sessionTypeArray[$i] = $_GET['type'.$i];
                    }
                    $_SESSION['typeArray'] = $sessionTypeArray;
                    
                } 
                if (isset($_GET['next'])){
                    header("Location:../input.step3.php");
                }
                
            } else {
                echo "Session is not working";
            }
        ?>
            <button type="submit" name="next">Next</button>
            <button type="submit" name="finish">Finish</button>
        </form>
        
        
    </body>
</html>
