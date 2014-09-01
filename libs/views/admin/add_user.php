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
            <li><a href="/manage/user"><?php echo lang('userlist');?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $title;?></li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab"><?php echo lang('user_info');?></a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <form id="from1" method="post" action="/manage/<?php echo $url?>">
        <label>Role</label>
        <div class="controls">
        <select name="role">
            <option value="1" <?php if(@$users[0]['role'] == 1) echo "selected";?>>Admin</option>
            <option value="2" <?php if(@$users[0]['role'] == 2) echo "selected";?>>Seller</option>
        </select>
        </div>
        <label><?php echo lang('u_username');?></label>
        <div class="controls">
        <input type="text" value="<?php echo @$users[0]['username']?>"<?php if($url == "edit_user") echo " readonly=\"readonly\"";?> name="username" id="username" class="input-xlarge"><em id="username_error" style="color:red;margin-left:10px;"></em>
        </div>
        <label><?php echo lang('u_pass');?></label>
        <div class="controls">
        <input type="password" name="password" id="password" value="<?php echo @$users[0]['password']?>" class="input-xlarge"><em id="password_error" style="color:red;margin-left:10px;"></em>
        <input type="hidden" name="password_chenk" value="<?php echo @$users[0]['password']?>">
		</div>
        <label><?php echo lang('u_linkname');?></label>
        <div class="controls">
        <input type="text" name="linkname" id="linkname" value="<?php echo @$users[0]['linkname']?>" class="input-xlarge"><em id="linkname_error" style="color:red;margin-left:10px;"></em>
        </div>
        <label><?php echo lang('u_tel');?></label>
        <div class="controls">
        <input type="text" name="tel" id="tel" value="<?php echo @$users[0]['tel']?>" class="input-xlarge"><em id="tel_error" style="color:red;margin-left:10px;"></em>
        </div>
        <input type="hidden" name="sub" value="1">
        <input type="hidden" name="id" value="<?php echo @$users[0]['id']?>">
    </form>
    <button id="sub" class="btn btn-primary"><i class="icon-save"></i> <?php echo lang('save');?></button>
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
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('form').validation();
            $('.demo-cancel-click').click(function(){return false;});
        });
        $('#save').click(function(){
            $('form').submit();
        });
        $('#save_add_station').click(function(){
            $('#is_addstation').val("1");
            $('form').submit();
        });
        $('#sub').click(function(){
        	if($("#username").val() == ""){
				$("#username").focus();
			}else if($("#password").val() == ""){
				$("#password").focus();
			}else if($("#linkname").val() == ""){
				$("#linkname").focus();
			}else if($("#tel").val() == ""){
				$("#tel").focus();
			}else{
            	$('form').submit();
			}
        });
        $("#username").blur(function(){
            var username = $(this).val();
        	 $.post('/manage/username_check',{op:"username", username:username},function(backData){
            	 if(backData == "ok"){
					 $("#username_error").html("");	
                 }else{
                	 $("#username_error").html("<?php echo lang('username_exis')?>");	
                 }
        	 });
        });
    </script>
    
  </body>
</html>


