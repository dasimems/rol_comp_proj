<?php
session_start();
require_once("../includes/mydb.php");
require_once("../includes/db.php");
require_once("../includes/check_user.php");

if(isset($_GET['page']) && !empty($_GET['page']) && isset($_GET['operation']) && !empty($_GET['operation'])){
    $dateadded = date("d F Y");
    $timeadded = date("H:i");
    $addedby = ADMIN_EMAIL;
    $timestamp = time();
    $yearmonths = array("January", "Febuary", "March", "April", "May", "June", "July", "August", "Semptember", "October", "November", "December");

    // $presenttimestamp = $timeclass->getTimestamp();

    // echo time();

    $page = $_GET['page'];
    $operation = $_GET['operation'];

    // echo $dateadded . "<br/>" . $timeadded . "<br/>" . $addedby;

    if($page === "admins"){
        
        if($operation === "addadmin"){
            // ( [admin-name] => [admin-email] => [admin-mobile-number] => [admin-address] => [admin-priviledge] => minimum )

            if(isset($_POST['admin-name']) && isset($_POST['admin-email']) && isset($_POST['admin-mobile-number']) && isset($_POST['admin-address']) && isset($_POST['admin-priviledge'])){

                $sessiondata = array(
                    "adminname"=>"",
                    "adminemail"=>"",
                    "adminmobilenumber"=>"",
                    "adminaddress"=>"",
                    "adminpriviledge"=>"",
                );


                
                if(!empty($_POST['admin-priviledge'])){

                    $newadminpriviledge = $_POST['admin-priviledge'];
                    $sessiondata['adminpriviledge'] = $newadminpriviledge;

                }else{
                    $_SESSION['message'] = "Admin Priviledge Can't Be Empty";
                    $_SESSION['messagetype'] = "error-message";
                    header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&operation=add&pagenum=1");

                }
                

                if(!empty($_POST['admin-address'])){

                    $newadminaddress = $_POST['admin-address'];
                    $sessiondata['adminaddress'] = $newadminaddress;

                }else{
                    $_SESSION['message'] = "Admin Address Can't Be Empty";
                    $_SESSION['messagetype'] = "error-message";
                    header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&operation=add&pagenum=1");

                }


                if(!empty($_POST['admin-mobile-number'])){

                    
                    $numberregex = "/^[+][0-9]{9,14}+$/";
                                
                    if(preg_match($numberregex, $_POST['admin-mobile-number'])){

                        $countemail = array(
                            "tableName"=>"admin",
                            "identityParams"=>"mobile_number",
                            "identityValues"=>$_POST['admin-mobile-number']
    
                        );
    
                        $countemailjson = json_encode($countemail);
    
                        if($dbconnect->countRow($countemailjson) > 0){
    
                            $_SESSION['message'] = "This Mobile Number Already Exist";
                            $_SESSION['messagetype'] = "error-message";
                            header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&operation=add&pagenum=1");
    
                        }else{
    
                            $newadminmobilenumber = $_POST['admin-mobile-number'];
                            $sessiondata['adminmobilenumber'] = $newadminmobilenumber;
                        }
                    }else{
                        $_SESSION['message'] = "Please Input A Valid Mobile Number";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&operation=add&pagenum=1");

                    }



                }else{
                    $_SESSION['message'] = "Admin Mobile Number Can't Be Empty";
                    $_SESSION['messagetype'] = "error-message";
                    header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&operation=add&pagenum=1");

                }                

                if(!empty($_POST['admin-email'])){

                    $emailregex = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";

                    if(preg_match($emailregex, $_POST['admin-email'])){

                        $countemail = array(
                            "tableName"=>"admin",
                            "identityParams"=>"email",
                            "identityValues"=>$_POST['admin-email']
    
                        );
    
                        $countemailjson = json_encode($countemail);
    
                        if($dbconnect->countRow($countemailjson) > 0){
    
                            $_SESSION['message'] = "This Email Already Exist";
                            $_SESSION['messagetype'] = "error-message";
                            header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&operation=add&pagenum=1");
    
                        }else{
    
                            $newadminemail = strtolower($_POST['admin-email']);
                            $sessiondata['adminemail'] = $newadminemail;
                        }

                    }else{
                        $_SESSION['message'] = "Please Input A Valid Email Address";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&operation=add&pagenum=1");

                    }

                    

                }else{
                    $_SESSION['message'] = "Admin Email Can't Be Empty";
                    $_SESSION['messagetype'] = "error-message";
                    header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&operation=add&pagenum=1");

                }

                if(!empty($_POST['admin-name'])){

                    $nameregex = "/^([a-zA-Z' ]+)$/";

                    if(preg_match($nameregex, $_POST['admin-name'])){

                        $newadminname = ucwords($_POST['admin-name']);
                        $sessiondata['adminname'] = $newadminname;

                    }else{

                        $_SESSION['message'] = "Admin Name Can Accept Only Alphabets";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&operation=add&pagenum=1");
                        
                    }


                }else{
                    $_SESSION['message'] = "Admin Name Can't Be Empty";
                    $_SESSION['messagetype'] = "error-message";
                    header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&operation=add&pagenum=1");

                }

                


                $_SESSION['data'] = $sessiondata;

                if(isset($newadminname) && !empty($newadminname) && isset($newadminemail) && !empty($newadminemail) && isset($newadminaddress) && !empty($newadminaddress) && isset($newadminmobilenumber) && !empty($newadminmobilenumber) && isset($newadminpriviledge) && !empty($newadminpriviledge)){

                    $passwordname = str_split($newadminname);
                    $passwordemail = str_split($newadminemail);
                    $passwordnumber = str_split($newadminmobilenumber);
                    
                    $passwordconcat = $passwordname[0].$passwordnumber[(count($passwordnumber) - 1)].$passwordemail[0].$passwordname[1].$passwordnumber[(count($passwordnumber) - 2)].$passwordemail[1];
                    $password = strtoupper($passwordconcat);
                    $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

                    // echo $password . "<br/>" . $hashedpassword;

                    $insertadminarray = array(
                        "tableName"=>"admin",
                        "tableParams"=>"name|email|mobile_number|password|address|priviledge|date_added|time_added|added_by",
                        "paramValues"=>"$newadminname|$newadminemail|$newadminmobilenumber|$hashedpassword|$newadminaddress|$newadminpriviledge|$dateadded|$timeadded|$addedby"

                    );

                    $insertadminjson = json_encode($insertadminarray);

                    if($dbconnect->insertTableRowData($insertadminjson)){

                        $notificationmessage = "A new Admin With The Name Of " . $newadminname . " Has Been Added By " . ADMIN_EMAIL . " Today $dateadded";

                        $insertnotifarray = array(
                            "tableName"=>"notification",
                            "tableParams"=>"message|admin_email|image|time_stamp",
                            "paramValues"=>"$notificationmessage|$addedby|avatar.svg|$timestamp"
    
                        );

                        $insertnotifjson = json_encode($insertnotifarray);

                        if($dbconnect->insertTableRowData($insertnotifjson)){

                            // /index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&pagenum=1

                            $_SESSION['message'] = "New Admin Added";
                            $_SESSION['messagetype'] = "success-message";
                            header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&pagenum=1");

                        }else{

                            $deletearray = array(
                                "tableName"=>"admin",
                                "identityParams"=>"email",
                                "identityValues"=>$newadminemail
                            );

                            $deletejson = json_encode($deletearray);

                            if($dbconnect->deleteRow($deletejson)){
                                $_SESSION['message'] = "Something Went Wrong! Record Added And Deleted";
                                $_SESSION['messagetype'] = "error-message";
                                header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&operation=add&pagenum=1");
                                
                            }else{
                                $_SESSION['message'] = "Something Went Wrong! Record Added And Not Deleted";
                                $_SESSION['messagetype'] = "error-message";
                                header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&operation=add&pagenum=1");
                            }

                        }



                    }else{
                        $_SESSION['message'] = "Something Went Wrong!";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&operation=add&pagenum=1");

                        
                    }

                }

            }else{

                header("location:../index.php?page=$page");

            }
        }
    }elseif($page === "record"){

        if(isset($_GET['data']) && !empty($_GET['data'])){

            $data = $_GET['data'];

            if($data === "hourly"){

                print_r($_POST);

                if(isset($_POST['line']) && isset($_POST['7:30-8:30']) && isset($_POST['8:30-9:30']) && isset($_POST['9:30-10:30']) && isset($_POST['10:30-11:30']) && isset($_POST['11:30-12:30']) && isset($_POST['12:30-1:30']) && isset($_POST['1:30-2:30']) && isset($_POST['2:30-3:30']) && isset($_POST['3:30-4:30']) && isset($_POST['4:30-5:30']) && isset($_POST['6:00-8:00'])){

                    $sessiondata = array(
                        "hourlyline"=>"",
                        "hourly730830"=>"",
                        "hourly830930"=>"",
                        "hourly9301030"=>"",
                        "hourly10301130"=>"",
                        "hourly11301230"=>"",
                        "hourly1230130"=>"",
                        "hourly130230"=>"",
                        "hourly230330"=>"",
                        "hourly330430"=>"",
                        "hourly430530"=>"",
                        "hourly600800"=>"",
                        "hourlytarget"=>""
                    );
                    

                    if(!empty($_POST['7:30-8:30'])){
                        
                        $hourly730830 = $_POST['7:30-8:30'];
                        $sessiondata['hourly730830'] = $hourly730830;
                    }else{

                        $hourly730830 = "0";

                    }

                    if(!empty($_POST['8:30-9:30'])){
                        
                        $hourly830930 = $_POST['8:30-9:30'];
                        $sessiondata['hourly830930'] = $hourly830930;
                    }else{
                        
                        $hourly830930 = "0";

                    }

                    

                    if(!empty($_POST['9:30-10:30'])){
                        
                        $hourly9301030 = $_POST['9:30-10:30'];
                        $sessiondata['hourly9301030'] = $hourly9301030;
                    }else{
                        
                        $hourly9301030 = "0";

                    }

                    

                    if(!empty($_POST['10:30-11:30'])){
                        
                        $hourly10301130 = $_POST['10:30-11:30'];
                        $sessiondata['hourly10301130'] = $hourly10301130;
                    }else{
                        
                        $hourly10301130 = "0";

                    }

                    

                    if(!empty($_POST['11:30-12:30'])){
                        
                        $hourly11301230 = $_POST['11:30-12:30'];
                        $sessiondata['hourly11301230'] = $hourly11301230;
                    }else{
                        
                        $hourly11301230 = "0";

                    }
                    

                    if(!empty($_POST['12:30-1:30'])){
                        
                        $hourly1230130 = $_POST['12:30-1:30'];
                        $sessiondata['hourly1230130'] = $hourly1230130;
                    }else{
                        
                        $hourly1230130 = "0";

                    }


                    if(!empty($_POST['1:30-2:30'])){
                        
                        $hourly130230 = $_POST['1:30-2:30'];
                        $sessiondata['hourly130230'] = $hourly130230;
                    }else{
                        
                        $hourly130230 = "0";

                    }


                    if(!empty($_POST['2:30-3:30'])){
                        
                        $hourly230330 = $_POST['2:30-3:30'];
                        $sessiondata['hourly230330'] = $hourly230330;
                    }else{
                        
                        $hourly230330 = "0";

                    }


                    if(!empty($_POST['3:30-4:30'])){
                        
                        $hourly330430 = $_POST['3:30-4:30'];
                        $sessiondata['hourly330430'] = $hourly330430;
                    }else{
                        
                        $hourly330430 = "0";

                    }


                    if(!empty($_POST['4:30-5:30'])){
                        
                        $hourly430530 = $_POST['4:30-5:30'];
                        $sessiondata['hourly430530'] = $hourly430530;
                    }else{
                        
                        $hourly430530 = "0";

                    }


                    if(!empty($_POST['6:00-8:00'])){
                        
                        $hourly600800 = $_POST['6:00-8:00'];
                        $sessiondata['hourly600800'] = $hourly600800;
                    }else{
                        
                        $hourly600800 = "0";

                    }

                    
                    if(!empty($_POST['target'])){

                        $hourlytarget = $_POST['target'];
                        $sessiondata['hourlytarget'] = $hourlytarget;

                    }else{

                        $_SESSION['message'] = "The Target Field Can't Be Empty";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=hourly&pagenum=1");
                    }

                    if(!empty($_POST['line'])){

                        $hourlyline = $_POST['line'];
                        $sessiondata['hourlyline'] = $hourlyline;

                    }else{

                        $_SESSION['message'] = "The Line Field Can't Be Empty";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=hourly&pagenum=1");
                    }

                    $_SESSION['data'] = $sessiondata;

                    if(isset($hourlyline) && isset($hourlytarget) && isset($hourly730830) && isset($hourly830930) && isset($hourly9301030) && isset($hourly10301130) && isset($hourly11301230) && isset($hourly1230130) && isset($hourly130230) && isset($hourly230330) && isset($hourly330430) && isset($hourly430530) && isset($hourly600800)){
                        $countreportarray = array(
                            "tableName"=>"h_r",
                            "identityParams"=>"date_added",
                            "identityValues"=>$dateadded
                        );

                        $countreportarrayjson = json_encode($countreportarray);

                        if($dbconnect->countRow($countreportarrayjson) > 0){
                            $_SESSION['message'] = "Found Data Recorded For Today! Please Update Data Instead";
                            $_SESSION['data'] = null;
                            $_SESSION['messagetype'] = "error-message";
                            header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=hourly&pagenum=1");
                        }else{

                            $columns = "line|date_added|seven_eight_thirthy|eight_nine_thirthy|nine_ten_thirthy|ten_eleven_thirthy|eleven_twelve_thirthy|twelve_one_thirthy|one_two_thirthy|two_three_thirthy|three_four_thirthy|four_five_thirthy|six_eight_clock|target|added_by|time_added";

                            $values = "$hourlyline|$dateadded|$hourly730830|$hourly830930|$hourly9301030|$hourly10301130|$hourly11301230|$hourly1230130|$hourly130230|$hourly230330|$hourly330430|$hourly430530|$hourly600800|$hourlytarget|$addedby|$timeadded";

                        
                            $inserthourlyarray = array(
                                "tableName"=>"h_r",
                                "tableParams"=>$columns,
                                "paramValues"=>$values

                            );

                            $inserthourlyjson = json_encode($inserthourlyarray);

                            if($dbconnect->insertTableRowData($inserthourlyjson)){

                                $_SESSION['message'] = "New Record Added";
                                $_SESSION['messagetype'] = "success-message";
                                header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=hourly&pagenum=1");

                            }else{
                                $_SESSION['message'] = "Unknown Error Occured!";
                                $_SESSION['messagetype'] = "error-message";
                                header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=hourly&pagenum=1");
                            }

                        }
                    }
                }

            }elseif($data === "production"){

                if(isset($_POST['line']) && isset($_POST['style']) && isset($_POST['po']) && isset($_POST['brand'])  && isset($_POST['input-quantity']) && isset($_POST['output-quantity']) && isset($_POST['rejection-quantity'])  && isset($_POST['order-quantity']) && isset($_POST['start-date']) && isset($_POST['end-date']) && isset($_POST['total'])){

                    $sessiondata = array(
                        "productionline"=>"",
                        "productionstyle"=>"",
                        "productionpo"=>"",
                        "productionbrand"=>"",
                        "productioninput"=>"",
                        "productionoutput"=>"",
                        "productionrejection"=>"",
                        "productionorder"=>"",
                        "productionstartdate"=>"",
                        "productionenddate"=>"",
                        "productiontotal"=>"",
                    );

                    if(!empty($_POST['total'])){

                        
                        

                        if(is_nan($_POST['total'])){

                            $_SESSION['message'] = "Production Total Column Accepts Only Numbers";
                            $_SESSION['messagetype'] = "error-message";
                            header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");
                        }else{
                            
                            $productiontotal = $_POST['total'];
                            $sessiondata['productiontotal'] = $productiontotal;
                        }

                    }else{

                        $_SESSION['message'] = "Production Total Can't Be Empty! Please Input Something";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");

                    }

                    if(!empty($_POST['end-date'])){
                        $productionenddate = $_POST['end-date'];
                        $sessiondata['productionenddate'] = $productionenddate;

                    }else{

                        $_SESSION['message'] = "Please Select End Date";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");

                    }

                    if(!empty($_POST['start-date'])){
                        $productionstartdate = $_POST['start-date'];
                        $sessiondata['productionstartdate'] = $productionstartdate;

                    }else{

                        $_SESSION['message'] = "Please Select Start Date";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");

                    }

                    if(!empty($_POST['order-quantity'])){

                        
                        

                        if(is_nan($_POST['order-quantity'])){
                            
                            $_SESSION['message'] = "Order Quantity Column Accepts Only Numbers";
                            $_SESSION['messagetype'] = "error-message";
                            header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");
                        }else{
                            
                            $productionorder = $_POST['order-quantity'];
                            $sessiondata['productionorder'] = $productionorder;
                        }

                    }else{

                        $_SESSION['message'] = "Order Quantity Can't Be Empty! Please Input Something";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");

                    }

                    if(!empty($_POST['rejection-quantity'])){

                            
                            $productionrejection = $_POST['rejection-quantity'];
                            $sessiondata['productionrejection'] = $productionrejection;
                        
                        
                    }else{
                        
                        $productionrejection = "0";
                        $sessiondata['productionrejection'] = $productionrejection;
                        

                    }

                    if(!empty($_POST['output-quantity'])){

                        
                        

                        if(is_nan($_POST['output-quantity'])){

                            $_SESSION['message'] = "Output Quantity Column Accepts Oly Numbers";
                            $_SESSION['messagetype'] = "error-message";
                            header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");

                        }else{
                            
                            $productionoutput = $_POST['output-quantity'];
                            $sessiondata['productionoutput'] = $productionoutput;
                        }

                    }else{

                        $_SESSION['message'] = "Output Quantity Can't Be Empty! Please Input Something";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");

                    }

                    if(!empty($_POST['input-quantity'])){

                        

                        if(is_nan($_POST['input-quantity'])){

                            
                            $_SESSION['message'] = "Input Quantity Column Accepts Numbers Only";
                            $_SESSION['messagetype'] = "error-message";
                            header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");


                        }else{
                            
                            $productioninput = $_POST['input-quantity'];
                            $sessiondata['productioninput'] = $productioninput;
                        }


                    }else{

                        $_SESSION['message'] = "Input Quantity Can't Be Empty! Please Input Something";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");

                    }

                    if(!empty($_POST['brand'])){
                        $productionbrand = $_POST['brand'];
                        $sessiondata['productionbrand'] = $productionbrand;

                    }else{

                        $_SESSION['message'] = "Brand Field Can't Be Empty! Please Input Something";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");

                    }

                    if(!empty($_POST['po'])){
                        $productionpo = $_POST['po'];
                        $sessiondata['productionpo'] = $productionpo;

                    }else{

                        $_SESSION['message'] = "PO Field Can't Be Empty! Please Input Something";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");

                    }

                    if(!empty($_POST['style'])){
                        $productionstyle = $_POST['style'];
                        $sessiondata['productionstyle'] = $productionstyle;

                    }else{

                        $_SESSION['message'] = "Style Field Can't Be Empty! Please Input Something";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");

                    }

                    if(!empty($_POST['line'])){

                        if(is_nan($_POST['line'])){

                            $_SESSION['message'] = "Please The Line Column Accepts Numbers Only";
                            $_SESSION['messagetype'] = "error-message";
                            header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");

                        }else{

                            $productionline = $_POST['line'];
                            $sessiondata['productionline'] = $productionline;
                        }

                    }else{

                        $_SESSION['message'] = "Line Field Can't Be Empty! Please Input Something";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");

                    }

                    $_SESSION['data'] = $sessiondata;

                    if(isset($productionline) && isset($productionstyle) && isset($productionpo) && isset($productionbrand) && isset($productioninput) && isset($productionoutput) && isset($productionrejection) && isset($productionorder) && isset($productionstartdate) && isset($productionenddate) && isset($productiontotal)){

                        $productionstartdateexplode = explode("-", $productionstartdate);
                        $productionenddateexplode = explode("-", $productionenddate);

                        $startdate = $productionstartdateexplode[2] . " " . $yearmonths[$productionstartdateexplode[1] -1 ] . " " . $productionstartdateexplode[0];

                        $enddate = $productionenddateexplode[2] . " " . $yearmonths[$productionenddateexplode[1] -1 ] . " " . $productionenddateexplode[0];

                        $columns = "line|style|po|brand|input_qty|output_qty|rejection_qty|order_qty|start_input_date|end_input_date|total|added_by|date_added|time_added";

                        $values = "$productionline|$productionstyle|$productionpo|$productionbrand|$productioninput|$productionoutput|$productionrejection|$productionorder|$startdate|$enddate|$productiontotal|$addedby|$dateadded|$timeadded";

                        

                        $insertproductionarray = array(
                            "tableName"=>"p_r",
                            "tableParams"=>$columns,
                            "paramValues"=>$values

                        );

                        $insertproductionjson = json_encode($insertproductionarray);

                        if($dbconnect->insertTableRowData($insertproductionjson)){

                            $_SESSION['data'] = null;
                            $_SESSION['message'] = "New Production Report Added";
                            $_SESSION['messagetype'] = "success-message";
                            header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");

                        }else{
                            $_SESSION['message'] = "Something Went Wrong!";
                            $_SESSION['messagetype'] = "error-message";
                            header("location:../index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1");
                        }
                    }

                }

            }

            // print_r($_POST);



        }else{

            header("location:../index.php?page=dashboard");

        }
    }

}else{
    header("location:../index.php?page=dashboard");
}

// print_r($_POST);