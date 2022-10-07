<div class="profile-container">

    <div class="profile-content">

        <div class="profile-content-image">

            <div class="profile-image">
                <img src="./assets/images/profile_images/<?php echo ADMIN_IMAGE; ?>" alt="">

                <button><a href="./index.php?page=profile&operation=changeimage"><i class="fas fa-edit"></i></a></button>
            </div>

        </div>

        <div class="profile-content-details">

            <div class="profile-details-content">
                <p id="title">
                    Name :
                </p>

                <p id="value">
                    <?php echo ADMIN_NAME; ?>
                </p>
            </div>

            
            <div class="profile-details-content">
                <p id="title">
                    Email :
                </p>

                <p id="value">
                    <a href="mailto:<?php echo ADMIN_EMAIL; ?>"><?php echo ADMIN_EMAIL; ?></a>
                </p>
            </div>


            <div class="profile-details-content">
                <p id="title">
                    Mobile Number :
                </p>

                <p id="value">
                    <a href="tel:<?php echo ADMIN_NUMBER; ?>"><?php echo ADMIN_NUMBER; ?></a>
                </p>
            </div>


            <div class="profile-details-content">
                <p id="title">
                    Social :
                </p>

                <p id="value">
                    <?php 
                    
                        if(empty(ADMIN_FACEBOOK) && empty(ADMIN_INSTAGRAM) && empty(ADMIN_TWITTER)){
                            echo "No Available Social Link";
                        }else{
                           
                    
                            if(!empty(ADMIN_FACEBOOK)){

                                ?>
                                    <button><a href="<?php echo ADMIN_FACEBOOK; ?>" target="_blank"><i class="fab fa-facebook-square"></i></a></button>

                                <?php

                            }

                            if(!empty(ADMIN_INSTAGRAM)){

                                ?>

                                    <button><a href="<?php echo ADMIN_INSTAGRAM; ?>" target="_blank"><i class="fab fa-instagram-square"></i></a></button>

                                <?php

                            }

                            if(!empty(ADMIN_TWITTER)){

                                ?>

                                    <button><a href="<?php echo ADMIN_TWITTER; ?>" target="_blank"><i class="fab fa-twitter-square"></i></a></button>

                                <?php

                            }
                    ?>

                    <?php

                        }

                    ?>
                </p>
            </div>

        </div>

        <button id="profile-content-edit-button">
        
            <a href="./index.php?page=settings"><i class="fas fa-edit"></i></a>

        </button>

    </div>

</div>