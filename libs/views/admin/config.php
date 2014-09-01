<?php include "header.php" ?>
<style>
.shoppingitem_edit .editimgfield {
position: absolute;
width: 32%;
/* background-color: #EEE; */
top: 5px;
border-right: 1px solid #eee;
bottom: 5px;
margin: 0;
}

.clear{clear:both;}

.uploadimagediv{width:15%; float:left; margin-right:5px;}

.upload_shopping_file {
position: relative;
left: 0;
top: 0;
right: 0;
bottom: 10px;
height: 24px;
margin-left: auto;
margin-right: auto;
}
.input_file {
position: absolute;
top: 0px;
left: 0px;
height: 30px;
width: 200px !important;
color: #999;
opacity: 0;
filter: alpha(opacity=0);
-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=0);
font-size: 160px;
overflow: hidden;
z-index: 10;
}

.buttons a, button {
border-style: solid;
border-color: rgb(238, 238, 238) rgb(222, 222, 222) rgb(222, 222, 222) rgb(238, 238, 238);
border-width: 1px;
margin: 0pt 7px 0pt 0pt;
padding: 5px 10px 6px 7px;
cursor: pointer;
font-size: 100%;
line-height: 130%;
display: block;
float: left;
background-color: rgb(245, 245, 245);
text-decoration: none;
font-weight: bold;
color: rgb(86, 86, 86);
}

.buttons a {
background-color: rgb(98, 153, 197);
color: rgb(255, 255, 255);
}

.progress {
height: 20px;
margin-bottom: 20px;
overflow: hidden;
background-color: #f5f5f5;
border-radius: 4px;
-webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
}

.progress-bar {
float: left;
width: 0;
height: 100%;
font-size: 12px;
line-height: 20px;
color: #fff;
text-align: center;
background-color: #428bca;
-webkit-box-shadow: inset 0 -1px 0 rgba(0,0,0,0.15);
box-shadow: inset 0 -1px 0 rgba(0,0,0,0.15);
-webkit-transition: width .6s ease;
transition: width .6s ease;
}
.progress-bar-success {
background-color: #5cb85c;
}

</style>
   <div class="sidebar-nav">
        <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i><?php echo lang('dashboard');?></a>
        <ul id="dashboard-menu" class="nav nav-list collapse in">
            <li><a href="/manage/main"><?php echo lang('home');?></a></li>
            <li><a href="/manage/lines"><?php echo lang('line_list');?></a></li>
            <li ><a href="/manage/stat"><?php echo lang('order_statistics');?></a></li>
            <li><a href="/manage/Report">Report</a></li>
            <li ><a href="/manage/ticket_stat">Ticket statistics</a></li>
            <li class="active"><a href="/manage/config">site config</a></li>
        </ul>

        <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase"></i><?php echo lang('customers');?><span class="label label-info">+3</span></a>
        <ul id="accounts-menu" class="nav nav-list collapse">
            <li ><a href="/manage/signup">Sign Up</a></li>
        </ul>

		<a href="/manage/user" class="nav-header" ><i class="icon-question-sign"></i><?php echo lang('admin_user');?></a>
    </div>
 
    
    <div class="content">
        
        <div class="header">
            
            <h1 class="page-title">site config</h1>
        </div>
        
        <ul class="breadcrumb">
            <li><a href="/manage/main"><?php echo lang('home');?></a> <span class="divider">/</span></li>
            <li class="active">site config, current time:<?php echo date("Y-m-d H:i:s");?></li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">site config</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <form id="from1" method="post" action="/manage/do_site_config">
        <label>site title</label>
        <div class="controls">
        <input type="text" value="<?php echo (!$title) ? "Akai Bus" : $title;?>" name="title" check-type="required" required-message="<?php echo lang('tip_linename');?>" class="input-xlarge">
        </div>
        <label>site meta</label>
        <div class="controls">
        <input type="text" name="meta" value="<?php echo (!$meta) ? "Akai Bus" : $meta;?>" class="input-xlarge">
        </div>
        <label>site keywords</label>
        <div class="controls">
        <input type="text" name="keywords" value="<?php echo (!$keywords) ? "Akai Bus" : $keywords;?>" class="input-xlarge">
        </div>
        <label>company</label>
        <div class="controls">
        <input type="text" name="company" value="<?php echo $company;?>" class="input-xlarge">
        </div>
        <label>address</label>
        <div class="controls">
        <input type="text" name="address1" value="<?php echo $address1;?>" class="input-xlarge">
        <input type="text" name="address2" value="<?php echo $address2;?>" class="input-xlarge">
        <input type="text" name="address3" value="<?php echo $address3;?>" class="input-xlarge">
        </div>
        <label>tel</label>
        <div class="controls">
        <input type="text" name="tel" value="<?php echo $tel;?>" class="input-xlarge">
        </div>
        <label>email</label>
        <div class="controls">
        <input type="text" name="email" value="<?php echo $email;?>" class="input-xlarge">
        </div>
        <label>notice</label>
        <div class="controls">
        <input type="text" name="notice" value="<?php echo $notice;?>" class="input-xlarge">
        </div>
        <label>slide upload</label>
        <div class="controls">
            <?php
            for($i = 0; $i<6; $i++){
            ?>
            <div class="uploadimagediv">
                        <img class="defaultimg" src="<?php echo ($images[$i] ? $images[$i] : "images/defaultImg.png");?>" alt="上传图片" style="width: 100%; display: inline;">
                        <img src="" alt="" class="editimg" style="display:none;">

                        <input type="hidden" class="slider" name="images[]" value="<?php echo ($images[$i] ? $images[$i] : "");?>">
                        <div class="upload_shopping_file" imgsrc="">
                            <input type="file" size="1" class="input_file" name="files[]" multiple="">
                            <a class="btn btn-primary btn_shopiingimg">上传图片</a>
                        </div>
            </div>
            <?php }?> 
            
        </div>
        <div class="clear"></div>
        <br>
        <label>Stop the ticket time(minute)</label>
        <div class="controls">
        <input type="text" name="stop_ticket" value="<?php echo (!$stop_ticket) ? "30" : $stop_ticket;?>" class="input-xlarge">
        </div>
        <label>ticket notice</label>
        <div class="controls">
        <input type="text" name="ticket_notice" value="<?php echo (!$ticket_notice) ? "5" : $ticket_notice;?>" class="input-xlarge">
        </div>
        <label>ticket notice email</label>
        <div class="controls">
        <input type="text" name="ticket_notice_email" value="<?php echo $ticket_notice_email;?>" class="input-xlarge">
        <label>transfer line price</label>
        <div class="controls">
        <input type="text" name="transfer_price" value="<?php echo $transfer_price;?>" class="input-xlarge">
        <label>Commission</label>
        <div class="controls">
        <input type="text" name="commission" value="<?php echo $commission;?>" class="input-xlarge">
        </div>

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
<script src="/static/js/vendor/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="/static/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="/static/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="/static/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="/static/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="/static/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="/static/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="/static/js/jquery.fileupload-validate.js"></script>
<script src="/static/js/cors/jquery.xdr-transport.js"></script>

    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('form').validation();
            $('.demo-cancel-click').click(function(){return false;});
        });
        $('#save').click(function(){
            $('form').submit();
        });

        $(document).ready(function(){
            $('.input_file').fileupload({
                dataType: "json",
                url: 'upload',
                drop: function (e) {
                    return false;
                },
                add: function (e, data) {
                    var flag = false;
                    if (data.files[0].size) {
                        if (data.files[0].size < 2000000) {
                            $(this).attr('hasFile', true);
                            // $(this).parent().siblings('.errorinfo').text(data.files[0].name).css("color", "#333333");
                            flag = true;
                        } else {
                            alert('The file is too big');
                            // $(this).siblings('p').css('color', '#B94A48');
                        }
                    } else {
                        $(this).attr('hasFile', true);
                        // $(this).siblings('p').text(data.files[0].name).css("color", "#333333");
                        flag = true;
                    }
                    if (flag) {
                        data.submit();
                    }
                },
                start: function (e, data) {
                    $(this).parent().siblings('.uploadinfo').text('开始上传！').show().css('color', '#333');
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 90, 10);
                    $(this).parent().siblings('.uploadinfo').text('上传中…' + progress + '%').show().css('color', '#333');
                },
                done: function (e, data) {
                    // var uploadFlag = data.result.data.flag;
                    var uploadFlag = data.result.files[0].url;
                    if (uploadFlag) {
                        uploadImageUrl = uploadFlag;
                        $(this).parent().siblings('.uploadinfo').text('上传成功!').show().css('color', '#333');
                        window.setTimeout((function ($ui) {
                            return function () {
                                $ui.parent().siblings('.uploadinfo').hide();
                            };
                        })($(this)), 300);
                        $(this).parent().parent().find(".defaultimg").attr("src", uploadFlag);
                        $(this).parent().parent().find(".slider").val(uploadFlag);

                    } else {
                        $(this).parent().siblings('.uploadinfo').text('上传失败...').show().css('color', '#333');
                    }
                    $(this).siblings('.progress').fadeOut();
                }
            });
        });
    </script>
    
  </body>
</html>



