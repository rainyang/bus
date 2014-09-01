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

		<a href="/manage/user" class="nav-header" ><i class="icon-question-sign"></i><?php echo lang('admin_user');?></a>
    </div>
 
    
    <div class="content">
        
        <div class="header">
            
            <h1 class="page-title"><?php echo lang('line_title');?></h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="/manage/main"><?php echo lang('home');?></a> <span class="divider">/</span></li>
            <li><a href="/manage/lines"><?php echo lang('lines');?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo lang('line');?></li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab"><?php echo lang('line_info');?></a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <form id="from1" method="post" action="/manage/add_line">
        <label><?php echo lang('line_name');?></label>
        <div class="controls">
        <input type="text" value="<?php echo (!$line['name']) ? "Atlanta - New York" : $line['name'];?>" name="name" check-type="required" required-message="<?php echo lang('tip_linename');?>" class="input-xlarge">
        </div>
        </div>
        <label><?php echo lang('total_tickets');?></label>
        <div class="controls">
        <input type="text" name="total_tickets" value="<?php echo $line['total_tickets'];?>" check-type="number" class="input-xlarge">
        <input type="hidden" value="0" name="is_addstation" id="is_addstation">
        <input type="hidden" value="<?php echo $line_id;?>" name="line_id" id="line_id">
        </div>
        <label><?php echo lang('contact_mail');?></label>
        <div class="controls">
        <input type="text" value="<?php echo (!$line['mail']) ? "akai@yahoo.com" : $line['mail'];?>" name="mail" check-type="required" required-message="<?php echo lang('tip_mail');?>" class="input-xlarge">
        </div>
        <label>transfer</label>
        <div class="controls">
        <input type="radio" value="1" name="is_need_tran" <?php echo ($line['is_need_tran'] ? "checked" : "");?> class="input-xlarge">
        transfer
        <input type="radio" value="0" name="is_need_tran"  <?php echo (!$line['is_need_tran'] ? "checked" : "");?> class="input-xlarge">
        direct
        </div>
        <br>
        <label><?php echo lang('free_facility');?></label>
        <div class="facility">
        <?php
        foreach($free_facility as $key => $val){
            $f = unserialize($line['free_facility']);
            $checked = (in_array($key, $f)) ? 'checked' : '';
            echo '<span><input type="checkbox" name="facility[]" '.$checked.' value="'.$key.'"> '.$val."</span>";
        }
        ?>
        </div>

    </form>
    <button id="save" class="btn btn-primary"><i class="icon-save"></i> <?php echo lang('save');?></button>
    <button id="save_add_station" class="btn"><i class="icon-save"></i> <?php echo lang('save_add_station');?></button>
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
    </script>
    
  </body>
</html>


