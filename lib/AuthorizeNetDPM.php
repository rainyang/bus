<?php
/**
 * Demonstrates the Direct Post Method.
 *
 * To implement the Direct Post Method you need to implement 3 steps:
 *
 * Step 1: Add necessary hidden fields to your checkout form and make your form is set to post to AuthorizeNet.
 *
 * Step 2: Receive a response from AuthorizeNet, do your business logic, and return
 *         a relay response snippet with a url to redirect the customer to.
 *
 * Step 3: Show a receipt page to your customer.
 *
 * This class is more for demonstration purposes than actual production use.
 *
 *
 * @package    AuthorizeNet
 * @subpackage AuthorizeNetDPM
 */

/**
 * A class that demonstrates the DPM method.
 *
 * @package    AuthorizeNet
 * @subpackage AuthorizeNetDPM
 */
class AuthorizeNetDPM extends AuthorizeNetSIM_Form
{

    const LIVE_URL = 'https://secure.authorize.net/gateway/transact.dll';
    const SANDBOX_URL = 'https://test.authorize.net/gateway/transact.dll';

    /**
     * Implements all 3 steps of the Direct Post Method for demonstration
     * purposes.
     */
    public static function directPostDemo($order, $url, $api_login_id, $transaction_key, $amount = "0.00", $md5_setting = "", $data = null)
    {
        
        // Step 1: Show checkout form to customer.
        if (!count($_POST) && !count($_GET))
        {
            $fp_sequence = time(); // Any sequential number like an invoice number.
            return AuthorizeNetDPM::getCreditCardForm($order, $amount, $fp_sequence, $url, $api_login_id, $transaction_key, $data);
        }
        
    }
    
    /**
     * A snippet to send to AuthorizeNet to redirect the user back to the
     * merchant's server. Use this on your relay response page.
     *
     * @param string $redirect_url Where to redirect the user.
     *
     * @return string
     */
    public static function getRelayResponseSnippet($redirect_url)
    {
        return "<html><head><script language=\"javascript\">
                <!--
                window.location=\"{$redirect_url}\";
                //-->
                </script>
                </head><body><noscript><meta http-equiv=\"refresh\" content=\"1;url={$redirect_url}\"></noscript></body></html>";
    }
    
    /**
     * Generate a sample form for use in a demo Direct Post implementation.
     *
     * @param string $amount                   Amount of the transaction.
     * @param string $fp_sequence              Sequential number(ie. Invoice #)
     * @param string $relay_response_url       The Relay Response URL
     * @param string $api_login_id             Your API Login ID
     * @param string $transaction_key          Your API Tran Key.
     * @param bool   $test_mode                Use the sandbox?
     * @param bool   $prefill                  Prefill sample values(for test purposes).
     *
     * @return string
     */
    public static function getCreditCardForm($order, $amount, $fp_sequence, $relay_response_url, $api_login_id, $transaction_key, $data = null, $test_mode = false, $prefill = true)
    {
        $time = time();
        $fp = self::getFingerprint($api_login_id, $transaction_key, $amount, $fp_sequence, $time);
        $sim = new AuthorizeNetSIM_Form(
            array(
            'x_amount'        => $amount,
            'x_fp_sequence'   => $fp_sequence,
            'x_fp_hash'       => $fp,
            'x_fp_timestamp'  => $time,
            'x_relay_response'=> "TRUE",
            'x_relay_url'     => $relay_response_url,
            'x_login'         => $api_login_id,
            'x_order'         => $order,
            //'x_test_request'         => true,
            )
        );
        $hidden_fields = $sim->getHiddenFieldString();
        $post_url = ($test_mode ? self::SANDBOX_URL : self::LIVE_URL);
        $billing_address = (!empty($data['user'])) ? '<div class="row"><label style="margin-left:30px; color:#ff8500">BILLING ADDRESS</label><input type="checkbox" style="margin-right:5px;" id="billing">Use my contact Address here</div>' : ""; //BILLING ADDRESS
        $exp_m = '';
        for($i = 1; $i<=12; $i++){
            $j = ($i < 10) ? "0".$i : $i;
            $exp_m .= "<option value='{$j}'>{$j}</option>";
        } 

        $Y = date("Y");
        $exp_y = '';
        for($i = $Y; $i < $Y+11; $i++){
            $val = substr($i, -2);
            $exp_y .= "<option value='{$val}'>{$i}</option>";
        }
        /*
<div class="row">
                    <label style="float:left; margin-left: 30.4%;margin-bottom: 6px;">Exp.</label>
                    <div class="date form_datetime b_date" data-date="'.date("Y-m-d").'" data-date-format="mm/dd" data-link-field="dtp_input1">
                   <input size="16" type="text" name="x_exp_date" class="form-control1 form-control-bus date_input input-sm" style="width:22%" value="04/17" readonly>
                        <span class="add-on" style="float:left;"><i class="icon-th"></i></span>
                    <input type="hidden" id="dtp_input1" value="" />
                    </div>
                </div>
         */

        
        $form = '
                <div class="row payment" style="width:100%;margin:0 auto;text-align:center"><form method="post" action="'.$post_url.'">
                '.$hidden_fields.'
                <div class="row" style="margin-left: -60px;">
                    <label>Card type</label>
                    <select name="card_type">
                    <option value="Visa">Visa</option>
                    <option value="American Express">American Express</option>
                    <option value="Diners Club">Diners Club</option>
                    <option value="Discover">Discover</option>
                    <option value="MasterCard">MasterCard</option>
                    <option value="UATP Card">UATP Card</option>
                    </select>
                </div>
                <div class="row">
                    <label>Card Number</label>
                    <input type="text" class="text required form-control2 input-sm" autocomplete="off" size="25" title="Card num" data-toggle="popover" data-content="Please enter your card number" data-type="number" name="x_card_num" value=""></input>
                </div>
                <div class="row">
                    <label style="float:left; margin-left: 30.4%;margin-bottom: 6px;">Exp.</label>
                    <select name="exp_m" style="float:left">'.$exp_m.'</select>
                    <select name="exp_y" style="float:left">'.$exp_y.'</select>
                    <input type="hidden" name="x_exp_date" value="">
                </div>
                <div class="row">
                    <label style="margin-left: 20px;">CCV</label>
                    <input type="text" class="text required form-control2 input-sm" size="25" data-type="number" autocomplete="off"  name="x_card_code" value=""></input>&nbsp;&nbsp;<a class="glyphicon glyphicon-question-sign" data-toggle="modal" data-target="#myModal">
</a>
                </div>
                <div class="row">
                    <label>First Name</label>
                    <input type="text" class="text required form-control2 input-sm" size="25" title="first name" name="x_first_name" data-content="John" value=""></input>
                </div>
                <div class="row">
                    <label>Last Name</label>
                    <input type="text" class="text required form-control2 input-sm" size="25" title="last name" name="x_last_name" data-content="Doe" value=""></input>
                </div>'.$billing_address.'
                <div class="row">
                    <label>Steet Address</label>
                    <input type="text" class="text required form-control2 input-sm" size="25" title="address" name="x_address" data-content="123 Main Street" value=""></input>
                </div>
                <div class="row">
                    <label></label>
                    <input type="text" class="text required form-control2 input-sm" size="25" title="address2" name="x_address2" data-content="123 Main Street" value=""></input>
                </div>
                <div class="row">
                    <label>City</label>
                    <input type="text" class="text required form-control2 input-sm" size="25" title="city" name="x_city" data-content="Boston" value=""></input>
                </div>
                <div class="row">
                    <label>State</label>
                    <select  class="text required form-control2 input-sm bfh-states" id="state" name="x_state" data-country="country"></select>
                </div>
                <div class="row">
                    <label>Zip Code</label>
                    <input type="text" class="text required form-control2 input-sm" size="25" title="zip" data-type="number" name="x_zip" data-content="02142" value=""></input>
                </div>
                <div class="row">
                    <label>Country</label>
                    <select id="country" name="x_country" class="text required form-control2 input-sm bfh-countries" data-country="US"></select>
                </div>
            <div class="row">
                <div class="col-md-12">
                    <label style="text-align:center; color:red; margin:0 auto">amount: $'.$amount.'</label>
                </div>
            </div>
            <div class="row" style="text-align:center">
<button type="button" id="btn-pay" class="noprint btn btn-primary ">Payment</button>
            </div>
        </form></div>';
        return $form;
    }

}
