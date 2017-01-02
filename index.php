<?php
//rozpoczęcie sesji
session_start();
//włączenie raportowania błędów 
//error_reporting(E_ALL);
//zdefiniowanie stałej ze ścieżką
$site_path = realpath(dirname(__FILE__));
$site_path = $site_path . "/html";
define('__SITE_PATH', $site_path);
define('APP_ROOT', 'inteligentnymagazyn');
//dołączenie pliku init.php
include 'html\includes\init.php';
//utworzenie instancji routera i dodanie go do rejestru
$registry->router = new router($registry);
//utworzenie instancji szablonu widoku i dodanie go do rejestru
$registry->template = new Template($registry);
//ustawienie ścieżki w której znajdują się kontrolery
$registry->router->setPath(__SITE_PATH . '\controller');
?>


<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Inteligentny Magazyn - system zarządzania narzędziami przez roboty</title>
        <!--Dołączenie arkusza stylów css biblioteki bootstrap -->
        <link rel="stylesheet" href="/<?= APP_ROOT ?>/html/content/css/bootstrap.min.css" type="text/css" />     
        <!--Dołączenie skrytpu javascript biblioteki jquery -->
        <script src="/<?= APP_ROOT ?>/html/content/scripts/jquery-1.11.2.min.js"></script> 
    </head>
    <body>
        <?php include 'html\includes\menu.php'; ?> 
        <div class="container">
            <div class="row">
                <div class="col-md-12">System inteligentnego magazynu</div>
               
                
                
                
            </div>
            <div class="row"> 
                <div class="col-md-12">
                    <?php include 'html\includes\login.php'; ?> 
                </div>
            </div>   
            <div class="row"> 
                <div class="col-md-12">
                    <?php include 'html\includes\RobotPelny.php'; ?> 
                </div>
            </div>  
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $registry->router->loader();
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br><br><br><br><br><br><br><br><br><br><br><br> <br><br><br>
                    <center> Created by MW 2016 </center>
                
                </div>
            </div>
        </div>
        <!--Dołączenie skrytpu javascript biblioteki bootstrap -->
        <script src="/<?= APP_ROOT ?>/html/content/scripts/bootstrap.min.js"></script> 
    </body>
</html>




