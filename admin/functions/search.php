<?php

session_start();
// index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&pagenum=1

// index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=hourly&pagenum=1

if(isset($_GET['page']) && !empty($_GET['page']) && isset($_GET['filter']) && !empty($_GET['filter']) && isset($_GET['operation']) && !empty($_GET['operation'])){
    $page = $_GET['page'];
    $filter = $_GET['filter'];

    if($page === "record"){
        if(isset($_GET['data']) && !empty($_GET['data'])){

            $data = $_GET['data'];

        }else{

            header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=hourly&pagenum=1");
        }
    }
    print_r($_POST);

    if(isset($_POST['search-value']) && !empty(trim($_POST['search-value']))){
        if(!empty($_POST['filter-value'])){

            $searchby = $_POST['filter-value'];

        }
        $searchvalue = urlencode($_POST['search-value']);

        if(isset($searchby) && !empty($searchby)){

            
            if($page === "record"){

                header("location:../index.php?page=record&search=$searchvalue&searchby=$searchby&order=descending&filter=$filter&data=$data&pagenum=1");
    
            }else if($page === "admins"){
                header("location:../index.php?page=admins&search=$searchvalue&searchby=$searchby&order=descending&filter=$filter&pagenum=1");
            }

        }else{
            if($page === "record"){

                header("location:../index.php?page=record&search=$searchvalue&order=descending&filter=$filter&data=$data&pagenum=1");
    
            }else if($page === "admins"){
                header("location:../index.php?page=admins&search=$searchvalue&order=descending&filter=$filter&pagenum=1");
            }
        }
        
    }else{

        $_SESSION['message'] = "Please Input Your Search Parameters";
        $_SESSION['messagetype'] = "error-message";

        if($page === "record"){

            header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=$filter&data=$data&pagenum=1");

        }else if($page === "admins"){
            header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=$filter&pagenum=1");
        }
        

    }
}