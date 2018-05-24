<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        
        <title></title>
    </head>
    <body>
        <h2>Input email and load data</h2>
        <form method="GET">
            <input type="text" name="email" placeholder="Your email">
            <br>
            <input type="file" name ="file" placeholder="Your file">
            <br>
            <input type="number" name="numCol" placeholder="Number of columns">
            <button type="submit" name="next">Next</button>
            <button type="submit" name="finish">Finish</button>
        </form>
        
        <?php
            session_start();
            
            $_SESSION['userEmail'] = $_GET['email'];
            $_SESSION['userFile'] = $_GET['file'];
            $_SESSION['userFileNumCol'] = $_GET['numCol'];
            
            if (isset($_GET['next'])){
                header("Location:input.step2.php");
            }elseif (isset($_GET['finish'])) {
                header("Location:input.finish.php");   
            }
        ?>
    </body>
</html>
