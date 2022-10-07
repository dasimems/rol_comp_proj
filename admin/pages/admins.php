<?php

    if(isset($_GET['page']) && !empty($_GET['page']) && isset($_GET['search']) && !empty($_GET['search']) && isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['filter']) && !empty($_GET['filter']) && isset($_GET['pagenum']) && !empty($_GET['pagenum']) && ADMIN_PRIVILEDGE === "maximum")
    {
        $page = $_GET['page'];
        $pagenum = $_GET['pagenum'];
        $order = $_GET['order'];
        $search = $_GET['search'];
        $filter = $_GET['filter'];

        // /index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&pagenum=1

        if($order !== "descending"){

            if(isset($_GET['searchby']) && !empty($_GET['searchby'])){
                $addlink = '&searchby='.$_GET['searchby'];
            }else{
                $addlink = "";
            }
            $orderlink = "./index.php?page=$page&search=$search".$addlink."&order=descending&filter=$filter&pagenum=$pagenum";
        }else{

            if(isset($_GET['searchby']) && !empty($_GET['searchby'])){
                $addlink = '&searchby='.$_GET['searchby'];
            }else{
                $addlink = "";
            }
            $orderlink = "./index.php?page=$page&search=$search".$addlink."&order=ascending&filter=$filter&pagenum=$pagenum";

        }

        $rowlimit = 10;
        $rowoffset = (($pagenum - 1) * $rowlimit);

        if($order === "descending"){

            $dataorder = "DESC";

        }else{

            $dataorder = "ASC";
        }

        if($search === "defaultsearchparameters"){

            $dataparam = array(

                "tableName"=>"admin",
                "order"=>$filter,
                "orderType"=>$dataorder,
                "limit"=>$rowlimit,
                "offset"=>$rowoffset
                
                
            );

            $dataparamjson = json_encode($dataparam);

            $tabledata = $dbconnect->getTableData($dataparamjson);

            // echo "<pre>";
            // print_r($tabledata);
            // echo "</pre>";
        }else{

            if(isset($_GET['searchby']) && !empty($_GET['searchby'])){
                $searchby = $_GET['searchby'];
            }else{
                $searchby = "name|email|mobile_number|address|date_added|added_by";

            }


            $dataparam = array(

                "tableName"=>"admin",
                "order"=>$filter,
                "orderType"=>$dataorder,
                "limit"=>$rowlimit,
                "offset"=>$rowoffset,
                "identityParams"=>$searchby,
                "identityValues"=>$search,
                "comparismOperator"=>"LIKE%"
                
                
            );

            $dataparamjson = json_encode($dataparam);

            $tabledata = $dbconnect->searchTable($dataparamjson);

            

        }

    
    

?>

        <div class="record-container">

            <div class="record-actions">

                        <div class="record-search">

                            <form action="./functions/search.php?page=admins&filter=<?php echo $filter; ?>&operation=search" method="post">

                                <div class="search-content">

                                    <div class="search-filter">


                                        <div class="search-filter-button">

                                            <button type="button" onclick="showSearchFilter()">
                                                <i class="fas fa-arrow-up-short-wide"></i>
                                            </button>

                                        </div>

                                        <input type="hidden" name="filter-value" id="filter-value">

                                    </div>
                                    <div class="search-box">

                                        <input type="text" name="search-value" id="search-value" value="<?php echo $search === "defaultsearchparameters"? "" : $search ; ?>">

                                    </div>
                                    <div class="search-button">

                                        <button type="submit">Search</button>

                                    </div>

                                    
                                    <div class="search-filter-links">

                                        <h2>Search By</h2>

                                        <ul>

                                            <li onclick="addfilter('name')"><a>Name</a></li>
                                            <li onclick="addfilter('email')"><a>Email</a></li>
                                            <li onclick="addfilter('mobile_number')"><a>Mobile Number</a></li>
                                            <li onclick="addfilter('address')"><a>Address</a></li>
                                            <li onclick="addfilter('date_added')"><a>Date Added</a></li>
                                            <li onclick="addfilter('added_by')"><a>Added By</a></li>
                                            <!-- <li onclick="addfilter('added_by')"><a>Added By</a></li> -->

                                        </ul>
                                                
                                    </div>

                                </div>

                            </form>

                        </div>

                        <div class="record-buttons">
                            
                            <button><a href="./index.php?page=admins&search=<?php echo $search; ?>&order=descending&filter=<?php echo $filter; ?>&operation=add&pagenum=<?php echo $pagenum; ?>"><i class="fas fa-add"></i></a></button>
                            <button onclick="printPage()"><a><i class="fas fa-print"></i></a></button>
                            <button><a href="./functions/save.php?page=<?php echo $page; ?>&search=<?php echo $search .$addlink; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&pagenum=<?php echo $pagenum; ?>"><i class="fas fa-save"></i></a></button>
                            <!-- <button><a href="./index.php?page=admins&search=<?php /* echo $search; */ ?>&order=descending&filter=<?php /* echo $filter; */ ?>&operation=share&pagenum=<?php /* echo $pagenum; */ ?>"><i class="fas fa-share"></i></a></button> -->
                            <button onclick="showFilterLink()"><a><i class="fas fa-sort"></i></a></button>

                            <div class="record-sort-by-items">

                                <h2>Sort By</h2>

                                <ul>

                                    <li><a href="./index.php?page=admins&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=id&pagenum=<?php echo $pagenum; ?>">No</a></li>
                                    <li><a href="./index.php?page=admins&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=name&pagenum=<?php echo $pagenum; ?>">Name</a></li>
                                    <li><a href="./index.php?page=admins&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=email&pagenum=<?php echo $pagenum; ?>">Email</a></li>
                                    <li><a href="./index.php?page=admins&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=mobile_number&pagenum=<?php echo $pagenum; ?>">Mobile Number</a></li>
                                    <li><a href="./index.php?page=admins&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=address&pagenum=<?php echo $pagenum; ?>">Address</a></li>
                                    <li><a href="./index.php?page=admins&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=date_added&pagenum=<?php echo $pagenum; ?>">Date Added</a></li>
                                    <li><a href="./index.php?page=admins&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=added_by&pagenum=<?php echo $pagenum; ?>">Added By</a></li>

                                </ul>

                            </div>

                        </div>

            </div>

            <div class="records-content">

                <div class="records-content-title">
                    <h1><?php echo $search === "defaultsearchparameters"? "Admin List" : "Search Result For \"" . $search. "\"" ; ?></h1>
                </div>

                <div class="records-content-table">

                                        
                    <table>

                        <thead>
                            <th>NO
                                <?php

                                    if($filter === "id"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?>
                            </th>
                            <th>Name
                                <?php

                                    if($filter === "name"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?>
                            </th>
                            <th>Email
                                <?php

                                    if($filter === "email"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?>
                            </th>
                            <th>Mobile Number
                                <?php

                                    if($filter === "mobile_number"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?>
                            </th>
                            <th>Address
                                <?php

                                    if($filter === "address"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?>
                            </th>
                            <th>social</th>
                            <th>Date Added
                                <?php

                                    if($filter === "date_added"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?>
                            </th>
                            <th>Added By
                                <?php

                                    if($filter === "added_by"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?>
                            </th>
                            <th>Action</th>
                        </thead> 
                        
                        <?php 

                            if($tabledata){
                                

                                for($b = 0; $b < count($tabledata); $b++){
                                    $datano = ($b + 1);
                                    $dataid = $tabledata[$b]["id"];
                                    $dataname = $tabledata[$b]["name"];
                                    $dataemail = $tabledata[$b]["email"];
                                    $datanumber = $tabledata[$b]["mobile_number"];
                                    $dataaddress = $tabledata[$b]["address"];
                                    $datafacebook = $tabledata[$b]["facebook"];
                                    $datatwitter = $tabledata[$b]["twitter"];
                                    $datainstagram = $tabledata[$b]["instagram"];
                                    $datadateadded = $tabledata[$b]["date_added"];
                                    $dataaddedby = $tabledata[$b]["added_by"];

                                    if($dataid === ADMIN_ID){
                                        
                                        $profilelink="./index.php?page=profile";
                                    }else{
                                        
                                        $profilelink="./index.php?page=$page&search=$search&order=$order&filter=$filter&pagenum=$pagenum&operation=viewadmindetails&id=$dataid";
                                    }

                                    ?>

                                        <tr>
                                            <td><?php echo $datano; ?></td>
                                            <td><?php echo strlen($dataname) > 10? substr($dataname, 0, 10)."...": $dataname; ?></td>
                                            <td><?php echo strlen($dataemail) > 10? substr($dataemail, 0, 10)."...": $dataemail; ?></td>
                                            <td><?php echo $datanumber; ?></td>
                                            <td><?php echo strlen($dataaddress) > 10? substr($dataaddress, 0, 10)."...": $dataaddress; ?></td>
                                            <td>

                                                <div class="table-row-icon">
                                                    <?php

                                                    if(!empty($datafacebook)){
                                                        ?>

                                                            <a href="<?php echo $datafacebook; ?>" target="_blank"><i class="fab fa-facebook-square"></i></a>
                                                        <?php
                                                    }

                                                    if(!empty($datainstagram)){

                                                        ?>

                                                            <a href="<?php echo $datainstagram; ?>" target="_blank"><i class="fab fa-instagram-square"></i></a>
                                                        <?php

                                                    }

                                                    if(!empty($datatwitter)){

                                                        ?>

                                                            <a href="<?php echo $datatwitter; ?>" target="_blank"><i class="fab fa-twitter-square"></i></a>
                                                        <?php

                                                    }

                                                    if(empty($datatwitter) && empty($datainstagram) && empty($datafacebook)){

                                                        ?>
                                                            No Record Found!
                                                        <?php
                                                    }


                                                    ?>

                                                </div>

                                            </td>
                                            <td><?php echo $datadateadded; ?></td>
                                            <td><?php echo strlen($dataaddedby) > 10? substr($dataaddedby, 0, 10)."...": $dataaddedby; ?></td>

                                            <td>

                                                    <div class="table-row-buttons">

                                                    <!-- /index.php?page=admins&search=defaultsearchparameters&order=descending&filter=id&pagenum=1# -->

                                                        <a id="view-link" href="<?php echo $profilelink; ?>"><i class="fas fa-eye"></i></a>

                                                        <?php

                                                            if($dataid !== ADMIN_ID){
                                                                ?>

                                                                    <a id="delete-link" href="./index.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&pagenum=<?php echo $pagenum; ?>&operation=deleteadmin&id=<?php echo $dataid;?>"><i class="fas fa-trash-alt"></i></a>
                                                                    
                                                                <?php
                                                            }

                                                        ?>
                                                        
                                                        

                                                    </div>

                                            </td>
                                        </tr>

                                    <?php
                                }
                                
                            }else{
                                
                                ?>

                                    <tr>
                                        <td colspan = "9">No Record Found</td>
                                    </tr>

                                <?php
                                
                            }
                        
                        
                        ?>

                        <!-- <tr>
                            <th>1</th>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                            <td>100</td>
                        </tr> -->


                    </table>                   

                </div>

                <div class="record-next-prev-page-btn">



                    <?php

                        if($search === "defaultsearchparameters"){

                            $dataparam = array(

                                "tableName"=>"admin"
                                
                                
                            );

                            $dataparamjson = json_encode($dataparam);

                            $counttabledata = $dbconnect->getTableData($dataparamjson);
                            
                            $linksearchby = "";

                            // echo "<pre>";
                            // print_r($tabledata);
                            // echo "</pre>";
                        }else{

                            if(isset($_GET['searchby']) && !empty($_GET['searchby'])){
                                $searchby = $_GET['searchby'];
                                $linksearchby = "&searchby=".$_GET['searchby'];
                            }else{
                                $searchby = "name|email|mobile_number|address|date_added|added_by";
                                $linksearchby = "";

                            }


                            $dataparam = array(

                                "tableName"=>"admin",
                                "identityParams"=>$searchby,
                                "identityValues"=>$search,
                                "comparismOperator"=>"LIKE%"
                                
                                
                            );

                            $dataparamjson = json_encode($dataparam);

                            $counttabledata = $dbconnect->searchTable($dataparamjson);

                            

                        }

                        if(is_array($counttabledata)){
                            $totaldatanumber = ceil(count($counttabledata) / $rowlimit);
                        }else{
                            $totaldatanumber = 0;

                        }

                        // echo $totaldatanumber . "<Br/>";


                                            if(isset($_GET['pagenum']) && !empty($_GET['pagenum']) && $_GET['pagenum'] <= $totaldatanumber){
                                                $pagenum = $_GET['pagenum'];
                                                $previouspagenum = $pagenum - 1;
                                                $nextpagenum = $pagenum + 1;

                                            
                                                if($pagenum > 1){

                                                
                                        ?>

                                            <button><a href="./index.php?page=admins&search=<?php echo $search; ?>&order=descending&filter=<?php echo $filter; ?>&pagenum=<?php echo $previouspagenum.$linksearchby; ?>"><i class="fas fa-angles-left"></i></a></button>

                                            <?php

                                                }

                                                for($t = 0; $t < $totaldatanumber; $t++){

                                                $calpagenum = $t + 1;

                                                if($calpagenum == $pagenum){
                                                    $id = "active-page-num";


                                                    $pagelinks = "#";
                                                }else{
                                                    $id="non-active-page-num";

                                                    $pagelinks = "./index.php?page=admins&search=$search&order=descending&filter=$filter&pagenum=$calpagenum".$linksearchby;
                                                }

                                                // echo $calpagenum;
                                                // echo $pagenum;

                                            ?>

                                            

                                            <button id="<?php echo $id; ?>"><a href="<?php echo $pagelinks; ?>"><?php echo $calpagenum; ?></a></button>

                                            <?php

                                                }

                                                if($pagenum < $totaldatanumber){

                                                

                                            ?>


                                            <button><a href="./index.php?page=admins&search=<?php echo $search; ?>&order=descending&filter=<?php echo $filter; ?>&pagenum=<?php echo $nextpagenum.$linksearchby; ?>"><i class="fas fa-angles-right"></i></a></button>

                                        <?php

                                                }

                                            }

                                        ?>

                                    </div>

                                    

                </div>

        </div>

<?php

    }else{

        header("location:./index.php?page=dashboard");
    }

?>

