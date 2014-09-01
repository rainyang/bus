<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AKAI Bus Tickets - schedule</title>
    <link href="/static/css/bus.css" rel="stylesheet">
    <link href="/static/css/bootstrap.css" rel="stylesheet">
    <link href="/static/css/bootstrap-select.css" rel="stylesheet">
    <link href="/static/css/datetimepicker.css" rel="stylesheet" media="screen">
</head>
<style type="text/css">
    @media print{
        .noprint{
            display:none
        }
        .noprint1{
            border:0;
        }
    }
</style>
<body>

<?php include "userinfo.php" ?>


<div class="container">
    
    <div class="slist row">
    <div class="stable">
        <div class="noprint tab_head">
            <li class="li_title"><span class="glyphicon glyphicon-star"></span> COMPLETED</li>
            <li>1:SEARCH</li>
            <li>2:SELECT</li>
            <li>3:PURCHASE</li>
            <li class="current">4:COMPLETED</li>
        </div>
        <div class="noprint1 restrictions-border">
            <div class="restrictions">
                <div class="noprint res-title">
                    <label data-toggle="collapse" data-target="#ticket-info">Payment success!</label>
                </div>
                <div class="noprint dashed-line"></div>
                <div class="noprint ticket-info panel-collapse collapse in"  id="ticket-info">
                <li class="noprint">Thank you! Your online order has been processed. Confirmation Number: <?php echo $o_number;?></li>
                <li class="noprint">The booking confirmation has been sent to the customer registration <?php echo $email;?> mailbox.</li>
                </div>

                <?php
                    //$to_station =  ($order['is_transfer'] == 1 && !$order['only_tran']) ? $tran_station['name'] : $station[$order['to_station_id']];  
                foreach($ticketdata as $val){
                    $to_station =  $station[$val['order']['to_station_id']];  
                ?>
                <!--startprint-->
                <div class="print print-ticket-info panel-collapse collapse in"  id="ticket-info">
                    <li class="b_title">AKAI Bus Tickets</li>
                    <li class="order_right">Confirmation Number:<?php echo $val['order']['o_number'];?></li>
                    <div class="noprint dashed-line"></div>
                    <li class="itinerary-info">DEPARTURE:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $station[$val['order']['from_station_id']];?> to <?php echo $to_station;?> | <?php echo $bpost['trip_type'];?></li>
                    <div id="pcontent">
                    <div class="pinfo">
                    <li class="itinerary-info">Departure:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $val['order']['departing_date'];?> <?php echo $val['order']['departing_time'];?></li>
                    <li class="itinerary-info">Departure Station:</li>
                    <li class="itinerary-info"><?php echo $val['depart_station']['address'];?></li>
                    <?php
                    if($bpost['trip_type'] == "Roundtrip"){
                    ?>
                    <li class="itinerary-info">RETURN:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $val['order']['return_date'];?> <?php echo $val['order']['return_time'];?></li>
                    <?php } ?>
                    <li class="itinerary-info">SEND TIME:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('Y-m-d', $val['order']['send_time']);?></li>
                    <li class="itinerary-info">SEND ADDRESS:&nbsp;&nbsp;&nbsp;&nbsp;WEB</li>
                    <?php
                    for($i = 0; $i < count($val['first_name']); $i++){
                        $j = $i +1;
                        echo "<li class=\"itinerary-info\">passenger{$j}:&nbsp;&nbsp;{$val['first_name'][$i]} {$val['last_name'][$i]}</li>";
                    }
                    ?>
                    </div>
                    <div class="qrcode"><?php echo $val['qrcode'];?></div>
                    </div>
                </div>
                <?php }?>
                <!--endprint-->

              
                <div style="margin-bottom:20px; text-align:center">
                    <button type="button" id="btn-finish" class="noprint btn btn-primary ">FINISH</button>
                    <button type="button" id="btn-print" class="noprint btn btn-primary ">PRINT</button>
                </div>
            </div>
        </div>
    </div>
    </div>
   <div class="noprint footer">
        <p>Privacy Policy | Terms & Conditions | 1Site Map | Mobile Site </p>
        <p>AKAI LLC Copyright &copy; 2013</p>
    </div> 
</div>
</body>
<script src="/static/js/jquery-1.9.1.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script src="/static/js/bootstrap-select.min.js"></script>

<script type="text/javascript">
            $('#btn-schedule').click(function(){
                $('#schedule-list').toggle();
            });
            $('#btn-print').click(function(){
                window.print(); 
            });

            $('#btn-finish').click(function(){
                window.location.href= '/';
            });

    </script>
</html>
