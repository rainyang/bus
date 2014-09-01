<?php include "header.php" ?>
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

		<a href="/manage/user" class="nav-header" ><i class="icon-question-sign"></i><?php echo lang('admin_user');?></a>
    </div>
 
    
    <div class="content">
        
        <div class="header">
            
            <h1 class="page-title"><?php echo $title;?></h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="/manage/main"><?php echo lang('home');?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $title;?></li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab"><?php echo lang('is_stop_website');?></a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <form id="from1" method="post" action="/manage/<?php echo $url?>">
    <li>is stop: <input type=checkbox name="chk_stop" id="chk_stop" <?php if($is_stop) echo "checked";?>></li>
    <li>stop info: <textarea name="stop_info" id="stop_info"><?php echo $stop_info;?></textarea>
    <input type="hidden" name="is_stop" id="is_stop" value="<?php echo $is_stop;?>">
    </form>
    <button id="save" class="btn btn-primary"><i class="icon-save"></i> <?php echo lang('save');?></button>
      </div>
  </div>

</div>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Delete Confirmation</h3>
  </div>
  <div class="modal-body">
    
    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-danger" data-dismiss="modal">Delete</button>
  </div>
</div>

<?php include "footer.php" ?>

                    
            </div>
        </div>
    </div>
    


    <script src="/static/lib/bootstrap/js/bootstrap.js"></script>
    <script src="/static/js/bootstrap-validation.js"></script>
    <script type="text/javascript">
        $('#chk_stop').click(function(){
            if($(this).prop("checked")){
                $('#is_stop').val('1');
            }
            else{
                $('#is_stop').val('0');
            }
        });
        $('#save').click(function(){
            if($('#stop_info').val()==''){
                alert('please input stop info!');
                return false;
            }
            $('form').submit();
        });
    </script>
    
  </body>
</html>


