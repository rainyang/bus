<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AKAI Bus Tickets - about</title>
    <link href="/static/css/bus.css" rel="stylesheet">
    <link href="/static/css/bootstrap.css" rel="stylesheet">
    <link href="/static/css/bootstrap-select.css" rel="stylesheet">
    <link href="/static/css/datetimepicker.css" rel="stylesheet" media="screen">
</head>
<body>

<?php include "userinfo.php" ?>


<div class="container">
<div class="row">
<h3>Privacy Policy</h3>
  <p>
As a valued consumer, you are entitled to your personal privacy. Akaibus.com knows that you care how information about you is used and shared, and we appreciate your trust that we will do so carefully and sensibly. This notice describes our privacy policy. By visiting our platform, you are accepting the practices described in this Privacy Notice.
</p>
<h3>Personal Information Collected</h3>
  <p>
The information we learn from customers helps us personalize and continually improve your shopping experience at akaibus.com. Please note that this statement is subject to change at any time without notice. Every effort, however, will be made to keep it updated to reflect our current policies.
</p>
  <p>
<b>Information We Collect:</b> We receive and store any information you enter on our Web site or give us in any other way. We use the information that you provide for such purposes as responding to your requests, customizing future shopping for you, improving our stores, and communicating with you. Akaibus.com will never sell your personal or financial information to any third party, but may be shared with our affiliates. Your personal or financial information, however, may be shared with third parties, who are authorized by Akaibus.com for the following purposes:<br>
1.      Credit card verification and fraud detection purposes as part of your ticket purchase.<br>
2.      Legal disclosure to a governmental agency, law enforcement authority or court as required by law in the good faith belief that disclosure is necessary or advisable.
</p>
<p>
<b>Information from Other Sources:</b> For reasons such as improving personalization of our service (for example, providing better product recommendations or special offers that we think will interest you), we might receive information about you from other sources and add it to our account information. We also sometimes receive updated delivery and address information from our shippers or other sources so that we can correct our records and deliver your next purchase or communication more easily.
</p>
<h3>Non-Personal Information Collected</h3>
  <p>
<b>Cookies:</b> Cookies are alphanumeric identifiers that we transfer to your computer's hard drive through your Web browser to enable our systems to recognize your browser and to provide features such as 1-Click purchasing, and storage of items in your Shopping Cart between visits.
</p>

<p>
<b>IP Addresses:</b> An Internet protocol ("IP") address is a numeric code. This code is used to communicate between your Internet service provider and the World Wide Web. The IP address does not identify you individually. Akaibus.com logs inbound IP addresses to administer our Web site and to compile aggregate information on site traffic for internal use.
</p>
<h3>Sharing of Personal Information</h3>
  <p>
Information about our customers is an important part of our business, and will never sell your personal or financial information to any third party.
</p>

<h3>Protection of Akaibus.com and Others</h3>
  <p>
We release account and other personal information when we believe release is appropriate to comply with law; enforce or apply our Conditions of Use and other agreements; or protect the rights, property, or safety of Akaibus.com, our users, or others. This includes exchanging information with other companies and organizations for fraud protection and credit risk reduction.
</p>
<h3>Consent</h3>
  <p>
Other than as set out above, we reserve the right to make changes to this privacy policy from time to time, without prior notice, and for this reason, we encourage you to review the policy posted at www.akaibus.com periodically.
</p>
<h3>Refund Policy:</h3>
  <p>
No refund or credits will be giving. Please check the selected schedule information carefully before purchasing. Duplicated tickets are also not refundable since duplicated tickets will prevent other customer from buying the ticket. There is no refund for unused or partially used tickets.<br>
<b>Changing Ticket:</b><br>
You may change the tickets 24 hours prior to departure time. A change fee of 15% will apply plus any additional amount due for the ticket difference. <br> 
<b>Conditions of ticket usage:</b><br>
1. Your  Ticket is only valid on the date, route, and time that were originally booked for.<br>
2. Customer has to show a valid ID and the printout of the ticket.<br>
3. Passengers are required to be at their departure point at least 30 minutes prior to departure time.<br>
<b>EXCEPTIONS:</b> Akai Bus reserves the right to cancel buses due to weather/traffic/coach condition. If customer purchased for a ticket which the bus is canceled, customer must initiate a refund request within 7 days after the departure date to receive a full refund of canceled trip.

</p>
</div>
</div>

   <div class="footer">
        <p>Privacy Policy | Terms & Conditions | Site Map | Mobile Site </p>
        <p>AKAI LLC Copyright &copy; 2014</p>
    </div> 
</div>
</body>
<script src="/static/js/jquery-1.9.1.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script src="/static/js/bootstrap-select.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
            $('.btn-schedule, .select_line').click(function(){
                $('.schedule-list:visible').hide();
                var scheduleid = $(this).attr('schedule-id');
                $('#schedule-list'+scheduleid).toggle();
            });

            $('.btn-return-schedule, .select_return_line').click(function(){
                $('.return-schedule-list:visible').hide();
                var scheduleid = $(this).attr('schedule-id');
                $('#return-schedule-list'+scheduleid).toggle();
            });

            $('.update_address').click(function(){
                $('#submit_address').val($(this).attr('address'));
                $('#form2').submit();
            });

});
    </script>
</html>
