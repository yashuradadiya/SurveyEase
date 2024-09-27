<?php 
session_start();
unset($_SESSION['survey_creator']);
header("location:index.php");
?>