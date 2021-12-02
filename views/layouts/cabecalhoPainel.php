<?php 
session_start();
if(!isset($_SESSION) || !isset($_SESSION['codigo']) || !isset($_SESSION['tipo'])) {
	header("location: ../../");
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="public/images/icon.ico" >
        <link href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@1,700&family=Nunito:wght@700&family=Yellowtail&display=swap" rel="stylesheet">
        <link href="../../public/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="../../public/css/normalize.css" rel="stylesheet" type="text/css"/>
        <script src="../../public/js/jquery.js" type="text/javascript"></script>
        <script src="../../public/js/jquery.mask.js" type="text/javascript"></script>
        <script src="../../public/js/bootstrap.js" type="text/javascript"></script>
        <script src="../../public/js/bootstrap.js" type="text/javascript"></script>
        <script src="../../public/js/jquery.validate.min.js" type="text/javascript"></script>