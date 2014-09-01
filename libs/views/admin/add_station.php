<?php include "header.php" ?>
   <div class="sidebar-nav">
        <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i><?php echo lang('dashboard');?></a>
        <ul id="dashboard-menu" class="nav nav-list collapse in">
            <li><a href="/manage/main"><?php echo lang('home');?></a></li>
            <li class="active"><a href="/manage/lines"><?php echo lang('line_list');?></a></li>
            <li ><a href="/manage/stat"><?php echo lang('order_statistics');?></a></li>
            
        </ul>

        <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase"></i><?php echo lang('customers');?><span class="label label-info">+3</span></a>
        <ul id="accounts-menu" class="nav nav-list collapse">
            <li ><a href="/manage/signup">Sign Up</a></li>
        </ul>


    </div>
 
    
    <div class="content">
        
        <div class="header">
            
        <h1 class="page-title"><?php echo lang('station_title');?> - <?php echo $line_name;?></h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="/manage/main"><?php echo lang('home');?></a> <span class="divider">/</span></li>
            <li><a href="/manage/lines"><?php echo lang('lines');?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo lang('station');?></li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">

<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th width="10%">#order no</th>
          <th><?php echo lang('station_name');?></th>
          <th><?php echo lang('view_stops');?></th>
          <th style="width: 46px;"></th>
        </tr>
      </thead>
      <tbody>
      <form name="updateform" action="/manage/update_orderno/<?php echo $lid;?>" method="post">
<?php
foreach($stations as $key => $val){
?>
        <tr>
        <td><input name="ordernos[]" class="input-mini" value="<?php echo $val['orderno'];?>"><input type="hidden" name="ids[]" value="<?php echo $val['id'];?>"></td>
        <td><?php echo $val['name'];?></td>
        <td><a href="/manage/add_route/<?php echo $val['id'] . "/" . $lid;?>"><?php echo lang('view_stops');;?></a></td>
          <td>
          <a href="/manage/add_route/<?php echo $val['id'] . "/" . $lid;?>"  rel="tooltip" data-toggle="tooltip" title="<?php echo lang('add_route');?>"><i class="icon-plus"></i></a>
          <a href="/manage/modi_station/<?php echo $val['id'] . "/" . $lid;?>"><i class="icon-pencil"></i></a>
              <a href="javascript:void(0)" line-id="<?php echo $lid;?>" station-id="<?php echo $val["id"];?>" class="del_line"><i class="icon-remove"></i></a>
          </td>
        </tr>
<?php }?>
<tr><td colspan="5"><button id="update-orderno" type="submit" class="btn btn-primary"><i class="icon-save"></i>update order</button></td></tr>
</form>
      </tbody>
    </table>
</div>

                    
<div class="well">
    <ul class="nav nav-tabs">
    <li class="active"><a href="#home" data-toggle="tab"><?php echo lang('station_info');?> - <?php echo $line_name;?></a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <form id="from1" method="post" action="/manage/do_add_station">
        <label><?php echo lang('station_name');?></label>
        <div class="controls">
        <input type="text" value="Atlanta" id="name" check-type="required" required-message="<?php echo lang('tip_linename');?>" class="input-xlarge">
        </div>
        <label><?php echo lang('orderno');?></label>
        <div class="controls">
        <input type="text" value="<?php echo $max_orderno;?>" id="orderno" name="orderno" check-type="required" required-message="<?php echo lang('tip_linename');?>" class="input-xlarge">
        </div>
        <label>is transfer station</label>
        <div class="controls">
        <input type="radio" value="0" name="is_tran_station" checked>no
        <input type="radio" value="1" name="is_tran_station">yes
        </div>
        <div class="controls">
        <input type="hidden" value="0" name="is_addstation" id="is_addstation">
        </div>
    </form>
    <button id="save" class="btn btn-primary"><i class="icon-save"></i> <?php echo lang('save');?></button>
    <button id="return_lines" class="btn"><i class="icon-save"></i> <?php echo lang('return_lines');?></button>
      </div>
  </div>

</div>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo lang('del_title')?></h3>
  </div>
  <div class="modal-body">
    
    <p class="error-text"><i class="icon-warning-sign modal-icon"></i><?php echo lang('del_station_content')?></p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-danger" id="do_del_line" data-dismiss="modal">Delete</button>
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
                lineid = $(this).attr('line-id');
                station_id = $(this).attr('station-id');
                $('#myModal').modal('show');
                //$('#del_line_id').val(lineid);
                //$('#myModal').modal('show').on('shown',function(){
                 //   alert(lineid);
                //})
            });

            $('#do_del_line').click(function(){
                $.post('/manage/del_station/'+lineid+'/'+station_id,function(data){
                    //$('#row'+lineid).remove();
                    alert('<?php echo lang("del_success");?>');
                    window.location.reload();
                });
            });

        });
        $('#save').click(function(){
            var name = $('#name').val();
            var line_id = <?php echo $lid;?>;
            var orderno = $('#orderno').val();
            var tran =$('input:radio[name="is_tran_station"]:checked').val();
            $.post('/manage/do_add_station', {name:name,orderno:orderno,line_id:line_id,is_transfer_station:tran}, function(data){
                window.location.reload();
            });
        });
        $('#return_lines').click(function(){
            window.location.href="/manage/lines";
        });
    </script>
    
  </body>
</html>


