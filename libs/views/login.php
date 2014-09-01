<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AKAI Bus Tickets - register</title>
    <link href="/static/css/bus.css" rel="stylesheet">
    <link href="/static/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/bootstrap-login.css" />
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
                        <li><a href="/schedule">Bus Schedule</a></li>
                        <li><a href="/about">About us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

<div class="container">
<div class="row re_center">
<div id="login1"></div>
</div>

   <div class="footer">
        <p>Privacy Policy | Terms & Conditions | Site Map | Mobile Site </p>
        <p>AKAI LLC Copyright &copy; 2013</p>
    </div> 
</div>
</body>
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/jquery.bootstrap.login.js"></script>
<script type="text/javascript">
$(function() {
        $('#login1').bootstrapLogin({
          lang: 'en',
          title: 'Akai Bus',
          action: '/account/do_login'
        });
        $('.alert-danger').hide();
      });
</script>
</html>
