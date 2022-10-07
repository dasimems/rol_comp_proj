<div class="header-logo">
</div>

<div class="header-links">
    <ul>
        <li id="<?php echo $page === "hourlyreport.php"? "active-link": "" ; ?>"><a href="<?php echo $page === "hourlyreport.php"? "#": "./index.php?page=hourlyreport"; ?>">Hourly Report</a></li>
        <li id="<?php echo $page === "productionreport.php"? "active-link": "" ; ?>"><a href="<?php echo $page === "productionreport.php"? "#": "./index.php?page=productionreport" ; ?>">Production Report</a></li>
        <li><a href="<?php echo ADMIN_HEADER_LINK? "./admin/index.php?page=dashboard" : "./login/" ;?>"><?php echo ADMIN_HEADER_LINK? 'Dashboard ' : 'Login <i class="fas fa-sign-in"></i>'; ?> </a></li>
    </ul>
</div>