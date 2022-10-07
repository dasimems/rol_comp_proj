<?php

// if(!isset($_GET['page'])){
    
//     header("location:./index.php?page=dashboard");
    
// }else if(empty($_GET['page'])){
    
//     header("location:./index.php?page=dashboard");

// }


?>
<header>
    <div class="logo"></div>

    <div class="header-links">

        <ul>
            <li><a onclick="openNotifictation()"><i class="fas fa-bell"></i><span class="header-counter" id="notification-counter">0</span></a></li>
            <li><a onclick="openSettings()"><i class="fas fa-gear"></i><span><i class="fas fa-angle-down"></i></span></a></li>
        </ul>

        <div class="header-settings-link">

            <ul id="settings-link">
                <li><a href="./index.php?page=profile">Profile</a></li>
                <li><a href="./index.php?page=settings">Settings</a></li>
                <li><a href="./functions/logout.php">Logout</a></li>
            </ul>

        </div>

        <div class="header-notification-link">
            <div id="notification-details">

                <div class="notification-animation">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>

                <div class="notification-details-content">

                    
                </div>


            </div>
        </div>

    </div>
</header>