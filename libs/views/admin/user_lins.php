<?php include "header.php" ?>
    <div class="sidebar-nav">
        <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i><?php echo lang('dashboard');?></a>
        <ul id="dashboard-menu" class="nav nav-list collapse in">
            <li><a href="/manage/main"><?php echo lang('home');?></a></li>
            <li><a href="/manage/lines"><?php echo lang('line_list');?></a></li>
            <li ><a href="/manage/stat"><?php echo lang('order_statistics');?></a></li>
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
            
            <h1 class="page-title"><?php echo lang('userlist')?></h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="/manage/main"><?php echo lang('home');?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo lang('userlist')?></li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button id="new-line" class="btn btn-primary"><i class="icon-plus"></i><?php echo lang('add_user')?></button>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Role</th>
          <th><?php echo lang("u_username")?></th>
          <th><?php echo lang("u_linkname")?></th>
          <th><?php echo lang('u_tel');?></th>
          <th style="width: 26px;"></th>
        </tr>
      </thead>
      <tbody>
<?php
foreach($users as $key => $val){
?>
    <tr id="row-<?php echo $val['id'];?>">
        <td><?php echo $val['id'];?></td>
        <td><?php echo $roles[$val['role']];?></td>
        <td><?php echo $val['username'];?></td>
        <td><?php echo $val['tel'];?></td>
        <td><?php echo $val['linkname'];?></td>
          <td>
              <a href="/manage/edit_user/<?php echo $val["id"];?>" data-id="<?php echo $val["id"];?>"><i class="icon-pencil edit_user"></i></a>
              <a href="/manage/del_user/<?php echo $val["id"];?>" data-id="<?php echo $val["id"];?>" class="del_user"><i class="icon-remove"></i></a>
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
            var userid = "";
            $('.demo-cancel-click').click(function(){return false;});

            $('.del_user').click(function(){
                userid = $(this).attr('data-id');
                $('#myModal').modal('show');
            });
            $('.edit_user').click(function(){
            	userid = $(this).attr('dta-id');
                window.location.href="/manage/edit_user/"+userid;
            });

            $('#do_del_line').click(function(){
                $.post('/manage/del_line/'+lineid,function(data){
                    alert('<?php echo lang("del_success");?>');
                    window.location.reload();
                });
            });
        });
        $('#new-line').click(function(){
            window.location.href="/manage/add_user";
        });

        
    </script>
    
  </body>
</html>


