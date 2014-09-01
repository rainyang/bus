<div class="top">
<div class="top_width">
<?php
if(empty($user)){
?>
<span style="color:#ffffff;font-weight:bold;"><a href="/account/login">Sign in</a> | <a href="/account/register">register</a></span>
<?php
}
else{
    echo '<span style="color:#ffffff;font-weight:bold;"><a href="#">'.$user["username"].'</a> | <a href="/account/signup">Sign up</a></span>';
}
?>
</div>
</div>
<div class="header_shadow_bg">
    <div class="header_shadow_bg2">
    <div class="header_shadow">
        <div class="header">
            <div class="header_width">
                <div class="logo"><a href="/"><img src="/static/images/logo.png" alt="AKAI Bus" /></a></div>
                <div class="nav">
                	<ul>
                    	<li><a href="/">Home</a></li>
                        <li><a href="/schedule">Bus Schedule</a></li>
                        <li><a href="/policy">Ticket Policy</a></li>
                        <li><a href="/about">About us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
