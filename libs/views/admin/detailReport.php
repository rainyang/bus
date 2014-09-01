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
#TranModal{ width:660px !important;}
</style>
    <div class="sidebar-nav">
        <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i><?php echo lang('dashboard');?></a>
        <ul id="dashboard-menu" class="nav nav-list collapse in">
            <li><a href="/manage/main"><?php echo lang('home');?></a></li>
            <li><a href="/manage/lines"><?php echo lang('line_list');?></a></li>
            <li><a href="/manage/stat"><?php echo lang('order_statistics');?></a></li>
            <li class="active"><a href="/manage/Report">Report</a></li>
            <li ><a href="/manage/is_stop_website"><?php echo lang('is_stop_website');?></a></li>
            <li ><a href="/manage/config">site config</a></li>
        </ul>


        <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase"></i><?php echo lang('customers');?></a>
        <ul id="accounts-menu" class="nav nav-list collapse">
            <li ><a href="/manage/signup">Sign Up</a></li>
        </ul>

        <a href="/manage/user" class="nav-header" ><i class="icon-question-sign"></i><?php echo lang('admin_user');?></a>

    </div>
    

    
    <div class="content">
        
        <div class="header">
            
            <h1 class="page-title">Order Reports</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="/manage/main"><?php echo lang('home');?></a> <span class="divider">/</span></li>
            <li class="active">Order Reports</li>
        </ul>

        <div class="container-fluid">



<div class="row-fluid">


<div class="row-fluid">
<div class="block" style="margin:0;border-bottom:0px;">
    <form action="/manage/Report" method="get">
        <div class="block-heading1">
            <div style="float:left;margin-right:10px;">
                <span>
                <select name="line_id" id="line_id" style="width:80px;">
                    <option value="0">All lines</option>
                    <?php
                    foreach($lines as $key => $val){
                        $dline = ($param['line_id'] == $val['id']) ? "selected" : "";
                        echo '<option value="'.$val['id'].'" '.$dline.'>'.$val['name'].'</option>';
                    }
                    ?>
                </select>
                </span>
            </div>

            <div style="float:left">
                <span>
                <select name="from_station_id" id="from_station_id" style="width:80px;">
                    <option value="0">Depart</option>
                    <?php
                    foreach($stations as $key => $val){
                        $dfrom_station_id = ($param['from_station_id'] == $key) ? "selected" : "";
                        echo '<option value="'.$key.'" '.$dfrom_station_id.'>'.$val.'</option>';
                    }
                    ?>
                </select>
                </span>
            </div>
            <div style="float:left; width:140px;" class="controls date form_datetime b_date" data-date="<?php echo date("Y-m-d");?>" data-date-format="dd MM yyyy" data-link-field="dtp_input1">
            <input size="16" type="text" name="departing_date" id="date1" style="width:100px; margin-left:15px;" class="form-control1 form-control-bus date_input input-sm" value="" placeholder="<?php echo ($param['departing_date']) ? $param['departing_date'] :'depart date';?>" readonly>
                        <span class="add-on" style="margin-left:-25px;color:#3BB3CA;height:30px;"><i class="icon-th" style="font-size:18px;"></i></span>
                    <input type="hidden" id="dtp_input1" value="" />
            </div>
            <div style="float:left;margin-left:4px;"><span>
                <select name="to_station_id" id='to_station_id' style="width:93px;">
                    <option value="0">Going To</option>
                    <?php
                    foreach($stations as $key => $val){
                        $dto_station_id = ($param['to_station_id'] == $key) ? "selected" : "";
                        echo '<option value="'.$key.'" '.$dto_station_id.'>'.$val.'</option>';
                    }
                    ?>
                </select>
                </span>
            </div> 
            <div class="controls date form_datetime b_date" style="float:left;width:140px" data-date="<?php echo date("Y-m-d");?>" data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                   <input size="16" type="text" name="return_date" id="date2" style="width:100px; margin-left:15px;" class="form-control1 form-control-bus date_input input-sm" value="" placeholder="<?php echo ($param['return_date']) ? $param['return_date'] :'return_date';?>"  readonly>
                        <span class="add-on" style="margin-left:-25px;color:#3BB3CA;height:30px;"><i class="icon-th" style="font-size:18px;"></i></span>
                    <input type="hidden" id="dtp_input1" value="" />
            </div>

<!--
            <div style="float:left; width:140px;" class="controls date form_datetime b_date" data-date="<?php echo date("Y-m-d");?>" data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                   <input size="16" type="text" name="date_one" id="date3" style="width:100px; margin-left:15px;" class="form-control1 form-control-bus date_input input-sm" value="" placeholder="<?php echo ($param['date_one']) ? $param['date_one'] :'date one';?>" readonly>
                        <span class="add-on" style="margin-left:-25px;color:#3BB3CA;height:30px;"><i class="icon-th" style="font-size:18px;"></i></span>
                    <input type="hidden" id="dtp_input1" value="" />
            </div>

            <div style="float:left; width:140px;" class="controls date form_datetime b_date" data-date="<?php echo date("Y-m-d");?>" data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                   <input size="16" type="text" name="date_two" id="date4" style="width:100px; margin-left:15px;" class="form-control1 form-control-bus date_input input-sm" value="" placeholder="<?php echo ($param['date_two']) ? $param['date_two'] :'date two';?>" readonly>
                        <span class="add-on" style="margin-left:-25px;color:#3BB3CA;height:30px;"><i class="icon-th" style="font-size:18px;"></i></span>
                    <input type="hidden" id="dtp_input1" value="" />
            </div>-->

            <div>
                <input type="radio" name="date" id="date" value='month' <?php echo ($param['date'] == 'month') ? 'checked' :'';?>>Month
                <input type="radio" name="date" id="date" value='lmonth' <?php echo ($param['date'] == 'lmonth') ? 'checked' :'';?>>Last month
                <button class="btn-default" type="submit" style="margin-left:5px;" id="search">Search</button> 
                <button class="btn-default" type="reset" style="margin-left:5px;" id="reset">Reset</button> </div>
        </div>
    </form>
    
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
                        <p class="detail">statistical:</p>
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
                        <p class="title" id="Total">$<?php echo $total;?></p>
                        <p class="detail">Total revenue</p>
                    </div>
                </div>

                <div class="stat-widget">
                    <div class="stat-button">
                    <p class="title" id="notpaying">$<?php echo $commission;?></p>
                        <p class="detail">Commission</p>
                    </div>
                </div>

            </div>
        </div>

</div>



<div class="well">
            <form id="form" method="post">
    <table class="table list">
                <thead>
                <tr>
                  <th>name</th>
                  <th>Confirmation Number</th>
                  <th>quantity</th>
                  <th>Depart</th>
                  <th class="data-order" data-id="departing_date" data-order="desc"><a href="javascript:void(0)">Depart Date</a></th>
                  <th>Going to</th>
                  <th class="data-order" data-id="Return_Date" data-order="desc"><a href="javascript:void(0)">Return Date</a></th>
                  <th>Create Date</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach($orders as $key => $val){
                    echo "<tr><td><i class=\"icon-user\">{$customers[$val['customer_id']]['first-name']} - {$customers[$val['customer_id']]['last-name']}</td><td>{$val['o_number']}</td><td>{$val['quantity']}</td><td>{$station[$val['from_station_id']]}</td><td>{$val['departing_date']} - {$val['departing_time']}</td><td>{$station[$val['to_station_id']]}</td><td>{$val['return_date']} - {$val['return_time']}</td><td><p>{$val['line_id']}, {$val['pay_price']}</p><a href=\"javascript:void(0)\"  class=\"btn btn-primary btn-lg view-transaction\" data-id=\"{$val['id']}\">View Transaction</a></td></tr>";
                }
                ?>
                <input type=hidden name="order" id="order">
                <input type=hidden name="ordersc" id="ordersc" value="<?php echo $ordersc;?>">
              </tbody>
            </table>
            </form>
</div>
<div class="pagination">
    <ul>
        <?php echo $pagination;?>

    </ul>
</div>

<!-- Modal -->
<div class="modal fade" id="TranModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Order Info</h4>
      </div>
      <div class="modal-body" id="tran-info">
       Loading... 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Delete Confirmation</h3>
    </div>
    <div class="modal-body">
        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the line?</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-danger" data-dismiss="modal">Delete</button>
    </div>
</div>


<div class="modal small hide fade" id="ReSendModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">re-send email</h3>
    </div>
    <div class="modal-body">
        <p class="error-text mail-text">Sending...</p>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
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
            //排序
            $(".data-order").click(function(){
                var dataid = $(this).attr("data-id");
                var ordersc = $("#ordersc").val();
                ordersc = (ordersc == 'desc') ? "asc" : "desc";
                $("#order").val(dataid);
                $("#ordersc").val(ordersc);
                $("#form").submit();
            });

            //详情
            $(".view-transaction").click(function(){
                var dataid = $(this).attr("data-id");
                $.post("/manage/getTransaction",{dataid: dataid}, function(data){
                    $("#tran-info").html(data);
                });
                $("#TranModal").modal('show');
            });
            $('#reset').click(function(){
                $('#line_id').find("option:selected").removeAttr('selected');
                $('#to_station_id').find("option:selected").removeAttr('selected');
                $('#from_station_id').find("option:selected").removeAttr('selected');
                $('#date1').attr("placeholder", "Depart date");
                $('#date2').attr("placeholder", "return date");
                
            });

        });
        $('#line').change(function(){
                window.location.href = '/<?php echo uri_string();?>' + '?line=' + $(this).val();
            })
    </script>
    
  </body>
</html>


