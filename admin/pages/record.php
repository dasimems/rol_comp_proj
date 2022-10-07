<?php

if(isset($_GET['page']) && !empty($_GET['page']) && isset($_GET['data']) && !empty($_GET['data'])  && isset($_GET['filter']) && !empty($_GET['filter'])  && isset($_GET['search']) && !empty($_GET['search']) && isset($_GET['pagenum']) && !empty($_GET['pagenum'])  && isset($_GET['order']) && !empty($_GET['order'])){
    $data = $_GET['data'];
    $filter = $_GET['filter'];
    $todaydate = date("d F Y");
    $search = $_GET['search'];
    $pagenum = $_GET['pagenum'];
    $order = $_GET['order'];
    $page = $_GET['page'];

    if(isset($_GET['editname']) && !empty($_GET['editname']) && isset($_GET['id']) && !empty($_GET['id'])){
        $editname = $_GET['editname'];
        $editid = $_GET['id'];
    }else{
        $editname = "";
        $editid = "";
    }

    // /index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=hourly&pagenum=1

    if($order !== "descending"){

        if(isset($_GET['searchby']) && !empty($_GET['searchby'])){
            $addlink = '&searchby='.$_GET['searchby'];
        }else{
            $addlink = "";
        }
        $orderlink = "./index.php?page=$page&search=$search".$addlink."&order=descending&filter=$filter&data=$data&pagenum=$pagenum";
    }else{

        if(isset($_GET['searchby']) && !empty($_GET['searchby'])){
            $addlink = '&searchby='.$_GET['searchby'];
        }else{
            $addlink = "";
        }
        $orderlink = "./index.php?page=$page&search=$search".$addlink."&order=ascending&filter=$filter&data=$data&pagenum=$pagenum";

    }


    if($order === "descending"){

        $dataorder = "DESC";

    }else{

        $dataorder = "ASC";
    }

    if($data === "hourly"){

        $tablename = "h_r";

        if(isset($_GET['searchby']) && !empty($_GET['searchby'])){
            $searchby = $_GET['searchby'];
        }else{
            $searchby = "line|date_added";

        }

        
    }else{

        $tablename = "p_r";

        if(isset($_GET['searchby']) && !empty($_GET['searchby'])){
            $searchby = $_GET['searchby'];
        }else{
            $searchby = "line|style|po|brand|start_input_date|end_input_date";

        }
    }

    
    $rowlimit = 10;

    if($search === "defaultsearchparameters"){
    
        $dataparam = array(

            "tableName"=>$tablename,
            "order"=>$filter,
            "orderType"=>$dataorder,
            
            
        );

        $dataparamjson = json_encode($dataparam);

        $tabledatacount = $dbconnect->getTableData($dataparamjson);

        // echo "<pre>";
        // print_r($tabledata);
        // echo "</pre>";
    }else{


        $dataparam = array(

            "tableName"=>$tablename,
            "order"=>$filter,
            "orderType"=>$dataorder,
            "identityParams"=>$searchby,
            "identityValues"=>$search,
            "comparismOperator"=>"LIKE%"
            
            
        );

        $dataparamjson = json_encode($dataparam);

        $tabledatacount = $dbconnect->searchTable($dataparamjson);

    }

    if(is_array($tabledatacount)){
        $datacount = ceil(count($tabledatacount)/10);
    }else{
        $datacount = 0;
    }

    if($pagenum > $datacount){
        $pagenum = $datacount;
    }
    
    $rowoffset = (($pagenum - 1) * $rowlimit);

    if($rowoffset < 0){
        $rowoffset = 0;
    }

    // echo $rowoffset;

    if($search === "defaultsearchparameters"){
    
        $dataparam = array(

            "tableName"=>$tablename,
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


        $dataparam = array(

            "tableName"=>$tablename,
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

                    <form action="./functions/search.php?page=record&filter=<?php echo $filter; ?>&data=<?php echo $data;?>&operation=search" method="post">

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

                                <input type="text" name="search-value" id="search-value" value="<?php echo $search !== "defaultsearchparameters"? $search : "";?>">

                            </div>
                            <div class="search-button">

                                <button type="submit">Search</button>

                            </div>

                            
                            <div class="search-filter-links">

                                <h2>Search By</h2>

                                <ul>

                                    <?php

                                        if($data === "hourly"){
                                            ?>

                                                <li onclick="addfilter('line')"><a>Line</a></li>
                                                <li onclick="addfilter('date_added')"><a>Date</a></li>

                                            <?php
                                        }elseif($data === "production"){

                                            ?>

                                                <li onclick="addfilter('line')"><a>Line</a></li>
                                                <li onclick="addfilter('style')"><a>Style</a></li>
                                                <li onclick="addfilter('po')"><a>PO</a></li>
                                                <li onclick="addfilter('brand')"><a>Brand</a></li>
                                                <li onclick="addfilter('start_input_date')"><a>Start Date</a></li>
                                                <li onclick="addfilter('end_input_date')"><a>End Date</a></li>

                                            <?php

                                        }

                                    ?>

                                </ul>
                                        
                            </div>

                        </div>

                    </form>

                </div>

                <div class="record-buttons">
                    <button><a href="#add-row"><i class="fas fa-add"></i></a></button> 

                    <button onclick="printPage()"><a><i class="fas fa-print"></i></a></button>
                    <button><a href="./functions/save.php?page=<?php echo $page; ?>&search=<?php echo $search .$addlink; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>"><i class="fas fa-save"></i></a></button>
                    <button><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&operation=share&pagenum=<?php echo $pagenum; ?>"><i class="fas fa-share"></i></a></button>
                    <button onclick="showFilterLink()"><a><i class="fas fa-sort"></i></a></button>

                    <div class="record-sort-by-items">

                        <h2>Sort By</h2>

                        <ul>
                            <?php

                                if($data === "hourly"){

                                    ?>

                                        <li><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=id&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>">No</a></li>
                                        <li><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=line&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>">Line</a></li>
                                        <li><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=date_added&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>">Date</a></li>
                                        <li><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=target&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>">Target</a></li>

                                    <?php

                                }elseif($data === "production"){

                                    ?>

                                        <li><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=id&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>">No</a></li>
                                        <li><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=line&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>">Line</a></li>
                                        <li><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=style&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>">Style</a></li>
                                        <li><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=po&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>">PO</a></li>
                                        <li><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=brand&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>">Brand</a></li>
                                        <li><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=input_qty&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>">Input Quantity</a></li>
                                        <li><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=output_qty&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>">Output Quantity</a></li>
                                        <li><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=rejection_qty&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>">Rejection Quantity</a></li>
                                        <li><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=order_qty&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>">Order Quantity</a></li>
                                        <li><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=start_input_date&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>">Start Date</a></li>
                                        <li><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=end_input_date&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>">End Date</a></li>
                                        <li><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=total&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>">Total</a></li>

                                    <?php



                                }

                            ?>
                        </ul>

                    </div>

                </div>

            </div>

            <div class="records-content">

                

                <?php

                    if($search !== "defaultsearchparameters"){
                        ?>

                            <button>
                                <a href="./index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=<?php echo $data; ?>&pagenum=1"><i class="fas fa-long-arrow-left"></i></a>
                            </button>

                        <?php
                    }


                    if($data === "hourly"){

                        ?>

                            <div class="records-content-title">
                                <h1>

                                    <?php 

                                        if($search === "defaultsearchparameters"){

                                            ?>

                                                Hourly Production Report

                                            <?php

                                        }else{

                                            ?>
                                            
                                                Hourly Production Search For "<?php echo $search; ?>"

                                            <?php

                                        }

                                    ?>
                                    
                                </h1>
                            </div>

                            <div class="records-content-table">

                                <table class="hourly">

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
                                        <th>Line

                                            <?php

                                    if($filter === "line"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?>

                                        </th>
                                        <th>Date

                                            <?php

                                    if($filter === "date_added"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?>

                                        </th>
                                        <th>7:30<br/>-<br/>8:30</th>
                                        <th>8:30<br/>-<br/>9:30</th>
                                        <th>9:30<br/>-<br/>10:30</th>
                                        <th>10:30<br/>-<br/>11:30</th>
                                        <th>11:30<br/>-<br/>12:30</th>
                                        <th>12:30<br/>-<br/>1:30</th>
                                        <th>1:30<br/>-<br/>2:30</th>
                                        <th>2:30<br/>-<br/>3:30</th>
                                        <th>3:30<br/>-<br/>4:30</th>
                                        <th>4:30<br/>-<br/>5:30</th>
                                        <th>6:00<br/>-<br/>8:00</th>
                                        <th>Target

                                            <?php

                                    if($filter === "target"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?>

                                        </th>
                                        <th>Action</th>
                                    </thead>

                                    <?php 


                                    if($tabledata < 1){

                                        ?>

                                            <tr>
                                                <td colspan="16">No Record Found!</td>
                                            </tr>

                                        <?php

                                    }else{

                                        for($b = 0; $b < count($tabledata); $b++){
                                            $datano = ($b + 1);
                                            $dataid = $tabledata[$b]['id'];
                                            $dataline = $tabledata[$b]['line'];
                                            $datadateadded = $tabledata[$b]['date_added'];
                                            $data730830 = $tabledata[$b]['seven_eight_thirthy'];
                                            $data830930 = $tabledata[$b]['eight_nine_thirthy'];
                                            $data9301030 = $tabledata[$b]['nine_ten_thirthy'];
                                            $data10301130 = $tabledata[$b]['ten_eleven_thirthy'];
                                            $data11301230 = $tabledata[$b]['eleven_twelve_thirthy'];
                                            $data1230130 = $tabledata[$b]['twelve_one_thirthy'];
                                            $data130230 = $tabledata[$b]['one_two_thirthy'];
                                            $data230330 = $tabledata[$b]['two_three_thirthy'];
                                            $data330430 = $tabledata[$b]['three_four_thirthy'];
                                            $data430530 = $tabledata[$b]['four_five_thirthy'];
                                            $data600800 = $tabledata[$b]['six_eight_clock'];
                                            $datatarget = $tabledata[$b]['target'];

                                        ?>

                                            <tr>
                                                <th><?php echo $datano; ?></th>
                                                <td><?php echo $dataline; ?></td>
                                                <td><?php echo $datadateadded ?></td>
                                                    
                                                    <td id="<?php echo $editname === "7:30-8:30" && $editid == $dataid  ? "allow-edit" : "default" ; ?>">
        
                                                        <form action="./functions/update.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter;?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum ?>&editname=7:30-8:30&id=<?php echo $dataid; ?>" method="POST">
        
                                                            <input type="number" name="7:30-8:30" id="7:30-8:30" value="<?php echo $data730830; ?>" <?php echo $editname === "7:30-8:30" && $editid == $dataid? "" : "disabled"; ?>>
        
                                                        </form>
        
                                                        
                                                        <?php 
                                                        
                                                            if($editname !== "7:30-8:30"){
                                                        
                                                        ?>
        
                                                        
                                                        <button id="edit-data-button">
        
                                                            <a href="./index.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>&editname=7:30-8:30&id=<?php echo $dataid; ?>"><i class="fas fa-pencil"></i></a>
        
                                                        </button>
        
                                                        <?php
        
                                                            }
        
                                                        ?>
        
                                                    </td>
                                                    
                                                    <td id="<?php echo $editname === "8:30-9:30" && $editid == $dataid  ? "allow-edit" : "default" ; ?>">
        
                                                        <form action="./functions/update.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter;?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum ?>&editname=8:30-9:30&id=<?php echo $dataid; ?>" method="POST">
        
                                                            <input type="number" name="8:30-9:30" id="8:30-9:30" value="<?php echo $data830930; ?>" <?php echo $editname === "8:30-9:30" && $editid == $dataid? "" : "disabled"; ?>>
        
                                                        </form>
        
                                                        
                                                        <?php 
                                                        
                                                            if($editname !== "8:30-9:30"){
                                                        
                                                        ?>
        
                                                        
                                                        <button id="edit-data-button">
        
                                                            <a href="./index.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>&editname=8:30-9:30&id=<?php echo $dataid; ?>"><i class="fas fa-pencil"></i></a>
        
                                                        </button>
        
                                                        <?php
        
                                                            }
        
                                                        ?>
        
                                                    </td>
                                                    
                                                    <td id="<?php echo $editname === "9:30-10:30" && $editid == $dataid ? "allow-edit" : "default" ; ?>">
        
                                                        <form action="./functions/update.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter;?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum ?>&editname=9:30-10:30&id=<?php echo $dataid; ?>" method="POST">
        
                                                            <input type="number" name="9:30-10:30" id="9:30-10:30" value="<?php echo $data9301030; ?>" <?php echo $editname === "9:30-10:30" && $editid == $dataid? "" : "disabled"; ?>>
        
                                                        </form>
        
                                                        
                                                        <?php 
                                                        
                                                            if($editname !== "9:30-10:30"){
                                                        
                                                        ?>
        
                                                        
                                                        <button id="edit-data-button">
        
                                                            <a href="./index.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>&editname=9:30-10:30&id=<?php echo $dataid; ?>"><i class="fas fa-pencil"></i></a>
        
                                                        </button>
        
                                                        <?php
        
                                                            }
        
                                                        ?>
        
                                                    </td>
                                                    
                                                    <td id="<?php echo $editname === "10:30-11:30" && $editid == $dataid    ? "allow-edit" : "default" ; ?>">
        
                                                        <form action="./functions/update.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter;?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum ?>&editname=10:30-11:30&id=<?php echo $dataid; ?>" method="POST">
        
                                                            <input type="number" name="10:30-11:30" id="10:30-11:30" value="<?php echo $data10301130; ?>" <?php echo $editname === "10:30-11:30" && $editid == $dataid? "" : "disabled"; ?>>
        
                                                        </form>
        
                                                        
                                                        <?php 
                                                        
                                                            if($editname !== "10:30-11:30"){
                                                        
                                                        ?>
        
                                                        
                                                        <button id="edit-data-button">
        
                                                            <a href="./index.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>&editname=10:30-11:30&id=<?php echo $dataid; ?>"><i class="fas fa-pencil"></i></a>
        
                                                        </button>
        
                                                        <?php
        
                                                            }
        
                                                        ?>
        
                                                    </td>
                                                    
                                                    <td id="<?php echo $editname === "11:30-12:30" && $editid == $dataid    ? "allow-edit" : "default" ; ?>">
        
                                                        <form action="./functions/update.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter;?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum ?>&editname=11:30-12:30&id=<?php echo $dataid; ?>" method="POST">
        
                                                            <input type="number" name="11:30-12:30" id="11:30-12:30" value="<?php echo $data11301230; ?>" <?php echo $editname === "11:30-12:30" && $editid == $dataid? "" : "disabled"; ?>>
        
                                                        </form>
        
                                                        
                                                        <?php 
                                                        
                                                            if($editname !== "11:30-12:30"){
                                                        
                                                        ?>
        
                                                        
                                                        <button id="edit-data-button">
        
                                                            <a href="./index.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>&editname=11:30-12:30&id=<?php echo $dataid; ?>"><i class="fas fa-pencil"></i></a>
        
                                                        </button>
        
                                                        <?php
        
                                                            }
        
                                                        ?>
        
                                                    </td>
                                                    
                                                    <td id="<?php echo $editname === "12:30-1:30" && $editid == $dataid ? "allow-edit" : "default" ; ?>">
        
                                                        <form action="./functions/update.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter;?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum ?>&editname=12:30-1:30&id=<?php echo $dataid; ?>" method="POST">
        
                                                            <input type="number" name="12:30-1:30" id="12:30-1:30" value="<?php echo $data1230130; ?>" <?php echo $editname === "12:30-1:30" && $editid == $dataid? "" : "disabled"; ?>>
        
                                                        </form>
        
                                                        
                                                        <?php 
                                                        
                                                            if($editname !== "12:30-1:30"){
                                                        
                                                        ?>
        
                                                        
                                                        <button id="edit-data-button">
        
                                                            <a href="./index.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>&editname=12:30-1:30&id=<?php echo $dataid; ?>"><i class="fas fa-pencil"></i></a>
        
                                                        </button>
        
                                                        <?php
        
                                                            }
        
                                                        ?>
        
                                                    </td>
                                                    
                                                    <td id="<?php echo $editname === "1:30-2:30" && $editid == $dataid  ? "allow-edit" : "default" ; ?>">
        
                                                        <form action="./functions/update.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter;?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum ?>&editname=1:30-2:30&id=<?php echo $dataid; ?>" method="POST">
        
                                                            <input type="number" name="1:30-2:30" id="1:30-2:30" value="<?php echo $data130230; ?>" <?php echo $editname === "1:30-2:30" && $editid == $dataid? "" : "disabled"; ?>>
        
                                                        </form>
        
                                                        <?php 
                                                        
                                                            if($editname !== "1:30-2:30"){
                                                        
                                                        ?>
        
                                                        
                                                        
                                                        <button id="edit-data-button">
        
                                                            <a href="./index.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>&editname=1:30-2:30&id=<?php echo $dataid; ?>"><i class="fas fa-pencil"></i></a>
        
                                                        </button>
        
                                                        <?php
        
                                                            }
        
                                                        ?>
        
                                                    </td>
                                                    
                                                    <td id="<?php echo $editname === "2:30-3:30" && $editid == $dataid  ? "allow-edit" : "default" ; ?>">
        
                                                        <form action="./functions/update.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter;?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum ?>&editname=2:30-3:30&id=<?php echo $dataid; ?>" method="POST">
        
                                                            <input type="number" name="2:30-3:30" id="2:30-3:30" value="<?php echo $data230330; ?>" <?php echo $editname === "2:30-3:30" && $editid == $dataid? "" : "disabled"; ?>>
        
                                                        </form>
        
                                                        <?php 
                                                        
                                                            if($editname !== "2:30-3:30"){
                                                        
                                                        ?>
        
                                                        
                                                        
                                                        <button id="edit-data-button">
        
                                                            <a href="./index.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>&editname=2:30-3:30&id=<?php echo $dataid; ?>"><i class="fas fa-pencil"></i></a>
        
                                                        </button>
        
                                                        <?php
        
                                                            }
        
                                                        ?>
        
                                                    </td>
                                                    
                                                    <td id="<?php echo $editname === "3:30-4:30" && $editid == $dataid  ? "allow-edit" : "default" ; ?>">
        
                                                        <form action="./functions/update.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter;?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum ?>&editname=3:30-4:30&id=<?php echo $dataid; ?>" method="POST">
        
                                                            <input type="number" name="3:30-4:30" id="3:30-4:30" value="<?php echo $data330430; ?>" <?php echo $editname === "3:30-4:30" && $editid == $dataid? "" : "disabled"; ?>>
        
                                                        </form>
        
                                                        <?php 
                                                        
                                                            if($editname !== "3:30-4:30"){
                                                        
                                                        ?>
        
                                                        
                                                        
                                                        <button id="edit-data-button">
        
                                                            <a href="./index.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>&editname=3:30-4:30&id=<?php echo $dataid; ?>"><i class="fas fa-pencil"></i></a>
        
                                                        </button>
        
                                                        <?php
        
                                                            }
        
                                                        ?>
        
                                                    </td>
                                                    
                                                    <td id="<?php echo $editname === "4:30-5:30" && $editid == $dataid  ? "allow-edit" : "default" ; ?>">
        
                                                        <form action="./functions/update.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter;?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum ?>&editname=4:30-5:30&id=<?php echo $dataid; ?>" method="POST">
        
                                                            <input type="number" name="4:30-5:30" id="4:30-5:30" value="<?php echo $data430530; ?>" <?php echo $editname === "4:30-5:30" && $editid == $dataid? "" : "disabled"; ?>>
        
                                                        </form>
        
                                                        <?php 
                                                        
                                                            if($editname !== "4:30-5:30"){
                                                        
                                                        ?>
        
                                                        
                                                        <button id="edit-data-button">
        
                                                            <a href="./index.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>&editname=4:30-5:30&id=<?php echo $dataid; ?>"><i class="fas fa-pencil"></i></a>
        
                                                        </button>
        
                                                        <?php
        
                                                            }
        
                                                        ?>
        
                                                    </td>
                                                    
                                                    <td id="<?php echo $editname === "6:00-8:00" && $editid == $dataid  ? "allow-edit" : "default" ; ?>">
        
                                                        <form action="./functions/update.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter;?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum ?>&editname=6:00-8:00&id=<?php echo $dataid; ?>" method="POST">
        
                                                            <input type="number" name="6:00-8:00" id="6:00-8:00" value="<?php echo $data600800; ?>" <?php echo $editname === "6:00-8:00" && $editid == $dataid? "" : "disabled"; ?>>
        
                                                        </form>
        
        
                                                        <?php 
                                                        
                                                            if($editname !== "6:00-8:00"){
                                                        
                                                        ?>
        
                                                        <button id="edit-data-button">
        
                                                            <a href="./index.php?page=<?php echo $page; ?>&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>&editname=6:00-8:00&id=<?php echo $dataid; ?>"><i class="fas fa-pencil"></i></a>
        
                                                        </button>
        
                                                        <?php
        
                                                            }
        
                                                        ?>
        
                                                    </td>
                                                    
                                                <td><?php echo $datatarget; ?></td>

                                                <td><button><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>&operation=delete&id=<?php echo $dataid; ?>"><i class="fas fa-trash-alt"></i></a></button></td>
                                            </tr>


                                        <?php

                                        }

                                    }

                                    ?>

                                    <tr class="add-row" id="add-row">

                                        <form action="./functions/add.php?page=record&data=hourly&operation=add" method="post">

                                            <td>#</td>
                                            <td>

                                                <input type="number" name="line" id="line" value="<?php echo isset($hourlylineerror) && !empty($hourlylineerror)? $hourlylineerror : "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="text" name="date" id="date" value="<?php echo $todaydate; ?>" disabled>

                                            </td>
                                            
                                            <td>

                                                <input type="number" name="7:30-8:30" id="7:30-8:30" value="<?php echo isset($hourly730830error) && !empty($hourly730830error)? $hourly730830error : "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="number" name="8:30-9:30" id="8:30-9:30" value="<?php echo isset($hourly830930error) && !empty($hourly830930error)? $hourly830930error : "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="number" name="9:30-10:30" id="9:30-10:30" value="<?php echo isset($hourly9301030error) && !empty($hourly9301030error)? $hourly9301030error : "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="number" name="10:30-11:30" id="10:30-11:30" value="<?php echo isset($hourly10301130error) && !empty($hourly10301130error)? $hourly10301130error : "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="number" name="11:30-12:30" id="11:30-12:30" value="<?php echo isset($hourly11301230error) && !empty($hourly11301230error)? $hourly11301230error : "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="number" name="12:30-1:30" id="12:30-1:30" value="<?php echo isset($hourly1230130error) && !empty($hourly1230130error)? $hourly1230130error : "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="number" name="1:30-2:30" id="1:30-2:30" value="<?php echo isset($hourly130230error) && !empty($hourly130230error)? $hourly130230error : "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="number" name="2:30-3:30" id="2:30-3:30" value="<?php echo isset($hourly230330error) && !empty($hourly230330error)? $hourly230330error : "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="number" name="3:30-4:30" id="3:30-4:30" value="<?php echo isset($hourly330430error) && !empty($hourly330430error)? $hourly330430error : "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="number" name="4:30-5:30" id="4:30-5:30" value="<?php echo isset($hourly430530error) && !empty($hourly430530error)? $hourly430530error : "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="number" name="6:00-8:00" id="6:00-8:00" value="<?php echo isset($hourly600800error) && !empty($hourly600800error)? $hourly600800error : "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="number" name="target" id="target" value="<?php echo isset($hourlytargeterror) && !empty($hourlytargeterror)? $hourlytargeterror : "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <button type="submit"><i class="fas fa-add"></i></button>

                                            </td>
                                            

                                        </form>

                                    </tr>

                                </table>

                            </div>



                        <?php
                        
                    }elseif($data === "production"){

                        ?>

                            <div class="records-content-title">
                                <h1>
                                    

                                    <?php 

                                        if($search === "defaultsearchparameters"){

                                            ?>

                                                Production Report

                                            <?php

                                        }else{

                                            ?>
                                            
                                                Production Report Search For "<?php echo $search; ?>"

                                            <?php

                                        }

                                    ?>
                                </h1>
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

                                ?></th>
                                        <th>Line
                                <?php

                                    if($filter === "line"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?></th>
                                        <th>Style
                                <?php

                                    if($filter === "style"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?></th>
                                        <th>Po
                                <?php

                                    if($filter === "po"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?></th>
                                        <th>Brand
                                <?php

                                    if($filter === "brand"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?></th>
                                        <th>Input Qty
                                <?php

                                    if($filter === "input_qty"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?></th>
                                        <th>Output Qty
                                <?php

                                    if($filter === "output_qty"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?></th>
                                        <th>Rejection Qty
                                <?php

                                    if($filter === "rejection_qty"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?></th>
                                        <th>Order Qty
                                <?php

                                    if($filter === "order_qty"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?></th>
                                        <th>Start Input Date
                                <?php

                                    if($filter === "start_input_date"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?></th>
                                        <th>End Input Date
                                <?php

                                    if($filter === "end_input_date"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?></th>
                                        <th>Total
                                <?php

                                    if($filter === "total"){
                                        ?>
                                            <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                        <?php
                                    }

                                ?></th>
                                        <th>Action</th>
                                    </thead>

                                    <?php 


                                    if($tabledata < 1){

                                        ?>

                                            <tr>
                                                <td colspan="13">No Record Found!</td>
                                            </tr>

                                        <?php

                                    }else{

                                        for($b = 0; $b < count($tabledata); $b++){

                                            $datano = ($b + 1);
                                            $dataid = $tabledata[$b]['id'];
                                            $dataline = $tabledata[$b]['line'];
                                            $datastyle = $tabledata[$b]['style'];
                                            $datapo = $tabledata[$b]['po'];
                                            $databrand = $tabledata[$b]['brand'];
                                            $datainputquantity = $tabledata[$b]['input_qty'];
                                            $dataoutputquantity = $tabledata[$b]['output_qty'];
                                            $datarejectionquantity = $tabledata[$b]['rejection_qty'];
                                            $dataorderquantity = $tabledata[$b]['order_qty'];
                                            $datastartdate = $tabledata[$b]['start_input_date'];
                                            $dataenddate = $tabledata[$b]['end_input_date'];
                                            $datatotal = $tabledata[$b]['total'];

                                            ?>

                                            

                                                <tr>
                                                    <th><?php echo $datano; ?></th>
                                                    <td><?php echo $dataline; ?></td>
                                                    <td><?php echo $datastyle; ?></td>
                                                    <td><?php echo $datapo; ?></td>
                                                    <td><?php echo $databrand; ?></td>
                                                    <td><?php echo $datainputquantity; ?></td>
                                                    <td><?php echo $dataoutputquantity; ?></td>
                                                    <td><?php echo $datarejectionquantity; ?></td>
                                                    <td><?php echo $dataorderquantity; ?></td>
                                                    <td><?php echo $datastartdate; ?></td>
                                                    <td><?php echo $dataenddate; ?></td>
                                                    <td><?php echo $datatotal; ?></td>

                                                    <!-- /index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1# -->
                                                    <td><button><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>&operation=delete&id=<?php echo $dataid; ?>"><i class="fas fa-trash-alt"></i></a></button></td>
                                                </tr>


                                            <?php

                                        }

                                    }

                                    ?>

                                    <tr class="add-row"  id="add-row">

                                        <form action="./functions/add.php?page=record&data=production&operation=add" method="post">

                                            <td>#</td>
                                            <td>

                                                <input type="number" name="line" id="line" value="<?php echo isset($productionlineerror) && !empty($productionlineerror)? $productionlineerror: "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="text" name="style" id="style" value="<?php echo isset($productionstyleerror) && !empty($productionstyleerror)? $productionstyleerror: "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="text" name="po" id="po" value="<?php echo isset($productionpoerror) && !empty($productionpoerror)? $productionpoerror: "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="text" name="brand" id="brand" value="<?php echo isset($productionbranderror) && !empty($productionbranderror)? $productionbranderror: "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="number" name="input-quantity" id="input-quantity" value="<?php echo isset($productioninputerror) && !empty($productioninputerror)? $productioninputerror: "" ; ?>" oninput="calcp()">

                                            </td>
                                            
                                            <td>

                                                <input type="number" name="output-quantity" id="output-quantity" value="<?php echo isset($productionoutputerror) && !empty($productionoutputerror)? $productionoutputerror: "" ; ?>" oninput="calcp()">

                                            </td>
                                            
                                            <td>

                                                <input type="number" name="rejection-quantity" id="rejection-quantity" value="<?php echo isset($productionrejectionerror) && !empty($productionrejectionerror)? $productionrejectionerror: "" ; ?>" oninput="calcp()">

                                            </td>
                                            
                                            <td>

                                                <input type="number" name="order-quantity" id="order-quantity" value="<?php echo isset($productionordererror) && !empty($productionordererror)? $productionordererror: "" ; ?>" oninput="calcp()">

                                            </td>
                                            
                                            <td>

                                                <input type="date" name="start-date" id="start-date" min="<?php echo date("Y");?>-01-01" max="<?php echo date("Y"); ?>-12-31" value="<?php echo isset($productionstartdateerror) && !empty($productionstartdateerror)? $productionstartdateerror: "" ; ?>">

                                            </td>
                                            
                                            <td>

                                                <input type="date" name="end-date" id="end-date"  min="<?php echo date("Y");?>-01-01" max="<?php echo date("Y"); ?>-12-31" value="<?php echo isset($productionenddateerror) && !empty($productionenddateerror)? $productionenddateerror: "" ; ?>">

                                            </td>
                                            
                                            
                                            <td>

                                                <input type="text" name="total" id="total" value="<?php echo isset($productiontotalerror) && !empty($productiontotalerror)? $productiontotalerror: "" ; ?>" readonly>

                                            </td>
                                            
                                            <td>

                                                <button type="submit"><i class="fas fa-add"></i></button>

                                            </td>
                                            

                                        </form>

                                    </tr>

                                </table>

                            </div>

                        <?php
                        
                    }else{
                        
                        ?>

                        <div class="records-content-title">
                            <h1>
                                

                                <?php 

                                    if($search === "defaultsearchparameters"){

                                        ?>

                                            Production Report

                                        <?php

                                    }else{

                                        ?>
                                        
                                            Production Report Search For "<?php echo $search; ?>"

                                        <?php

                                    }

                                ?>
                            </h1>
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

                            ?></th>
                                    <th>Line
                            <?php

                                if($filter === "line"){
                                    ?>
                                        <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                    <?php
                                }

                            ?></th>
                                    <th>Style
                            <?php

                                if($filter === "style"){
                                    ?>
                                        <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                    <?php
                                }

                            ?></th>
                                    <th>Po
                            <?php

                                if($filter === "po"){
                                    ?>
                                        <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                    <?php
                                }

                            ?></th>
                                    <th>Brand
                            <?php

                                if($filter === "brand"){
                                    ?>
                                        <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                    <?php
                                }

                            ?></th>
                                    <th>Input Qty
                            <?php

                                if($filter === "input_qty"){
                                    ?>
                                        <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                    <?php
                                }

                            ?></th>
                                    <th>Output Qty
                            <?php

                                if($filter === "output_qty"){
                                    ?>
                                        <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                    <?php
                                }

                            ?></th>
                                    <th>Rejection Qty
                            <?php

                                if($filter === "rejection_qty"){
                                    ?>
                                        <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                    <?php
                                }

                            ?></th>
                                    <th>Order Qty
                            <?php

                                if($filter === "order_qty"){
                                    ?>
                                        <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                    <?php
                                }

                            ?></th>
                                    <th>Start Input Date
                            <?php

                                if($filter === "start_input_date"){
                                    ?>
                                        <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                    <?php
                                }

                            ?></th>
                                    <th>End Input Date
                            <?php

                                if($filter === "end_input_date"){
                                    ?>
                                        <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                    <?php
                                }

                            ?></th>
                                    <th>Total
                            <?php

                                if($filter === "total"){
                                    ?>
                                        <button id="order-button"><a href="<?php echo $orderlink; ?>"><i class="fas fa-<?php echo $order === "descending"? "sort-up": "sort-down" ; ?>"></i></a></button>
                                    <?php
                                }

                            ?></th>
                                    <th>Action</th>
                                </thead>

                                <?php 


                                if($tabledata < 1){

                                    ?>

                                        <tr>
                                            <td colspan="13">No Record Found!</td>
                                        </tr>

                                    <?php

                                }else{

                                    for($b = 0; $b < count($tabledata); $b++){

                                        $datano = ($b + 1);
                                        $dataid = $tabledata[$b]['id'];
                                        $dataline = $tabledata[$b]['line'];
                                        $datastyle = $tabledata[$b]['style'];
                                        $datapo = $tabledata[$b]['po'];
                                        $databrand = $tabledata[$b]['brand'];
                                        $datainputquantity = $tabledata[$b]['input_qty'];
                                        $dataoutputquantity = $tabledata[$b]['output_qty'];
                                        $datarejectionquantity = $tabledata[$b]['rejection_qty'];
                                        $dataorderquantity = $tabledata[$b]['order_qty'];
                                        $datastartdate = $tabledata[$b]['start_input_date'];
                                        $dataenddate = $tabledata[$b]['end_input_date'];
                                        $datatotal = $tabledata[$b]['total'];

                                        ?>

                                        

                                            <tr>
                                                <th><?php echo $datano; ?></th>
                                                <td><?php echo $dataline; ?></td>
                                                <td><?php echo $datastyle; ?></td>
                                                <td><?php echo $datapo; ?></td>
                                                <td><?php echo $databrand; ?></td>
                                                <td><?php echo $datainputquantity; ?></td>
                                                <td><?php echo $dataoutputquantity; ?></td>
                                                <td><?php echo $datarejectionquantity; ?></td>
                                                <td><?php echo $dataorderquantity; ?></td>
                                                <td><?php echo $datastartdate; ?></td>
                                                <td><?php echo $dataenddate; ?></td>
                                                <td><?php echo $datatotal; ?></td>

                                                <!-- /index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1# -->
                                                <td><button><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $pagenum; ?>&operation=delete&id=<?php echo $dataid; ?>"><i class="fas fa-trash-alt"></i></a></button></td>
                                            </tr>


                                        <?php

                                    }

                                }

                                ?>

                                <tr class="add-row"  id="add-row">

                                    <form action="./functions/add.php?page=record&data=production&operation=add" method="post">

                                        <td>#</td>
                                        <td>

                                            <input type="number" name="line" id="line" value="<?php echo isset($productionlineerror) && !empty($productionlineerror)? $productionlineerror: "" ; ?>">

                                        </td>
                                        
                                        <td>

                                            <input type="text" name="style" id="style" value="<?php echo isset($productionstyleerror) && !empty($productionstyleerror)? $productionstyleerror: "" ; ?>">

                                        </td>
                                        
                                        <td>

                                            <input type="text" name="po" id="po" value="<?php echo isset($productionpoerror) && !empty($productionpoerror)? $productionpoerror: "" ; ?>">

                                        </td>
                                        
                                        <td>

                                            <input type="text" name="brand" id="brand" value="<?php echo isset($productionbranderror) && !empty($productionbranderror)? $productionbranderror: "" ; ?>">

                                        </td>
                                        
                                        <td>

                                            <input type="number" name="input-quantity" id="input-quantity" value="<?php echo isset($productioninputerror) && !empty($productioninputerror)? $productioninputerror: "" ; ?>">

                                        </td>
                                        
                                        <td>

                                            <input type="number" name="output-quantity" id="output-quantity" value="<?php echo isset($productionoutputerror) && !empty($productionoutputerror)? $productionoutputerror: "" ; ?>">

                                        </td>
                                        
                                        <td>

                                            <input type="number" name="rejection-quantity" id="rejection-quantity" value="<?php echo isset($productionrejectionerror) && !empty($productionrejectionerror)? $productionrejectionerror: "" ; ?>">

                                        </td>
                                        
                                        <td>

                                            <input type="number" name="order-quantity" id="order-quantity" value="<?php echo isset($productionordererror) && !empty($productionordererror)? $productionordererror: "" ; ?>">

                                        </td>
                                        
                                        <td>

                                            <input type="date" name="start-date" id="start-date" min="<?php echo date("Y");?>-01-01" max="<?php echo date("Y"); ?>-12-31" value="<?php echo isset($productionstartdateerror) && !empty($productionstartdateerror)? $productionstartdateerror: "" ; ?>">

                                        </td>
                                        
                                        <td>

                                            <input type="date" name="end-date" id="end-date"  min="<?php echo date("Y");?>-01-01" max="<?php echo date("Y"); ?>-12-31" value="<?php echo isset($productionenddateerror) && !empty($productionenddateerror)? $productionenddateerror: "" ; ?>">

                                        </td>
                                        
                                        
                                        <td>

                                            <input type="number" name="total" id="total" value="<?php echo isset($productiontotalerror) && !empty($productiontotalerror)? $productiontotalerror: "" ; ?>" readonly>

                                        </td>
                                        
                                        <td>

                                            <button type="submit"><i class="fas fa-add"></i></button>

                                        </td>
                                        

                                    </form>

                                </tr>

                            </table>

                        </div>

                    <?php

                        
                        // header("loaction:./index.php?page=record&search=defaultsearchparameters&order=decending&filter=id&data=hourly&pagenum=1");
                    }

                ?>

                
                            <div class="record-next-prev-page-btn">

                                <?php
                                

                                    

                                    if($data === "hourly"){
                                        $tablename = "h_r";
                                    }else{
                                        $tablename = "p_r";
                                    }

                                    if($search === "defaultsearchparameters"){

                                        $dataparam = array(

                                            "tableName"=>$tablename
                                            
                                            
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

                                            if($data === "hourly"){

                                                $searchby = "line|date_added";
                                            }else{

                                                $searchby = "line|style|po|brand|start_input_date|end_input_date";
                                            }
                                            $linksearchby = "";

                                        }


                                        $dataparam = array(

                                            "tableName"=>$tablename,
                                            "identityParams"=>$searchby,
                                            "identityValues"=>$search,
                                            "comparismOperator"=>"LIKE%"
                                            
                                            
                                        );

                                        $dataparamjson = json_encode($dataparam);

                                        $counttabledata = $dbconnect->searchTable($dataparamjson);

                                        

                                    }

                                    if(is_array($counttabledata)){
                                        $totaldatanumber = ceil(count($counttabledata) / $rowlimit);

                                        // echo count($counttabledata) / $rowlimit;
                                    }else{
                                        $totaldatanumber = 0;

                                    }

                                    
                                        
                                    // $totaldatanumber = 10;
                                        $previouspagenum = $pagenum - 1;
                                        $nextpagenum = $pagenum + 1;

                                    
                                        if($pagenum > 1){

                                        
                                ?>

                                    <button><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $previouspagenum.$linksearchby; ?>"><i class="fas fa-angles-left"></i></a></button>

                                    <?php


                                        }


                                        for($t = 0; $t < $totaldatanumber; $t++){

                                            $calpagenum = $t + 1;
                                            $nextpage = $pagenum + 1;
                                            $previouspage = $pagenum - 1;


                                            if($calpagenum == $pagenum){
                                                $id = "active-page-num";


                                                $pagelinks = "#";
                                            }else{
                                                $id="non-active-page-num";

                                                $pagelinks = "./index.php?page=$page&search=$search&order=$order&filter=$filter&data=$data&pagenum=$calpagenum".$linksearchby;
                                            }

                                            // echo $calpagenum;
                                            // echo $pagenum;

                                            if($totaldatanumber > 5){

                                                if($pagenum >= 4){

                                                    if($calpagenum > 1 && $calpagenum < $previouspage){

                                                        if($calpagenum == $previouspage - 1){
                                                            ?>

                                                            <button id="dot-list">. . .</button>
                                
                                                        <?php
                                                        }
                                                    }elseif($calpagenum > $nextpage && $calpagenum < $totaldatanumber){
                                                        if($calpagenum == $nextpage + 1){
                                                            ?>

                                                            <button id="dot-list">. . .</button>
                                
                                                            <?php
                                                        }
                                                    }else{ 
                                                        ?>

                                                        <button id="<?php echo $id; ?>"><a href="<?php echo $pagelinks; ?>"><?php echo $calpagenum; ?></a></button>
    
                                                        <?php

                                                    }

                                                }else{
                                                    if($calpagenum > 4){
                                                        if($calpagenum == 5){ 
                                                            ?>

                                                            <button id="dot-list">. . .</button>
                                
                                                            <?php
                                                        }elseif($calpagenum == $totaldatanumber){            
                                                            
                                                            ?>

                                                            <button id="<?php echo $id; ?>"><a href="<?php echo $pagelinks; ?>"><?php echo $calpagenum; ?></a></button>
        
                                                            <?php

                                                        }
                                                    }else{

                                                        ?>

                                                        <button id="<?php echo $id; ?>"><a href="<?php echo $pagelinks; ?>"><?php echo $calpagenum; ?></a></button>
    
                                                    <?php

                                                    }
                                                }
                                                
                                            }else{
                                        

                                                ?>

                                                    <button id="<?php echo $id; ?>"><a href="<?php echo $pagelinks; ?>"><?php echo $calpagenum; ?></a></button>

                                                <?php

                                            }

                                     }

                                     if($pagenum < $totaldatanumber){


                                    ?>
                                        <button><a href="./index.php?page=record&search=<?php echo $search; ?>&order=<?php echo $order; ?>&filter=<?php echo $filter; ?>&data=<?php echo $data; ?>&pagenum=<?php echo $nextpagenum.$linksearchby; ?>"><i class="fas fa-angles-right"></i></a></button>

                                <?php

                                     }

                                ?>

                            </div>

            </div>

        </div>


    <?php
}else{
    // ./index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=hourly&pagenum=1
}