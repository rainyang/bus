<?php include "header.php" ?>
    <link href="/static/css/datetimepicker.css" rel="stylesheet" media="screen">
<style>
.block-heading1{
background: #dddddd;
background: -webkit-gradient(linear, left bottom, left top, color-stop(0, #dddddd), color-stop(1, #fdfdfd));
background: -ms-linear-gradient(bottom, #dddddd, #fdfdfd);
background: -moz-linear-gradient(center bottom, #dddddd 0%, #fdfdfd 100%);
background: -o-linear-gradient(bottom, #dddddd, #fdfdfd);
filter: progid:dximagetransform.microsoft.gradient(startColorStr='#4d5b76', EndColorStr='#6c7a95');
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorStr='#fdfdfd',EndColorStr='#dddddd')";
color: #505050;
display: block;
padding-left: 1em;
border-top: 1px solid #fff;
outline: none;
margin-bottom: 0px;
text-shadow: none;
text-transform: none;
font-weight: bold;
font-size: .85em;
line-height: 3em;
border-bottom: 1px solid #a6a6a6;
border-left: none;
}
</style>
    <div class="sidebar-nav">
        <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i><?php echo lang('dashboard');?></a>
        <ul id="dashboard-menu" class="nav nav-list collapse in">
            <li><a href="/manage/main"><?php echo lang('home');?></a></li>
            <li><a href="/manage/lines"><?php echo lang('line_list');?></a></li>
            <li ><a href="/manage/stat"><?php echo lang('order_statistics');?></a></li>
            <li ><a href="/manage/is_stop_website"><?php echo lang('is_stop_website');?></a></li>
            <li ><a href="/manage/ticket_stat">Ticket statistics</a></li>
            
        </ul>

        <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase"></i><?php echo lang('customers');?></a>
        <ul id="accounts-menu" class="nav nav-list collapse">
            <li ><a href="/manage/signup">Sign Up</a></li>
        </ul>
        <a href="/manage/user" class="nav-header" ><i class="icon-question-sign"></i><?php echo lang('admin_user');?></a>
    </div>
    

    
    <div class="content">
        
        <div class="header">
<!--
            <div class="stats">
    <p class="stat"><span class="number">53</span>tickets</p>
    <p class="stat"><span class="number">27</span>tasks</p>
    <p class="stat"><span class="number">15</span>waiting</p>
</div>
-->

            <h1 class="page-title"><?php echo lang('dashboard');?></h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="/manage/main"><?php echo lang('home');?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo lang('dashboard');?></li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    

<div class="row-fluid">


    <div class="block">
        <div class="block-heading1">
            <div style="float:left">
            	<span>Today <?php echo lang('latest_stats');?></span>
            	<span style="margin-left:20px;" class="btn Today btn-mini"><a href="/manage/main/1" data-day="Today" class="today">Today</a></span>
            	<span style="margin-left:10px;" class="btn Week btn-mini"><a href="/manage/main/2" data-day="Week" class="week">Week</a></span>
                <span style="margin-left:10px;" class="btn Month btn-mini"><a href="/manage/main/3" data-day="Month" class="month">Month</a></span>
            </div>
            <div style="float:left; width:140px;" class="controls date form_datetime b_date" data-date="<?php echo date("Y-m-d");?>" data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                   <input size="16" type="text" name="date1" id="date1" style="width:100px; margin-left:15px;" class="form-control1 form-control-bus date_input input-sm" value="<?php echo date("Y-m-d", time()-60*60*24*7);?>" readonly>
                        <span class="add-on" style="margin-left:-25px;color:#3BB3CA;height:30px;"><i class="icon-th" style="font-size:18px;"></i></span>
                    <input type="hidden" id="dtp_input1" value="" />
            </div>
            <div style="float:left;margin-left:10px;">To</div> 
            <div class="controls date form_datetime b_date" style="float:left;width:140px" data-date="<?php echo date("Y-m-d");?>" data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                   <input size="16" type="text" name="date2" id="date2" style="width:100px; margin-left:15px;" class="form-control1 form-control-bus date_input input-sm" value="<?php echo date("Y-m-d");?>" readonly>
                        <span class="add-on" style="margin-left:-25px;color:#3BB3CA;height:30px;"><i class="icon-th" style="font-size:18px;"></i></span>
                    <input type="hidden" id="dtp_input1" value="" />
            </div>
            <div style="float:left;margin-left:5px;margin-top:3px;">
            <select id="line" style="width:150px; margin-right:5px;">
            <option value='0' <?php echo ($line_id == 0) ? " selected" : ""; ?>>line</option>
            <?php
            foreach($lines as $val){
                $selected = ($line_id == $val['id']) ? "selected" : "";
                echo "<option value='{$val['id']}' {$selected}>{$val['name']}</option>";
            }
            ?>
            </select>
            </div> 
            <div><button class="btn-default" id="search">Search</button></div> 
        </div>

        <div id="page-stats" class="block-body collapse in" style="clear:both">

            <div class="stat-widget-container">
                <!--
                <div class="stat-widget">
                    <div class="stat-button">
                    <p class="title">Options</p>
                        <p class="detail">Day, Week, Month</p>
                    </div>
                </div>
                -->

                <div class="stat-widget">
                    <div class="stat-button">
                    <p class="title" id="Customers"><?php echo $customer;?></p>
                        <p class="detail">Customers</p>
                    </div>
                </div>

                <div class="stat-widget">
                    <div class="stat-button">
                        <p class="title" id="Orders"><?php echo count($orders);?></p>
                        <p class="detail">Orders</p>
                    </div>
                </div>

                <div class="stat-widget">
                    <div class="stat-button">
                        <p class="title" id="Total">$<?php echo $total_income;?></p>
                        <p class="detail">Total Income</p>
                    </div>
                </div>

                <div class="stat-widget">
                    <div class="stat-button">
                    <p class="title" id="notpaying">$<?php echo $not_pay;?></p>
                        <p class="detail">Not paying</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    
    <div class="block span12">
        <div class="block-heading">
            <span class="block-icon pull-right">
                <a href="#" class="demo-cancel-click" rel="tooltip" title="Click to refresh"><i class="icon-refresh"></i></a>
            </span>

            <a href="#widget2container" data-toggle="collapse"><?php echo lang('orders');?></a>
        </div>
        <div id="widget2container" class="block-body collapse in">
            <table class="table list">
                <thead>
                <tr>
                  <th>name</th>
                  <th>Confirmation Number</th>
                  <th>Depart</th>
                  <th>Depart Date</th>
                  <th>Going to</th>
                  <th>Return Date</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach($orders as $key => $val){
                    if($key >= 7)
                        break;
                    echo "<tr><td><i class=\"icon-user\">{$customers[$val['customer_id']]['first-name']} - {$customers[$val['customer_id']]['last-name']}</td><td>{$val['o_number']}</td><td>{$station[$val['from_station_id']]}</td><td>{$val['departing_date']} - {$val['departing_time']}</td><td>{$station[$val['to_station_id']]}</td><td>{$val['return_date']} - {$val['return_time']}</td><td><p>{$val['is_pay']}</p><a>View Transaction</a></td></tr>";
                }
                ?>

              </tbody>
            </table>
        </div>
    </div>

<!--
    <div class="block span6">
        <a href="#tablewidget" class="block-heading" data-toggle="collapse"><?php echo lang('customers');?><span class="label label-warning">+10</span></a>
        <div id="tablewidget" class="block-body collapse in">
            <table class="table">
              <thead>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;
                foreach($customers as $key => $val){
                    if($i >= 10)
                        break;
                    echo "<tr><td>{$val['first-name']}</td><td>{$val['last-name']}</td><td>{$val['email']}</td></tr>";
                    $i ++;
                }
                ?>
              </tbody>
            </table>
            <p><a href="users.html">More...</a></p>
        </div>
    </div>
-->
</div>


<?php include "footer.php" ?>
                    
                    
            </div>
        </div>
    </div>
    


    <script src="/static/lib/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="/static/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
            $('.b_date').datetimepicker({
                //language:  'fr',
                format: 'yyyy-mm-dd',
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                showMeridian: 1,
                minView: 2,
            });
            /*
            $('.total').click(function(){
				var day = $(this).attr('data-day');
                $.post("/manage/ajax_total",{op:"total",day:day},function(backData){
                	eval("var data=" + backData + "");
                	if(data.code == "A00006"){
						$("#Accounts").html(data.customers_num);
						$("#Orders").html(data.orders_num);
						$("#Total").html(data.total_price);
                    }
                    	$(".btn-mini").removeClass("btn-info");
                    	$("."+day).addClass("btn-info");
                });
            });
             */
            $('#line').change(function(){
                window.location.href = '/<?php echo uri_string();?>' + '?line=' + $(this).val();
            })
            $('#search').click(function(){
                window.location.href = '/manage/main/4/'+$('#date1').val() + '/' + $('#date2').val();
            });
        });
    </script>
    
  </body>
</html>


