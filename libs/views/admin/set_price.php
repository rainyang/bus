<?php include "header.php" ?>
   <div class="sidebar-nav">
        <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i><?php echo lang('dashboard');?></a>
        <ul id="dashboard-menu" class="nav nav-list collapse in">
            <li><a href="/manage/main"><?php echo lang('home');?></a></li>
            <li class="active"><a href="/manage/lines"><?php echo lang('line_list');?></a></li>
            <li><a href="/manage/ticket_price"><?php echo lang('ticket_price');?></a></li>
            <li ><a href="/manage/stat"><?php echo lang('order_statistics');?></a></li>
            <li ><a href="/manage/settings"><?php echo lang('settings');?></a></li>
            
        </ul>

        <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase"></i><?php echo lang('customers');?><span class="label label-info">+3</span></a>
        <ul id="accounts-menu" class="nav nav-list collapse">
            <li ><a href="sign-in.html"><?php echo lang('sigi_in');?></a></li>
            <li ><a href="sign-up.html">Sign Up</a></li>
        </ul>


        <a href="help.html" class="nav-header" ><i class="icon-question-sign"></i><?php echo lang('help');?></a>
        <a href="faq.html" class="nav-header" ><i class="icon-comment"></i><?php echo lang('faq');?></a>
    </div>
 
    
    <div class="content">
        
        <div class="header">
            
        <h1 class="page-title"><?php echo lang('ticket_price');?> - <?php echo $line['name'];?></h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="/manage/main"><?php echo lang('home');?></a> <span class="divider">/</span></li>
            <li><a href="/manage/lines"><?php echo lang('lines');?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo lang('ticket_price');?></li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">

<div class="well">
    <form id="from1" method="post" action="/manage/do_add_price">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th><?php echo lang('from_station');?></th>
          <th><?php echo lang('to_station');?></th>
          <th><?php echo lang('item_price');?></th>
          <th>Discount</th>
          <th>is_allow_return</th>
        </tr>
      </thead>
      <tbody>
<?php
foreach($stations as $key => $val){
    $discount = ($val['discount'] ? $val['discount'] : 0);
?>
        <tr>
        <td><?php echo $key+1;?></td>
        <td><?php echo $val['from_station']['name'];?></td>
        <td><?php echo $val['to_station']['name'];?></td>
        <td>
        <input type="hidden" value="<?php echo $val['from_station']['id'];?>" name="from_station[]">
        <input type="hidden" value="<?php echo $val['to_station']['id'];?>" name="to_station[]">
        <input type="text"  class="input-small" value="<?php echo ($val['price']) ? $val['price'] : '0.00';?>" id="price" name="price[]" validate="required" check-type="required" required-message="sdfsdf" class="input-xlarge">
        </td>
        <td>
        <input type="text" class="input-mini" value="<?php echo $discount;?>" name="discount[]" validate="required" check-type="required" required-message="<?php echo lang('tip_timezone');?>" class="input-xlarge">
        </td>
        <td>
        <input type="text"  class="input-mini" value="<?php echo ($val['is_allow_return'] == '' or $val['is_allow_return'] == '1') ? 1 : 0;?>" name="is_allow_return[]" class="input-xlarge">
        </td>
        </tr>
<?php }?>
        <input type="hidden" value="<?php echo $line['id'];?>" name="line_id">
        <tr><td colspan=8><button id="save" class="btn btn-primary"><i class="icon-save"></i> <?php echo lang('save');?></button></td></tr>
      </tbody>
    </table>
</form>
</div>

                    

                    <footer>
                        <hr>
                        <p class="pull-right">A <a href="http://www.test.com/" target="_blank">Power</a> by <a href="http://www.test.com" target="_blank">AKIA</a></p>

                        <p>&copy; 2013 <a href="http://www.test.com" target="_blank">AKIA</a></p>
                    </footer>
                    
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
        });
        $('#save').click(function(){
            $('form').submit();
        });
    </script>
    
  </body>
</html>


