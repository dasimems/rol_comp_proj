<?php
session_start();
require_once("../includes/mydb.php");
require_once("../includes/db.php");
require_once("../includes/check_user.php");
$presenttime = time();

function timepassed($timestamp){
    if($timestamp < 1){
        return "0 sec ago";
    }elseif($timestamp < 59){

        if($timestamp > 1){

            return $timestamp . " secs Ago";
        }else{
            return $timestamp . " sec Ago";

        }
    }elseif($timestamp < 3599){
        $min = floor($timestamp/60);

        // echo ($timestamp/60). "<br/>";
        if($min > 1){

            return $min . " mins ago";
        }else{
            
            return $min . " min ago";
        }


    }elseif($timestamp < 43199){

        $hour = floor($timestamp/3600);

        // echo ($timestamp/60). "<br/>";
        if($hour > 1){

            return $hour . " hours ago";
        }else{
            
            return $hour . " hour ago";
        }


    }elseif($timestamp < 302399){
        $days = floor($timestamp/43200);

        // echo ($timestamp/60). "<br/>";
        if($days > 1){

            return $days . " days ago";
        }else{
            
            return $days . " day ago";
        }
    }elseif($timestamp < 1209599){
        $weeks = floor($timestamp/302400);

        if($weeks > 1){

            return $weeks . " weeks ago";
        }else{
            
            return $weeks . " week ago";
        }
    }else{
        
        return " 1+ month";
    }
}



if(isset($_GET['page']) && !empty($_GET['page'])){
    $getdate = date("d F Y");

    $page = $_GET['page'];

    if($page === "dashboard"){

        $dataarray = array(

            "totals"=>array(
                "totalAdmin"=>"",
                "totalHourlyReport" => "",
                "totalProductionReport" => "",
                "totalNotification" => ""
            ),

            "reports"=>array(

                "hourlyReport"=>array(
                    "7:30-8:30"=>"",
                    "8:30-9:30"=>"",
                    "9:30-10:30"=>"",
                    "10:30-11:30"=>"",
                    "11:30-12:30"=>"",
                    "12:30-1:30"=>"",
                    "1:30-2:30"=>"",
                    "2:30-3:30"=>"",
                    "3:30-4:30"=>"",
                    "4:30-5:30"=>"",
                    "6:00-8:30"=>"",
                    "target"=>""
                ),

                "productionReport"=>array(
                    "totalInputQuantity"=>"",
                    "totalOutputQuantity"=>"",
                    "totalRejectionQuantity"=>"",
                    "totalOrderQuantity"=>""
                )
            )
        );

        //getting the total numbers

        //gets the total number of admin

        $countadminarray = array(
            "tableName"=>"admin"
        );

        $countadminarrayjson = json_encode($countadminarray);

        $admincount = $dbconnect->countRow($countadminarrayjson);

        $dataarray["totals"]['totalAdmin'] = $admincount;

        //gets the total number of unread notification

        $countnotificationreportarray = array(
            "tableName"=>"notification",
            "identityParams"=>"admin_email|status",
            "identityValues"=>ADMIN_EMAIL . "|unread"
        );

        $countnotificationreportarrayjson = json_encode($countnotificationreportarray);

        $notificationreportcount = $dbconnect->countRow($countnotificationreportarrayjson);

        $dataarray["totals"]['totalNotification'] = $notificationreportcount;

        //gets the total number of hourly report

        $counthourlyreportarray = array(
            "tableName"=>"h_r"
        );

        $counthourlyreportarrayjson = json_encode($counthourlyreportarray);

        $hourlyreportcount = $dbconnect->countRow($counthourlyreportarrayjson);

        $dataarray["totals"]['totalHourlyReport'] = $hourlyreportcount;

        //gets the total number of production report

        $countproductionreportarray = array(
            "tableName"=>"p_r"
        );

        $countproductionreportarrayjson = json_encode($countproductionreportarray);

        $productionreportcount = $dbconnect->countRow($countproductionreportarrayjson);

        $dataarray["totals"]['totalProductionReport'] = $productionreportcount;

        //getting the datas in the database

        //getting the data in the hourly report table

        $gethourlylistarray = array(
            "tableName"=>"h_r",
            "columns"=>"seven_eight_thirthy|eight_nine_thirthy|nine_ten_thirthy|ten_eleven_thirthy|eleven_twelve_thirthy|twelve_one_thirthy|one_two_thirthy|two_three_thirthy|three_four_thirthy|four_five_thirthy|six_eight_clock|target",
            "identityParams"=>"date_added",
            "identityValues"=>$getdate
        );

        $gethourlylistarrayjson = json_encode($gethourlylistarray);

        $hourlylist = $dbconnect->getTableData($gethourlylistarrayjson);

        if($hourlylist){

            $columns = explode("|", $gethourlylistarray['columns']);

            $i = 0; 
            foreach($dataarray["reports"]['hourlyReport'] as $key=>$value){
                $dataarray["reports"]['hourlyReport'][$key] = $hourlylist[0][$columns[$i]];
                $i++;
            }

        }else{
            foreach($dataarray["reports"]['hourlyReport'] as $key=>$value){
                $dataarray["reports"]['hourlyReport'][$key] = "0";
            }
            
        }

        //getting the production list

        $getproductionlistarray = array(
            "tableName"=>"p_r",
            "columns"=>"input_qty|output_qty|rejection_qty|order_qty"
        );

        $getproductionlistarrayjson = json_encode($getproductionlistarray);

        $productionlist = $dbconnect->getTableData($getproductionlistarrayjson);

        $productioncolumns = explode("|", $getproductionlistarray['columns']);

        foreach($productioncolumns as $value){
            $$value = 0;
        }

        if(is_array($productionlist)){
            
            for($i = 0; $i < count($productionlist); $i++){
                $input_qty += $productionlist[$i]['input_qty'];
                $output_qty += $productionlist[$i]['output_qty'];
                $rejection_qty += $productionlist[$i]['rejection_qty'];
                $order_qty += $productionlist[$i]['order_qty'];
    
            }
        }

        
        $productiondata = array($input_qty, $output_qty,  $rejection_qty, $order_qty);
        
        $v = 0;
        foreach($dataarray["reports"]['productionReport'] as $key=>$value){

            $dataarray["reports"]['productionReport'][$key] = $productiondata[$v];
            $v++;

        }

        //this code is to be executed when all array has been filled

        if(isset($_GET['data']) && !empty($_GET['data'])){

            if($_GET['data'] === "graph"){

                $datajson = json_encode($dataarray);

                echo $datajson;
            }
            // echo "found";
        }else{
            
            header("location:../index.php?page=dashboard");
        }


        // echo "<pre>";
        // print_r($dataarray);
        // // print_r($productionlist);
        // echo "</pre>";


    }elseif($page === "notification"){
        $selectnotiarray = array(
            "tableName"=>"notification",
            "identityParams"=>"admin_email",
            "identityValues"=>ADMIN_EMAIL,
            "limit"=>6,
            "order"=>"id",
            "orderType"=>"DESC"
        );

        $selectnotijson = json_encode($selectnotiarray);

        if($dbconnect->getTableData($selectnotijson)){
            $notifdata = $dbconnect->getTableData($selectnotijson);
            // print_r($dbconnect->getTableData($selectnotijson));

            for($i = 0; $i < count($notifdata); $i++){
                $notificationstatus = $notifdata[$i]['status'];
                $notification = $notifdata[$i]['message'];
                $notificationid = $notifdata[$i]['id'];
                $notificationimage = $notifdata[$i]['image'];
                $notificationtimestamp = $notifdata[$i]['time_stamp'];
                $notificationemail = $notifdata[$i]['admin_email'];

                $timeexhausted = ($presenttime - $notificationtimestamp);

                ?>

                    <div class="notification-content" id="<?php echo $notificationstatus === "unread"? "new-notification": "read-notification"; ?>">
                        <div class="notification-image">
    
                            <img src="./assets/images/notification_images/<?php echo $notificationimage; ?>" alt="notification image">
    
                        </div>
    
                        <div class="notification-text">
                            <p class="description"><?php echo $notification; ?></p>
    
                            <p class="timestamp">
                                <?php echo timepassed($timeexhausted); ?>
                            </p>
                        </div>
                    </div>

                <?php

                

                if($notificationstatus === "unread"){
                    $updatestat = array(
                        "tableName"=>"notification",
                        "tableParams"=>"status",
                        "paramValues"=>"read",
                        "identityParams"=>"id",
                        "identityParamsValues"=>$notificationid
                    );

                    $updatestatjson = json_encode($updatestat);

                    $dbconnect->updateTableRowData($updatestatjson);
                }
            }
        }else{

            ?>

            <p class="no-notification">No Notification Yet</p>

            <?php
        }


    }

}else{
    header("location:../index.php?page=dashboard");
}