<?php ob_start(); ?>
<?php session_start();

$_SESSION['username'] = null;
$_SESSION['password'] = null;
$_SESSION['email'] = null;
$_SESSION['role'] = null;
$_SESSION['firstname'] = null;
$_SESSION['lastname'] = null;
    
header("Location: /myWebSite/cms/index.php");

?>