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
<body>

<?php include "userinfo.php" ?>

<div class="container">
    <div class="slist row">
    <div class="stable">
    <div class="tab_head">
        <li class="li_title"><span class="glyphicon glyphicon-star"></span> SELECT</li>
        <li>1:SEARCH</li>
        <li class="current">2:SELECT</li>
        <li>3:PURCHASE</li>
        <li>4:COMPLETED</li>
    </div>
<div>
<form id="form2" action="/search/map" method="post" target="_blank">
    <input type="hidden" id="submit_address" name="address" value=""> 
</form>
<form id="form1" action="/search/purchase" method="post">
    <table class="table table-bordered">
    <tr><td colspan="12">Choose Departing Schedule: <?php echo $sinfo['depart_city'];?> to <?php echo $sinfo['return_city'] . "&nbsp;&nbsp;&nbsp;  Depart Date:" . $sinfo['depart_date'];?></td></tr>
    <tr><td>Departing</td><td>PRICE</td><td>Discount Price</td><td>features</td><td></td></tr>
    <?php
        $count_lines = count($schedules);
        $checked = ($count_lines == 1) ? " checked" : "";
        $default_price =($count_lines == 1) ? $schedules[0]['price'] : ""; 
        $default_discount_price =($count_lines == 1) ? $schedules[0]['discount_price'] : ""; 
        $default_return_price = ($count_lines == 1 && $schedules[0]['is_return_free'] == 0) ? $schedules[0]['return_price'] : "free"; 
        $default_discount_return_price = ($count_lines == 1 && $schedules[0]['is_return_free'] == 0) ? $schedules[0]['discount_return_price'] : "free"; 

    ?>
    <input type="hidden" name="price" id="price" value="<?php echo $default_discount_price;?>">
    <input type="hidden" name="return_price" id="return_price" value="<?php echo $default_discount_return_price;?>">
    <input type="hidden" name="is_transfer" id="is_transfer" value="">
    <input type="hidden" name="only_tran" id="only_tran" value="">
    <input type="hidden" name="tran_line" id="tran_line" value="">
<?php
            foreach($schedules as $key => $val){
                //换乘情况
                if($val['is_transfer'] == 1){
                    $tran_depart = " tran_tickets = '{$val['tran_depart_tickets']}'";
                    $istran = " is_transfer= 1";
                    $tranline = " tran_line= '{$val['tran_line_id']}'";
                    $only_tran = " only_tran= '{$val['only_tran']}'";
                    if($val['only_tran'] == 1){
                        $val['depart_tickets'] = 200;
                    }
                }

                $discount = ( empty($val['discount_price']) ) ? "-" : $val['discount_price'];
                echo "<tr class=\"success\"><td><input type=\"radio\" {$istran} {$tranline} ${only_tran} data-price=\"{$val['price']}\" data-discount-price=\"{$val['discount_price']}\" name=\"select_line\" {$tran_depart} {$checked} schedule-id=\"{$key}\" class=\"select_line\" tickets=\"{$val['depart_tickets']}\"  value='{$val['lineinfo']}'>{$val['departing_time']}</td><td>{$val['price']}</td><td>{$discount}</td><td>{$val["free_facility"]}</td><td><button type=\"button\" data-discount-price=\"{$val['discount_price']}\" data-price=\"{$val['price']}\" schedule-id=\"{$key}\"  class=\"btn btn-primary btn-sm btn-schedule\">+ Choose Station</button></td></tr>";
        ?>
        <tr>
            <td id="schedule-list<?php echo $key;?>" colspan="12" style="display:none" class="schedule-list">
                <div class="row busstop">
                    <div class="col-md-6 depart">
                        <li><span class="green glyphicon glyphicon-circle-arrow-up"></span> Select Pick Up Info<li>
                        <li><?php echo $sinfo['depart_city'];?><li>
                        <?php
                            foreach($val['from_route'] as $v){
                                //$time = ($val['order'] == 'asc') ? $v['departing_time'] : $v['return_time'];
                                $time = $v['departing_time'];
                                echo "<li><span><input type=radio name=\"stops\"  {$checked} value=\"{$v['id']}|{$time}\"> {$time}</span><span class=\"address\"><a address=\"{$v['address']}\" class=\"update_address\"><img src=\"/static/images/address_g.png\"></a>{$v['address']}</span></li>";
                            }
                        ?>
                    </div>
                    <div class="col-md-6 arrval">
                        <li><span class="red glyphicon glyphicon-circle-arrow-down"></span> Select Drop Off Info<li>
                        <li><?php echo $sinfo['return_city'];?><li>
                        <?php
                            foreach($val['to_route'] as $v){
                                //$time = ($val['order'] == 'asc') ? $v['departing_time'] : $v['return_time'];
                                $time = "";
                                echo "<li><span><input type=radio name=\"arr_stops\"  {$checked}  value=\"{$v['id']}|{$time}\"></span><span class=\"address\"><a address=\"{$v['address']}\" class=\"update_address\"><img src=\"/static/images/address_r.png\"></a>{$v['address']}</span></li>";
                            }
                        ?>
                    </div>
                </div>
            </td>
        </tr>
<?php }?>
</table>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Warning</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
         <!--return schedule-->
<?php
if($sinfo['trip_type'] == 1){
?>

<div>
    <table class="table table-bordered">
        <tr><td colspan="12">Choose Returning Schedule: <?php echo $sinfo['return_city'];?> to <?php echo $sinfo['depart_city']  . "&nbsp;&nbsp;&nbsp;  Return Date:" . $sinfo['return_date'];?></td></tr>
        <tr><td>Departing</td><td>Price</td><td>Discount Price</td><td>features</td></tr>
        <?php
            foreach($schedules as $key => $val){
                if($val['is_transfer'] == 1){
                    $tran_return = " tran_return_tickets = '{$val['tran_return_tickets']}'";
                }
                $price = ($val['is_return_free'] == 1) ? "free" : $val['return_price'];
                $discount = ( empty($val['discount_return_price']) ) ? "-" : $val['discount_return_price'];
                echo "<tr class=\"success\"><td><input type=\"radio\" data-discount-price=\"{$val['discount_return_price']}\" data-price=\"{$price}\" name=\"select_return_line\" {$tran_return} {$checked} tickets=\"{$val['return_tickets']}\"  schedule-id=\"{$key}\" class=\"select_return_line\" value=\"{$val['lineinfo']['line_id']}-{$val['lineinfo']['to_id']}-{$val['lineinfo']['id']}\">{$val['arriving_time']}</td><td>{$price}</td><td>{$discount}</td><td>{$val['free_facility']}</td><td><button type=\"button\"  schedule-id=\"{$key}\"  data-discount-price=\"{$val['discount_return_price']}\" data-price=\"{$price}\" class=\"btn btn-primary btn-sm btn-return-schedule\">+ Choose Station</button></td></tr>";
        ?>
        <tr>
            <td id="return-schedule-list<?php echo $key;?>" colspan="12" style="display:none" class="return-schedule-list">
                <div class="row busstop">
                    <div class="col-md-6 depart">
                        <li><img src="/static/images/depart.png" />Select Departure<li>
                        <li><?php echo $sinfo['return_city'];?><li>
                        <?php
                            foreach($val['to_route'] as $v){
                                $address = urlencode($v['address']);
                                $time = $v['return_time'];
                                echo "<li><span>ss<input type=radio name=\"return-stops\"  {$checked}  value=\"{$v['id']}|{$time}\"> {$time}</span><span class=\"address\"><a address=\"{$v['address']}\" class=\"update_address\"><img src=\"/static/images/address_g.png\"></a>{$v['address']}</span></li>";
                            }
                        ?>
                    </div>
                    <div class="col-md-6 arrval">
                        <li><img src="/static/images/arrival.png" />Select Arrival<li>
                        <li><?php echo $sinfo['depart_city'];?><li>
                        <?php
                            foreach($val['from_route'] as $v){
                                $time = "";
                                echo "<li><span><input type=radio name=\"return-arr_stops\"  {$checked}  value=\"{$v['id']}|{$time}\"> {$time}</span><span class=\"address\"><a address=\"{$v['address']}\" class=\"update_address\"><img src=\"/static/images/address_r.png\"></a>{$v['address']}</span></li>";
                            }
                        ?>
                    </div>
                </div>
             </td>
        </tr>
<?php }?>
    </table>
</div>
<?php 
}

?>
<div><button style="float:right" type="button" id="btn-continue" class="btn btn-success btn-sm">continue</button></div>
</form>
   
    </div>
    </div>
   <div class="footer">
        <p>Privacy Policy | Terms & Conditions | Site Map | Mobile Site </p>
        <p>AKAI LLC Copyright &copy; 2013</p>
    </div> 
</div>
</body>
<script src="/static/js/jquery-1.9.1.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script src="/static/js/bootstrap-select.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
            $('.btn-schedule, .select_line').click(function(){
                $('.schedule-list:visible').hide();
                if(typeof($(this).attr('is_transfer')) != 'undefined'){
                    $('#is_transfer').val($(this).attr('is_transfer'));
                    $('#only_tran').val($(this).attr('only_tran'));
                    $('#tran_line').val($(this).attr('tran_line'));
                }
                var scheduleid = $(this).attr('schedule-id');
                var price = $(this).attr('data-discount-price');
                $('#price').val(price);
                $('#schedule-list'+scheduleid).toggle();
            });

            $('.btn-return-schedule, .select_return_line').click(function(){
                $('.return-schedule-list:visible').hide();
                var scheduleid = $(this).attr('schedule-id');
                var price = $(this).attr('data-discount-price');
                $('#return_price').val(price);
                $('#return-schedule-list'+scheduleid).toggle();
            });

            $('.update_address').click(function(){
                $('#submit_address').val($(this).attr('address'));
                $('#form2').submit();
            });

            $('#btn-continue').click(function(){
                var trip_type = <?php echo $sinfo['trip_type'];?>;
                var $selectline = $("input[type='radio'][name='select_line']:checked");

                if(typeof($selectline.attr('is_transfer')) != 'undefined'){
                    $('#is_transfer').val($selectline.attr('is_transfer'));
                    $('#only_tran').val($selectline.attr('only_tran'));
                    $('#tran_line').val($selectline.attr('tran_line'));
                }
                //if ($selectline.attr('tickets') <= 0 || $selectline.attr('tran_tickets') <=0 ){
                if ($selectline.attr('tickets') <= 0){
                    $('.modal-body').html('Sorry, Tickets sold out');
                    $('#myModal').modal();
                    return false;
                }

                if($("input[type='radio'][name='select_line']:checked").length == 0){
                    $('.modal-body').html('Please select a depart line');
                    $('#myModal').modal();
                    return false;
                }
                if($("input[type='radio'][name='stops']:checked").length == 0){
                    $('.modal-body').html('Please select a bus stops');
                    $('#myModal').modal();
                    return false;
                }
                if($("input[type='radio'][name='arr_stops']:checked").length == 0){
                    $('.modal-body').html('Please select a bus stops');
                    $('#myModal').modal();
                    return false;
                }
                if(trip_type == 1){
                    if($("input[type='radio'][name='select_return_line']:checked").length == 0){
                        $('.modal-body').html('Please select a return line');
                        $('#myModal').modal();
                        return false;
                    }
                    if($("input[type='radio'][name='return-stops']:checked").length == 0){
                        $('.modal-body').html('Please select a return bus stop');
                        $('#myModal').modal();
                        return false;
                    }
                    if($("input[type='radio'][name='return-arr_stops']:checked").length == 0){
                        $('.modal-body').html('Please select a return bus stop');
                        $('#myModal').modal();
                        return false;
                    }
                }
                $('#form1').submit();
            });
});
    </script>
</html>
