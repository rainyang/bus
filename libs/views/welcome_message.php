<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AKAI Bus Tickets</title>
    <link href="/static/css/bus.css" rel="stylesheet">
    <link href="/static/css/bootstrap.css" rel="stylesheet">
    <link href="/static/css/bootstrap-select.css" rel="stylesheet">
    <link href="/static/css/datetimepicker.css" rel="stylesheet" media="screen">
</head>
<body>

<div class="container">
    <div class="row b_top">
        <div class="col-md-7">
            <div class="logo"><img class="img-responsive" src="/static/images/logo.png"></div>
        </div>
        <div class="col-md-5">
            <div class="b_right">
                <div class="like_tweet"><img src="/static/images/like.png"><img src="/static/images/tweet.png"></div>
                <div class="tel"><img class="img-responsive" src="/static/images/tel.png"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <ul class="nav nav-justified">
           <li class="active"><a href="#">Home</a></li>
              <li><a href="#">Services</a></li>
              <li><a href="#">DEALS & DISCOUNTS</a></li>
              <li class="nav_tickets"><a href="#">TICKETS & TRAVEL INFO</a></li>
              <li><a href="#">ROAD & REWARDS</a></li>
              <li><a href="#">HOTELS & PACKAGES</a></li> 
        </ul>
    </div>

    <div class="row tickets">
        <div class="ticket_left">
            <form class="form-horizontal" role="form" method="post" action="/search/tlist">
            <div class="ticket_title round">
                <div class="title">
                    Tickets
                </div>
            </div>
            <div class="ticket_content">
                <div class="t1">
                <li style="height:30px;line-height:30px;"><input type="radio" name="round" value="1" checked> Roundtrip&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="round" value="0"> One Way</li>
                <li>Leaving from:</li>
                <li><select class="selectpicker" name="leaving" data-width="100%">
                            <?php
                            foreach($station as $key => $val){
                                echo "<option value=\"{$key}\">{$val}</option>";
                            }
                            ?>
                        </select>
                </li>
                <li>Going to:</li>
                <li><select class="selectpicker" name="goingto" data-width="100%">
                            <?php
                            ksort($station);
                            foreach($station as $key => $val){
                                echo "<option value=\"{$key}\">{$val}</option>";
                            }
                            ?>
                        </select>
                </li>

                <li>Departing on:</li>
                <li>
                    <div class="controls date form_datetime b_date" data-date="<?php echo date("m/d/Y");?>" data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                   <input size="16" type="text" name="departing_date" class="form-control1 form-control-bus date_input input-sm" value="<?php echo date("m/d/Y");?>" readonly>
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                    <input type="hidden" id="dtp_input1" value="" />
                </li>

                <li>Return Date:</li>
                <li>
                    <div class="controls date form_datetime b_date" data-date="<?php echo date("m/d/Y");?>" data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                   <input size="16" type="text" name="return_date" class="form-control1 form-control-bus date_input input-sm" value="<?php echo date("m/d/Y");?>" readonly>
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                    <input type="hidden" id="dtp_input1" value="" />
                </li> 

                <li><span>Adults:</span><span style="display:block;float:right;">Children:(0-12):</span></li>
                <li>
                    <span style="display:block;float:left;width:49%">
                        <select id="adults" name="adults" class="selectpicker"  data-width="100%">
                            <option value="0">0</option>
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </span>
                    <span  style="display:block;float:right;width:49%;">
                        <select id="children" name="children" class="selectpicker"  data-width="100%">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </span>
                </li>

                <li>Discount Type:</li>
                <li>
                    <select class="selectpicker" name="discount" data-width="100%">
                            <option value="0">No Discounts</option>
                            <option value="1">Military Roundtrip Discount</option>
                            <option value="2">Companion Fare</option>
                            <option value="3">Student Advantage</option>
                            <option value="4">Veterans Advantage</option>
                        </select>
                </li>
                <li style="height:40px; margin-top:10px;text-align:center;"><button type="submit" class="btn btn-success btn-schedule">SEARCH SCHEDULES</button></li>
                </div>
            </div>
            </form>
        </div>



        <div class="ticket_right">
            <div class="jumbotron">
                <h1>WELCOME GO MY SITE!</h1>
                <p>PAY WITH CASH
ADVANCE PURCHASE SPECIAL
GREYHOUND EXPRESS
HOTELS & TRAVEL PACKAGES<p>
                <p><a class="btn btn-primary btn-lg" role="button">Learn more</a></p>
            </div>
           
            <div>
                <div class="list-group group1">
                  <a href="#" class="list-group-item active">
                    Popular Travel Destinations
                  </a>
                  <a href="#" class="list-group-item">New Yor</a>
                  <a href="#" class="list-group-item">Atlanta</a>
                  <a href="#" class="list-group-item">Boston</a>
                  <a href="#" class="list-group-item">Orlando</a>
                </div>

                <div class="group2">
                    <h4>Kontaktdaten!</h4>
                    <div class="kont">
                        <div class="kont_left">
                        <p>Telefon:     9011 | 6000 28 74</p>
                        <p>Fax:     9011 | 6000 28 73</p>
                        <p>Email:</p>
                        <p>Website::</p>
                        </div>
                        <div class="kont_right">
                            <img src="/static/images/kont.png" />
                        </div>
                    </div>
                    <div class="btn_kont">
                        <button type="button" class="btn btn-success btn-sm">kontakt</button>
                    </div>
                </div>

            </div>
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
<script type="text/javascript" src="/static/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="/static/js/jquery.placeholder.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.autocomplete.js"></script>

<script type="text/javascript">
        $(window).on('load', function () {

            $('.selectpicker').selectpicker({
                'selectedText': 'cat'
            });

            // $('.selectpicker').selectpicker('hide');
        });
        $('.b_time').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  0,
		autoclose: 1,
		todayHighlight: 0,
		startView: 1,
		forceParse: 0,
        showMeridian: 1,
		minView: 1,
    });
    $('.b_date').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1,
		minView: 2,
    });

    //autocomplete
$(document).ready(function(){
    var round = $("input[type='radio'][name='round']");
    round.click(function(){
        if($("input[type='radio'][name='round']:checked").val() == 1){
            $('.return-option').css('display','');
        }
        else{
            $('.return-option').css('display','none');
        }
    });
    /*
    $('input, textarea').placeholder();
    $('#leaving').autocomplete({
		source:function(query,process){

			var matchCount = this.options.items;
			$.post("/search/leaving",{"name":query,"matchCount":matchCount},function(respData){
				return process(respData);
			});
		},
		formatItem:function(item){
            //alert(item);
			return item["name"];
		},
		setValue:function(item){
			return {'data-value':item["name"],'real-value':item["id"]};
		}
	});
     $('#goingto').autocomplete({
		source:function(query,process){

			var matchCount = this.options.items;
			$.post("/search/leaving",{"name":query,"matchCount":matchCount},function(respData){
				return process(respData);
			});
		},
		formatItem:function(item){
            //alert(item);
			return item["name"];
		},
		setValue:function(item){
			return {'data-value':item["name"],'real-value':item["id"]};
		}
	});
     */
});
    </script>
</html>
