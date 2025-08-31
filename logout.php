<?php 
session_unset();


header("Location:index.php");
    $_SESSION['response']="Successfully Logout";
    $_SESSION['type']="success";
session_destroy();

?>