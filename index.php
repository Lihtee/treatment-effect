
<?php 
    session_start();
    if (isset($_SESSION['userEmail'])){
        header("Location:../web/main.php");
    } else {
        header("Location:../web/login.php");
    }
?>
