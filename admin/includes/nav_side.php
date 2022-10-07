
<nav>

    <div class="nav-button" onclick="hideNav()">
        <button>
            <i class="fas fa-arrow-left"></i>
        </button>
    </div>

    <!-- Getting the admin image -->
    <div class="nav-image">

        <div class="profile-image">

            <img src="./assets/images/profile_images/<?php echo ADMIN_IMAGE; ?>" alt="Profile Image" srcset="">

        </div>

    </div>

    <div class="nav-profile">

        <a href="./index.php?page=profile"><?php echo $profilename[0] ." " . substr($profilename[1], 0, 1) . "."; ?></a>

    </div>

    <div class="nav-links">

        <ul>
            <li><a href="<?php echo isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] === "dashboard"? "#" : "./index.php?page=dashboard";?>" id="<?php echo isset($_GET['page']) && $_GET['page'] === "dashboard"? "active" : "non-active" ; ?>"><i class="fas fa-home"></i> &nbsp;Dashboard</a></li>
        </ul>

        <?php

            if(ADMIN_PRIVILEDGE === "maximum"){
                ?>

                                
                    <ul>
                        <li><a href="<?php echo isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] === "admins"? "#" : "./index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&pagenum=1";?>" id="<?php echo isset($_GET['page']) && $_GET['page'] === "admins"? "active" : "non-active" ; ?>"><i class="fas fa-user"></i> &nbsp;Admins</a></li>
                    </ul>

                <?php
            }

        ?>


        <ul class="dropdown-container" onclick="openDropdown(0)" id="dropdown-one">
            <li><a href="#"  id="<?php echo isset($_GET['page']) && $_GET['page'] === "record"? "active" : "non-active" ; ?>"><button><i class="fas fa-add"></i></button> &nbsp;Reports</a></li>

            <ul class="dropdown-links">

                <li><a href="<?php echo isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] === "record" && isset($_GET['data']) && !empty($_GET['data']) && $_GET['data'] === "hourly"? "#" : "./index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=hourly&pagenum=1";?>" id="<?php echo isset($_GET['data']) && $_GET['data'] === "hourly"? "active" : "non-active" ; ?>">Hourly Report</a></li>

                <li><a href="<?php echo isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] === "record" && isset($_GET['data']) && !empty($_GET['data']) && $_GET['data'] === "production"? "#" : "./index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1";?>" id="<?php echo isset($_GET['data']) && $_GET['data'] === "production"? "active" : "non-active" ; ?>">Production Report</a></li>

            </ul>
        </ul>

    </div>

</nav>
