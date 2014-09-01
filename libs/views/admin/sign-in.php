<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Akai Admin</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="/static/lib/bootstrap/css/bootstrap.css">
    
    <link rel="stylesheet" type="text/css" href="/static/stylesheets/theme.css">
    <link rel="stylesheet" href="/static/lib/font-awesome/css/font-awesome.css">

    <script src="/static/lib/jquery-1.7.2.min.js" type="text/javascript"></script>

    <!-- Demo page code -->

    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
        .lang{
            color:#fff;
            float:right;
            margin-right:10px;
            display:block;
            cursor: pointer;
        }
        .navbar .brand{ width:100%;}
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
  <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
  <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
  <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
  <!--[if (gt IE 9)|!(IE)]><!--> 
  <body> 
  <!--<![endif]-->
    
    <div class="navbar">
        <div class="navbar-inner">
                <li class="brand" ><span class="first">AKAI</span> <span class="second">Bus Tickets</span><span class="lang" id="c_lang">中文</span><span id="e_lang" class="lang">english</span></li>

        </div>
    </div>
        <div class="row-fluid">
    <div class="dialog">
        <div class="block">
            <p class="block-heading"><?php echo lang('sign_in');?></p>
            <div class="block-body">
                <form action="" method="post" id="login">
                    <label><?php echo lang('username');?></label>
                    <input type="text" name="username" id="username" class="span12">
                    <label><?php echo lang('password');?></label>
                    <input type="password"	name="password" id="password" class="span12">
                    <input type="hidden" name="sub" value="1">
                    <a href="#" class="btn btn-primary pull-right" id="submit"><?php echo lang('sign_in');?></a>
                    <label class="remember-me" style="color:#FF0000;"><?php echo $error?></label>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
        <p class="pull-right" style=""><a href="http://www.akaiticket.com" target="blank">Power by AKAI</a></p>
    </div>
</div>
    <script src="/static/lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
           
        });
         $('#c_lang').click(function(){
                $.post('/manage/set_lang',{lang:"chinese"},function(data){
                    window.location.reload();
                });
            });
            $('#e_lang').click(function(){
                $.post('/manage/set_lang',{lang:"english"},function(data){
                    window.location.reload();
                });
            });
		$("#submit").click(function (){
			if($("#username").val() == ""){
				$(".remember-me").html("<?php echo lang('login_user_error')?>");
			}else if($("#password").val() == ""){
				$(".remember-me").html("<?php echo lang('login_pass_error')?>");
			}else{
				$("#login").submit();
			}	
		});
    </script>
    
  </body>
</html>


