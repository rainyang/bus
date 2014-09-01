<?php include "header.php" ?>
<style>
.modal-body li {list-style:none}
.modal-body li input{width:300px;}
.modal-body li span{width:100px;display:block;float:left;}
</style>
   <div class="sidebar-nav">
        <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i><?php echo lang('dashboard');?></a>
        <ul id="dashboard-menu" class="nav nav-list collapse in">
            <li><a href="/manage/main"><?php echo lang('home');?></a></li>
            <li class="active"><a href="/manage/lines"><?php echo lang('line_list');?></a></li>
            <li ><a href="/manage/stat"><?php echo lang('order_statistics');?></a></li>
            
        </ul>

        <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase"></i><?php echo lang('customers');?></a>
        <ul id="accounts-menu" class="nav nav-list collapse">
            <li ><a href="/manage/signup">Sign Up</a></li>
        </ul>


    </div>
 
    
    <div class="content">
        
        <div class="header">
            
        <h1 class="page-title"><?php echo lang('route_title');?> - <?php echo $station['name'];?></h1>
        </div>
        
            <ul class="breadcrumb">
                <li><a href="/manage/main"><?php echo lang('home');?></a> <span class="divider">/</span></li>
                <li><a href="/manage/lines"><?php echo lang('lines');?></a> <span class="divider">/</span></li>
                <li><a href="/manage/add_station/<?php echo $lid;?>"><?php echo lang('station');?></a> <span class="divider">/</span></li>
                <li class="active"><?php echo lang('route_name');?></li>
            </ul>

        <div class="container-fluid">
            <div class="row-fluid">

<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th><?php echo lang('route_name');?></th>
          <th><?php echo lang('order');?></th>
          <th><?php echo lang('departing_time');?></th>
          <th><?php echo lang('return_time');?></th>
          <th style="width: 46px;"></th>
        </tr>
      </thead>
      <tbody>
<?php
foreach($routes as $key => $val){
?>
        <tr>
        <td><?php echo $val['id'];?></td>
        <td><?php echo $val['address'];?></td>
        <td><?php echo $val['orderno'];?></td>
        <td><?php echo $val['departing_time'];?></td>
        <td><?php echo $val['return_time'];?></td>
          <td>
              <a href="javascript:void(0)" route-id="<?php echo $val['id'];?>" class="modi_route"><i class="icon-pencil"></i></a>
              <a href="javascript:void(0)" route-id="<?php echo $val['id'];?>" class="del_line"><i class="icon-remove"></i></a>
          </td>
        </tr>
<?php }?>
      </tbody>
    </table>
</div>

                    
<div class="well">
    <ul class="nav nav-tabs">
    <li class="active"><a href="#home" data-toggle="tab"><?php echo lang('route_title');?> - <?php echo $station['name'];?></a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <form id="from1" method="post" action="/manage/do_add_route">
        <label><?php echo lang('route_name');?></label>
        <div class="controls">
            <input type="text" value="" id="address" name="address" check-type="required" required-message="<?php echo lang('tip_routename');?>" class="input-xlarge">
        </div>
        <label><?php echo lang('order');?>(<?php echo lang('order_rem');?></label>
        <div class="controls">
        <input type="text" value="" id="orderno" name="orderno" check-type="required" required-message="<?php echo lang('tip_orderno');?>" class="input-xlarge">
        </div>
        <label><?php echo lang('time_zone');?></label>
        <div class="controls">
        <input type="text" value="GL" id="time_zone" name="time_zone" check-type="required" required-message="<?php echo lang('tip_timezone');?>" class="input-xlarge">
        </div>
        <label><?php echo lang('departing_time');?></label>
        <div class="controls">
        <input type="text" value="3:30pm" name="departing_time" id="departing_time" check-type="required" required-message="<?php echo lang('tip_departing_time');?>" class="input-xlarge">
        </div>
        <label><?php echo lang('return_time');?></label>
        <div class="controls">
        <input type="text" value="6:00am" id="return_time" name="return_time" check-type="required" required-message="<?php echo lang('tip_return_time');?>" class="input-xlarge">
        </div>
        <div class="controls">
        <input type="hidden" value="<?php echo $lid;?>" name="line_id" id="line_id">
        <input type="hidden" value="<?php echo $sid;?>" name="station_id">
        </div>
    </form>
    <button id="save" class="btn btn-primary"><i class="icon-save"></i> <?php echo lang('save');?></button>
    <button id="return_station" class="btn"><i class="icon-save"></i> <?php echo lang('save_add_return_station');?></button>
      </div>
  </div>

</div>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo lang('del_title')?></h3>
  </div>
  <div class="modal-body">
    
    <p class="error-text"><i class="icon-warning-sign modal-icon"></i><?php echo lang('del_route_content')?></p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-danger" id="do_del_line" data-dismiss="modal">Delete</button>
  </div>
</div>

<div class="modal small hide fade" id="ModiModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo lang('modi_title')?></h3>
  </div>
  <div class="modal-body">
        <li><span>Bus Stop</span><input type="text" id="bus-stop" /><input type="hidden" id="id" /></li>
        <li><span>Stop Order</span><input type="text" id="stop-order" /></li>
        <li><span>Departing Time</span><input type="text" id="dtime" /></li>
        <li><span>Return Time</span><input type="text" id="rtime" /></li>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-danger" id="do_modi_route" data-dismiss="modal">save</button>
  </div>
</div>

<?php include "footer.php" ?>

            </div>
        </div>
    </div>


    <script src="/static/lib/bootstrap/js/bootstrap.js"></script>
    <script src="/static/js/bootstrap-validation.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip({'placement':'left'});
        $(function() {
            $('form').validation();
            $('.demo-cancel-click').click(function(){return false;});

            $('.del_line').click(function(){
                route_id = $(this).attr('route-id');
                $('#myModal').modal('show');
            });

            $('#do_del_line').click(function(){
                $.post('/manage/del_route/'+route_id,function(data){
                    //$('#row'+lineid).remove();
                    alert('<?php echo lang("del_success");?>');
                    window.location.reload();
                });
            });

            $('.modi_route').click(function(){
                route_id = $(this).attr('route-id');
                var ts = $(this).parent().parent().find("td");
                $("#ModiModal").find("#id").val(route_id);
                $("#ModiModal").find("#bus-stop").val(ts[1].innerHTML);
                $("#ModiModal").find("#stop-order").val(ts[2].innerHTML);
                $("#ModiModal").find("#dtime").val(ts[3].innerHTML);
                $("#ModiModal").find("#rtime").val(ts[4].innerHTML);
                $('#ModiModal').modal('show');

            });

            $("#do_modi_route").click(function(){
                var pdata = {};
                pdata.id = $("#ModiModal").find("#id").val();
                pdata.address = $("#ModiModal").find("#bus-stop").val();
                pdata.orderno = $("#ModiModal").find("#stop-order").val();
                pdata.departing_time = $("#ModiModal").find("#dtime").val();
                pdata.return_time = $("#ModiModal").find("#rtime").val();
                $.post('/manage/modi_route/',pdata,function(data){
                    if(data == 'ok'){
                        alert('Modify the success');
                        location.reload(true);
                    }
                });
            });

            $('#save').click(function(){
                $('form').submit();
            });
            $('#return_station').click(function(){
                window.location.href="/manage/add_station/<?php echo $lid;?>";
            });
        });
    </script>
    
  </body>
</html>


