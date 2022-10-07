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

    if($dbconnect->countRow($countarrayjson) > 0){

        $getdata = array(
            "tableName"=>ADMIN_TABLE,
            "identityParams"=>"id",
            "identityValues"=>$sessionadminid
        );

        $getdatajson = json_encode($getdata);

        $data = $dbconnect->getTableData($getdatajson);

        // print_r($data);

        $adminid = $data[0]['id'];
        $adminname = $data[0]['name'];
        $adminemail = $data[0]['email'];

        if($adminemail === $sessionadminemail){

            header("location:./index.php?page=dashboard");

        }

    }



}