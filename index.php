<?php

require_once("./admin/includes/mydb.php");
require_once("./admin/includes/db.php");
require_once("./includes/check_login_user.php");

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Reports</title>
        <meta name="description" content="<?php  ?>">
        <link rel="stylesheet" href="./assets/css/all.css">
        <link rel="stylesheet" href="./assets/fonts/font-style.css">
        <link rel="stylesheet" href="./assets/css/index.css">
        <link rel="stylesheet" href="./assets/css/header.css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <section id="header-content">
            <?php require_once('./includes/header.php'); ?>
        </section>

        <section id="body-content">
            <?php


                require_once("./pages/".$page);

                

            ?>
        </section>
        
        <section id="footer-content">
            <?php require_once('./includes/footer.php'); ?>
        </section>
        <script src="" async defer></script>
    </body>
</html>