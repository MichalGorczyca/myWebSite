<?php include "includes/db.php"; ?>
<?php session_start(); ?>
<?php

    if(isset($_SESSION['username'])){

        $_SESSION['user_id'] = null;
        $_SESSION['username'] = null;
        $_SESSION['password'] = null;
        $_SESSION['user_firstname'] = null;
        $_SESSION['user_lastname'] = null;
        $_SESSION['user_email'] = null;
        $_SESSION['user_role'] = null;
        $_SESSION['user_date'] = null;

        header("Location: login.php");

    }

?>