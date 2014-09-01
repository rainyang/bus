<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends CI_Controller {

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

    private $pay_status = array( 0 => 'Not pay', 1 => 'Payment has been');

    public function __construct(){
        parent::__construct();
        $this->load->model('bus_model', 'bm');
        $lang = $this->session->userdata('lang');
        $this->lang->load('admin', $lang);
        $this->load->helper('language');
        $admin = $this->session->userdata('admin');
        $url = $this->uri->rsegment(2);
        if(!$admin && $url != 'index' & $url !='set_lang'){
            redirect('/manage/');
        }
        $this->admin = $admin;

        //exit;
        $allows = array('stat', 'signup', 'ajax_stat', 'ajax_total', 'index', 'main', 'set_lan', 'getTransaction');
        if($admin['role'] == 2){
            if(!in_array($this->uri->segment(2), $allows))
            {
                exit('You don\'t have this permission');
            }
        }
    }


    function is_stop_website(){
        $data = '';
        $data['is_stop'] = file_exists('is_stop.txt') ? 1 : 0;
        $data['stop_info'] = '';
        if($data['is_stop']){
            $data['stop_info'] = file_get_contents('is_stop.txt');
        }
        $data['title'] = 'website stop or start';
        $data['url'] = "do_is_stop_website";
    	$this->load->view('admin/stop_website', $data);
    }

    function do_is_stop_website(){
        $is_stop = $this->input->post('is_stop');
        $stop_info = $this->input->post('stop_info');
        if($is_stop){
            file_put_contents('is_stop.txt', $stop_info);
        }
        else{
            unlink('is_stop.txt');
        }

        redirect('/manage/main');
    }

    public function index()
    {
    	if($this->input->post('sub', true)){
    		$username = $this->input->post('username');
    		$password = $this->input->post('password');
    		if($admin = $this->bm->get_login($username, $password)){
    			$this->session->set_userdata('admin', $admin);
                header('location:/manage/main');
    		}else{
    			$data['error'] = lang("login_error");
    		}
    	}else{
	        $data['error'] ='';
    	}
    	$this->load->view('admin/sign-in', $data);
    }

    public function main($type= 1, $date1 = null, $date2 = null){
        header('location:/manage/stat');
        exit;
        $param = $_GET;
        $data['stations'] = $this->bm->get_station();

        $start_page = (!empty($param['start_page'])) ? $param['start_page'] : "1";
        //echo $start_page;
        $rs_count = 10;
        $limit_start = ($start_page - 1) * $rs_count;

        $order = ($order = $this->input->post("order")) ? $order : "departing_date";
        $ordersc = ($ordersc = $this->input->post("ordersc")) ? $ordersc : "desc";
        
        $order = $order . " ". $ordersc;

        $data['station'] = $this->bm->get_station(false);
        $data['customers'] = $this->bm->get_customers();

        $post = $this->input->post();

        if($post){
            unset($post['order']);
            unset($post['ordersc']);
            foreach($post as $k => $val){
                if($k == 'is_pay' && $val != 'all'){
                    $cond1 .= " and `{$k}` = '{$val}'";
                    continue;
                }

                if(empty($val) or ($k == 'is_pay' && $val == 'all')){
                    unset($post[$k]);
                }
                else{
                    $cond1 .= " and `{$k}` = '{$val}'";
                }
            }
            //print_r($post);
        }

        //分页
        $sql = "select count(1) as count_orders from b_order where 1 {$cond1}";
        $res = $this->db->query($sql);
        $rs= $res->row_array();
        $data['count_orders'] = $rs['count_orders'];

        $sql = "select * from b_order where 1 {$cond1} order by {$order} limit {$limit_start}, {$rs_count}";
        //echo $sql;
        $res = $this->db->query($sql);
        $rs= $res->result_array();
        $data['orders'] = $rs;

        $cur_url =  uri_string();
        $line = !empty($param['line']) ? "line=".$param['line'] : "";
        $count = ceil($data['count_orders'] / $rs_count);

        $str = "";
        for($i = 1; $i<=$count; $i++){
            $str .= "<li><a href=\"/{$cur_url}?{$line}&start_page={$i}\">{$i}</a></li>";
        }
        $data['pagination'] = $str;
        $data['pay_status'] = $this->pay_status;
        $data['ordersc'] = $ordersc;

		$this->load->view('admin/stat', $data);
    }

    public function signup(){
        $this->session->unset_userdata('admin');
        redirect('/manage/');
    }

    public function ajax_stat($date, $date1 = null, $date2 = null){

        switch ($date){
            case 1:
                $cond = "to_days(create_time) = to_days(now())";
                break;
            case 2:
                $cond = "DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(`create_time`)";
                break;
            case 3:
                $cond = "DATE_SUB(CURDATE(), INTERVAL 1 MONTH) <= date(`create_time`)";
                break;
            case 4:
                $cond = "date(`create_time`) >= '{$date1}' and date(`create_time`) <= '{$date2}'";
                break;
        }
        $sql = "select * from customer where {$cond}";
        $res = $this->db->query($sql);
        $rs= $res->result_array();
        echo json_encode($rs);
    }
    
    /**
     * 统计
     */
    public function ajax_total()
    {
    	if($this->input->post('op') != "total") show_404();
    	$day = $this->input->post('day');
    	$return = array();
    	$daytime = strtotime(date('Y-m-d',time()));
    	switch ($day){
    		case "Today":
    			$dtime = $daytime;
    			break;
    		case "Week":
    			$dtime = strtotime(date('Y-m-d',time()));
    			//周日是0，-1来计算天数
    			$z = (date("w",time())) ? date("w",time())-1 : 6;
    			$dtime = $daytime - ($z*24*60*60);
    			break;
    		case "Month":
    			$z = date("d",time())-1;
    			$dtime = $daytime - ($z*24*60*60);
    			break;
    	}
    	$return['station_num'] = $this->bm->get_station_num(array('datetime >=' => $dtime));
    	$return['customers_num'] = $this->bm->get_customers_num(array('datetime >=' => $dtime));
    	$return['orders_num'] = $this->bm->get_orders_num(array('send_time >=' => $dtime));
    	$prices = $this->bm->get_total_income(array('send_time >=' => $dtime));
    	$return['total_price'] = $prices[0]["price"];
    	$return['code'] = "A00006";
    	echo json_encode($return);
    }
    public function lines(){
        $data['lines'] = $this->bm->get_lines();
		$this->load->view('admin/lines', $data);
    }

    public function line($line_id = 0){
        $free_facility = $this->config->item('free_facility');
        $data['free_facility'] = $free_facility;
        $data['line_id'] = intval($line_id);
        $data['line'] = $this->bm->get_line_by_id($data['line_id']);
		$this->load->view('admin/line', $data);
    }

    public function add_line(){
        $data['name'] = $this->input->post('name');
        $data['is_need_tran'] = $this->input->post('is_need_tran');
        $data['price'] = $this->input->post('price');
        $data['mail'] = $this->input->post('mail');
        $data['free_facility'] = serialize($this->input->post('facility'));
        $data['total_tickets'] = $this->input->post('total_tickets');
        $is_addstation = $this->input->post('is_addstation');
        $line_id = intval($this->input->post('line_id'));

        if($line_id == 0)
            $lid = $this->bm->add_line($data);
        else{
            $this->bm->update_line($data, $line_id);
            $lid = $line_id;
        }
        if($is_addstation){
            header("Location:/manage/add_station/{$lid}");
            exit;
        }
        header("Location:/manage/lines");
    }

    function add_station($line_id){
        $lid = intval($line_id);
        $line = $this->bm->get_line_by_id($lid);
        $data['stations'] = $this->bm->get_station_by_line_id($lid);
        $sql = "select max(orderno) as max_orderno from station where line_id={$lid}";
        $res = $this->db->query($sql);
        $rs= $res->row_array();
        $data['max_orderno'] = $rs['max_orderno'] + 1;
        $data['line_name'] = $line['name'];
        $data['lid'] = $lid;
		$this->load->view('admin/add_station', $data);
    }

    function modi_station($sid, $line_id){
        $data = $this->bm->get_station_by_id($sid);
        //debug($data);
		$this->load->view('admin/modi_station', $data);
    }

    function do_add_station(){
        $isupd = $this->input->post('isupd');
        $data['name'] = $this->input->post('name');
        $data['orderno'] = $this->input->post('orderno');
        $data['line_id'] = $this->input->post('line_id');
        $data['is_transfer_station'] = $this->input->post('is_transfer_station');
        $sid = $this->input->post('sid');
        if($isupd){
            $this->bm->update_station($data, $sid);
        }
        else{
            $this->bm->add_station($data);
        }
    }

    function update_orderno($lid){
        $ordernos = $this->input->post("ordernos");
        $ids = $this->input->post("ids");

        foreach($ids as $key => $val){
            $data['orderno'] = $ordernos[$key];
            $this->bm->update_station($data, $val);
        }

        redirect('/manage/add_station/'.$lid);

    }

    function order_stat($type= 3, $date1 = null, $date2 = null){
        $param = $_GET;

        $data['stations'] = $this->bm->get_station();


        $start_page = (!empty($param['start_page'])) ? $param['start_page'] : "1";
        //echo $start_page;
        $rs_count = 10;
        $limit_start = ($start_page - 1) * $rs_count;

        $order = ($order = $this->input->post("order")) ? $order : "is_pay";
        $ordersc = ($ordersc = $this->input->post("ordersc")) ? $ordersc : "desc";
        
        $order = $order . " ". $ordersc;

        $data['station'] = $this->bm->get_station(false);
        $data['customers'] = $this->bm->get_customers();
        $data['lines'] = $this->bm->get_lines();

        switch ($type){
            case 1:
                $cond = "and to_days(create_time) = to_days(now())";
                break;
            case 2:
                $cond = "and DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(`create_time`)";
                break;
            case 3:
                $cond = "and DATE_SUB(CURDATE(), INTERVAL 1 MONTH) <= date(`create_time`)";
                break;
            case 4:
                $cond = "and date(`create_time`) >= '{$date1}' and date(`create_time`) <= '{$date2}'";
                break;
        }

        $line = $this->input->get('line');
        $sline = $this->session->userdata('lid');
        if($line != 0){
            $line_id = intval($this->input->get('line'));
            $this->session->set_userdata('lid', $line_id);
            $cond1 = $cond . " and line_id={$line_id}";
            $data['line_id'] = $line_id;
        }
        else if($line == 0){
            $cond1 = $cond;
            $data['line_id'] = 0;
        }
        else if(!empty($sline)){
            $line_id = $this->session->userdata('lid');
            $cond1 = $cond . " and line_id={$line_id}";
            $data['line_id'] = $line_id;
        }
        else{
            ;
        }

        $post = $this->input->post();

        if($post){
            $cond = $cond1 = "";
            foreach($post as $k => $val){
                if(empty($val)){
                    unset($post[$k]);
                }

                if($k == 'is_pay' && $val == 'all'){
                    unset($post[$k]);
                }
            }
            print_r($post);
        }

        $sql = "select count(1) as count_orders from b_order where 1 {$cond1}";
        $res = $this->db->query($sql);
        $rs= $res->row_array();
        $data['count_orders'] = $rs['count_orders'];

        $sql = "select * from b_order where 1 {$cond1} order by {$order} limit {$limit_start}, {$rs_count}";
        //echo $sql;
        $res = $this->db->query($sql);
        $rs= $res->result_array();
        $data['orders'] = $rs;


        $sql = "select sum(`pay_price`) as price from b_order where is_pay = 1 {$cond1}";
        $res = $this->db->query($sql);
        $rs= $res->row_array();
        $data['total_income'] = $rs['price'];

        $sql = "select sum(`pay_price`) as price from b_order where is_pay = 0 {$cond1}";
        $res = $this->db->query($sql);
        $rs= $res->row_array();
        $data['not_pay'] = $rs['price'];

        $sql = "select count(1) as customer from customer where 1 {$cond}";
        $res = $this->db->query($sql);
        $rs= $res->row_array();
        $data['customer'] = $rs['customer'];
        $data['type'] = $type;

        $cur_url =  uri_string();
        $line = !empty($param['line']) ? "line=".$param['line'] : "";
        $count = ceil($data['count_orders'] / $rs_count);
        //$str = "<li><a href=\"/{$cur_url}?{$line}&start_page=0\">Prev</a></li>";
        $str = "";
        for($i = 1; $i<=$count; $i++){
            $str .= "<li><a href=\"/{$cur_url}?{$line}&start_page={$i}\">{$i}</a></li>";
        }
        $data['pagination'] = $str;
        $data['pay_status'] = $this->pay_status;
        $data['ordersc'] = $ordersc;

		$this->load->view('admin/stat', $data);

    }

    function stat()
    {
        $param = $this->input->get();
        $data['stations'] = $this->bm->get_station();

        $start_page = (!empty($param['start_page'])) ? $param['start_page'] : "1";
        //echo $start_page;
        $rs_count = 10;
        $limit_start = ($start_page - 1) * $rs_count;

        $order = ($order = $this->input->post("order")) ? $order : "departing_date";
        $ordersc = ($ordersc = $this->input->post("ordersc")) ? $ordersc : "desc";
        
        $order = $order . " ". $ordersc;

        $data['station'] = $this->bm->get_station(false);
        $data['customers'] = $this->bm->get_customers();

        $get = $this->input->post();
        unset($param['start_page']);

        $current_url = $_SERVER["QUERY_STRING"];

        if($start_page){
            $current_url = preg_replace('|&start_page=(\d+)|', '', $current_url);
        }

        if($param){
            unset($param['order']);
            unset($param['ordersc']);
            foreach($param as $k => $val){
                if($k == 'is_pay' && $val != 'all'){
                    $cond1 .= " and `{$k}` = '{$val}'";
                    continue;
                }

                if($k == 'date' && $val == 'month'){
                    $cond1 .= " and date_format(create_time,'%Y-%m')=date_format(now(),'%Y-%m')";
                    continue;
                }

                if($k == 'date' && $val == 'lmonth'){
                    $cond1 .= " and DATE_SUB(CURDATE(), INTERVAL 1 MONTH) <= date(`create_time`)";
                    continue;
                }

                if(empty($val) or ($k == 'is_pay' && $val == 'all')){
                    unset($post[$k]);
                }
                else{
                    $cond1 .= " and `{$k}` = '{$val}'";
                }
            }
            //print_r($post);
        }

        //分页
        $sql = "select count(1) as count_orders from b_order where 1 {$cond1}";
        $res = $this->db->query($sql);
        $rs= $res->row_array();
        $data['count_orders'] = $rs['count_orders'];
    
        $sql = "select * from b_order where 1 {$cond1} order by {$order} limit {$limit_start}, {$rs_count}";
        $res = $this->db->query($sql);
        $rs= $res->result_array();
        $data['orders'] = $rs;

        $cur_url =  uri_string();
        $line = !empty($param['line']) ? "line=".$param['line'] : "";
        $count = ceil($data['count_orders'] / $rs_count);

        $str = "";
        for($i = 1; $i<=$count; $i++){
            $active = ($start_page == $i) ? ' class="active"' : ''; 
            $str .= "<li {$active}><a href=\"/{$cur_url}?{$current_url}&start_page={$i}\">{$i}</a></li>";
        }
        $data['pagination'] = $str;
        $data['pay_status'] = $this->pay_status;
        $data['ordersc'] = $ordersc;

		$this->load->view('admin/stat', $data);
    }

    function Report(){
        $tran_line = $this->bm->get_tran_line_id();
        $sconfig = $this->bm->get_siteinfo();
        $tran_line_price = $sconfig['transfer_price'];
        $commission = $sconfig['commission'];

        $param = $this->input->get();
        $data['stations'] = $this->bm->get_station();
        $data['lines'] = $this->bm->get_lines();

        $start_page = (!empty($param['start_page'])) ? $param['start_page'] : "1";
        //echo $start_page;
        $rs_count = 20;
        $limit_start = ($start_page - 1) * $rs_count;

        $order = ($order = $this->input->post("order")) ? $order : "departing_date";
        $ordersc = ($ordersc = $this->input->post("ordersc")) ? $ordersc : "desc";
        
        $order = $order . " ". $ordersc;

        $data['station'] = $this->bm->get_station(false);
        $data['customers'] = $this->bm->get_customers();

        $get = $this->input->post();
        unset($param['start_page']);

        $current_url = $_SERVER["QUERY_STRING"];

        if($start_page){
            $current_url = preg_replace('|&start_page=(\d+)|', '', $current_url);
        }

        if($param){
            unset($param['order']);
            unset($param['ordersc']);
            foreach($param as $k => $val){
                if($k == 'is_pay' && $val != 'all'){
                    $cond1 .= " and `{$k}` = '{$val}'";
                    continue;
                }

                if($k == 'line_id' && $val){
                    $cond1 .= " and (line_id = '{$val}' or line_id like '%|{$val}' or line_id like '{$val}|%')";
                    continue;
                }

                if($k == 'date' && $val == 'month'){
                    $cond1 .= " and date_format(create_time,'%Y-%m')=date_format(now(),'%Y-%m')";
                    continue;
                }

                if($k == 'date' && $val == 'lmonth'){
                    $cond1 .= " and DATE_SUB(CURDATE(), INTERVAL 1 MONTH) <= date(`create_time`)";
                    continue;
                }

                if(empty($val) or ($k == 'is_pay' && $val == 'all')){
                    unset($post[$k]);
                }
                else{
                    $cond1 .= " and `{$k}` = '{$val}'";
                }
            }
            //print_r($post);
        }

        //echo $cond1;

        //分页
        $sql = "select count(1) as count_orders from b_order where is_pay=1 {$cond1}";
        $res = $this->db->query($sql);
        $rs= $res->row_array();
        $data['count_orders'] = $rs['count_orders'];

        $sql = "select * from b_order where is_pay=1 {$cond1}";
        $res = $this->db->query($sql);
        $rs= $res->result_array();

        $total = 0;
        //非换乘线路
        if($param['line_id'] != $tran_line){
            foreach($rs as $val){
                $lines = explode('|', $val['line_id']);

                //不需换乘
                if(!in_array($tran_line, $lines)){
                    $total += $val['pay_price'];
                }
                else{
                    //换乘线路价格*人数
                    $payprice = $val['quantity'] * $tran_line_price;

                    //如果往返再乘2
                    if($val['return_date']){
                        $payprice = $payprice * 2;
                    }

                    $payprice = $val['pay_price'] - $payprice;
                    
                    $total += $payprice; 
                }
            }
        }
        else
        {
            //换乘线路的话都一样计费,比如24|13，但实际我们只算13这个线路的价格
            foreach($rs as $val){
                //换乘线路价格*人数
                $payprice = $val['quantity'] * $tran_line_price;

                //如果往返再乘2
                if($val['return_date']){
                    $payprice = $payprice * 2;
                }

                $total += $payprice; 
            }
        }

        $data['total'] = $total; 
        $data['commission'] = $total * $commission;
        $sql = "select * from b_order where is_pay=1 {$cond1} order by {$order} limit {$limit_start}, {$rs_count}";
        $res = $this->db->query($sql);
        $rs= $res->result_array();
        $data['orders'] = $rs;
        $data['param'] = $param;

        $cur_url =  uri_string();
        $line = !empty($param['line']) ? "line=".$param['line'] : "";
        $count = ceil($data['count_orders'] / $rs_count);

        $str = "";
        for($i = 1; $i<=$count; $i++){
            $active = ($start_page == $i) ? ' class="active"' : ''; 
            $str .= "<li {$active}><a href=\"/{$cur_url}?{$current_url}&start_page={$i}\">{$i}</a></li>";
        }
        $data['pagination'] = $str;
        $data['pay_status'] = $this->pay_status;
        $data['ordersc'] = $ordersc;

		$this->load->view('admin/detailReport', $data);
    }

    //订单详细信息
    function getTransaction(){
        $id = $this->input->post('dataid');
        //$id = 32;
        $station = $this->bm->get_station(false);
        $customers = $this->bm->get_customers();

        $sql = "select * from b_order where id={$id}";
        $res = $this->db->query($sql);
        $rs= $res->row();

        $onbus = $this->bm->get_route_by_rid($rs->depart_on_bus);
        $offbus = $this->bm->get_route_by_rid($rs->depart_off_bus);

        $trip_type = ($rs->return_on_bus) ? "Round Trip" : "One Way";

        $list = "<table class=\"table\"><tr><td style=\"width:300px;\">Confirmation Number: {$rs->o_number}</td><td>{$trip_type}</td></tr>";
        $list .= "<tr><td>from station: {$station[$rs->from_station_id]}</td><td>to station: {$station[$rs->to_station_id]}</td></tr>";
        $list .= "<tr><td>depart on bus: {$onbus['address']}</td><td>depart off bus: {$offbus['address']}</td></tr>";

        if($rs->return_on_bus){
            $ronbus = $this->bm->get_route_by_rid($rs->return_on_bus);
            $roffbus = $this->bm->get_route_by_rid($rs->return_off_bus);
            $list .= "<tr><td>return on bus: {$ronbus['address']}</td><td>return off bus: {$roffbus['address']}</td></tr>";
        }

        $list .= "<tr><td>name:{$customers[$rs->customer_id]['first-name']} - {$customers[$rs->customer_id]['last-name']}</td><td>pay status:{$this->pay_status[$rs->is_pay]}</td></tr>";
        $list .= "<tr><td>quantity:{$rs->quantity}</td><td>sum price:{$rs->pay_price}</td></tr>";
        $list .= "<tr><td>departing date:{$rs->departing_date}</td><td>departing time:{$rs->departing_time}</td></tr>";
        $list .= "<tr><td>return date:{$rs->return_date}</td><td>return time:{$rs->return_time}</td></tr>";
        //$list .= "<tr><td>depart on bus:{$rs->depart_on_bus}</td><td>depart off bus:{$rs->depart_off_bus}</td></tr>";
        $list .= "<tr><td>create_time:{$rs->create_time}</td><td>transaction_id:{$rs->transaction_id}</td></tr>";
        $list .= "<tr><td colspan=2>******Customer Info******</td></tr>";
        $list .= "<tr><td colspan=2>first name:{$customers[$rs->customer_id]['first-name']}, last-name:{$customers[$rs->customer_id]['last-name']}</td></tr>";
        $list .= "<tr><td>email:{$customers[$rs->customer_id]['email']}</td><td>tel:{$customers[$rs->customer_id]['tel']}</td></tr>";
        $list .= "<tr><td colspan=2>address:{$customers[$rs->customer_id]['country']},{$customers[$rs->customer_id]['state']},{$customers[$rs->customer_id]['city']},{$customers[$rs->customer_id]['address']},{$customers[$rs->customer_id]['address2']}</td></tr>";
        $list .= "<tr><td colspan=2>zipcode:{$customers[$rs->customer_id]['zipcode']}</td></tr>";

        echo $list."</table>";
    }

    function set_lang(){
        $lang = $this->input->post('lang');
        $this->session->set_userdata('lang', $lang);
        echo $lang;
    }

    function modi_route(){
        $data = $_POST;
        $id = $_POST["id"];
        array_shift($data);

        $this->bm->update_route($data, $id);
        echo "ok";
    }

    function add_route($station_id, $line_id){
        $sid = intval($station_id);
        $lid = intval($line_id);
        $data['routes'] = $this->bm->get_route_by_id($sid, $lid);
        $data['station'] = $this->bm->get_station_by_id($sid);
        $data['sid'] = $sid;
        $data['lid'] = $lid;
		$this->load->view('admin/add_route', $data);
    }

    public function do_add_route(){
        $data['route'] = $_POST;
        $data['sid'] = $_POST['station_id'];
        $data['lid'] = $_POST['line_id'];

        $this->bm->add_route($data['route']);
        header("Location:/manage/add_route/{$data['sid']}/{$data['lid']}");

		$this->load->view('admin/add_route', $data);
    }

    function get_combination_station($stations){

        for($i = 0; $i<count($stations) - 1; $i++){
            $newStation[] = array('from_station' => $stations[$i],'to_station' => $stations[$i+1]);
        }
        
    }

    function set_price($line_id){
        $line_id = intval($line_id);
        $line = $this->bm->get_line_by_id($line_id);
        $stations = $this->bm->get_station_by_line_id($line_id);

        if($line_id != 13 && $line['is_need_tran']){
            //换乘线路不能再与自己合并
            $tran_stations = $this->bm->get_station_by_line_id(13, 1);
        }
        else{
            $tran_stations = array();
        }

        //合并换乘线路进来，可自己设置从一条线路的一个站到换乘线路的一个站之间的票价
        $stations = array_merge($stations, $tran_stations);

        $newStation = array();
        //原有往返票价相同的逻辑
        /*
        for($j = 0; $j<count($stations); $j++){
            for($i = $j; $i<count($stations) - 1; $i++){
                $cond = " and (from_station_id = {$stations[$j]['id']} and to_station_id = {$stations[$i+1]['id']} ) and line_id={$line_id}";
                $row = $this->bm->get_price_by_condition($cond);
                if(!empty($row))
                    $newStation[] = array('from_station' => $stations[$j], 'to_station' => $stations[$i+1], 'price' => $row['price']);
                else
                    $newStation[] = array('from_station' => $stations[$j], 'to_station' => $stations[$i+1], 'price' => '');
                    
            }
        }
         */

        //往返分别计算了
        for($j = 0; $j<count($stations); $j++){
            for($i = 0; $i<count($stations); $i++){
                if($stations[$j]['id'] == $stations[$i]['id']) continue;
                $cond = " and (from_station_id = {$stations[$j]['id']} and to_station_id = {$stations[$i]['id']} ) and line_id={$line_id}";
                $row = $this->bm->get_price_by_condition($cond);
                if(!empty($row))
                    $newStation[] = array('from_station' => $stations[$j], 'to_station' => $stations[$i], 'price' => $row['price'], 'discount' => $row['discount'], 'is_allow_return' => $row['is_allow_return']);
                else
                    $newStation[] = array('from_station' => $stations[$j], 'to_station' => $stations[$i], 'price' => '', 'discount' => '');
                    
            }
        }

        $data['stations'] = $newStation;
        $data['line'] = $line;
		$this->load->view('admin/set_price', $data);
    }

    function do_add_price(){
        $line_id = intval($this->input->post('line_id'));
        for($i = 0; $i<count($_POST['from_station']); $i++){
            $data['from_station_id'] = $_POST['from_station'][$i];
            $data['to_station_id'] = $_POST['to_station'][$i];
            $data['price'] = $_POST['price'][$i];
            $data['discount'] = $_POST['discount'][$i];
            $data['is_allow_return'] = $_POST['is_allow_return'][$i];
            $data['line_id'] = $line_id;
            //鏌ョ湅琛ㄩ噷鏄惁宸茬粡鏈夋璁板綍,濡傛灉鏈�,鐩存帴杈撳叆浠锋牸
            $cond = " and (from_station_id = {$data['from_station_id']} and to_station_id = {$data['to_station_id']} ) and line_id={$line_id}";
            $row = $this->bm->get_price_by_condition($cond);
            if(!empty($row)){
                $this->bm->update_price_by_condition($cond, $data['price'], $data['discount'],$data['is_allow_return']);   
            }
            else
                $this->bm->add_price($data);
        }
        echo '<script>alert("add sucess!");window.location.href="/manage/lines/'.$line_id.'"</script>';
    }


    //鍒犻櫎line,鍚屾椂鍒犻櫎line涓嬬殑鎵�鏈塻tation/stops/ticket_price
    function del_line($line_id){
        $line_id = intval($line_id);
        $this->bm->del_line($line_id);
        $this->bm->del_station_by_line_id($line_id);
        $this->bm->del_route_by_line_id($line_id);
        $this->bm->del_ticket_price_by_line_id($line_id);
        echo "ok";
    }

    //鍒犻櫎station,鍚屾椂鍒犻櫎stops/ticket_price
    function del_station($line_id, $station_id){
        $line_id = intval($line_id);
        $station_id = intval($station_id);
        $this->bm->del_station_by_id($station_id);
        $this->bm->del_route_by_line_station_id($line_id, $station_id);
        $this->bm->del_ticket_price_by_station_id($station_id);
        echo "ok";
    }

    //鍒犻櫎route
    function del_route($route_id){
        $this->bm->del_route_by_id($route_id);
        echo "ok";
    }
    
    public function user()
    {
        $data['roles'] = $this->config->item('role');
    	$data['users'] = $this->bm->get_users();
    	$this->load->view("admin/user_lins", $data);
    }
    
    public function add_user()
    {
    	if($this->input->post('sub')){
    		$data['username'] = $this->input->post('username');
    		$data['password'] = $this->input->post('password');
    		$data['tel'] = $this->input->post('tel');
    		$data['role'] = $this->input->post('role');
    		$data['linkname'] = $this->input->post('linkname');
    		$data['group'] = 1;
    		$data['create_time'] = time();
    		if($this->bm->save_user($data)){
    			redirect('/manage/user');
    		}
    	}else{
    		$data['url'] = "add_user";
    		$data['title'] = lang('add_user');
    		$this->load->view("admin/add_user", $data);
    	}
    }
    
	public function edit_user($id = null)
    {
    	if($this->input->post('sub')){
    		$data['username'] = $this->input->post('username');
            //echo md5($this->input->post('password'));
    		if(($pass = $this->input->post('password')) != $this->input->post('password_chenk')){
    			$data['password'] = md5($pass);
    		}
    		$data['role'] = $this->input->post('role');
    		$data['tel'] = $this->input->post('tel');
    		$data['linkname'] = $this->input->post('linkname');
    		$id = $this->input->post('id');
    		if($this->bm->edit_user($id, $data)){
    			redirect('/manage/user');
    		}
    	}else{
    		$data['url'] = "edit_user";
    		$data['title'] = lang('edit_user');
    		$data['users'] = $this->bm->get_users(array("id" => $id));
    		$this->load->view("admin/add_user", $data);
    	}
    }
    
    public function username_check()
    {
    	if($this->input->post('sub')) show_404();
    	$username = $this->input->post('username');
    	if(!$this->bm->get_users(array('username' => $username)))
    		echo "ok";
    }
    
    public function del_user($id)
    {
    	if($this->bm->del_user($id))
    		redirect('/manage/user');
    }

    //站点配置
    function config(){
        $data = $this->bm->get_siteinfo();
        $images = explode(",", $data['images']);
        $data['images'] = $images;
        $this->load->view("admin/config", $data);
    }

    function do_site_config(){
        $data = $_POST;

        foreach($data['images'] as $val){
            if($val){
                $images .= $val.",";
            }
        }
        $images = rtrim($images, ",");

        $data['images'] = $images;
        $data = $this->bm->update_siteinfo($data);
        redirect('/manage/config');
    }

    function upload(){
        $this->load->library('UploadHandler');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

