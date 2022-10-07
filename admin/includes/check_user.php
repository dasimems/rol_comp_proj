<?php


if(isset($_SESSION['adminid']) && !empty($_SESSION['adminid']) && isset($_SESSION['adminemail']) && !empty($_SESSION['adminemail'])){

    $sessionadminid = $_SESSION['adminid'];
    $sessionadminemail = $_SESSION['adminemail'];



    $countarray = array(
        "tableName"=>ADMIN_TABLE,
        "identityParams"=>"id",
        "identityValues"=>$sessionadminid
    );

    $countarrayjson = json_encode($countarray);

    if($dbconnect->countRow($countarrayjson) < 1){

        $_SESSION['message'] = "Please Login";
        $_SESSION['messagetype'] = "error-message";
        header("location:./login.php");

    }else{

        $getdata = array(
            "tableName"=>ADMIN_TABLE,
            "identityParams"=>"id",
            "identityValues"=>$sessionadminid
        );

        $getdatajson = json_encode($getdata);

        $data = $dbconnect->getTableData($getdatajson);

        // print_r($data);

        $adminemail = $data[0]['email'];

        if($adminemail !== $sessionadminemail){

            $_SESSION['message'] = "Please Login";
            $_SESSION['messagetype'] = "error-message";
            header("location:./login.php");

        }else{
            
            define("ADMIN_ID", $data[0]['id']);
            define("ADMIN_EMAIL", $data[0]['email']);
            define("ADMIN_NAME", $data[0]['name']);
            define("ADMIN_NUMBER", $data[0]['mobile_number']);
            define("ADMIN_ADDRESS", $data[0]['address']);
            define("ADMIN_IMAGE", $data[0]['image']);
            define("ADMIN_FACEBOOK", $data[0]['facebook']);
            define("ADMIN_INSTAGRAM", $data[0]['instagram']);
            define("ADMIN_TWITTER", $data[0]['twitter']);
            define("ADMIN_PRIVILEDGE", $data[0]['priviledge']);
            $profilename = explode(" ", ADMIN_NAME);
        }

    }

    

}else{
    session_start();
    $_SESSION['message'] = "Please Login";
    $_SESSION['messagetype'] = "error-message";
    header("location:../login.php");
    header("location:./login.php");
    exit;
}