<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AKAI Bus Tickets - schedule</title>
    <link href="/static/css/bus.css" rel="stylesheet">
    <link href="/static/css/bootstrap.css" rel="stylesheet">
    <link href="/static/css/bootstrap-select.css" rel="stylesheet">
    <link href="/static/css/bootstrap-formhelpers.min.css" rel="stylesheet">
    <link href="/static/css/datetimepicker.css" rel="stylesheet" media="screen">
</head>
<body>

<?php include "userinfo.php" ?>


<div class="container">
    
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
    <div class="slist row">
    <div class="stable">
        <div class="tab_head">
            <li class="li_title"><span class="glyphicon glyphicon-star"></span> PURCHASE</li>
            <li>1:SEARCH</li>
            <li>2:SELECT</li>
            <li class="current">3:PURCHASE</li>
            <li>4:COMPLETED</li>
        </div>
<form action="/search/do_order" id="form1" method="post">
        <div class="restrictions-border">
            <div class="restrictions">
                <div class="res-title">
                    <label data-toggle="collapse" data-target="#ticket-info">TICKET RESTRICTIONS <span class="glyphicon glyphicon-chevron-down"></span></label>
                </div>
                <div class="dashed-line"></div>
                <div class="ticket-info panel-collapse collapse in"  id="ticket-info">
                    <li class="itinerary">Your Current Itinerary</li>
                    <li class="itinerary-info">DEPARTURE:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $get['depart_city'];?> to <?php echo $get['return_city'];?> | <?php echo ($get['trip_type'] == 1) ? "Roundtrip" : "One Way";?></li>
                    <div class="dashed-line"></div>
                    <div>
                        <div>Departing Schedule</div>
                        <table class="table">
                        <tr><td>Departing</td><td>PRICE</td><td>Passengers</td></tr>
                        <?php
                            $passengers = $get['quantity'];
                            $ds = explode('|', $post['stops']);
                            $depart = $ds[1];
                            $as = explode('|', $post['arr_stops']);
                            $arrvial = $as[1];
                            echo "<tr class=\"success\"><td>{$depart}</td><td>{$from_price}</td><td>".$passengers."</td></tr>";
                        ?>
                        </table>
                    </div>
<!--return schedule-->
                    <?php
                    if($get['trip_type'] == 1){
                    ?>
<li class="itinerary-info">Return:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $get['return_city'];?> to <?php echo $get['depart_city'];?> </li>
                    <div class="dashed-line"></div>
<div>
                        <div>Return Schedule</div>
                        <table class="table">
                        <tr><td>Departing</td><td>PRICE</td><td>Passengers</td></tr>
                        <?php
                            $passengers = $get['quantity'];
                            $ds = explode('|', $post['return-stops']);
                            $depart = $ds[1];
                            $as = explode('|', $post['return-arr_stops']);
                            $arrvial = $as[1];
                            $tps = ($to_price == 0) ? "free" : $to_price;
                            echo "<tr class=\"success\"><td>{$depart}</td><td>{$tps}</td><td>".$passengers."</td></tr>";
                        ?>
                        </table>
                    </div>
<?php }?>

                </div>
                <!--ticket-info end-->

                <!--passenger-info-->
                 <div class="res-title">
                    <label data-toggle="collapse" data-target="#passenger-info">1.PASSENGER INFORMATION<span class="glyphicon glyphicon-chevron-down"></span></label>
                </div>
                <div class="dashed-line"></div>
                <div class="ticket-info panel-collapse collapse in"  id="passenger-info">
                    <table class="table">
                    <tr><td></td><td>First Name</td><td>Last Name</td><td>Price Per Person</td></tr>
                    <?php
                    for($i = 1; $i<= $passengers; $i++){
                        echo "<tr><td>Passengers {$i}*</td><td><input  name='a-first-name[]' data-content=\"Please enter first name {$i}\" type='input'  class=\"form-control form-control-bus input-sm\"></td><td><input name='a-last-name[]' data-content=\"Please enter last name {$i}\" type='input' class=\"form-control form-control-bus input-sm\"></td><td>\${$from_price} (US Dollars)</td></tr>";
                    }
                    ?>
                    </table>
                </div>
                <!--passenger-info-->

                <!--traveler-info-->
                 <div class="res-title">
                    <label data-toggle="collapse" data-target="#traveler-info">2.Traveler Contact Information<span class="glyphicon glyphicon-chevron-down"></span></label>
                </div>
                <div class="dashed-line"></div>
                <div class="ticket-info panel-collapse collapse in"  id="traveler-info">
                    <table class="table" style="width:60%; margin:0 auto;">
                    <!--
                    <tr><td>First Name*</td><td><input type="input" name="first-name" data-content="Please enter traveler first name" class="form-control form-control-bus input-sm"></td><td>Last Name*</td><td><input type="input" name="last-name" data-content="Please enter traveler last name" class="form-control form-control-bus input-sm"></td></tr>
                    <tr><td>Contact Email*</td><td><input type="input" name="email" id="email" data-content="Please enter email" class="form-control form-control-bus input-sm"></td><td>Re-type Email*</td><td><input type="input" name="re-email" data-content="Please enter re-email" class="form-control form-control-bus input-sm"></td></tr>
                    <tr><td>Contact Phone*</td><td><input type="input" data-content="Please enter tel" name="tel" class="form-control form-control-bus input-sm"></td>
                    <td>Address*</td><td><input type="input" name="address" data-content="Please enter address" class="form-control form-control-bus input-sm"></td></tr>
-->
<tr><td>First Name<font color="#FF0000">*</font></td><td><input type="input" name="first-name" value="<?php echo @$user['first-name'];?>" data-content="Please enter first name" class="form-control form-control-bus input-sm"></td></tr>
                    <tr><td>Last Name<font color="#FF0000">*</font></td><td><input type="input" value="<?php echo @$user['last-name'];?>" name="last-name" data-content="Please enter last name" class="form-control form-control-bus input-sm"></td></tr>
                    <tr><td style="width:30%">Street address:<font color="#FF0000">*</font></td><td><input type="input" value="<?php echo @$user['address'];?>" name="address" data-content="Please enter address" class="form-control form-control-bus input-sm address"></td></tr>
                    <tr><td>&nbsp;</td><td><input type="input" value="<?php echo @$user['address2'];?>" name="address2" data-content="Please enter address" class="form-control form-control-bus input-sm address1"></td></tr>
                    
                    <tr><td>Town or city:<font color="#FF0000">*</font></td><td><input type="input"  value="<?php echo @$user['city'];?>" data-content="Please enter town or city" name="city" class="form-control form-control-bus input-sm"></td></tr>
                    <tr><td>State<font color="#FF0000">*</font></td><td><select  class="form-control bfh-states" id="state" name="state" data-country="country" data-state="<?php echo (empty($user['state'])) ? "" : $user['state']?>"></select></td></tr>
                    <tr><td>Zip Code:<font color="#FF0000">*</font></td><td><input type="input"  value="<?php echo @$user['zipcode'];?>" data-content="Please enter Zip code" name="zipcode" class="form-control form-control-bus input-sm"></td></tr>
                    <tr><td>Country:<font color="#FF0000">*</font></td><td><select id="country" name="country" class="form-control bfh-countries" data-country="<?php echo (empty($user['country'])) ? "US" : $user['country']?>"></select></td></tr>
                    <tr><td>Contact Phone<font color="#FF0000">*</font></td><td><input type="input" value="<?php echo @$user['tel'];?>" data-content="Please enter tel" name="tel" class="form-control form-control-bus input-sm"></td>
                    <tr><td>Contact Email<font color="#FF0000">*</font></td><td><input type="input" value="<?php echo @$user['email'];?>" name="email" id="email" data-content="Please enter email" class="form-control form-control-bus input-sm"></td></tr>

                    </table>
                </div>

<?php
if(empty($user)){
?>
                 <div class="res-title">
                    <label data-toggle="collapse" data-target="#payment-method">3.register<font color="reg">(optional)</font><span class="glyphicon glyphicon-chevron-down"></span></label>
                </div>
                <div class="dashed-line"></div>
                <div class="ticket-info panel-collapse collapse in"  id="payment-method">
                    <p>
If you are the first time use akaillc.com to order bus tickets,please enter password to <a id="register">register</a>. Or old customer <a id="login">Login</a>.
                    <br>
                    </p>
                    <div class="d-register">
                        <table class="table" style="width:60%; margin:0 auto;">
                        <tr><td>Email Address:</td><td><input type="input" id="username" name="username" data-content="Your e-mail address serves as your login ID. It is important that it be an e-mail address where you can be contacted." class="form-control form-control-bus input-sm"></td></tr>
                        <tr><td>Password:</td><td><input type="password" id="password" name="password" data-content="Choose a password between 4 and 10 characters." class="form-control form-control-bus input-sm"></td></tr>
                        <tr><td>Re-enter Password:</td><td><input type="password" id="password2" name="password2" data-content="Please re-enter password" class="form-control form-control-bus input-sm"></td></tr>
                        </table>
                    </div>
                    <div class="d-login">
                        <table class="table" style="width:60%; margin:0 auto;">
                        <tr><td>username:</td><td><input type="input" id="login-username" data-content="Your e-mail address serves as your login ID. It is important that it be an e-mail address where you can be contacted." class="form-control form-control-bus input-sm"></td></tr>
                        <tr><td>Password:</td><td><input type="password" id="login-password"  data-content="Choose a password between 4 and 10 characters." class="form-control form-control-bus input-sm"></td></tr>
                        <tr><td colspan=2 align="center"><button type="button" id="btn-login" class="btn btn-warning btn-sm">LOGIN</button></td></tr>
                        </table> 
                    </div>
                </div>
<?php }?>

                <!--NONREFUNDABLE-->
                 <div class="res-title">
                    <label data-toggle="collapse" data-target="#complete-order">NONREFUNDABLE - NO REFUND WOULD BE GRANTED.<span class="glyphicon glyphicon-chevron-down"></span></label>
                </div>
                <div class="dashed-line"></div>
                <div class="ticket-info panel-collapse collapse in"  id="complete-order">
                    <p>
                    <label for="nonrefundable">
                    Please check the selected schedule information carefully before check out, ticket purchases are final and are not refundable or changeable. Duplicate transactions are also not refundable because duplicate transactions block other customers from purchasing tickets. There will be no refund for any unused or partly used services. 
                    <br>
                    <br>
                        <input type="checkbox" name="nonrefundable" value="1" id="nonrefundable">&nbsp;&nbsp;By checking this box, I acknowledge that I have read, understand, and agree to the Terms and Conditions. 
                    </label>
                    </p>
                </div>
                <!--NONREFUNDABLE-->

<br>
                <!--complete-order-->
                 <div class="res-title">
                    <label data-toggle="collapse" data-target="#complete-order">Complete your order<span class="glyphicon glyphicon-chevron-down"></span></label>
                </div>
                <div class="dashed-line"></div>
                <div class="ticket-info panel-collapse collapse in"  id="complete-order">
                <?php
                    $sum_price = $passengers * ($from_price + $to_price);
                ?>
                    <label>You will be charged $<?php echo $sum_price;?> when you complete this reservation.</label>
                    <input type="hidden" value="<?php echo $sum_price;?>" name="sum_price">
                    <input type="hidden" value="<?php echo $line_id;?>" name="line_id">
                    <br>
                    <div style="margin:0 auto; text-align:center;margin:20px;">
                    <button type="button" id="btn-submit" class="btn btn-primary ">Complete My Order</button>
                    </div>
                </div>
                <!--complete-order-end-->

                
            </div>
        </div>
</form>
    </div>
    </div>
   <div class="footer">
        <p>Privacy Policy | Terms & Conditions | Site Map | Mobile Site </p>
        <p>AKAI LLC Copyright &copy; 2014</p>
    </div> 
</div>
</body>
<script src="/static/js/jquery-1.9.1.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script src="/static/js/bootstrap-select.min.js"></script>
<script src="/static/js/bootstrap-formhelpers.js"></script>

<script type="text/javascript">

$(document).ready(function(){
    $('.form-control-bus').focus(function(){
        $(this).popover({placement: 'right',trigger: 'focus',container:'body'});
        $(this).popover('show');
    });

    $('.form-control-bus').blur(function(){
        $(this).popover('hide');
        $(this).css('background', '#fff');
    });

    $('#username').blur(function(){
        $this = $(this);
        if(!$this.val()) return;
        $.post('/account/is_register',{username:$this.val()}, function(data){
            if(data > 0){
                $this.css('background', 'red');
                $this.attr('data-content','Email already exists, please change');
                $this.popover({placement: 'right',trigger: 'focus',container:'body'});
                $this.popover('show');
                $this.focus().select();
                return false;
            }
        });
    });

    $("#btn-login").click(function(){
        $.post('/account/ajax_login', {username: $("#login-username").val(), password: $("#login-password").val()},
            function(data){
                if(data == "ok"){
                    $(".d-login").empty().append("login success!");
                }
                else{
                    alert('UserName or PassWord error! Please input again');
                }
            }
        );
    });

    $("#login").click(function(){
        $(".d-register").hide();
        $(".d-login").show();
    });

    $(".d-register").hide();

    $("#register").click(function(){
        $(".d-register").show();
        $(".d-login").hide();
    });

    $('#btn-schedule').click(function(){
        $('#schedule-list').toggle();
    });
    $('#btn-return-schedule').click(function(){
        $('#return-schedule-list').toggle();
    });
    var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    $('#btn-submit').click(function(){
        if($("#username").val()){
            if($("#password").val() != $("#password2").val()){
                alert('The two passwords don\'t match');
                return false;
            }    
        }

        var isright = 1;
        $('.form-control-bus').each(function(){
            if($(this).attr("id") == 'login-username' || $(this).attr("id") == 'login-password'){
                return true;
            }
            if($(this).val()=='' && $(this).attr('name') != 'address2' && $(this).attr('name') != 'username' && $(this).attr('name') != 'password' && $(this).attr('name') != 'password2'){ 
                //var rem = $(this).attr('data-content');
                //alert('please input '+rem);
                $(this).focus().select();
                isright = 0;
                return false;
            }
            else if($(this).attr('name') == 'email'){
                if(!reg.test($(this).val())){
                    isright = 0;
                    $(this).attr('data-content','Please enter the correct email format');
                    $(this).popover({placement: 'right',trigger: 'focus',container:'body'});
                    $(this).popover('show');
                    $(this).focus().select();
                    return false;
                }
            }
            else if($(this).attr('name') == 're-email'){
                if($(this).val() != $("#email").val()){
                    isright = 0;
                    $(this).attr('data-content','Two input is inconsistent');
                    $(this).popover({placement: 'right',trigger: 'focus',container:'body'});
                    $(this).popover('show');
                    $(this).focus().select();
                    return false;
                    
                }
            }
            else{
                isright = 1;
            }
        });
        if($('#nonrefundable').prop('checked') != true && isright ==1){
            alert('You have to agree our terms and conditions before continue.');
            return false;
        }
        if(isright == 1)
            $('#form1').submit();
    });

});
    </script>
</html>
