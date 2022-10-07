<?php

session_start();


if(session_unset() && session_destroy()){
    header("location:../login.php");
}