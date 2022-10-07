
<?php

require_once("./includes/message.php");
require_once("./includes/mydb.php");
require_once("./includes/db.php");
require_once("./includes/check_user.php");

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php

            if(isset($_GET['page']) && !empty($_GET['page'])){

                echo ucwords($_GET['page']);
    
                if($_GET['page'] === "record" && isset($_GET['data']) && ($_GET['data'] === "hourly" || $_GET['data'] === "production")){
                    echo " | ".ucwords($_GET['data']) . " Report";
                }
            }else{
                echo "Dashboard";
            }
        
        
        ?></title>
        <meta name="description" content="">
        <link rel="stylesheet" href="../assets/css/all.css">
        <link rel="stylesheet" href="../assets/fonts/font-style.css">
        <link rel="stylesheet" href="./assets/css/index.css">
        <link rel="stylesheet" href="./assets/css/header.css">
    </head>

    <body>


        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <?php

        if(isset($_GET['operation']) && !empty($_GET['operation'])){

            $operation = $_GET['operation']
            ?>

                <div class="modal">

                    <div class="modal-container">
                        <?php

                        if(isset($_GET['page']) && !empty($_GET['page'])){
                            $operationpage = $_GET['page'];

                            if($operationpage === "record"){

                                if($operation === "share"){
                                    $link = "https://" . $_SERVER['SERVER_NAME'] . "/pages/share.php?key=thiuvsknyivybfdajhkbiyHYBVGVyadfhy";
                                    
                                    ?>

                                        <div class="share-content">

                                            <input type="text" id="share-input-box" value="<?php echo $link; ?>" disabled>
                                            
                                            <button onclick="copyrecordlink()"><i class="fas fa-copy"></i></button>
                                        </div>

                                        <div class="close-button">
                                            <button><a href="./index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=hourly&pagenum=1">Cancel</a></button>
                                        </div>

                                    <?php
                                }elseif($operation === "delete"){
                                    // /index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1&operation=delete&id=2

                                    $deletesearch = $_GET['search'];
                                    $deleteorder = $_GET['order'];
                                    $deletefilter = $_GET['filter'];
                                    $deletedata = $_GET['data'];
                                    $deletepagenum = $_GET['pagenum'];
                                    $deleteid = $_GET['id'];

                                    ?>

                                        <div class="record-delete-content">


                                            <p>Are You Sure You Want To Delete This Record</p>
    
                                            <div class="record-delete-button">

                                                <button id="default-button">
                                                    <a href="./index.php?page=record&search=<?php echo $deletesearch; ?>&order=<?php echo $deleteorder; ?>&filter=<?php echo $deletefilter; ?>&data=<?php echo $deletedata; ?>&pagenum=<?php echo $deletepagenum; ?>">Cancel</a>
                                                </button>

                                                <button id="red-button">
                                                    <a href="./functions/delete.php?page=record&search=<?php echo $deletesearch; ?>&order=<?php echo $deleteorder; ?>&filter=<?php echo $deletefilter; ?>&data=<?php echo $deletedata; ?>&pagenum=<?php echo $deletepagenum; ?>&operation=delete&id=<?php echo $deleteid; ?>">Yes</a>
                                                </button>

                                            </div>

                                        </div>

                                    <?php
                                }

                            }else if($operationpage === "profile"){

                                if($operation === "changeimage"){
                                    
                                    
                                    ?>

                                        <form action="./functions/update.php?page=profile&operation=changeimage" method="post" enctype="multipart/form-data">
                                        
                                            <div class="form-content">
                                                <label for="input-content">Change Profile Image</label>
                                                <input type="file" name="input-content" id="input-content" placeholder="Please Select A File">
                                            </div>

                                            <div class="form-content">

                                                <button id="red-button" type="button"><a href="./index.php?page=profile">Cancel</a></button>
                                                <button id="green-button" type="submit">Submit</button>

                                            </div>

                                        </form>

                                    <?php
                                }

                            }else if($operationpage === "admins"){

                                if($operation === "add"){

                                

                                    ?>

                                        <form action="./functions/add.php?page=admins&operation=addadmin" method="post" enctype="multipart/formdata">

                                                <div class="form-content">
                                                    <h1>Add New Admin</h1>
                                                </div>
                                            
                                                <div class="form-content">
                                                    <label for="admin-name">Admin Name</label>
                                                    <input type="text" name="admin-name" id="admin-name" placeholder="Please Input Admin Name" value="<?php echo isset($adminnameerror) && !empty($adminnameerror)? $adminnameerror : ""; ?>">
                                                </div>

                                                <div class="form-content">
                                                    <label for="admin-email">Admin Email</label>
                                                    <input type="email" name="admin-email" id="admin-email" placeholder="Please Input Admin Email" value="<?php echo isset($adminemailerror) && !empty($adminemailerror)? $adminemailerror : ""; ?>">
                                                </div>

                                                <div class="form-content">
                                                    <label for="admin-mobile-number">Admin Mobile Number</label>
                                                    <input type="tel" name="admin-mobile-number" id="admin-mobile-number" placeholder="Please Input Admin Mobile Number" value="<?php echo isset($adminmobilenumbererror) && !empty($adminmobilenumbererror)? $adminmobilenumbererror : ""; ?>">
                                                </div>

                                                <div class="form-content">
                                                    <label for="admin-address">Admin Address</label>
                                                    <input type="text" name="admin-address" id="admin-address" placeholder="Please Input Admin Address" value="<?php echo isset($adminaddresserror) && !empty($adminaddresserror)? $adminaddresserror : ""; ?>">
                                                </div>

                                                <div class="form-content">
                                                    <label for="admin-priviledge">Admin Priviledge</label>
                                                    <select name="admin-priviledge" id="admin-priviledge" value="<?php echo isset($adminpriviledgeerror) && !empty($adminpriviledgeerror)? $adminpriviledgeerror : "minimum"; ?>">
                                                        <option value="minimum">Minimum</option>
                                                        <option value="maximum">Maximum</option>
                                                    </select>
                                                </div>




                                                <div class="form-content">

                                                    <button id="red-button" type="button"><a href="./index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&pagenum=1">Cancel</a></button>
                                                    <button id="green-button" type="submit">Submit</button>

                                                </div>

                                            </form>

                                    <?php

                                }elseif($operation === "deleteadmin"){

                                    // /index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&pagenum=1&operation=deleteadmin&id=1

                                    $sentadminid = $_GET['id'];
                                    $search = $_GET['search'];
                                    $order = $_GET['order'];
                                    $filter = $_GET['filter'];
                                    $pagenum = $_GET['pagenum'];

                                    $getdeletearray = array(
                                        "tableName"=>"admin",
                                        "columns"=>"name",
                                        "identityParams"=>"id",
                                        "identityValues"=>$sentadminid
                                    );

                                    $getdeletedatajson = json_encode($getdeletearray);

                                    $getdeletedata = $dbconnect->getTableData($getdeletedatajson);

                                    ?>

                                        <div class="delete-admin-content">
                                            <p>Are You Sure You Want To Delete <span><?php echo explode(" ", $getdeletedata[0]['name'])[0]; ?></span> From Admin List?</p>

                                            <div class="delete-admin-button">
                                                <button id="default-button"><a href="./index.php?page=admins&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&pagenum=<?php echo $pagenum; ?>">Cancel</a></button>

                                                <button id="red-button"><a href="./functions/delete.php?page=admin&operation=deleteadmin&id=<?php echo $sentadminid; ?>">Yes</a></button>
                                            </div>
                                        </div>

                                    <?php

                                }elseif($operation === "viewadmindetails"){

                                    // /index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&pagenum=1&operation=deleteadmin&id=1

                                    $sentadminid = $_GET['id'];
                                    $search = $_GET['search'];
                                    $order = $_GET['order'];
                                    $filter = $_GET['filter'];
                                    $pagenum = $_GET['pagenum'];

                                    $getadmindetailsarray = array(
                                        "tableName"=>"admin",
                                        "identityParams"=>"id",
                                        "identityValues"=>$sentadminid
                                    );

                                    $getadmindetailsjson = json_encode($getadmindetailsarray);

                                    $getadmindata = $dbconnect->getTableData($getadmindetailsjson);

                                    ?>

                                        <div class="admin-profile-content">

                                            <div class="profile-content-details">

                                                <div class="profile-content-image">
                                                    <img src="./assets/images/profile_images/<?php echo $getadmindata[0]["image"]; ?>" alt="" srcset="">
                                                </div>

                                                <div class="profile-content-description">

                                                    <div class="profile-description-content">
                                                        <p class="title">Full Name:</p>
                                                        <p class="value"><?php echo $getadmindata[0]['name']; ?></p>
                                                    </div>

                                                    
                                                    <div class="profile-description-content">
                                                        <p class="title">Email Address:</p>
                                                        <p class="value"><?php echo $getadmindata[0]['email']; ?></p>
                                                    </div>

                                                    
                                                    <div class="profile-description-content">
                                                        <p class="title">Mobile Number:</p>
                                                        <p class="value"><?php echo $getadmindata[0]['mobile_number']; ?></p>
                                                    </div>

                                                    
                                                    <div class="profile-description-content">
                                                        <p class="title">Home Address:</p>
                                                        <p class="value"><?php echo $getadmindata[0]['address']; ?></p>
                                                    </div>

                                                    
                                                    <div class="profile-description-content">
                                                        <p class="title">Added By:</p>
                                                        <p class="value"><?php echo $getadmindata[0]['added_by']; ?></p>
                                                    </div>

                                                    
                                                    <div class="profile-description-content">
                                                        <p class="title">Date Added:</p>
                                                        <p class="value"><?php echo $getadmindata[0]['date_added']; ?></p>
                                                    </div>

                                                    
                                                    <div class="profile-description-content">
                                                        <p class="title">Social Link:</p>
                                                        
                                                        <div class="table-row-icon">
                                                            <?php

                                                            if(!empty($getadmindata[0]['facebook'])){
                                                                ?>

                                                                    <a href="<?php echo $getadmindata[0]['facebook']; ?>" target="_blank"><i class="fab fa-facebook-square"></i></a>
                                                                <?php
                                                            }

                                                            if(!empty($getadmindata[0]['instagram'])){

                                                                ?>

                                                                    <a href="<?php echo $getadmindata[0]['instagram']; ?>" target="_blank"><i class="fab fa-instagram-square"></i></a>
                                                                <?php

                                                            }

                                                            if(!empty($getadmindata[0]['twitter'])){

                                                                ?>

                                                                    <a href="<?php echo $getadmindata[0]['twitter']; ?>" target="_blank"><i class="fab fa-twitter-square"></i></a>
                                                                <?php

                                                            }

                                                            if(empty($getadmindata[0]['twitter']) && empty($getadmindata[0]['instagram']) && empty($getadmindata[0]['facebook'])){

                                                                ?>
                                                                    No Record Found!
                                                                <?php
                                                            }


                                                            ?>

                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        

                                                <button><a href="./index.php?page=admins&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&pagenum=<?php echo $pagenum; ?>"><i class="fas fa-times"></i></a></button>



                                        </div>
                                    
                                    <?php

                                }

                            }

                        }else{

                            header("loaction:./index.php?page=dashboard");

                        }

                        ?>
                    </div>

                </div>

            <?php
        }

        ?>
        <!-- Geting the header -->
        
        <?php require_once("./includes/header.php"); ?>
        
        <section id="main-body">
            
            <div class="side-bar">

                <!-- Getting the side nav-bar -->

                <?php require_once("./includes/nav_side.php"); ?>

            </div>

            <div class="main-container">

                <?php
                
                    $dir = "./pages"; // file directory for the pages

                    $availablepages = scandir($dir); // scans the directory for files and return an array of the found files
                    

                    if(isset($_GET['page']) && !empty($_GET['page'])){ // if the global attribute $_GET is set in the url and not empty, execute this code

                        $page = $_GET['page'] . ".php"; // gets the value of the $_GET['page'] from the url and adds .php at the back of the value gotten

                        if(in_array($page, $availablepages)){ // check the returned scanned directory if any file corresponds with the $page variable
                            require_once("./pages/" . $page); // requires the php file if it corresponds

                        }else{

                            require_once("./pages/dashboard.php"); // if it doesn't correspond, redirect to the following url

                        }

                    }else{

                        require_once("./pages/dashboard.php"); // if $_GET['page'] global variable isn't set, redirect to the url given

                    }

                
                ?>

            </div>

        </section>

        <script src="./assets/js/Chart_new.min.js"></script>

        <?php require_once("./includes/footer.php"); ?>

        
        
    </body>
</html>