<?php
session_start();
require_once("../includes/mydb.php");
require_once("../includes/db.php");
require_once("../includes/check_user.php");
//checking if the $_GET['page'] is set and not empty

if(isset($_GET['page']) && !empty($_GET['page'])){

    $page = $_GET['page'];

    

    if($page === "settings"){ //executes this codes when $page variable gotten from $_GET['page'] the header information is the same as settings

        if(isset($_GET['information']) && !empty($_GET['information'])){ // executes this code if $_GET['information'] is set and not empty

            $information = $_GET['information'];

            if($information === "profile"){ //executes this codes when $infformation variable gotten from $_GET['information'] the header information is the same as profile

                if(isset($_GET['content']) && !empty($_GET['content'])){ // executes this code if $_GET['content'] is set and not empty

                    $content = $_GET['content'];

                    if(isset($_POST['input-content'])){ // execute this code if the form is submited which sets the $_POST['input-content']

                        if(empty($_POST['input-content'])){

                            $_SESSION['message'] = "Please The Field Can't Be Left Empty";
                            $_SESSION['messagetype'] = "error-message";

                            header('location:../index.php?page=settings&action=edit&content=' . $content); // if $_POST['input-content'] is of empty value redirect to the given loaction


                        }else{

                            
                            if($content === "name"){

                                $regex = "/^([a-zA-Z' ]+)$/";
                                
                                if(preg_match($regex, $_POST['input-content'])){

                                    $inputcontent = $_POST['input-content'];
                                    
                                }else{

                                    $_SESSION['message'] = "Please Only Alphabets Are Allowed";
                                    $_SESSION['messagetype'] = "error-message";

                                    header('location:../index.php?page=settings&action=edit&content=' . $content); // if $_POST['input-content'] is of empty value redirect to the given loaction

                                }
                            }

                            if($content === "email"){

                                $regex = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
                                
                                if(preg_match($regex, $_POST['input-content'])){

                                    $inputcontent = $_POST['input-content'];
                                    
                                }else{

                                    $_SESSION['message'] = "Please Input A Valid Email";
                                    $_SESSION['messagetype'] = "error-message";

                                    header('location:../index.php?page=settings&action=edit&content=' . $content); // if $_POST['input-content'] is of empty value redirect to the given loaction

                                }
                            }

                            
                            if($content === "mobile_number"){

                                $regex = "/^[+][0-9]{9,14}+$/";
                                
                                if(preg_match($regex, $_POST['input-content'])){

                                    $inputcontent = $_POST['input-content'];
                                    
                                }else{

                                    $_SESSION['message'] = "Please Input A Valid Mobile Number";
                                    $_SESSION['messagetype'] = "error-message";

                                    header('location:../index.php?page=settings&action=edit&content=' . $content); // if $_POST['input-content'] is of empty value redirect to the given loaction

                                }
                            }

                            if($content === "facebook"){

                                $regex = "/^(https?:\/\/)(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/";
                                
                                if(preg_match($regex, $_POST['input-content'])){

                                    $inputcontent = $_POST['input-content'];
                                    
                                }else{

                                    $_SESSION['message'] = "Please Input A Valid Facebook Link";
                                    $_SESSION['messagetype'] = "error-message";

                                    header('location:../index.php?page=settings&action=edit&content=' . $content); // if $_POST['input-content'] is of empty value redirect to the given loaction

                                }
                            }

                            
                            if($content === "instagram"){

                                $regex = "/^(https?:\/\/)(www\.)?instagram.com\/[a-zA-Z0-9(\.\?)?]/";
                                
                                if(preg_match($regex, $_POST['input-content'])){

                                    $inputcontent = $_POST['input-content'];
                                    
                                }else{

                                    $_SESSION['message'] = "Please Input A Valid Instagram Link";
                                    $_SESSION['messagetype'] = "error-message";

                                    header('location:../index.php?page=settings&action=edit&content=' . $content); // if $_POST['input-content'] is of empty value redirect to the given loaction

                                }
                            }

                            if($content === "twitter"){

                                $regex = "/^(https?:\/\/)(www\.)?twitter.com\/[a-zA-Z0-9(\.\?)?]/";
                                
                                if(preg_match($regex, $_POST['input-content'])){

                                    $inputcontent = $_POST['input-content'];
                                    
                                }else{

                                    $_SESSION['message'] = "Please Input A Valid Twitter Link";
                                    $_SESSION['messagetype'] = "error-message";

                                    header('location:../index.php?page=settings&action=edit&content=' . $content); // if $_POST['input-content'] is of empty value redirect to the given loaction

                                }
                            }

                            if($content === "password"){

                                $oldpassword = $_POST['input-content'];

                                $savedpassword = $data[0]['password'];

                                if(password_verify($oldpassword, $savedpassword)){

                                    if(isset($_POST['new-password-one']) && !empty($_POST['new-password-one']) && isset($_POST['new-password-two']) && !empty($_POST['new-password-two'])){

                                        $newpasswordone = $_POST['new-password-one'];
                                        $newpasswordtwo = $_POST['new-password-two'];

                                        if($oldpassword === $newpasswordone){

                                            $_SESSION['message'] = "New Password Is The Same As The Old Password";
                                            $_SESSION['messagetype'] = "error-message";
        
                                            header('location:../index.php?page=settings&action=edit&content=' . $content); // if the value gotten from the input doesnt match the one in db redirect to the given loaction



                                        }else{

                                            if(strlen($newpasswordone) < 8){

                                                $_SESSION['message'] = "New Password Lenght Should Be Greater Than 7 Characters";
                                                $_SESSION['messagetype'] = "error-message";
            
                                                header('location:../index.php?page=settings&action=edit&content=' . $content); // if the value gotten from the input doesnt match the one in db redirect to the given loaction

                                            }else{

                                                if($newpasswordone === $newpasswordtwo){

                                                    $inputcontent = password_hash($newpasswordone, PASSWORD_DEFAULT);

                                                }else{
                                                    
                                                    $_SESSION['message'] = "New Password Doesn't Match";
                                                    $_SESSION['messagetype'] = "error-message";
                
                                                    header('location:../index.php?page=settings&action=edit&content=' . $content); // if the value gotten from the input doesnt match the one in db redirect

                                                }

                                            }

                                        }


                                    }else{

                                        $_SESSION['message'] = "New Password Field Can't Be Empty";
                                        $_SESSION['messagetype'] = "error-message";
    
                                        header('location:../index.php?page=settings&action=edit&content=' . $content); // if the value gotten from the input doesnt match the one in db redirect to the given loaction
                                    }

                                }else{

                                    $_SESSION['message'] = "Wrong Old Password";
                                    $_SESSION['messagetype'] = "error-message";

                                    header('location:../index.php?page=settings&action=edit&content=' . $content); // if the value gotten from the input doesnt match the one in db redirect to the given loaction

                                }
                            }

                            if(isset($inputcontent) && !empty($inputcontent)){

                                $insertarray = array(
                                    "tableName"=>"admin",
                                    "tableParams"=>$content,
                                    "paramValues"=>$inputcontent,
                                    "identityParams"=>"id",
                                    "identityParamsValues"=>ADMIN_ID
                                );

                                $insertarrayjson = json_encode($insertarray);

                                if($dbconnect->updateTableRowData($insertarrayjson)){

                                    if($content === "email"){
                                        $_SESSION['adminemail'] = $inputcontent;
                                    }

                                    $_SESSION['message'] = "Data Updated";
                                    $_SESSION['messagetype'] = "success-message";

                                    header('location:../index.php?page=settings'); // if data is updated, redirect to this location and give a success message

                                }else{
                                    $_SESSION['message'] = "Something Went Wrong! Please Try Again Later";
                                    $_SESSION['messagetype'] = "error-message";

                                    header('location:../index.php?page=settings'); // if data is updated, redirect to this location and give an error message
                                }

                            }else{

                                // header('location:../index.php?page=settings');
                            }

                        }

                    }else{
                        
                        header('location:../index.php?page=settings'); //else if $_POST['input-content'] is not set redirect to the given loaction

                    }

                }else{

                    header('location:../index.php?page=settings'); //else if $_GET['content'] is empty or not set redirect to the given loaction
                }


            }



        }else{ 

            header('location:../index.php?page=settings'); //else if $_GET['information'] is empty or not set redirect to the given loaction

        }

    }elseif($page === "profile"){

        if(isset($_FILES['input-content'])){
            if( !empty($_FILES['input-content']['name'])){

                if($_FILES['input-content']['error'] > 0){

                    
                    $_SESSION['message'] = "Something Went Wrong!";
                    $_SESSION['messagetype'] = "error-message";

                    header('location:../index.php?page=profile&operation=changeimage');

                }else{

                    $ex = array("images/png", "image/png", "png", "images/jpg", "image/jpg", "jpg", "images/jpeg", "image/jpeg", "jpeg", "images/svg", "image/svg", "svg", "images/gif", "image/gif", "gif");

                    if(in_array($_FILES['input-content']['type'], $ex)){

                        $imagetmpname = $_FILES['input-content']['tmp_name'];

                        $dir = "../assets/images/profile_images/" . ADMIN_ID . ".png";

                        echo $dir;

                        if(move_uploaded_file($imagetmpname, $dir)){

                            $inputcontent = ADMIN_ID . ".png";

                            $insertarray = array(
                                "tableName"=>"admin",
                                "tableParams"=>"image",
                                "paramValues"=>$inputcontent,
                                "identityParams"=>"id",
                                "identityParamsValues"=>ADMIN_ID
                            );

                            $insertarrayjson = json_encode($insertarray);

                            if($dbconnect->updateTableRowData($insertarrayjson)){


                                $_SESSION['message'] = "Profile Image Updated";
                                $_SESSION['messagetype'] = "success-message";

                                header('location:../index.php?page=profile'); // if data is updated, redirect to this location and give a success message

                            }else{
                                unlink($dir);
                                $_SESSION['message'] = "Something Went Wrong! Please Try Again Later";
                                $_SESSION['messagetype'] = "error-message";

                                header('location:../index.php?page=profile&operation=changeimage');
                            }



                        }else{

                            
                            $_SESSION['message'] = "Unable To Upload Image";
                            $_SESSION['messagetype'] = "error-message";

                            header('location:../index.php?page=profile&operation=changeimage');

                        }
                    }else{

                        
                        $_SESSION['message'] = "Please Upload Images Only";
                        $_SESSION['messagetype'] = "error-message";

                        header('location:../index.php?page=profile&operation=changeimage');

                    }


                }

            }else{

                

                $_SESSION['message'] = "Please Select An Image";
                $_SESSION['messagetype'] = "error-message";

                header('location:../index.php?page=profile&operation=changeimage'); // if the value gotten from the input doesnt match the one in db redirect to the given loaction

            }
        }else{

            header("location:../index.php?page=profile");

        }

        print_r($_FILES);
    }elseif($page === "record"){

        // echo "<pre>";
        // print_r($_POST);
        // print_r($_GET);
        
        // echo "</pre>";

        if(isset($_GET['search']) && !empty($_GET['search']) && isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['filter']) && !empty($_GET['filter']) && isset($_GET['data']) && !empty($_GET['data']) && isset($_GET['pagenum']) && !empty($_GET['pagenum']) && isset($_GET['editname']) && !empty($_GET['editname'])  && isset($_GET['id']) && !empty($_GET['id'])){

            // /update.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=hourly&pagenum=1&editname=7:30-8:30&id=2
            $search = $_GET['search'];
            $order = $_GET['order'];
            $filter = $_GET['filter'];
            $data = $_GET['data'];
            $pagenum = $_GET['pagenum'];
            $editname = $_GET['editname'];
            $id = $_GET['id'];

            if(isset($_POST[$editname]) && !empty($_POST[$editname])){

                if(is_nan($_POST[$editname])){
                    $_SESSION['message'] = "Please Input Only Numeric Characters";
                    $_SESSION['messagetype'] = "error-message";
                    header("location:../index.php?page=record&search=$search&order=$order&filter=$filter&data=$data&pagenum=$pagenum&editname=$editname&id=$id");

                }else{


                    $value = $_POST[$editname];
                    if($editname === "7:30-8:30"){
                        $column = "seven_eight_thirthy";
                        
                    }elseif($editname === "8:30-9:30"){
                        $column = "eight_nine_thirthy";

                    }elseif($editname === "9:30-10:30"){
                        $column = "nine_ten_thirthy";

                    }elseif($editname === "10:30-11:30"){
                        $column = "ten_eleven_thirthy";

                    }elseif($editname === "11:30-12:30"){
                        $column = "eleven_twelve_thirthy";

                    }elseif($editname === "12:30-1:30"){
                        $column = "twelve_one_thirthy";

                    }elseif($editname === "1:30-2:30"){
                        $column = "one_two_thirthy";

                    }elseif($editname === "2:30-3:30"){
                        $column = "two_three_thirthy";

                    }elseif($editname === "3:30-4:30"){
                        $column = "three_four_thirthy";

                    }elseif($editname === "4:30-5:30"){
                        $column = "four_five_thirthy";

                    }elseif($editname === "6:00-8:00"){
                        $column = "six_eight_clock";

                    }

                    // echo $value . "<br/>" . $column;

                    $updatearray = array(
                        "tableName"=>"h_r",
                        "tableParams"=>$column,
                        "paramValues"=>$value,
                        "identityParams"=>"id",
                        "identityParamsValues"=>$id
                    );

                    $updatearrayjson = json_encode($updatearray);

                    if($dbconnect->updateTableRowData($updatearrayjson)){
                        $_SESSION['message'] = "Record Updated";
                        $_SESSION['messagetype'] = "success-message";
                        header("location:../index.php?page=record&search=$search&order=$order&filter=$filter&data=$data&pagenum=$pagenum");
                    }else{

                        $_SESSION['message'] = "An Unknown Error Occured!";
                        $_SESSION['messagetype'] = "error-message";
                        header("location:../index.php?page=record&search=$search&order=$order&filter=$filter&data=$data&pagenum=$pagenum&editname=$editname&id=$id");

                    }

                }

            }else{
                $_SESSION['message'] = "You Can't Send An Empty Field";
                $_SESSION['messagetype'] = "error-message";
                header("location:../index.php?page=record&search=$search&order=$order&filter=$filter&data=$data&pagenum=$pagenum&editname=$editname&id=$id");

            }
        }else{
            header("location:../index.php?page=dashboard");
        }
    }
}

// print_r($_POST);