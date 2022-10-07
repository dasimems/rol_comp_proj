<div class="settings-container">

    <div class="settings-content">

    
                <?php

                    $undisabledfield = "";

                    if(isset($_GET['action']) && !empty($_GET['action']) && isset($_GET['content']) && !empty($_GET['content'])){

                            $undisabledfield = $_GET['content'];

                    }

                ?>

        <div class="settings-content-details">

            <div class="settings-content-details-title">
                <h1>Profile Imformation</h1>
            </div>

            <div class="settings-details-content">


                <div class="settings-details-edit">

                    <form action="./functions/update.php?page=settings&action=edit&information=profile&content=<?php echo $undisabledfield; ?>" method="post">
                        <div class="form-content">
                            <label for="input-content">Name</label>

                            <input type="text" name="input-content" id="input-content" value="<?php echo ADMIN_NAME; ?>" placeholder= "Please Input Your Name"<?php  echo $undisabledfield === "name"? "": "disabled";?>>

                            
                        </div>

                        <div class="form-content">
                            <?php

                                if(isset($_GET['action']) && !empty($_GET['action']) && $undisabledfield === "name"){

                                    ?>

                                        <button type="button" id="red-button"><a href="./index.php?page=settings">Cancel</a></button>
                                        <button type="submit" id="green-button">Update</button>

                                    <?php
                                    
                                }else{

                            ?>
                                <button type="button" id="default-button"><a href="./index.php?page=settings&action=edit&content=name">Edit&nbsp; <i class="fas fa-edit"></i></a></button>

                            <?php

                            
                                    
                                }


                            ?>
                        </div>
                    </form>

                </div>

                <div class="settings-details-edit">

                    <form action="./functions/update.php?page=settings&action=edit&information=profile&content=<?php echo $undisabledfield; ?>" method="post">
                        <div class="form-content">
                            <label for="input-content">Email</label>

                            <input type="email" name="input-content" id="input-content" value="<?php echo ADMIN_EMAIL; ?>" placeholder= "Please Input Your Email Address"<?php  echo $undisabledfield === "email"? "": "disabled";?>>

                            
                        </div>

                        <div class="form-content">
                            <?php

                                if(isset($_GET['action']) && !empty($_GET['action']) && $undisabledfield === "email"){

                                    ?>

                                        <button type="button" id="red-button"><a href="./index.php?page=settings">Cancel</a></button>
                                        <button type="submit" id="green-button">Update</button>

                                    <?php
                                    
                                }else{

                            ?>
                                <button type="button" id="default-button"><a href="./index.php?page=settings&action=edit&content=email">Edit&nbsp; <i class="fas fa-edit"></i></a></button>

                            <?php

                            
                                    
                                }


                            ?>
                        </div>
                    </form>

                </div>

                <div class="settings-details-edit">

                    <form action="./functions/update.php?page=settings&action=edit&information=profile&content=<?php echo $undisabledfield; ?>_number" method="post">
                        <div class="form-content">
                            <label for="input-content">Mobile Number</label>

                            <input type="tel" name="input-content" id="input-content" value="<?php echo ADMIN_NUMBER; ?>" placeholder= "Please Input Your Mobile Number"<?php  echo $undisabledfield === "mobile"? "": "disabled";?>>

                            
                        </div>

                        <div class="form-content">
                            <?php

                                if(isset($_GET['action']) && !empty($_GET['action']) && $undisabledfield === "mobile"){

                                    ?>

                                        <button type="button" id="red-button"><a href="./index.php?page=settings">Cancel</a></button>
                                        <button type="submit" id="green-button">Update</button>

                                    <?php
                                    
                                }else{

                            ?>
                                <button type="button" id="default-button"><a href="./index.php?page=settings&action=edit&content=mobile">Edit&nbsp; <i class="fas fa-edit"></i></a></button>

                            <?php

                            
                                    
                                }


                            ?>
                        </div>
                    </form>

                </div>

                <div class="settings-details-edit">

                    <form action="./functions/update.php?page=settings&action=edit&information=profile&content=<?php echo $undisabledfield; ?>" method="post">
                        <div class="form-content">
                            <label for="input-content">Facebook Link</label>

                            <input type="text" name="input-content" id="input-content" value="<?php echo ADMIN_FACEBOOK; ?>" placeholder= "Please Input Your Facebook Link E. G https://www.facebook.com/your_username"<?php  echo $undisabledfield === "facebook"? "": "disabled";?>>

                            
                        </div>

                        <div class="form-content">
                            <?php

                                if(isset($_GET['action']) && !empty($_GET['action']) && $undisabledfield === "facebook"){

                                    ?>

                                        <button type="button" id="red-button"><a href="./index.php?page=settings">Cancel</a></button>
                                        <button type="submit" id="green-button">Update</button>

                                    <?php
                                    
                                }else{

                            ?>
                                <button type="button" id="default-button"><a href="./index.php?page=settings&action=edit&content=facebook">Edit&nbsp; <i class="fas fa-edit"></i></a></button>

                            <?php

                            
                                    
                                }


                            ?>
                        </div>
                    </form>

                </div>

                <div class="settings-details-edit">

                    <form action="./functions/update.php?page=settings&action=edit&information=profile&content=<?php echo $undisabledfield; ?>" method="post">
                        <div class="form-content">
                            <label for="input-content">Instagram Link</label>

                            <input type="text" name="input-content" id="input-content" value="<?php echo ADMIN_INSTAGRAM; ?>" placeholder= "Please Input Your Facebook Link E. G https://www.instagram.com/your_username"<?php  echo $undisabledfield === "instagram"? "": "disabled";?>>

                            
                        </div>

                        <div class="form-content">
                            <?php

                                if(isset($_GET['action']) && !empty($_GET['action']) && $undisabledfield === "instagram"){

                                    ?>

                                        <button type="button" id="red-button"><a href="./index.php?page=settings">Cancel</a></button>
                                        <button type="submit" id="green-button">Update</button>

                                    <?php
                                    
                                }else{

                            ?>
                                <button type="button" id="default-button"><a href="./index.php?page=settings&action=edit&content=instagram">Edit&nbsp; <i class="fas fa-edit"></i></a></button>

                            <?php

                            
                                    
                                }


                            ?>
                        </div>
                    </form>

                </div>

                <div class="settings-details-edit">

                    <form action="./functions/update.php?page=settings&action=edit&information=profile&content=<?php echo $undisabledfield; ?>" method="post">
                        <div class="form-content">
                            <label for="input-content">Twitter Link</label>

                            <input type="text" name="input-content" id="input-content" value="<?php echo ADMIN_TWITTER; ?>" placeholder= "Please Input Your Facebook Link E. G https://www.twitter.com/your_username"<?php  echo $undisabledfield === "twitter"? "": "disabled";?>>

                            
                        </div>

                        <div class="form-content">
                            <?php

                                if(isset($_GET['action']) && !empty($_GET['action']) && $undisabledfield === "twitter"){

                                    ?>

                                        <button type="button" id="red-button"><a href="./index.php?page=settings">Cancel</a></button>
                                        <button type="submit" id="green-button">Update</button>

                                    <?php
                                    
                                }else{

                            ?>
                                <button type="button" id="default-button"><a href="./index.php?page=settings&action=edit&content=twitter">Edit&nbsp; <i class="fas fa-edit"></i></a></button>

                            <?php

                            
                                    
                                }


                            ?>
                        </div>
                    </form>

                </div>

                

            </div>

        </div>

        
        <div class="settings-content-details">

            <div class="settings-content-details-title">
                <h1>Security</h1>
            </div>

            <div class="settings-details-content">

                <div class="settings-details-edit">

                    <form action="./functions/update.php?page=settings&action=edit&information=profile&content=<?php echo $undisabledfield; ?>" method="post">
                        <div class="form-content" id="password-field">

                            <label for="input-content">Change Password</label>

                            <input type="password" name="input-content" id="input-content" placeholder= "Old Password"<?php  echo $undisabledfield === "password"? "": "disabled";?>>

                            <input type="password" name="new-password-one" id="new-password-one" placeholder= "New Password"<?php  echo $undisabledfield === "password"? "": "disabled";?>>

                            <input type="password" name="new-password-two" id="new-password-two" placeholder= "New Password"<?php  echo $undisabledfield === "password"? "": "disabled";?>>

                            
                        </div>

                        <div class="form-content">
                            <?php

                                if(isset($_GET['action']) && !empty($_GET['action']) && $undisabledfield === "password"){

                                    ?>

                                        <button type="button" id="red-button"><a href="./index.php?page=settings">Cancel</a></button>
                                        <button type="submit" id="green-button">Update</button>

                                    <?php
                                    
                                }else{

                            ?>
                                <button type="button" id="default-button"><a href="./index.php?page=settings&action=edit&content=password">Change&nbsp; <i class="fas fa-edit"></i></a></button>

                            <?php

                            
                                    
                                }


                            ?>
                        </div>
                    </form>

                </div>

                

            </div>

        </div>

    </div>

</div>