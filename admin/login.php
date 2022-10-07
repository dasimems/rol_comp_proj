<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->


<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="../assets/css/all.css">
        <link rel="stylesheet" href="../assets/fonts/font-style.css">
        <link rel="stylesheet" href="./assets/css/login.css">
        <link rel="stylesheet" href="./assets/css/header.css">
    </head>
    <body>

        
        <?php

            require_once("./includes/message.php");
            require_once("./includes/mydb.php");
            require_once("./includes/db.php");
            require_once("./includes/check_login_user.php");

        ?>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        
        <header>

            <div class="logo"></div>

        </header>

        <section id="main-body">

            <div class="login-body">

                <div class="login-content">
                    
    
                    <div class="login-header">
                        <h1>Login</h1>
                    </div>
    
                    <form action="./functions/login.php" method="post">
    
                        <div class="form-content">
    
                            <input type="email" name="admin-email" id="admin-email" placeholder=" Email Address" value="<?php  echo isset($emailerror)? $emailerror: "" ;?>">
    
                        </div>
    
                        <div class="form-content">
    
                            <input type="password" name="admin-password" id="admin-password" placeholder="Account Password" value="<?php  echo isset($passworderror)? $passworderror: "" ;?>">

                            <button type="button" id="show-password-btn" onclick="showPassword()">
                                <i class="fas fa-eye"></i>
                            </button>
    
                        </div>
    
                        <div class="form-content">
    
                            <button type="submit">Login</button>
    
                        </div>
    
                    </form>
    
                </div>

            </div>


        </section>

        <script src="./assets/js/message.js" async defer></script>
    </body>
</html>