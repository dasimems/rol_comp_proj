<div class="dashboard-contents">

    <div class="dashboard-cards">

        <div class="dashboard-card-content">

            <p class="title">Admins</p>

            <div class="card-details">

                <p class="counter" id="admin-counter">0</p>

                <p class="icon"><i class="fas fa-user"></i></p>

            </div>

        </div>

        
        <div class="dashboard-card-content">

            <p class="title">Hourly Report</p>

            <div class="card-details">

                <p class="counter" id="hourly-report-counter">0</p>

                <p class="icon"><i class="fas fa-archive"></i></p>

            </div>

        </div>


        <div class="dashboard-card-content">

            <p class="title">Production Report</p>

            <div class="card-details">

                <p class="counter" id="production-report-counter">0</p>

                <p class="icon"><i class="fas fa-book"></i></p>

            </div>

        </div>

    </div>

    <div class="dashboard-charts">

        <div class="hourly-report-line-charts">

            <div class="hourly-chart-text">

                <h1>Hourly Report</h1>
                
            </div>

            <div id="hourly-line-chart">

                <canvas id="hourly-chart"></canvas>

            </div>

        </div>

        <div class="production-report-pie-chart">

            <div class="production-chart-text">

                <h1>Total Production Report Quantities</h1>

            </div>

            <div id="production-pie-chart">

                <canvas id="production-chart"></canvas>

            </div>

            <div class="production-chart-text">

                <p><span id="green-background"></span> Input Quantity</p>
                <p><span id="yellow-background"></span> Output Quantity</p>
                <p><span id="red-background"></span> Rejection Quantity</p>
                <p><span id="blue-background"></span> Order Quantity</p>

            </div>


        </div>

    </div>

    <div class="reports">

        <div class="report-content">

            <?php

            
                $dataparam = array(
        
                    "tableName"=>"p_r",
                    "order"=>"id",
                    "orderType"=>"DESC",
                    "limit"=>"5",
                    "offset"=>"0"
                    
                    
                );
        
                $dataparamjson = json_encode($dataparam);
        
                $tabledata = $dbconnect->getTableData($dataparamjson);
            
            
            ?>
            
            <div class="report-title">
                <h1>Production Report</h1>
            </div>

            <div class="report-table">

                <table>

                    <thead>
                        <th>NO</th>
                        <th>Line</th>
                        <th>Style</th>
                        <th>Po</th>
                        <th>Brand</th>
                        <th>Input Qty</th>
                        <th>Output Qty</th>
                        <th>Rejection Qty</th>
                        <th>Order Qty</th>
                        <th>Start Input Date</th>
                        <th>End Input Date</th>
                        <th>Total</th>
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
                                                                            
                        </tr>

                    <?php

                            }

                        }

                    ?>


                </table>

            </div>

            <?php 

            if(is_array($tabledata)){

                ?>

                    <div class="report-links">
        
                        <button><a href="./index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=production&pagenum=1">View All Records</a></button>
        
                    </div>


                <?php

            }

            ?>



        </div>

        <div class="report-content">
            
            <div class="report-title">
                <h1>Hourly Production Report</h1>
            </div>

            <div class="report-table">

                <table>

                    <thead>
                        <th>NO</th>
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

                        $dataparamhour = array(
        
                            "tableName"=>"h_r",
                            "order"=>"id",
                            "orderType"=>"DESC",
                            "limit"=>"5",
                            "offset"=>"0"
                            
                            
                        );
                
                        $dataparamhourjson = json_encode($dataparamhour);
                
                        $hourtabledata = $dbconnect->getTableData($dataparamhourjson);

                        if($hourtabledata < 1){

                            ?>

                                <tr>
                                    <td colspan="16">No Record Found!</td>
                                </tr>

                            <?php

                        }else{

                            

                            for($b = 0; $b < count($hourtabledata); $b++){
                                $datano = ($b + 1);
                                $dataid = $hourtabledata[$b]['id'];
                                $dataline = $hourtabledata[$b]['line'];
                                $datadateadded = $hourtabledata[$b]['date_added'];
                                $data730830 = $hourtabledata[$b]['seven_eight_thirthy'];
                                $data830930 = $hourtabledata[$b]['eight_nine_thirthy'];
                                $data9301030 = $hourtabledata[$b]['nine_ten_thirthy'];
                                $data10301130 = $hourtabledata[$b]['ten_eleven_thirthy'];
                                $data11301230 = $hourtabledata[$b]['eleven_twelve_thirthy'];
                                $data1230130 = $hourtabledata[$b]['twelve_one_thirthy'];
                                $data130230 = $hourtabledata[$b]['one_two_thirthy'];
                                $data230330 = $hourtabledata[$b]['two_three_thirthy'];
                                $data330430 = $hourtabledata[$b]['three_four_thirthy'];
                                $data430530 = $hourtabledata[$b]['four_five_thirthy'];
                                $data600800 = $hourtabledata[$b]['six_eight_clock'];
                                $datatarget = $hourtabledata[$b]['target'];

                                ?>

                                    
                                    <tr>
                                        <th><?php echo $datano; ?></th>
                                        <td><?php echo $dataline; ?></td>
                                        <td><?php echo $datadateadded; ?></td>
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
                        }


                    ?>

                </table>

            </div>

            <?php 

                if(is_array($hourtabledata)){

                    ?>

                        <div class="report-links">
            
                            <button><a href="./index.php?page=record&search=defaultsearchparameters&order=descending&filter=id&data=hourly&pagenum=1">View All Records</a></button>
            
                        </div>

                    <?php
                    
                }


            ?>

        </div>

    </div>

</div>