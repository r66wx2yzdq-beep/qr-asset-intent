<?
session_start();
session_unset();
session_destroy();
ob_start();
header("location:https://qrintent.ictlab.kz");
ob_end_flush(); 
include '../index.php';
exit();
?>
