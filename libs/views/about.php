<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AKAI Bus Tickets - about</title>
    <link href="/static/css/bus.css" rel="stylesheet">
    <link href="/static/css/bootstrap.css" rel="stylesheet">
    <link href="/static/css/bootstrap-select.css" rel="stylesheet">
    <link href="/static/css/datetimepicker.css" rel="stylesheet" media="screen">
</head>
<body>

<?php include "userinfo.php" ?>


<div class="container">
<div class="row">
<h1>About Us</h1>
  <p>
	AKAI.com is a New Bus service provided for all travelers, we provide bus route from Brimingham to New York, and will be expanding to other routes shortly.</p>
<p>
	We concentrate on the quality and services we provide.</p>
<p>
	COMPANY:AKAI LLC<br />
	ADDRESS:243 W. VALLEY AVENUE, SUITE 101 HOMEWOOD, AL 35209<br />
    EMAIL: Akai_bus@outlook.com	<br />
 TEL: 205-290-6868<br />
</p>
<p>
<p>
	&nbsp;</p>
<p>
	Thank you!</p>
<p>
	Enjoying Your Ride!<br />
	AKAI.com</p>

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

<script type="text/javascript">
$(document).ready(function(){
            $('.btn-schedule, .select_line').click(function(){
                $('.schedule-list:visible').hide();
                var scheduleid = $(this).attr('schedule-id');
                $('#schedule-list'+scheduleid).toggle();
            });

            $('.btn-return-schedule, .select_return_line').click(function(){
                $('.return-schedule-list:visible').hide();
                var scheduleid = $(this).attr('schedule-id');
                $('#return-schedule-list'+scheduleid).toggle();
            });

            $('.update_address').click(function(){
                $('#submit_address').val($(this).attr('address'));
                $('#form2').submit();
            });

});
    </script>
</html>
