<?php

session_start();
require_once("../includes/mydb.php");
require_once("../includes/db.php");
require_once("../includes/check_user.php");




if(isset($_GET['page']) && !empty($_GET['page'])){
    $page = $_GET['page'];
    $timecreated = date("H:i");
    $datecreated = date("d F Y");
    $creationtitle = "Created On " . $datecreated . " " . $timecreated . " BY " . ADMIN_EMAIL;

    if($page === "admins"){

        $filename = "AdminsList.xls";
        $colspannum = 7;

        $title = "Admin List As At " . $datecreated;

        $getlistarray = array(
            "tableName"=>"admin"
        );

        $getlistarrayjson = json_encode($getlistarray);

        $list = $dbconnect->getTableData($getlistarrayjson);
        
    }elseif($page === "record"){
        
        if(isset($_GET['data']) && !empty($_GET['data'])){
            
            $data = $_GET['data'];
            
            if($data === "hourly"){

                $filename = "Hourlyreportlist.xls";

                $title = "Hourly Report List As At " . $datecreated;
                
                $colspannum = 15;

                

                $getlistarray = array(
                    "tableName"=>"h_r"
                );

                $getlistarrayjson = json_encode($getlistarray);

                $list = $dbconnect->getTableData($getlistarrayjson);
                
            }elseif($data === "production"){
                
                $filename = "Productionreportlist.xls";
                
                $title = "Production Report List As At " . $datecreated;

                $colspannum = 12;
                

                $getlistarray = array(
                    "tableName"=>"p_r"
                );

                $getlistarrayjson = json_encode($getlistarray);

                $list = $dbconnect->getTableData($getlistarrayjson);
            }

        }else{
            header("location:../index.php?page=dashboard");
        }
        
    }else{
        header("location:../index.php?page=dashboard");
    }


    ob_end_clean();
    ob_start();
    
    header('Content-Type: application/octet-stream');
    header("Accept-Ranges:bytes");
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');


    

        ?>

            

            <table style="border-collapse: collapse;">

                
                <tr>
                    <td colspan="4" style="text-align: left; color: blue; font-size: 10px; "><?php echo $creationtitle; ?></td>
                </tr>

                <thead>
                    <th colspan = "<?php echo $colspannum; ?>"><h1><?php echo $title; ?></h1></th>
                </thead>

                <tr></tr>
                <tr></tr>

                <thead>
                    <?php

                        if($page === "admins"){

                            ?>

                                    <th style="border: 1px solid black; padding: 5px 10px;">S/N</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">NAME</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">EMAIL</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">MOBILE NUMBER</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">ADDRESS</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">DATE ADDED</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">ADDED BY</th>
                                    
                            <?php

                                }elseif($page === "record"){
                                    
                                    if($data === "hourly"){

                                        ?>

                                    <th style="border: 1px solid black; padding: 5px 10px;">S/N</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">LINE</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">DATE</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">7:30 - 8:30</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">8:30 - 9:30</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">9:30 - 10:30</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">10:30 - 11:30</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">11:30 - 12:30</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">12:30 - 1:30</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">1:30 - 2:30</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">2:30 - 3:30</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">3:30 - 4:30</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">4:30 - 5:30</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">6:00 - 8:00</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">TARGET</th>
                                        
                                        <?php
                                        
                                        
                                        
                                    }elseif($data === "production"){

                                        ?>

                                    <th style="border: 1px solid black; padding: 5px 10px;">S/N</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">LINE</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">STYLE</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">PO</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">BRAND</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">INPUT QUANTITY</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">OUTPUT QUANTITY</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">REJECTION QUANTITY</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">ORDER QUANTITY</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">START INPUT DATE</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">END INPUT DATE</th>
                                    <th style="border: 1px solid black; padding: 5px 10px;">TOTAL</th>

                                        <?php
                                        
                                    }
                                    
                                    
                                }

                    ?>
                </thead>

                <?php

                    if(is_array($list)){

                        for($i = 0; $i < count($list); $i++){
                            $listno = ($i + 1);

                            ?>

                                <tr>
                                

                                    <?php

                                    if($page === "admins"){
            
                                        $listname = ucwords($list[$i]['name']);
                                        $listemail = $list[$i]['email'];
                                        $listnumber = $list[$i]['mobile_number'];
                                        $listaddress = $list[$i]['address'];
                                        $listdateadded = $list[$i]['date_added'];
                                        $listaddedby = $list[$i]['added_by'];

                                        ?>

                                            <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listno; ?></td>
                                            <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listname; ?></td>
                                            <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listemail; ?></td>
                                            <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listnumber; ?></td>
                                            <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listaddress; ?></td>
                                            <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listdateadded; ?></td>
                                            <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listaddedby; ?></td>

                                        <?php
            
                                    }elseif($page === "record"){
            
                                        if($data === "hourly"){
                                            $listline = $list[$i]['line'];
                                            $listdate = $list[$i]['date_added'];
                                            $list730830 = $list[$i]['seven_eight_thirthy'];
                                            $list830930 = $list[$i]['eight_nine_thirthy'];
                                            $list9301030 = $list[$i]['nine_ten_thirthy'];
                                            $list10301130 = $list[$i]['ten_eleven_thirthy'];
                                            $list11301230 = $list[$i]['eleven_twelve_thirthy'];
                                            $list1230130 = $list[$i]['twelve_one_thirthy'];
                                            $list130230 = $list[$i]['one_two_thirthy'];
                                            $list230330 = $list[$i]['two_three_thirthy'];
                                            $list330430 = $list[$i]['three_four_thirthy'];
                                            $list430530 = $list[$i]['four_five_thirthy'];
                                            $list600800 = $list[$i]['six_eight_clock'];
                                            $listtarget = $list[$i]['target'];
                                            

                                            ?>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listno; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listline; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listdate; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $list730830; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $list830930; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $list9301030; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $list10301130; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $list11301230; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $list1230130; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $list130230; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $list230330; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $list330430; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $list430530; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $list600800; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listtarget; ?></td>

                                            <?php
            
                                        }elseif($data === "production"){
                                            $listline = $list[$i]['line'];
                                            $liststyle = $list[$i]['style'];
                                            $listpo = $list[$i]['po'];
                                            $listbrand = $list[$i]['brand'];
                                            $listinput_qty = $list[$i]['input_qty'];
                                            $listoutput_qty = $list[$i]['output_qty'];
                                            $listrejection_qty = $list[$i]['rejection_qty'];
                                            $listorder_qty = $list[$i]['order_qty'];
                                            $liststart_input_date = $list[$i]['start_input_date'];
                                            $listend_input_date = $list[$i]['end_input_date'];
                                            $listtotal = $list[$i]['total'];
                                            
                                            ?>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listno; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listline; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $liststyle; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listpo; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listbrand; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listinput_qty; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listoutput_qty; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listrejection_qty; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listorder_qty; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $liststart_input_date; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listend_input_date; ?></td>
                                                <td style="border: 1px solid black; padding: 5px 10px;"><?php echo $listtotal; ?></td>

                                            <?php
            
                                        }
            
                                    }

                                    ?>

                            
                                </tr>

                            <?php
                        }


                    }else{

                        ?>

                            <tr>
                                <td colspan="<?php echo $colspannum; ?>">No Record Found</td>
                            </tr>

                        <?php

                    }

                ?>
            </table>

        <?php

}else{
    header("location:../index.php?page=dashboard");
}

exit();

?>