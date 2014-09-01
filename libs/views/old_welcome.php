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

    <!--Welcome-->
    <div class="row">
        <div class="col-md-7 welcome">
            <h1>WELCOME GO MY SITE</h1>
            <h3>WELCOME GO MY SITE</h3>
            <h3>WELCOME GO MY SITE</h3>
        </div>
        <div class="col-md-5 b_tip">
            <div class="pay">
                <h4>PAY WITH CASH</h4>
                <h4>ADVANCE PURCHASE SPECIAL</h4>
                <h4>GREYHOUND EXPRESS</h4>
                <h4>HOTELS & TRAVEL PACKAGES</h4>
            </div>
        </div>
    </div>

    <div class="row bias">
        <div class="col-md-9">
        </div>
        <div class="col-md-3">
            <img src="/static/images/style1_03.png" />
        </div>
    </div>

    <!--go grehound-->
    <div class="row gohound">
        <div class="col-md-4">
            <h4>GO GREYHOUND TO SIX FLAGS!</h4>
            <button type="button" class="btn btn-success btn-sm">Mehr Infos</button>
        </div>
        <div class="col-md-4">
            <h4>GO GREYHOUND TO SIX FLAGS!</h4>
            <button type="button" class="btn btn-success btn-sm">Mehr Infos</button>
        </div>
        <div class="col-md-4">
        </div>
    </div>

    <div class="row tickets">
        <div class="col-md-7 ticket_search">
            <form class="form-horizontal" role="form" method="post" action="/search/tlist">
                <div class="form-group row">
                    <label for="inputEmail3" class="round control-label"><input type="radio" name="round" value="1" checked> Roundtrip&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="round" value="0"> One Way <span class="buy-one">Buy One Get One Free</span></label>
              </div>
               <div class="form-group row1">
                    <label for="inputEmail3" class="col-sm-3 control-label">Leaving from:</label>
                    <label for="inputEmail3" class="col-sm-3 control-label">Going to:</label>
                    <div class="col-sm-4 adults col-sm-offset-2">
                        <label for="inputEmail3" class="col-sm-6 control-label">Adults:</label>
                        <label for="inputEmail3" class="col-sm-6 control-label">Seniors:</label>
                    </div>
              </div>

              <div class="form-group row2">
                    <!--
                    <div class="col-sm-3">
                        <input type="text" id="leaving" name="leaving" class="form-control form-control-bus input-sm" placeholder="">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" id="goingto" name="goingto" class="form-control form-control-bus input-sm" placeholder="">
                    </div>
                    -->
                    <div class="col-sm-3 discount">
                         <select class="selectpicker" name="leaving" data-width="100%">
                            <?php
                            foreach($station as $key => $val){
                                echo "<option value=\"{$key}\">{$val}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-3 discount">
                         <select class="selectpicker" name="goingto" data-width="100%">
                            <?php
                            ksort($station);
                            foreach($station as $key => $val){
                                echo "<option value=\"{$key}\">{$val}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-4 adults  col-md-offset-2">
                        <div class="col-sm-6">
                        <select id="adults" name="adults" class="selectpicker"  data-width="100%">
                            <option value="0">0</option>
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        </div>

                        <div class="col-sm-6">
                        <select id="adults" name="seniors" class="selectpicker"  data-width="100%">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <label class="control-label">(62+)</label>
                        </div>
                    </div>
              </div>


               <div class="form-group row4">
                    <label for="inputEmail3" class="col-sm-3 control-label">Departing on:</label>
                    <label for="inputEmail3" class="col-sm-3 control-label">Time:</label>
                    <label for="inputEmail3" class="return-option col-sm-3 control-label">Return Date:</label>
                    <label for="inputEmail3" class="return-option col-sm-3 control-label">Return Time:</label>
              </div>

               <div class="form-group row5">
                    <div class="col-sm-3">
                   <div class="controls date form_datetime b_date" data-date="<?php echo date("m/d/Y");?>" data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                   <input size="16" type="text" name="departing_date" class="form-control form-control-bus date_input input-sm" value="<?php echo date("m/d/Y");?>" readonly>
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                    <input type="hidden" id="dtp_input1" value="" /><br/>
                    </div>
                    
                    <div class="col-sm-3 return-option">
                    <div class="controls date form_datetime b_time" data-date="05:00" data-date-format="HH:ii" data-link-field="dtp_input2">
                        <input size="16" type="text" value="Any" name="departing_time"  class="form-control form-control-bus date_input input-sm" readonly>
                        <span class="add-on"><i class="icon-th ti"></i></span>
                    </div>
                    <input type="hidden" id="dtp_input2" value="" /><br/>
                    </div>

                    <div class="col-sm-3 return-option">
                   <div class="controls date form_datetime b_date" data-date="<?php echo date("m/d/Y");?>" data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                   <input size="16" type="text" name="return_date" class="form-control form-control-bus date_input input-sm" value="<?php echo date("m/d/Y");?>" readonly>
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                    <input type="hidden" id="dtp_input3" value="" /><br/>
                    </div>
                    
                    <div class="col-sm-3">
                    <div class="controls date form_datetime b_time" data-date="05:00" data-date-format="HH:ii" data-link-field="dtp_input2">
                        <input size="16" type="text" value="Any" name="return_time"  class="form-control form-control-bus date_input input-sm" readonly>
                        <span class="add-on"><i class="icon-th ti"></i></span>
                    </div>
                    <input type="hidden" id="dtp_input4" value="" /><br/>
                    </div>

<!--
                    <div class="col-sm-4 adults col-sm-offset-2">
                        <div class="col-sm-6">
                        <select id="adults" name="children" class="selectpicker"  data-width="100%">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <label class="control-label">(2-11)</label>
                        </div>
                    </div>
-->
              </div>

            <!--return option-->
<!--
            <div class="form-group row" id="return-title">
                    <label for="inputEmail3" class="col-sm-3 control-label">Departing on:</label>
                    <label for="inputEmail3" class="col-sm-3 control-label">Time:</label>
                    <div class="col-sm-4 adults col-sm-offset-2">
                    </div>
              </div>
            <div class="form-group row5" id="return-input">
                    <div class="col-sm-3">
                   <div class="controls date form_datetime b_date" data-date="<?php echo date("m/d/Y");?>" data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                   <input size="16" type="text" name="return_date" class="form-control form-control-bus date_input input-sm" value="<?php echo date("m/d/Y");?>" readonly>
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                    <input type="hidden" id="dtp_input3" value="" /><br/>
                    </div>
                    
                    <div class="col-sm-3">
                    <div class="controls date form_datetime b_time" data-date="05:00" data-date-format="HH:ii" data-link-field="dtp_input2">
                        <input size="16" type="text" value="Any" name="return_time"  class="form-control form-control-bus date_input input-sm" readonly>
                        <span class="add-on"><i class="icon-th ti"></i></span>
                    </div>
                    <input type="hidden" id="dtp_input4" value="" /><br/>
                    </div>
                    <div class="col-sm-4 adults col-sm-offset-2">
                    </div>
              </div>
-->
            
                <div class="form-group row6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Discount Type:</label>
                    
                    <label for="inputEmail3" class="col-sm-3 control-label">Promotion code:</label>
              </div>

                <div class="form-group row7 discount">
                    <div class="col-sm-3">
                        
                        <select class="selectpicker" name="discount" data-width="100%">
                            <option value="0">No Discounts</option>
                            <option value="1">Military Roundtrip Discount</option>
                            <option value="2">Companion Fare</option>
                            <option value="3">Student Advantage</option>
                            <option value="4">Veterans Advantage</option>
                        </select>

                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-bus input-sm" placeholder="">
                    </div>
                    <div class="col-sm-4 col-sm-offset-2">
                        <button type="submit" class="btn btn-success btn-sm btn-schedule">SEARCH SCHEDULES</button>
                    </div>
              </div>

            </form>
<br>
        </div>

        <div class="col-md-4 detail_info col-md-offset-1">
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
