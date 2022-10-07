<?php

session_start();


if(isset($_POST['admin-email']) && isset($_POST['admin-password'])){

    require_once('../includes/mydb.php');
    require_once('../includes/db.php');
  
    if(!empty($_POST['admin-email'])){

        $adminemail = $_POST['admin-email'];

        if(!empty($_POST['admin-password'])){

            $adminpassword = $_POST['admin-password'];

            $countarray = array(
                "tableName"=>ADMIN_TABLE,
                "identityParams"=>"email",
                "identityValues"=>$adminemail
            );

            $countarrayjson = json_encode($countarray);


            if($dbconnect->countRow($countarrayjson) < 1){

                $_SESSION['data'] = array(

                    "email"=>$_POST['admin-email'],
                    "password"=>$_POST['admin-password']
                );
                
                $_SESSION['message'] = "Invalid Email";
                $_SESSION['messagetype'] = "error-message";
                header("location:../login.php");

            }else{

                $getdata = array(
                    "tableName"=>ADMIN_TABLE,
                    "columns"=>"id|name|password",
                    "identityParams"=>"email",
                    "identityValues"=>$adminemail
                );

                $getdatajson = json_encode($getdata);

                $data = $dbconnect->getTableData($getdatajson);

                // print_r($data);

                $savedpassword = $data[0]['password'];
                $adminid = $data[0]['id'];
                $adminname = explode(" ", $data[0]['name']);

                // print_r($adminname);
                if(password_verify($adminpassword, $savedpassword)){

                    $_SESSION['adminemail'] = $adminemail;
                    $_SESSION['adminid'] = $adminid;
                    $_SESSION['message'] = "Welcome " . $adminname[0];
                    $_SESSION['messagetype'] = "success-message";

                    if(isset($_SESSION['page']) && !empty($_SESSION['page'])){

                        header("location:../index.php?page=".$_SESSION['page']);
                    }else{

                        header("location:../index.php?page=dashboard");
                    }


                }else{

                    $_SESSION['data'] = array(
    
                        "email"=>$_POST['admin-email']
                    );
                    
                    $_SESSION['message'] = "Wrong Password";
                    $_SESSION['messagetype'] = "error-message";
                    header("location:../login.php");

                }


            }

        }else{

            $_SESSION['data'] = array(

                "email"=>$_POST['admin-email']
            );

            $_SESSION['message'] = "Password Cannot Be Empty";
            $_SESSION['messagetype'] = "error-message";
            header("location:../login.php");
        }

    }else{

        $_SESSION['message'] = "Email Cannot Be Empty";

        $_SESSION['messagetype'] = "error-message";
        header("location:../login.php");
    }

    


    // print_r($_POST);
}else{
    header("location:../index.php?page=dashboard");
}

?>

