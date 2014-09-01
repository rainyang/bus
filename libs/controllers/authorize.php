<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authorize extends CI_Controller {

	/**
	 * search class.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
     *
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/search/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct(){
        parent::__construct();
    }

	public function test()
    {
        /**
         * akai info
         * api_login_id:7x5PAs35
         * tr.._key:3LD5EQ5au89u9s69
         * md5:Simon
         */
        require_once 'AuthorizeNet.php'; // The SDK
        $url = "http://218.29.188.212:8009/authorize/testrs";
        $api_login_id = '7x5PAs35';
        $transaction_key = '84L84T83MWrmg5vX';
        $md5_setting = 'Simon'; // Your MD5 Setting
        $amount = "6.99";

        $this->session->set_userdata('order', '123123123');
        AuthorizeNetDPM::directPostDemo($url, $api_login_id, $transaction_key, $amount, $md5_setting);
	}

    public function testrs(){
        require_once 'AuthorizeNet.php'; // The SDK
        $url = "http://218.29.188.212:8009/authorize/testrs";
        $redirect_url = 'http://218.29.188.212:8009/authorize/redirect';
        $api_login_id = '7x5PAs35';
        $transaction_key = '84L84T83MWrmg5vX';
        $md5_setting = 'Simon'; // Your MD5 Setting
        $response = new AuthorizeNetSIM($api_login_id, $md5_setting);
        echo "<pre>";
        print_r($response);
        echo "</pre>";
        if ($response->isAuthorizeNet())
        {
            if ($response->approved)
            {
            // Do your processing here.
            $redirect_url .= '?response_code=1&transaction_id=' .$response->transaction_id;
            }
            else
            {
            $redirect_url .= '?response_code='.$response->response_code . '&response_reason_text=' . $response->response_reason_text;
            }
            echo AuthorizeNetDPM::getRelayResponseSnippet($redirect_url);
        }
        else
        {
            echo "Error. Check your MD5 Setting.";
        }
    }

    public function redirect(){
        print_r($_GET);
        echo "<br>";
        echo $this->session->userdata('order');;
    }

}
