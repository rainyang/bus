<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AKAI Bus Tickets - register</title>
    <link href="/static/css/bus.css" rel="stylesheet">
    <link href="/static/css/bootstrap.css" rel="stylesheet">
    <link href="/static/css/bootstrap-select.css" rel="stylesheet">
    <link href="/static/css/bootstrap-formhelpers.min.css" rel="stylesheet">
    <link href="/static/css/datetimepicker.css" rel="stylesheet" media="screen">
</head>
<body>

<?php include "userinfo.php" ?>


<div class="container">
<div class="row re_center">
<h1>Register</h1>
<div class="ticket-info panel-collapse collapse in register"  id="traveler-info">
<form action="/account/do_register" id="form1" method="post">
                    <table class="table">

                    <tr><td>Email Address:<font color="#FF0000">*</font></td><td><input type="input" id="username" name="username" data-content="Your e-mail address serves as your login ID. It is important that it be an e-mail address where you can be contacted." class="form-control form-control-bus input-sm"></td></tr>
                    <tr><td>Password:<font color="#FF0000">*</font></td><td><input type="password" id="password" name="password" data-content="Choose a password between 4 and 10 characters." class="form-control form-control-bus input-sm"></td></tr>
                    <tr><td>Re-enter Password:<font color="#FF0000">*</font></td><td><input type="password" name="password2" data-content="Please re-enter password" class="form-control form-control-bus input-sm"></td></tr>
                    <tr><td>First Name<font color="#FF0000">*</font></td><td><input type="input" name="first-name" data-content="Please enter first name" class="form-control form-control-bus input-sm"></td></tr>
                    <tr><td>Last Name<font color="#FF0000">*</font></td><td><input type="input" name="last-name" data-content="Please enter last name" class="form-control form-control-bus input-sm"></td></tr>
                    <tr><td style="width:30%">Street address:<font color="#FF0000">*</font></td><td><input type="input" name="address" data-content="Please enter address" class="form-control form-control-bus input-sm address"></td></tr>
                    <tr><td>&nbsp;</td><td><input type="input" name="address2" data-content="Please enter address" class="form-control form-control-bus input-sm address1"></td></tr>
                    
                    <tr><td>Town or city<font color="#FF0000">*</font></td><td><input type="input" name="city" data-content="Please enter Town or city" class="form-control form-control-bus input-sm"></td></tr>
                    <tr><td>Country:<font color="#FF0000">*</font></td><td><select id="country" name="country" class="form-control bfh-countries" data-country="US"></select></td></tr>
                    <tr><td>State<font color="#FF0000">*</font></td><td><select  class="form-control bfh-states" id="state" name="state" data-country="country"></select></td></tr>
                    <tr><td>Zip Code:<font color="#FF0000">*</font></td><td><input type="input"  data-content="Please enter Zip code" name="zipcode" class="form-control form-control-bus input-sm"></td></tr>
                    <tr><td>Contact Phone<font color="#FF0000">*</font></td><td><input type="input" data-content="Please enter tel" name="tel" class="form-control form-control-bus input-sm"></td>
                    <tr><td>Contact Email<font color="#FF0000">*</font></td><td><input type="input" name="email" id="email" data-content="Please enter email" class="form-control form-control-bus input-sm"></td></tr>
                    <tr><td colspan=2><button style="text-align:center" type="button" id="btn-submit" class="btn btn-success btn-sm">Register</button></td></tr>
                    </table>
</form>
                </div>

</div>
</div>

   <div class="footer">
        <p>Privacy Policy | Terms & Conditions | Site Map | Mobile Site </p>
        <p>AKAI LLC Copyright &copy; 2013</p>
    </div> 
</div>
</body>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
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
        $(this).css('background', '#fff');
        $(this).popover('hide');
    });

    $('#username').blur(function(){
        $this = $(this);
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

    var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    $('#btn-submit').click(function(){
        var isright = 1;
        $('.form-control-bus').each(function(){
            if($(this).val()==''){ 
                //var rem = $(this).attr('data-content');
                //alert('please input '+rem);
                $(this).css('background', 'red');
                $(this).focus().select();
                isright = 0;
                return false;
            }
            else if($(this).attr('name') == 'email'){
                if(!reg.test($(this).val())){
                    isright = 0;
                    $(this).css('background', 'red');
                    $(this).attr('data-content','Please enter the correct email format');
                    $(this).popover({placement: 'right',trigger: 'focus',container:'body'});
                    $(this).popover('show');
                    $(this).focus().select();
                    return false;
                }
            }
            else if($(this).attr('name') == 'username'){
                if(!reg.test($(this).val())){
                    isright = 0;
                    $(this).css('background', 'red');
                    $(this).attr('data-content','Please enter the correct email format');
                    $(this).popover({placement: 'right',trigger: 'focus',container:'body'});
                    $(this).popover('show');
                    $(this).focus().select();
                    return false;
                }
                
            }
            else if($(this).attr('name') == 'password'){
                if(($(this).val() + "").length < 4 || ($(this).val() + "").length > 10){
                    isright = 0;
                    $(this).css('background', 'red');
                    $(this).attr('data-content','Value must be greater than 4 and smaller than 10');
                    $(this).popover({placement: 'right',trigger: 'focus',container:'body'});
                    $(this).popover('show');
                    $(this).focus().select();
                    return false;
                }
            }
            else if($('#state').val() == ''){
                isright = 0;
                alert('The state can\'t be empty');
                return false;
            }

            else if($(this).attr('name') == 'password2'){
                if($(this).val() != $("#password").val()){
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
        if(isright == 1)
            $('#form1').submit();
    });

});
</script>
</html>

