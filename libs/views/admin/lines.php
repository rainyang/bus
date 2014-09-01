<?php include "header.php" ?>
    <div class="sidebar-nav">
        <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i><?php echo lang('dashboard');?></a>
        <ul id="dashboard-menu" class="nav nav-list collapse in">
            <li><a href="/manage/main"><?php echo lang('home');?></a></li>
            <li class="active"><a href="/manage/lines"><?php echo lang('line_list');?></a></li>
            <li ><a href="/manage/stat"><?php echo lang('order_statistics');?></a></li>
            <li><a href="/manage/Report">Report</a></li>
            <li ><a href="/manage/is_stop_website"><?php echo lang('is_stop_website');?></a></li>
        </ul>

        <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase"></i><?php echo lang('customers');?><span class="label label-info">+3</span></a>
        <ul id="accounts-menu" class="nav nav-list collapse">
            <li ><a href="/manage/signup">Sign Up</a></li>
        </ul>

		<a href="/manage/user" class="nav-header" ><i class="icon-question-sign"></i><?php echo lang('admin_user');?></a>
    </div>
    

    
    <div class="content">
        
        <div class="header">
            
            <h1 class="page-title">Lines</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="/manage/main"><?php echo lang('home');?></a> <span class="divider">/</span></li>
            <li class="active">Lines</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button id="new-line" class="btn btn-primary"><i class="icon-plus"></i> New Line</button>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Line Name</th>
          <th><?php echo lang('line_price');?></th>
          <th><?php echo lang('total_tickets');?></th>
          <th>view station</th>
          <th style="width: 26px;"></th>
        </tr>
      </thead>
      <tbody>
<?php
foreach($lines as $key => $val){
?>
    <tr id="row-<?php echo $val['id'];?>">
        <td><?php echo $val['id'];?></td>
        <td><?php echo $val['name'];?></td>
        <td><a href="/manage/set_price/<?php echo $val['id'];?>"> <?php echo lang('ticket_price');?></a></td>
        <td><?php echo $val['total_tickets'];?></td>
        <td><a href="/manage/add_station/<?php echo $val['id'];?>"> <?php echo lang('view_station');?></a> </td>
          <td>
          <a href="/manage/line/<?php echo $val['id'];?>"><i class="icon-pencil"></i></a>
              <a href="javascript:void(0)" line-id="<?php echo $val["id"];?>" class="del_line"><i class="icon-remove"></i></a>
          </td>
        </tr>
<?php }?>
      </tbody>
    </table>
</div>
<div class="pagination">
    <ul>
        <li><a href="#">Prev</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">Next</a></li>
    </ul>
</div>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel"><?php echo lang('del_title')?></h3>
    </div>
    <div class="modal-body">
    <p class="error-text"><i class="icon-warning-sign modal-icon"></i><?php echo lang('del_line_content')?></p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <input type="hidden" value="" id="del_line_id">
        <button class="btn btn-danger" id="do_del_line" data-dismiss="modal">Delete</button>
    </div>
</div>


<?php include "footer.php" ?>

                    
            </div>
        </div>
    </div>
    


    <script src="/static/lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});

            $('.del_line').click(function(){
                lineid = $(this).attr('line-id');
                $('#myModal').modal('show');
                //$('#del_line_id').val(lineid);
                //$('#myModal').modal('show').on('shown',function(){
                 //   alert(lineid);
                //})
            });

            $('#do_del_line').click(function(){
                $.post('/manage/del_line/'+lineid,function(data){
                    //$('#row'+lineid).remove();
                    alert('<?php echo lang("del_success");?>');
                    window.location.reload();
                });
            });
        });
        $('#new-line').click(function(){
            window.location.href="/manage/line";
        });

        
    </script>
    
  </body>
</html>


