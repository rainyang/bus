<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AKAI Bus Tickets - error</title>
    <link href="/static/css/bus.css" rel="stylesheet">
    <link href="/static/css/bootstrap.css" rel="stylesheet">
    <link href="/static/css/bootstrap-select.css" rel="stylesheet">
    <link href="/static/css/datetimepicker.css" rel="stylesheet" media="screen">
</head>
<body>

<div class="top">
<!--
<div class="top_width">
<span style="color:#ffffff;font-weight:bold;"><a href="#">Sign in</a> | <a href="#">Sign up</a></span>
</div>
-->
</div>
	<div class="header_shadow_bg">
    <div class="header_shadow_bg2">
    <div class="header_shadow">
        <div class="header">
            <div class="header_width">
                <div class="logo"><a href="/"><img src="/static/images/logo.png" width="124" height="39" alt="AKAI" /></a></div>
                <div class="nav">
                	<ul>
                    	<li><a href="/">Home</a></li>
                        <li><a href="/about">About us</a></li>
                        <li><a href="/schedule">Bus Schedule</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

<div class="container">
    
    <div class="slist row">
    <div class="stable">
        <div class="noprint tab_head">
            <li class="li_title"><span class="glyphicon glyphicon-star"></span> Payment</li>
            <li>1:SEARCH</li>
            <li>2:SELECT</li>
            <li>3:PURCHASE</li>
            <li class="current">4:Payment</li>
        </div>
        <div class="noprint1 restrictions-border">
            <div class="restrictions">
                <div class="noprint res-title">
                    <label data-toggle="collapse" data-target="#ticket-info">There was an error payment:</label>
                </div>
                <div class="noprint dashed-line"></div>
                <div class="noprint ticket-info panel-collapse collapse in"  id="ticket-info">
                </div>

                <!--startprint-->
                <div class="payment">
<?php echo $error;?>  <a href="javascript:void(0)" onclick="history.go(-1)">back to payment</a>
                </div>
                <!--endprint-->
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
</html>
