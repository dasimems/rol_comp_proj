
<?php

session_start();


// $_SESSION['message'] = "testing the error message";
// $_SESSION['messagetype'] = "error-message";

if(isset($_SESSION['message']) && !empty($_SESSION['message']) && isset($_SESSION['messagetype']) && !empty($_SESSION['messagetype'])){

$sentmessage = $_SESSION['message'];
$messagetype = $_SESSION['messagetype'];

if(isset($_SESSION['data']) && !empty($_SESSION['data'])){

    foreach($_SESSION['data'] as $key=>$value){

        $errorname = $key . "error";
        $$errorname = $value;

    }

    $_SESSION['data'] = null;
    
}

$_SESSION['message'] = null;
$_SESSION['messagetype'] = null;

?>

<div class="modal-message-container">

    <p id="<?php echo $messagetype; ?>"><?php echo $sentmessage;?></p>

</div>

<?php

    }

?>