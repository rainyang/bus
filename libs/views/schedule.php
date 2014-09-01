<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AKAI Bus Tickets - Schedule</title>
    <link href="/static/css/bus.css" rel="stylesheet">
    <link href="/static/css/bootstrap.css" rel="stylesheet">
    <link href="/static/css/bootstrap-select.css" rel="stylesheet">
    <link href="/static/css/datetimepicker.css" rel="stylesheet" media="screen">
</head>
<body>

<?php include "userinfo.php" ?>

<form id="form2" action="/search/map" method="post" target="_blank">
    <input type="hidden" id="submit_address" name="address" value=""> 
</form>
<div class="container">
    <div class="row">
    <h1>Bus Schedule</h1>
        <?php
            foreach($lines as $val){
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="list-group">
                <?php
                  echo '<a href="javascript:void(0)" class="list-group-item active">';
                  echo $val['stations'][0]['name'] . " to " . $val['stations'][count($val['stations']) -1]['name'] . '</a>';

                    foreach($val['stations'] as $key => $station){
                        $i = $key + 1;
                        echo "<a href=\"javascript:void(0)\" class=\"list-group-item\" data-toggle=\"collapse\" data-target=\"#route{$val['line']['id']}{$key}\"><span class=\"schedule_right glyphicon glyphicon-chevron-down\"></span>{$i}: {$station['name']}</a>";
                        echo "<li id=\"route{$val['line']['id']}{$key}\" class=\"collapse\">";
                        foreach($station['route'] as $rk => $route){
                            echo "<a href=\"javascript:void(0)\" address=\"{$route['address']}\" class=\"list-group-item update_address\">Departure:{$route['departing_time']} <img src=\"/static/images/address_g.png\">{$route['address']}</a>";
                        }
                        echo "</li>";
                    }
                ?>
                  
                </div>
            </div>
            <!--return line-->
            <div class="col-md-6">
                <div class="list-group">
                  <a href="javascript:void(0)" class="list-group-item active">
                    <?php echo  $val['stations'][count($val['stations']) -1]['name'] . " to " . $val['stations'][0]['name'];?>
                  </a>
                <?php 
                    $stations = array_reverse($val['stations']);
                    foreach($stations as $key => $station){
                        $i = $key + 1;
                        echo "<a href=\"javascript:void(0)\" class=\"list-group-item\" data-toggle=\"collapse\" data-target=\"#route-return-{$val['line']['id']}{$key}\"><span class=\"schedule_right glyphicon glyphicon-chevron-down\"></span>{$i}: {$station['name']}</a>";
                        echo "<li id=\"route-return-{$val['line']['id']}{$key}\" class=\"collapse\">";
                        foreach($station['route'] as $rk => $route){
                            echo "<a href=\"javascript:void(0)\" address=\"{$route['address']}\" class=\"list-group-item update_address\">Departure:{$route['return_time']} <img src=\"/static/images/address_r.png\">{$route['address']}</a>";
                        }
                        echo "</li>";
                    }
                ?>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
</div>

   <div class="footer">
        <p>Privacy Policy | Terms & Conditions | Site Map | Mobile Site </p>
        <p>AKAI LLC Copyright &copy; 2013</p>
    </div> 
</div>
</body>
<script src="/static/js/jquery-1.9.1.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script src="/static/js/bootstrap-select.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
            $('.update_address').click(function(){
                $('#submit_address').val($(this).attr('address'));
                $('#form2').submit();
            });
});
    </script>
</html>
