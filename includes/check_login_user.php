<?php
session_start();



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

            define("ADMIN_HEADER_LINK", true);
            
        }else{

            define("ADMIN_HEADER_LINK", false);
            
        }
        
    }else{

        define("ADMIN_HEADER_LINK", false);
    }
    
    
    
}else{
    
    define("ADMIN_HEADER_LINK", false);
}

$dir = scandir('./pages');

// setting the page query from the url using the get query method

if(isset($_GET['page']) && !empty($_GET['page']) && in_array($_GET['page'].".php", $dir)){

    $pageq = $_GET['page'];
    $page = $_GET['page'].".php";
    
}else{

    $pageq = "hourlyreport";
    $page = "hourlyreport.php";

}



$limit = 10;

// getting the num of page from the url using the get query parameter

if(isset($_GET['n']) && !empty($_GET['n'])){

    $n = $_GET['n'];

    
    if(is_numeric($n)){

        
        $pagenum = floor($_GET['n']);
    }else{
        
        $pagenum = 1;
    }
}else{
    $pagenum = 1;
}




if($pageq === "hourlyreport"){
    $tablename = "h_r";
}else{
    $tablename = "p_r";
}


$countdataarr = array(
    "tableName"=>$tablename
);

$countdatajson = json_encode($countdataarr);

$datacount = $dbconnect->countRow($countdatajson);

$buttonno = ceil($datacount/$limit);

// echo $buttonno;

if($pagenum > 1){

    $previouspagenum = ($pagenum - 1);
}else{
    
    $previouspagenum = 1;
    $pagenum = 1;
}

if($pagenum < $buttonno){
    $nextpagenum = ($pagenum + 1);

}else{
    $nextpagenum = $buttonno;
    $pagenum = $buttonno;
}

$offset = (($pagenum - 1) * $limit);

if($offset < 0){
    $offset = 0;
}

// fetching the report from the database


$fetchtablearr = array(
    "tableName"=>$tablename,
    "limit"=>$limit,
    "offset"=>$offset,
    "order"=>"id",
    "orderType"=>"DESC"
);

$fetchtablejson = json_encode($fetchtablearr);

$data = $dbconnect->getTableData($fetchtablejson);
