<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
<head>
<title><?php echo $site['title'];?></title>
<meta name="description" content="<?php echo $site['title'];?>" />
<meta name="keywords" content="<?php echo $site['title'];?>" />

<link rel="stylesheet" type="text/css" href="/static/view/theme/default/stylesheet/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="/static/view/theme/default/stylesheet/stylex.css" />
<script type="text/javascript" src="/static/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/static/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="/static/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="/static/view/javascript/jquery/ui/external/jquery.cookie.js"></script>
<script type="text/javascript" src="/static/view/javascript/jquery/colorbox/jquery.colorbox.js"></script>
<link rel="stylesheet" type="text/css" href="/static/view/javascript/jquery/colorbox/colorbox.css" media="screen" />
<script type="text/javascript" src="/static/view/javascript/jquery/tabs.js"></script>
<script type="text/javascript" src="/static/view/javascript/common.js"></script>
<script type="text/javascript" src="/static/view/javascript/jquery/jquery.validate.js"></script>
<script type="text/javascript" src="/static/view/javascript/jquery/additional-methods.js"></script>
<link rel="stylesheet" type="text/css" href="/static/css/bus.css" media="screen" />
  <link rel="stylesheet" href="/static/css/font-awesome.min.css">

<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="/static/view/theme/default/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="/static/view/theme/default/stylesheet/ie6.css" />
<script type="text/javascript" src="/static/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
</head>
<body>

<?php include "userinfo.php" ?>

<!--
<div id="stop_site">
    <div id="stop_info"><div class="stop_info_content">网站建设中，请稍后访问</div></div>
</div>
-->
<div id="notification"></div>



<div class="header_shadow_bg">
<div class="header_shadow_bg2">

    <div class="shadow_text">
    	<!--<img src="/static/images/slectroute.png" width="800" height="109" />-->
        <div class="shadow_bg">
        <div id="slides">
            <!--<img src="/static/images/busm1.png">
            <img src="/static/images/busm.png">-->
            <?php
                foreach($site['images'] as $img){
                    echo '<img src="'.$img.'">';  
                }
            ?>
        </div>
        </div>
    </div>
    
    <h2 style="text-align:center;color:#fff"><?php echo $site['notice'];?></h2>
     
    <div class="search_site">
    	<div id="demoTab1_" class="demoTabTitle">
         <ul>
             <input type="hidden" name ="trip_type" id ="trip_type" value ="1" /><li id="demoTab1_1" class="NewTab001" model ="1" >Round Trip</li><li id="demoTab1_2" class="NewTab002" model ="0" >One Way</li>         </ul>
        </div>
        
        <div class="demoTabcct">
          <div class="dis" id="demoTable1_1">
            <div class="tabcontainer">
               <ul class="optionlist">
               	  <li><span>Leaving From</span><input type="text" class="optioninput" name="depart_city" id="depart_city" readonly="readonly" /><a class="option_img" id="depart_city_list_open"><img src="/static/images/arrow_down.png" width="45" height="42"  /></a>
                    <input type="hidden" value="" name="leaving">
                  <div class="option_tangchu_depart" id="depart_city_list" style="display:none" >
                  	 <div class="option_close"><a id="depart_city_list_close" ><img src="/static/images/btn_close.png" alt="close" title="close"  /></a></div>
                   <?php
                            foreach($station as $key => $val){
                            ?>
                     <div class="option_citylist">
                     	<ul>
                        <li class="option_city" leaving="<?php echo $key;?>" city="<?php echo $val;?>"><a><?php echo $val;?></a></li> 
                        </ul>
                      </div>
                    <?php }?>
                    </div>
                  </li>
                  <li><span>Going To</span><input type="text" class="optioninput"  name="return_city" id="return_city"  readonly="readonly" /><a class="option_img" id="return_city_list_open" ><img src="/static/images/arrow_down.png" width="45" height="42"   /></a></li>
                  
                  <div class="option_tangchu_return" id="return_city_list" style="display:none"  >
                  	 <div class="option_close"><a id="return_city_list_close" ><img src="/static/images/btn_close.png" alt="close" title="close"  /></a></div>
                     
				    <div id="return_list_view"> 
                     <div class="option_citylist" state="Georgia">
                     	<ul>
                             <li class="option_city" city="" state=""><a  >Please select a leving from</a></li> 
                        </ul>
                      </div>
<!--
                     <div class="option_citylist" state="Georgia">
                     	<ul>
                             <li class="option_city" city="Chamblee, GA" state="Georgia"><a  >Chamblee, GA</a></li> 
                        </ul>
                      </div>
                     
                     <div class="option_citylist" state="South Carolina">
                     	<ul>
                             <li class="option_city" city="Anderson, SC" state="South Carolina"><a  >Anderson, SC</a></li> 
                        </ul>
                      </div>
-->
                     </div>
                     </div>
                  </li>
                  
                  <li id="li_depart_container" ><span>Departing Date</span><input class="optioninput_date"  type="text" id="depart_date" name="depart_date" /></li>
                  <li id="li_return_container" ><span id="text_return_date">Returning Date</span><input class="optioninput_date"  type="text" id="return_date" name="return_date" /></li>
                  <li class="optionlistnumber"><span>Number of Traveler(s)</span><input type="text" name="quantity" id="quantity" readonly="readonly" class="optioninput_number" value="1" /><a id="quantity_open" class="option_img" onFocus= "this.blur()"><img src="/static/images/arrow_down.png" width="45" height="42"   /></a>
                  	<div class="option_tangchu option_tangchu_number" id="quantity_list" style="display:none">
                    	<ul class="option_numberlist">
		               		<li quantity='1'><a>1</a></li><li quantity='2'><a>2</a></li><li quantity='3'><a>3</a></li><li quantity='4'><a>4</a></li><li quantity='5'><a>5</a></li><li quantity='6'><a>6</a></li><li quantity='7'><a>7</a></li><li quantity='8'><a>8</a></li><li quantity='9'><a>9</a></li><li quantity='10'><a>10</a></li>                        </ul>
                    </div>
                  </li>
                  <li class="option_btn"><a onclick="routeSubmit();"><img id="img_order_submit" src="/static/images/btn_order_now.png" width="245" height="49"  /></a></li>
                  <li id="stop_info">site building ...</li>
               </ul>
               <br clear="left" />
            </div>
          </div>
        </div>
    </div>    
    
    <br />

</div>
</div>
     

<div class="footer_1">
<div class="footer_2">

<div id="footer">
    <div class="column">
      </div>
    <div class="column">
<img src="/static/images/logo_footer.png">
  </div>
  <div class="column">
  </div>
  <div class="column">
   <h3>Contact Us</h3>
    <ul>
            <li>COMPANY:AKAI LLC</li>
            <li>ADDRESS:<?php echo $site['address1'];?>,
            <?php echo $site['address2'];?>,<?php echo $site['address3'];?>
            </li>
            <li>TEL:<?php echo $site['tel'];?></li>
            <li>EMAIL:<?php echo $site['email'][0];?></li>
            <?php
                array_shift($site['email']);
                foreach($site['email'] as $mail){
                    echo '<li style="padding-left:38px;">'.$mail.'</li>';  
                }
            ?>
          </ul>

  </div>
</div>

    <div class="copyright">
    	<div class="copyright_width">
    	<div class="copyright_text">
            Copyright&copy; 2014 <a href="http://www.AKAI.com">AKAI.com</a>. All rights reserved 
        </div>
        <div class="copyright_card">
            <a href="#"><img src="/static/images/visa.png" width="42" height="25" /></a>
            <a href="#"><img src="/static/images/mastercard.png" width="42" height="25" /></a>
            <a href="#"><img src="/static/images/discover.png" width="42" height="25" /></a>
        </div>
        <br clear="left" />
        </div>
    </div>
    
</div></div>
</body></html>
  <script src="/static/js/jquery.slides.min.js"></script>

<script type="text/javascript">

function routeSubmit(){

    /*
	alert('trip type:' + $('#trip_type').val() + '\n' + 
		  'depart city: ' + $('#depart_city').val() + '\n' +
		  'return city: ' + $('#return_city').val() + '\n' +
		  'depart date: ' + $('#depart_date').val() + '\n' + 
		  'return date: ' + $('#return_date').val() + '\n' +
		  'quantity: ' + $('#quantity').val()
	      );
     */
<?php
    if($is_stop){
?>
return false;
<?php
    }
?>

    if($('#depart_city').val() == '' || 
    	($('#return_city').val() == '' && $('#trip_type').val()== '1' ) ||
        $('#depart_date').val() == '' || 
	    ($('#return_date').val() == '' && $('#trip_type').val()== '1' ) ||
    	 $('#quantity').val() == '') {
			alert("Please complete all required fields and try again.");
    	 } else {
			 window.location = '/search/tlist?trip_type=' + $('#trip_type').val() +
	 										 '&depart_city=' + $('#depart_city').val() +
	 										 '&depart_date=' + $('#depart_date').val() +
	 										 '&return_city=' + $('#return_city').val() +
	 										 '&return_date=' + $('#return_date').val() +
	 										 '&quantity=' + $('#quantity').val();
    	 }
	
}

$(document).ready(function(){
    $('#slides').slidesjs({
        width: 940,
        height: 410,
        play: {
          active: true,
          auto: true,
          interval: 4000,
          swap: true
        }
      });

<?php
    if($is_stop){
?>
$('#img_order_submit').attr('src', '/static/images/btn_order_now_ disallowed.png');
$('#stop_info').addClass('stop_info');
$('#stop_info').html('<?php echo $stop_info;?>');
<?php
    }
    else{
        echo "$('#stop_info').addClass('stop_info_none');";
    }
?>
	
	$('#quantity').focus(function() {
		$('#quantity_list').show();
	});

	$('#quantity_open').click(function() {
		if($('#quantity_list').is(':visible')) {
			$('#quantity_list').hide();
		} else {
			$('#quantity_list').show();
		}
	});	

	$('#quantity').change(function() {
		$('#quantity_list').hide();
	});

	$('#quantity_list li').click(function(){
		$('#quantity').val($(this).attr('quantity'));
		$('#quantity_list').hide();
	});
	

	$('#depart_city').focus(function() {
		$('#depart_city_list').show();
		$('#return_city_list').hide();
	});

	$('#depart_city_list_open').click(function() {
		$('#depart_city_list').show();
		$('#return_city_list').hide();
	});	

	
	$('#depart_city_list_close').click(function() {
		$('#depart_city_list').hide();
	});


	
	$('#return_city').focus(function() {
		$('#return_city_list').show();
		$('#depart_city_list').hide();
	});

	$('#return_city_list_open').click(function() {
		$('#return_city_list').show();
		$('#depart_city_list').hide();
	});	
	
	$('#return_city_list_close').click(function() {
		$('#return_city_list').hide();
	});	

	$('#depart_city_list li').click(function(){
        var depart_city = $(this).attr('city');
		$('#depart_city').val($(this).attr('city'));
		$('#leaving').val($(this).attr('leaving'));
		$('#depart_city_list').hide();
        
        $.post('/welcome/get_going_station_by_name', {name:depart_city, trip_type: $("#trip_type").val()}, function(data){
		    $('#return_city').val('');
            $('#return_list_view').empty();
            $('#return_list_view').append(data);
            $('#return_city_list li').click(function(){
                $('#return_city').val($(this).attr('city'));
                $('#return_city_list').hide(); 
            });	
        });
        //

		$("#return_city_list").show();

	});	

	$('#return_city_list li').click(function(){
		$('#return_city').val($(this).attr('city'));
		$('#return_city_list').hide(); 
	});			

	$('#demoTab1_1').click(function(){
		$('#demoTab1_1').attr('class', 'NewTab001');
		$('#demoTab1_2').attr('class', 'NewTab002');
		$('#return_date').removeAttr("disabled"); 
		
		$('#return_date').removeClass('optioninput_date_disabled');
		$('#return_date').addClass('optioninput_date');
		$('#li_return_container img.ui-datepicker-trigger').attr('src', '/static/images/icon_data_blue.png');
		
		
		$('#text_return_date').css("text-decoration", "none");
		$('#text_return_date').css("color", "#99dbff");
		$('#trip_type').val($(this).attr('model'));
	});
	
	$('#demoTab1_2').click(function(){
		$('#demoTab1_1').attr('class', 'NewTab002');
		$('#demoTab1_2').attr('class', 'NewTab001');
		$('#return_date').attr("disabled", "disabled");
		
		$('#return_date').removeClass('optioninput_date');
		$('#return_date').addClass('optioninput_date_disabled');
		$('#li_return_container img.ui-datepicker-trigger').attr('src', '/static/images/icon_data_blue-grey.png');

		$('#return_date').val(''); 
		$('#text_return_date').css("text-decoration", "line-through");
		$('#text_return_date').css("color", "#c6c6c6"); 
		
		trip_type = $(this).attr('model');
		$('#trip_type').val($(this).attr('model'));
	});	

    $('#depart_date, #return_date').datepicker({
        showOn: 'both',
        buttonImage: '/static/images/icon_data_blue.png',
        buttonImageOnly: true,
        beforeShow: customRange,
        buttonText: 'Open Calendar',
        firstDay: 1,
        dateFormat: 'yy-mm-dd',
        onSelect: function(date) {
            date = $(this).datepicker('getDate');
            if($(this).attr("id") != 'return_date'){
                var returnDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 1);
                //$('#return_date').val($.datepicker.formatDate('yy-mm-dd', returnDate));
                $('#return_date').val();
            }
        }
    });
    
    $(".ui-datepicker-trigger").attr("align", "absmiddle");	
    $(".ui-datepicker-trigger").css("margin-bottom", "7px");	

});

function customRange(a) {
    var returnDateMin;
    var b = new Date();
    var c = new Date(b.getFullYear(), b.getMonth(), b.getDate());
    if (a.id == 'return_date') 
    {
        if ($('#depart_date').datepicker('getDate') != null) {
            c = $('#depart_date').datepicker('getDate');
        }
        returnDateMin = new Date(c.getFullYear(), c.getMonth(), c.getDate() + 1);
    }
    else
    {
        returnDateMin = c;
    }
    return {
        minDate: returnDateMin
    }
}

</script>

