<div class="record-container">

<?php

?>


<table>
    <thead>
        <th>S/N</th>
        <th>Line</th>
        <th>Style</th>
        <th>PO</th>
        <th>Brand</th>
        <th>Input Quantity</th>
        <th>Output Quantity</th>
        <th>Rejection Quantity</th>
        <th>Order Quantity</th>
        <th>Start Input Date</th>
        <th>End Input Date</th>
        <th>Total</th>
    </thead>

    <?php

    if(is_array($data)){
        
        
                for($i = 0; $i < count($data); $i++){
                    $datano = $i + 1;
                    $dataline = $data[$i]['line'];
                    $datadate = $data[$i]['date_added'];
                    $datastyle = $data[$i]['style'];
                    $datapo = $data[$i]['po'];
                    $databrand = $data[$i]['brand'];
                    $datainput_qty = $data[$i]['input_qty'];
                    $dataoutput_qty = $data[$i]['output_qty'];
                    $datarejection_qty = $data[$i]['rejection_qty'];
                    $dataorder_qty = $data[$i]['order_qty'];
                    $datastart_input_date = $data[$i]['start_input_date'];
                    $dataend_input_date = $data[$i]['end_input_date'];
                    $datatotal = $data[$i]['total'];
                    ?>
        
                        <tr>
        
                            <td><?php echo $datano; ?></td>
                            <td><?php echo $dataline; ?></td>
                            <td><?php echo $datastyle; ?></td>
                            <td><?php echo $datapo; ?></td>
                            <td><?php echo $databrand; ?></td>
                            <td><?php echo $datainput_qty; ?></td>
                            <td><?php echo $dataoutput_qty; ?></td>
                            <td><?php echo $datarejection_qty; ?></td>
                            <td><?php echo $dataorder_qty; ?></td>
                            <td><?php echo $datastart_input_date; ?></td>
                            <td><?php echo $dataend_input_date; ?></td>
                            <td><?php echo $datatotal; ?></td>
                        </tr>
        
                    <?php
                }
    }else{
        ?>

        <tr><td colspan="12">No Record Found</td></tr>

        <?php
    }


    ?>
</table>

<div class="page-button">

    <ul>
        <?php

        if($pagenum > 1){

        ?>
            <li><a href="./index.php?page=<?php echo $pageq; ?>&n=<?php echo $previouspagenum; ?>"><i class="fas fa-angle-double-left"></i></a></li>

        <?php

        }

        // $buttonno = 10;

        // $pagenum = $_GET['n'];

        for($v = 0; $v < $buttonno; $v++){

        $num = $v + 1;

        // echo $num;
        

        if($buttonno > 5){
            $nextpage = $pagenum + 1;
            $previouspage = $pagenum - 1;

            if($pagenum >= 4){

                if($num >= 2 && $num < $previouspage){
                    if($num === $previouspage - 1){
                        ?>

                            <li id="dot-list">. . .</li>

                        <?php
                    }
                }elseif($num > $nextpage && $num < $buttonno){

                    if($num === $nextpage + 1){
                        ?>

                            <li id="dot-list">. . .</li>

                        <?php
                    }

                }else{?>

        

                    <li id="<?php  echo $num == $pagenum? "active-btn": "non-active"; ?>"><a href="<?php echo $num == $pagenum? "#": "./index.php?page=$pageq&n=$num"; ?>"><?php echo $num;?></a></li>

                <?php

                }

            }else{
                if($num > 4){
                    if($num === 5){
                        ?>

                            <li id="dot-list">. . .</li>

                        <?php
                    }elseif($num === $buttonno){

                        ?>

        

                        <li id="<?php  echo $num == $pagenum? "active-btn": "non-active"; ?>"><a href="<?php echo $num == $pagenum? "#": "./index.php?page=$pageq&n=$num"; ?>"><?php echo $num;?></a></li>

                    <?php

                    }
                }else{
                    ?>

        

                        <li id="<?php  echo $num == $pagenum? "active-btn": "non-active"; ?>"><a href="<?php echo $num == $pagenum? "#": "./index.php?page=$pageq&n=$num"; ?>"><?php echo $num;?></a></li>

                    <?php
                }
            }
        }else{

        

        ?>

        

            <li id="<?php  echo $num == $pagenum? "active-btn": "non-active"; ?>"><a href="<?php echo $num == $pagenum? "#": "./index.php?page=$pageq&n=$num"; ?>"><?php echo $num;?></a></li>

        <?php

        }

        }

        if($pagenum < $buttonno){
            

        ?>
            <li><a href="./index.php?page=<?php echo $pageq; ?>&n=<?php echo $nextpagenum; ?>"><i class="fas fa-angle-double-right"></i></a></li>

        <?php

        }

        ?>
    </ul>
</div>

</div>
    
</div>