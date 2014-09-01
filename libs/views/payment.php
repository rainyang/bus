<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AKAI Bus Tickets - schedule</title>
    <link href="/static/css/bus.css" rel="stylesheet">
    <link href="/static/css/bootstrap.css" rel="stylesheet">
    <link href="/static/css/bootstrap-select.css" rel="stylesheet">
    <link href="/static/css/datetimepicker.css" rel="stylesheet" media="screen">
    <link href="/static/css/bootstrap-formhelpers.min.css" rel="stylesheet">
</head>
<body>

<?php include "userinfo.php" ?>


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
                    <label data-toggle="collapse" data-target="#ticket-info">Important! Please read:</label>
                </div>
                <div class="noprint dashed-line"></div>
                <div class="noprint ticket-info panel-collapse collapse in"  id="ticket-info">
                </div>

                <!--startprint-->
                <div class="payment">
                <?php echo $html;?>
                </div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">help</h4>
      </div>
      <div class="modal-body">
<h2 style="margin-left: 6px;">American Express</h2>
	<img src="/static/images/cvv_amex.gif" border="0" alt="Amex CVV example">
	
	<br><br>
	<h2 style="margin-left: 6px;">VISA, MasterCard, Discover</h2>
	<img src="/static/images/cvv_cardback.gif" border="0" alt="VISA/MC CVV example">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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
<script type="text/javascript" src="/static/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<script src="/static/js/bootstrap-formhelpers.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('#billing').click(function(){
        if($('#billing').is(":checked") == true){
            $(':input[name="x_address"]').val('<?php echo $user['address'];?>');
            $(':input[name="x_address2"]').val('<?php echo $user['address2'];?>');
            $(':input[name="x_city"]').val('<?php echo $user['city'];?>');
            $('#state').val('<?php echo $user['state'];?>');
            //alert($('#state').attr('data-state'));
            $(':input[name="x_zip"]').val('<?php echo $user['zipcode'];?>');
            $(':input[name="x_country"]').val('<?php echo $user['country'];?>');
            $('select.bfh-states, span.bfh-states, div.bfh-states').bfhstates({'country':'<?php echo $user['country'];?>','state':'<?php echo $user['state'];?>', 'ischange': 'true'});
        }
        else{
            $(':input[name="x_address"]').val('');
            $(':input[name="x_address2"]').val('');
            $(':input[name="x_city"]').val('');
            //alert($('#state').attr('data-state'));
            $(':input[name="x_zip"]').val('');
            $(':input[name="x_country"]').val('US');
            $('select.bfh-states, span.bfh-states, div.bfh-states').bfhstates({'country':'US','state':'', 'ischange': 'true'});
        
        }
    
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
    $('.required').focus(function(){
        $(this).popover({placement: 'right',trigger: 'focus',container:'body'});
        $(this).popover('show');
    });
    $('.required').blur(function(){
        $(this).popover('hide');
    });
    $('#btn-pay').click(function(){
        var issubmit = 1;
        var reg = new RegExp("^[0-9]*$");
        $('.required').each(function(){
            if($(this).val()=='' && $(this).attr('name') != 'x_address2'){
                issubmit = 0;
                //alert('Please enter '+ $(this).attr('title'));
                $(this).focus().select();
                return false;
            }
            else{
                if($(this).attr('data-type') == 'number'){
                    if(!reg.test($(this).val())){
                        issubmit = 0;
                        //alert('Please enter a number!');   
                        $(this).focus().select();
                        return false;
                    }
                }
            }
        })

        if(issubmit == 1){
            //地址合并
            var $address = $(':input[name="x_address"]');
            var $address2 = $(':input[name="x_address2"]');
            if($address2.val() != '')
                $address.val($address.val() + ' ' + $address2.val());
            var exp_m = $(':input[name="exp_m"]').val();
            var exp_y = $(':input[name="exp_y"]').val();
            var exp = exp_m + '/' + exp_y;
            $(':input[name="x_exp_date"]').val(String(exp));
            $('form').submit();
        }
    });
});
    </script>
</html>
