<?php 


session_start();
require_once("../includes/mydb.php");
require_once("../includes/db.php");
require_once("../includes/check_user.php");

if(isset($_GET['page']) && !empty($_GET['page']) && isset($_GET['operation']) && !empty($_GET['operation'])){
    $page = $_GET['page'];
    $operation = $_GET['operation'];


    if($page === "admin"){

        if($operation === "deleteadmin"){

            if(isset($_GET['id']) && !empty($_GET['id'])){
                $adminid = $_GET['id'];
                // http://localhost/roland_work/company_project/admin/functions/delete.php?page=admin&operation=deleteadmin&id=1

                if($adminid !== ADMIN_ID){

                    $deleteadminarray = array(
                        "tableName"=>"admin",
                        "identityParams"=>"id",
                        "identityValues"=>$adminid
                    );

                    $deleteadminjson = json_encode($deleteadminarray);

                    if($dbconnect->deleteRow($deleteadminjson)){

                        $_SESSION['message'] = "Admin Deleted Successfully";
                        $_SESSION['messagetype'] = "success-message";
                        header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=mobile_number&pagenum=1");

                    }else{
                        
                        $_SESSION['message'] = "An Unknown Error Occured";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=mobile_number&pagenum=1");
                    }

                }else{
                    $_SESSION['message'] = "Can't Delete An Account Of Yourself";
                    $_SESSION['messagetype'] = "error-message";
                    header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=mobile_number&pagenum=1");

                }

            }else{
                header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=mobile_number&pagenum=1");
            }

        }
    }elseif($page === "record"){
        print_r($_GET);

        if(isset($_GET['search']) && !empty($_GET['search']) &&isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['filter']) && !empty($_GET['filter']) && isset($_GET['data']) && !empty($_GET['data']) && isset($_GET['pagenum']) && !empty($_GET['pagenum']) && isset($_GET['id']) && !empty($_GET['id'])){

            $page = $_GET['page'];
            $search = $_GET['search'];
            $order = $_GET['order'];
            $filter = $_GET['filter'];
            $data = $_GET['data'];
            $pagenum = $_GET['pagenum'];
            $deleteid = $_GET['id'];
    
            if($data === "production"){
                $tablename = "p_r";
    
            }elseif($data === "hourly"){
                $tablename = "h_r";
            }
    
            $deleterecordarray = array(
                "tableName"=>$tablename,
                "identityParams"=>"id",
                "identityValues"=>$deleteid
            );
    
            $deleterecordjson = json_encode($deleterecordarray);
    
            if($dbconnect->deleteRow($deleterecordjson)){
    
                $_SESSION['message'] = "Record Deleted Successfully";
                $_SESSION['messagetype'] = "success-message";
                header("location:../index.php?page=record&search=$search&order=$order&filter=$filter&data=$data&pagenum=$pagenum");
    
            }else{
                
                $_SESSION['message'] = "An Unknown Error Occured";
                $_SESSION['messagetype'] = "error-message";
                header("location:../index.php?page=record&search=$search&order=$order&filter=$filter&data=$data&pagenum=$pagenum");
            }

        }else{

            header("loaction:../index.php?page=dashboard");
        }

    }

}else{
    header("loaction:../index.php?page=dashboard");
}


?>