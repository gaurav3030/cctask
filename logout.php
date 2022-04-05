<?php
session_start();
session_destroy();
    unset($_SESSION['loggedin']);
    unset($_SESSION['email']);
    header("location: index.php");
?>