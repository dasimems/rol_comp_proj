<div class="record-container">


    <table>
        <thead>
            <th>S/N</th>
            <th>Line</th>
            <th>Date</th>
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
            <th>Target</th>
        </thead>

        <?php

        if(is_array($data)){

            for($i = 0; $i < count($data); $i++){
                $datano = $i + 1;
                $dataline = $data[$i]['line'];
                $datadate = $data[$i]['date_added'];
                $data730830 = $data[$i]['seven_eight_thirthy'];
                $data830930 = $data[$i]['eight_nine_thirthy'];
                $data9301030 = $data[$i]['nine_ten_thirthy'];
                $data10301130 = $data[$i]['ten_eleven_thirthy'];
                $data11301230 = $data[$i]['eleven_twelve_thirthy'];
                $data1230130 = $data[$i]['twelve_one_thirthy'];
                $data130230 = $data[$i]['one_two_thirthy'];
                $data230330 = $data[$i]['two_three_thirthy'];
                $data330430 = $data[$i]['three_four_thirthy'];
                $data430530 = $data[$i]['four_five_thirthy'];
                $data600800 = $data[$i]['six_eight_clock'];
                $datatarget = $data[$i]['target'];

                ?>

                    <tr>

                        <td><?php echo $datano; ?></td>
                        <td><?php echo $dataline; ?></td>
                        <td><?php echo $datadate; ?></td>
                        <td><?php echo $data730830; ?></td>
                        <td><?php echo $data830930; ?></td>
                        <td><?php echo $data9301030; ?></td>
                        <td><?php echo $data10301130; ?></td>
                        <td><?php echo $data11301230; ?></td>
                        <td><?php echo $data1230130; ?></td>
                        <td><?php echo $data130230; ?></td>
                        <td><?php echo $data230330; ?></td>
                        <td><?php echo $data330430; ?></td>
                        <td><?php echo $data430530; ?></td>
                        <td><?php echo $data600800; ?></td>
                        <td><?php echo $datatarget; ?></td>
                    </tr>

                <?php
            }
        }else{
            ?>

                <tr><td colspan="15">No Record Found</td></tr>

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