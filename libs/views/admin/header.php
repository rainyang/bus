<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>AKAI Admin</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="RainYang">

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
  <body class=""> 
  <!--<![endif]-->
    
    <div class="navbar">
        <div class="navbar-inner">
                <ul class="nav pull-right">
                    
                    <li><a href="/" target="_blank" class="hidden-phone visible-tablet visible-desktop" role="button">Web Site</a></li>
                    <li id="fat-menu" class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user"></i><?php echo $this->admin['username'];?> 
                            <i class="icon-caret-down"></i>
                        </a>


                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="/manage/edit_user/<?php echo $this->admin['id'];?>"><?php echo lang('myaccount');?></a></li>
                            <li class="divider"></li>
                            <li><a tabindex="-1" class="visible-phone" href="#"><?php echo lang('settings');?></a></li>
                            <li class="divider visible-phone"></li>
                            <li><a tabindex="-1" href="/manage/signup"><?php echo lang('logout');?></a></li>
                        </ul>
                    </li>
                    
                </ul>
                <a class="brand" href="/manage/main"><span class="first">AKAI</span> <span class="second">Bus Tickets</span></a>
        </div>
    </div>