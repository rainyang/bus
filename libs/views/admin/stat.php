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
            <li class="active"><a href="/manage/stat"><?php echo lang('order_statistics');?></a></li>
            <li><a href="/manage/Report">Report</a></li>
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
            
            <h1 class="page-title"><?php echo lang('order_statistics');?></h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="/manage/main"><?php echo lang('home');?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo lang('order_statistics');?></li>
        </ul>

        <div class="container-fluid">



<div class="row-fluid">


<div class="row-fluid">
<div class="block" style="margin:0;border-bottom:0px;">
    <form action="/manage/stat" method="get">
        <div class="block-heading1">
            <div style="float:left">
                <span>
                <select name="from_station_id" style="width:80px;">
                    <option value="0">Depart</option>
                    <?php
                    foreach($stations as $key => $val){
                        echo '<option value="'.$key.'">'.$val.'</option>';
                    }
                    ?>
                </select>
                </span>
            </div>
            <div style="float:left; width:140px;" class="controls date form_datetime b_date" data-date="<?php echo date("Y-m-d");?>" data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                   <input size="16" type="text" name="departing_date" id="date1" style="width:100px; margin-left:15px;" class="form-control1 form-control-bus date_input input-sm" value="" placeholder="depart date" readonly>
                        <span class="add-on" style="margin-left:-25px;color:#3BB3CA;height:30px;"><i class="icon-th" style="font-size:18px;"></i></span>
                    <input type="hidden" id="dtp_input1" value="" />
            </div>
            <div style="float:left;margin-left:4px;"><span>
                <select name="to_station_id" style="width:93px;">
                    <option value="0">Going To</option>
                    <?php
                    foreach($stations as $key => $val){
                        echo '<option value="'.$key.'">'.$val.'</option>';
                    }
                    ?>
                </select>
                </span>
            </div> 
            <div class="controls date form_datetime b_date" style="float:left;width:140px" data-date="<?php echo date("Y-m-d");?>" data-date-format="dd MM yyyy" data-link-field="dtp_input1">
                   <input size="16" type="text" name="return_date" id="date2" style="width:100px; margin-left:15px;" class="form-control1 form-control-bus date_input input-sm" value="" placeholder="return date"  readonly>
                        <span class="add-on" style="margin-left:-25px;color:#3BB3CA;height:30px;"><i class="icon-th" style="font-size:18px;"></i></span>
                    <input type="hidden" id="dtp_input1" value="" />
            </div>
            <div style="float:left;margin-left:4px;"><span>
                <select name="is_pay" style="width:90px;">
                    <option value="all">status</option>
                        <option value=0>not pay</option>
                        <option value=1>Payment has been</option>
                </select>
                </span>
            </div> 
            <div style="float:left;margin-left:5px;margin-top:3px;">
                <span><input type="text" name="first-name" placeholder="first-name" class="input-mini" /> <input type="text" placeholder="last-name" class="input-mini" name="last-name" /> <input type="text" placeholder="Confirmation Number" style="width:150px;" name="o_number" /> </span>
            </div> 
            <div>
                <input type="radio" name="date" id="date" value='month'>Month
                <input type="radio" name="date" id="date" value='lmonth'>Last month
                <button class="btn-default" type="submit" style="margin-left:5px;" id="search">Search</button></div> 
        </div>
    </form>
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
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach($orders as $key => $val){
                    echo "<tr><td><i class=\"icon-user\">{$customers[$val['customer_id']]['first-name']} - {$customers[$val['customer_id']]['last-name']}</td><td>{$val['o_number']}</td><td>{$val['quantity']}</td><td>{$station[$val['from_station_id']]}</td><td>{$val['departing_date']} - {$val['departing_time']}</td><td>{$station[$val['to_station_id']]}</td><td>{$val['return_date']} - {$val['return_time']}</td><td><p>{$pay_status[$val['is_pay']]}</p><a href=\"javascript:void(0)\"  class=\"btn btn-primary btn-lg view-transaction\" data-id=\"{$val['id']}\">View Transaction</a> <a href=\"javascript:void(0)\" class=\"btn btn-sm re-send\" data-id=\"{$val['transaction_id']}\">re-send email</a> <a href=\"javascript:void(0)\" class=\"btn btn-sm re-print\" target=\"_blank\" data-id=\"{$val['transaction_id']}\">re-print</a></td></tr>";
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
            $(".re-send").click(function(){
                var tid = $(this).attr("data-id");
                    $(".mail-text").html("Sending...");
                $("#ReSendModal").modal("show");
                $.get("/search/complete?response_code=1&transaction_id="+tid+"&resend=1", function(data){
                    $(".mail-text").html(data);
                });
            })

            $(".re-print").click(function(){
                var tid = $(this).attr("data-id");
                window.open('/search/complete?x_response_reason_code=1&response_code=1&transaction_id='+tid+'&reprint=1', '_blank');
            })

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

        });
        $('#line').change(function(){
                window.location.href = '/<?php echo uri_string();?>' + '?line=' + $(this).val();
            })
    </script>
    
  </body>
</html>


