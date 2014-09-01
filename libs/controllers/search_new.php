<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*=============================================================================
#     FileName: search.php
#         Desc: 前台控制类,基本逻辑都在这里 
#               2014-04-17修改逻辑,换乘线路问题重新计算,如果用户换乘，需要在order里分别插入
#       Author: RainYang
#        Email: rainyang2012@qq.com
#     HomePage: http://www.v-dian.com
#      Version: 0.0.1
#   LastChange: 2014-01-29 19:47:42
#      History:
=============================================================================*/

class Search extends CI_Controller {

    /*
    private $api_login_id = '7x5PAs35';
    private $transaction_key = '84L84T83MWrmg5vX';
    private $md5_setting = 'yangyu'; // Your MD5 Setting
    */

    //回答问题:CHICAGO
    private $api_login_id = '9AbzzGM35X';
    private $transaction_key = '2Tm7bWhM2b7765fX';
    private $md5_setting = 'akai'; // Your MD5 Setting
    private $host = 'http://www.akaiticket.com'; // Your MD5 Setting
    private $isTestMode = 0;

    public function __construct(){
        parent::__construct();
        $this->load->model('bus_model', 'bm');
    }

	public function leaving()
    {
        $q = $this->input->post('name');
        $rs = $this->bm->get_station_by_name($q);
        if($rs){
            echo json_encode($rs);
        }
        else{
            echo "no";
        }
	}

    private function calOddTickets($fromid, $toid, $departdate, $returndate){
        //计算票数
        $sql = "SELECT count(1) as ds FROM `b_order` WHERE (`from_station_id`={$fromid} and `to_station_id` = {$toid} and `departing_date` = '{$departdate}') and is_pay = 1 and only_tran = 0";
        $query = $this->db->query($sql);
        $depart_tickets = $query->row_array();

        //返程是否邮票
        $sql = "SELECT count(1) as ds FROM `b_order` WHERE (`from_station_id`={$toid} and `to_station_id` = {$fromid} and `return_date` = '{$return_date}') and is_pay = 1 and only_tran = 0";
        $query = $this->db->query($sql);
        $return_tickets = $query->row_array(); 
        $odd_tickets['depart_tickets'] = $depart_tickets['ds'];
        $odd_tickets['return_tickets'] = $return_tickets['ds'];
        return $odd_tickets; 

    }

    //根据用户选择的出发和到达站点查询经过的所有站,为了看是否有换乘的情况
    private function get_stations_by_section($from_ordreno, $to_orderno, $line_id){
        $sql = "select * from station where line_id = {$line_id} and orderno>= {$from_orderno} and orderno<={$to_orderno} order by orderno";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    private function get_tran_station_by_lineid($line_id){
        $sql = "select s.name,s.id as sid, r.departing_time, r.return_time, r.time_zone, r.address from station s inner join routeinfo as r on s.id = r.station_id and s.line_id = r.line_id where s.line_id = {$line_id} and s.is_transfer_station = 1";
        $query = $this->db->query($sql);
        $rs = $query->result_array();
        return $rs[0];
    }

    public function tlist()
    {
        $data['user'] = $this->session->userdata('user');
        extract($_GET);

        //免费设施
        $free_facility = $this->config->item('free_facility');

        $data['sinfo'] = $_GET;


        //思路：
        //Step 1: 根据名称找到所有可行线路(from_station 和 to_station在同一条线路上),换乘根据from或toid去查看数据库字段，是否需要换乘
        //如fromid或toid有一个需要换乘，并且不是换乘站，那么就需要换车了，多出一张票

        //Step 2: 根据station_id和line_id去route表里找时间,时间根据orderno判定取depart time还是return_time,
        //Step 3: 根据ticket_price表取价格,(from_station_id = from_station_id and to_station_id = tid) or (from_id = tid and tid=fid)...
        //Step 4: 组合列表
        $sql = "select s.*,t.name as to_name,t.id as to_id,t.orderno as to_orderno,t.is_transfer as to_transfer,t.is_transfer_station as to_transfer_station, t.transfer_line as to_transfer_line from station as s inner join (select * from station where name='{$return_city}') as t on s.line_id=t.line_id where s.name='{$depart_city}'";
        $query = $this->db->query($sql);
        $res = $query->result_array();

        do{
            //如果同一线路没找到,查看是否可能是从一条线路导到另一线路去了,分别查看线路
            if(!$res){
                $sql = "select l.is_transfer as st,s.* from station as s inner join line as l on s.line_id = l.id where (s.name = '{$return_city}' or s.name='{$depart_city}') limit 2";
                $query = $this->db->query($sql);
                $ts = $query->result_array();

                //如果也没找到，跳出处理，提示没有找到可行的线路
                if(!$ts){
                    break;
                }

                $depart_is_has_ticket = true;
                $return_is_has_ticket = true;

                foreach($ts as $k => $v){
                    //取每一线路总票数
                    $line = $this->bm->get_line_by_id($v['line_id']);
                    $v['tickets'] = $line['total_tickets'];

                    //确定出发及到达地点
                    if($v['name'] == $return_city){
                        $routeinfo['tocity'] = $v;
                    }
                    else{
                        $routeinfo['fromcity'] = $v;
                        $vfree_facility = unserialize($line['free_facility']);
                    }
                }

                //fromcity在前，显示票的时候才能是按顺序的
                ksort($routeinfo);

                if($this->isTestMode){
                    echo "<pre>";
                    print_r($routeinfo);
                    echo "</pre>";
                }

                //此部分主要是计算票价，如果需要换乘的，从出发到换乘站的票价+换乘站到终点的票价
                foreach($routeinfo as $key => $val){
                    //st是line表里表示是否是换乘线路
                    if($val['st'] == 0){    //如果不是单独换乘线路,那就是换乘站
                        $sql = "select id from station where line_id = {$val['line_id']} and is_transfer_station = 1";
                        $query = $this->db->query($sql);
                        $row = $query->first_row();
                        $transfer_id = $row->id;
                        $odd_tickets[$val['line_id']] = $this->calOddTickets($val['id'], $transfer_id, $depart_date, $return_date);

                        $data['schedules'][0]['depart_tickets'] = $val['tickets'] - $odd_tickets[$val['line_id']]['depart_tickets'];
                        $data['schedules'][0]['return_tickets'] = $val['tickets'] - $odd_tickets[$val['line_id']]['return_tickets'];

                        //计算票价
                        /*
                        $cond = " and line_id={$val['line_id']} and ((from_station_id = {$val['id']} and to_station_id = {$transfer_id}) or (from_station_id = {$transfer_id} and to_station_id = {$val['id']}))";
                        $prices = $this->bm->get_price_by_condition($cond);

                        if($key == 'fromcity'){
                            $lineinfo[] = array('line_id' => $val['line_id'], 'id' => $val['id'], 'to_id' => $transfer_id, 'price' => $prices['price']);
                        }
                        else{
                            $lineinfo[] = array('line_id' => $val['line_id'], 'id' => $transfer_id, 'to_id' => $val['id'], 'price' => $prices['price']);
                        }
                         */
                    }
                    else{
                        $transfer_id = 22; //Atlanta是默认的换乘站,都从这里算起,先写死，后期再改
                        $odd_tickets[$val['line_id']] = $this->calOddTickets($val['id'], $transfer_id, $depart_date, $return_date);

                        //计算票价
                        /*
                        $cond = " and line_id={$val['line_id']} and ((from_station_id = {$val['id']} and to_station_id = {$transfer_id}) or (from_station_id = {$transfer_id} and to_station_id = {$val['id']}))";
                        $prices = $this->bm->get_price_by_condition($cond);

                        if($key == 'fromcity'){
                            $lineinfo[] = array('line_id' => $val['line_id'], 'id' => $val['id'], 'to_id' => $transfer_id, 'price' => $prices['price']);
                        }
                        else{
                            $lineinfo[] = array('line_id' => $val['line_id'], 'id' => $transfer_id, 'to_id' => $val['id'], 'price' => $prices['price']);
                        }
                         */
                    }


                    //$price['price'] += $prices['price'];

                }

                //票价信息
                if($data['sinfo']['trip_type']){
                    $cond = " and (from_station_id = {$routeinfo['tocity']['id']} and to_station_id = {$routeinfo['fromcity']['id']})";
                    $rprice = $this->bm->get_price_by_condition($cond);
                    $data['schedules'][0]['return_price'] = $rprice['price'];
                    
                }
                $cond = " and (from_station_id = {$routeinfo['fromcity']['id']} and to_station_id = {$routeinfo['tocity']['id']})";
                $price = $this->bm->get_price_by_condition($cond);

                //+++++++++
                //免费设施
                $facilitys = "";
                foreach($vfree_facility as $fval){
                    $facilitys .= "<img style=\"margin-right:8px;\" src=\"/static/images/{$free_facility[$fval]}.png\" />";
                } 

                $lineinfo[] = array('line_id' => $routeinfo['fromcity']['line_id']."|".$routeinfo['tocity']['line_id'], 'id' => $routeinfo['fromcity']['id'], 'to_id' => $routeinfo['tocity']['id']);
                $data['schedules'][0]['lineinfo'] = serialize($lineinfo);
                $data['schedules'][0]['price'] = $price['price'];
                $data['schedules'][0]['free_facility'] = $facilitys;
                $data['schedules'][0]['is_transfer'] = 1;
                $data['schedules'][0]['tran_line_id'] = 13; //todo,后期修改

                //from_station
                $from_route = $this->bm->get_route_by_id($routeinfo['fromcity']['id'], $routeinfo['fromcity']['line_id']);
                $to_route = $this->bm->get_route_by_id($routeinfo['tocity']['id'], $routeinfo['tocity']['line_id']);

                //出发站时间大于到达站时间,出发时间取renturn_time,等于返程
                if($from_route[0]['orderno'] > $to_route[0]['orderno']){
                    $data['schedules'][0]['order'] = 'desc';
                    $data['schedules'][0]['departing_time'] = $from_route[0]['return_time'];
                    $data['schedules'][0]['arriving_time'] = $to_route[0]['return_time'];
                    $data['schedules'][0]['r_departing_time'] = $to_route[0]['departing_time'];
                    $data['schedules'][0]['r_arriving_time'] = $from_route[0]['departing_time'];
                }
                else{
                    $data['schedules'][0]['order'] = 'asc';
                    $data['schedules'][0]['departing_time'] = $from_route[0]['departing_time'];
                    $data['schedules'][0]['arriving_time'] = $to_route[0]['departing_time'];
                    $data['schedules'][0]['r_departing_time'] = $from_route[0]['return_time'];
                    $data['schedules'][0]['r_arriving_time'] = $to_route[0]['return_time'];
                }

                $data['schedules'][0]['from_route'] = $from_route;
                $data['schedules'][0]['to_route'] = $to_route;
                
                break;
            }
            /*echo "<pre>";*/
            //print_r($res);
            /*echo "</pre>";*/
             
            //可能有多条线路可选
            foreach($res as $key => $val){
                //票价信息
                if($data['sinfo']['trip_type']){
                    $cond = " and line_id={$val['line_id']} and (from_station_id = {$val['to_id']} and to_station_id = {$val['id']})";
                    $rprice = $this->bm->get_price_by_condition($cond);
                    $data['schedules'][$key]['return_price'] = $rprice['price'];
                    
                }
                $cond = " and line_id={$val['line_id']} and (from_station_id = {$val['id']} and to_station_id = {$val['to_id']})";
                $price = $this->bm->get_price_by_condition($cond);

                //$sumprice = $rprice['price'] + $price['price'];

                $data['schedules'][$key]['lineinfo'] = serialize(array(array('line_id' => $val['line_id'], 'id' => $val['id'], 'to_id' => $val['to_id'])));
                /*
                //是否需要换乘
                if( ($val['is_transfer'] == 1 && $val['is_transfer_station'] != 1) 
                    or ($val['to_transfer'] == 1 && $val['to_transfer_station'] != 1) ){
                    $data['schedules'][$key]['is_transfer'] = 1;
                }

                //如果两个都是换乘线路的,实际上就不需要乘坐当前线路了，是另一台车
                if( ($val['is_transfer'] == 1 && $val['to_transfer'] == 1) ){
                    $data['schedules'][$key]['is_transfer'] = 1;
                    $data['schedules'][$key]['only_tran'] = 1;
                }

                $tran_line_id = ($val['transfer_line']) ? $val['transfer_line'] : $val['to_transfer_line'];
                $data['schedules'][$key]['tran_line_id'] = $tran_line_id;
                 */

                /*
                echo "<pre>";
                print_r($price);
                echo "</pre>";
                */

                //总票数
                //票数是根据b_order里的线路计算出来的
                $line = $this->bm->get_line_by_id($val['line_id']);
                $vfree_facility = unserialize($line['free_facility']);
                $tickets = $line['total_tickets'];

                //$data['schedules'][$key]['price'] = $line['price'];
                $data['schedules'][$key]['price'] = $price['price'];
                $data['schedules'][$key]['is_return_free'] = $line['is_return_free'];

                //免费设施
                $facilitys = "";
                foreach($vfree_facility as $fval){
                    $facilitys .= "<img style=\"margin-right:8px;\" src=\"/static/images/{$free_facility[$fval]}.png\" />";
                } 
                $data['schedules'][$key]['free_facility'] = $facilitys;

                //单程是否有票,根据出发日期和返程日期确定票数
                $odd_tickets = $this->calOddTickets($val['id'], $val['to_id'], $depart_date, $return_date);

                /*
                //需要换乘
                if($data['schedules'][$key]['is_transfer']){
                    //换乘线路总票数
                    $tranline = $this->bm->get_line_by_id($tran_line_id);
                    $tran_tickets = $tranline['total_tickets'];

                    //单程是否有票,根据出发日期和返程日期确定票数
                    $tran_odd_tickets = $this->calOddTickets($val['id'], $val['to_id'], $depart_date, $return_date);
                    
                    //出发及返程剩余票数
                    $data['schedules'][$key]['tran_depart_tickets'] = $tran_tickets - $tran_odd_tickets['depart_tickets'];
                    $data['schedules'][$key]['tran_return_tickets'] = $tran_tickets - $tran_odd_tickets['return_tickets'];
                }
                 */

                //出发及返程剩余票数
                $data['schedules'][$key]['depart_tickets'] = $tickets - $tran_odd_tickets['depart_tickets'];
                $data['schedules'][$key]['return_tickets'] = $tickets - $tran_odd_tickets['return_tickets'];

                //from_station
                $from_route = $this->bm->get_route_by_id($val['id'], $val['line_id']);
                $to_route = $this->bm->get_route_by_id($val['to_id'], $val['line_id']);

                //出发站时间大于到达站时间,出发时间取renturn_time,等于返程
                if($from_route[0]['orderno'] > $to_route[0]['orderno']){
                    $data['schedules'][$key]['order'] = 'desc';
                    $data['schedules'][$key]['departing_time'] = $from_route[0]['return_time'];
                    $data['schedules'][$key]['arriving_time'] = $to_route[0]['return_time'];
                    $data['schedules'][$key]['r_departing_time'] = $to_route[0]['departing_time'];
                    $data['schedules'][$key]['r_arriving_time'] = $from_route[0]['departing_time'];
                }
                else{
                    $data['schedules'][$key]['order'] = 'asc';
                    $data['schedules'][$key]['departing_time'] = $from_route[0]['departing_time'];
                    $data['schedules'][$key]['arriving_time'] = $to_route[0]['departing_time'];
                    $data['schedules'][$key]['r_departing_time'] = $from_route[0]['return_time'];
                    $data['schedules'][$key]['r_arriving_time'] = $to_route[0]['return_time'];
                }

                $data['schedules'][$key]['from_route'] = $from_route;
                $data['schedules'][$key]['to_route'] = $to_route;

            }
        }while(0);
        $this->session->set_userdata('search', serialize($_GET));
        //$data['rs'] = $this->bm->get_route($line_id);
        //$data['station'] = $this->bm->get_station();
		$this->load->view('list', $data);
    }

    //提交及确认用户信息页面
    public function purchase()
    {
        $data['user'] = $this->session->userdata('user');
        //$this->session->unset_userdata('user');

        $post = $_POST;
        if($this->isTestMode){
            print_r($post);
        }
        $get = unserialize($this->session->userdata('search'));
        if(!$get){
            echo "<script>alert('session timeout,Please choose again'); window.location.href='/'</script>";
            exit;
        }
        $data['get'] = $get;
        $post['quantity'] = $get['quantity'];
        $data['post'] = $post;

        //print_r($get);
        $this->session->set_userdata('bpost', serialize($post));

        //$ids = explode('-', $post['select_line']);
        //$line = $this->bm->get_line_by_id($ids[0]);
        /*
        $ids = explode('-', $post['select_line']);
        $cond = " and line_id={$ids[0]} and ((from_station_id = {$ids[1]} and to_station_id = {$ids[2]}) or (from_station_id = {$ids[2]} and to_station_id = {$ids[1]}))";
        $from_price = $this->bm->get_price_by_condition($cond);

        if($get['trip_type'] == 1){
            $ids = explode('-', $post['select_return_line']);
            $cond = " and line_id={$ids[0]} and ((from_station_id = {$ids[1]} and to_station_id = {$ids[2]}) or (from_station_id = {$ids[2]} and to_station_id = {$ids[1]}))";
            $to_price = $this->bm->get_price_by_condition($cond);
            $data['to_price'] = $to_price['price'];
        }
         */
        //$data['from_price'] = $line['price'];
        $data['from_price'] = $post['price'];
        if($line['is_return_free'] == 1 or $get['trip_type'] == 0){
            $data['to_price'] = 0;
        }
        else{
            $data['to_price'] = $post['return_price'];
        }
        //$data['line_id'] = $line['id'];
        /*
        echo "<pre>";
        print_r($data);
        echo "</pre>";
         */
		$this->load->view('purchase', $data);
    }

    public function do_order(){
        $bpost = unserialize($this->session->userdata('bpost'));
        $s_info = unserialize($this->session->userdata('search'));
        if($this->isTestMode){
            print_r($s_info);
        }
        if(!$s_info){
            echo "<script>alert('session timeout,Please choose again'); window.location.href='/'</script>";
            exit;
        }

        $stops = explode('|',$bpost['stops']);
        $arr_stops = explode('|',$bpost['arr_stops']);

        //往返
        if($s_info['trip_type'] == 1){
            $return_stops = explode('|',$bpost['return-stops']);
            $return_arr_stops = explode('|',$bpost['return-arr_stops']);
            //$rids = explode('-', $bpost['select_return_line']);
        }

        $data['user'] = $this->session->userdata('user');

        $first_name = implode(',', $_POST['a-first-name']);
        $last_name = implode(',', $_POST['a-last-name']);
        array_shift($_POST);
        array_shift($_POST);
        $sum_price = $_POST['sum_price'];
        //$line_id = $_POST['line_id'];
        unset($_POST['re-email']);
        unset($_POST['sum_price']);
        unset($_POST['line_id']);
        unset($_POST['nonrefundable']);
        unset($_POST['password2']);

        if(!empty($_POST['password'])){
            $_POST['password'] = md5($_POST['password']);
        }
        $customer = $_POST;

        if(empty($data['user'])){
            $c_id = $this->bm->add_customer($customer);
            $customer['id'] = $c_id;
          
            if(!empty($customer['username'])){
                $this->session->set_userdata('user', $customer);
                //发送邮件
                $content = "Welcome you to become an Akai bus members, Your user name is {$customer['username']}";
                $subject = 'AKAI bus Register mail';
                $this->sendmail($customer, $content, $subject); 
                log_message('debug', '发送成功:'. $content . '\r\nmail to:' . $customer['email']);
            }
        }
        else{
            $c_id = $data['user']['id'];
            $username = $data['user']['username'];
            $this->bm->update_customer($c_id, $_POST);
            $data['user'] = $_POST;
            $data['user']['id'] = $c_id;
            $data['user']['username'] = $username;
            $this->session->unset_userdata('user');
            $this->session->set_userdata('user', $data['user']);
        }

        //$ids = explode('-', $bpost['select_line']);

        if(empty($c_id)){
            log_message('debug', '系统错误:客户信息未录入或超时,data[user]'. print_r($data['user'], true));
            echo "<script>alert('login timeout, please login again');history.go(-1)</script>";
            exit;
        }

        $odata['customer_id'] = $c_id;
        $odata['o_number'] = date("Ymd").$c_id. mt_rand(1,10000);
        $odata['first-name'] = $first_name;  
        $odata['last-name'] = $last_name;  
        $odata['quantity'] = $bpost['quantity'];  
        $odata['departing_date'] = $s_info['depart_date'];  
        $odata['departing_time'] = $stops[1];  
        //换乘信息
        $odata['is_transfer'] = intval($bpost['is_transfer']);
        $odata['only_tran'] = intval($bpost['only_tran']);
        $odata['tran_line'] = intval($bpost['tran_line']);
        $odata['send_site'] = 'web'; //出票地点怎么做
        $odata['barcode'] = ''; //条形码如何做
        $odata['depart_on_bus'] = $stops[0];  
        $odata['depart_off_bus'] = $arr_stops[0];  

        if($this->isTestMode){
            echo "<br>++++<br>";
            print_r(unserialize($bpost['select_line']));
        }

        foreach(unserialize($bpost['select_line']) as $key => $val){
            //如果是换乘的话,上车地点改为换乘站的上车地点
            if($key > 0){
                $ds = $this->bm->get_route_by_id($val['id'], $val['line_id']);
                $odata['depart_on_bus'] = $ds[0]['id']; 
            }
            $odata['from_station_id'] = $val['id'];
            $odata['to_station_id'] = $val['to_id'];
            $odata['seat_NO'] = mt_rand(1,100); //todo 座号怎么处理 
            $odata['send_time'] = time();
            $odata['line_id'] = $val['line_id'];
            //$odata['is_pay'] = 1;  //是否支付
            $odata['pay_price'] = $sum_price;  //总价格

            if($s_info['trip_type'] == 1){
                $odata['return_date'] = $s_info['return_date'];  
                $odata['return_time'] = $return_stops[1];  
                $odata['return_on_bus'] = $return_stops[0];  
                $odata['return_off_bus'] = $return_arr_stops[0];  
            }
            $o_id = $this->bm->add_order($odata);
        }


        //print_r($_POST);
        $data['odata'] = $odata;
        $data['o_id'] = $odata['o_number'];
        $data['customer'] = $customer;
        $data['sinfo'] = $s_info;
        $data['station'] = $this->bm->get_station();

        $this->session->set_userdata('oid', $data['o_id']);
        $this->session->set_userdata('cdata', $_POST);
    
        /*
        $content = "Confirmation Number:{$odata['o_number']}<br>first-name:{$customer['first-name']},last-name:{$customer['last-name']}<br>Departing:".$s_info['depart_city']." to ".$s_info['return_city'] . "<br> Departing Time:{$stops}";
        $this->load->library('email');
        $this->email->from('1315068148@qq.com','杨雨');
        $this->email->to($customer['email'],$customer['first-name'] . "-" . $customer['last-name']);
        $this->email->subject('AKAI Bus Tickets Info');
        $this->email->message($content);
        if (!$this->email->send()){
            //echo '发送邮件失败!';//这个地方可以加些跳转效果
        }
		$this->load->view('complete', $data);
         */

        header("Location:/search/payment");
    }

    //支付界面
    public function payment(){
        $data['user'] = $this->session->userdata('user');
        $data['o_id'] = $this->session->userdata('oid');
        $o_id = $data['o_id'];
        $oprice = $this->bm->getTotalPrice($o_id);
        require_once 'AuthorizeNet.php'; // The SDK
        //$url = "http://218.29.188.212:8009/search/relay";
        //$url = "http://www.duyeye.com/search/relay";
        $url = $this->host . "/search/relay";

        $amount = $oprice;
        //$amount = "1.00";

        $data['html'] = AuthorizeNetDPM::directPostDemo($o_id, $url, $this->api_login_id, $this->transaction_key, $amount, $this->md5_setting, $data);
		$this->load->view('payment', $data);
    }

    //回调,从authorizeNet返回
    public function relay(){
        require_once 'AuthorizeNet.php'; // The SDK
        //$redirect_url = 'http://218.29.188.212:8009/search/complete';
        //$redirect_url = 'http://www.duyeye.com/search/complete';
        $redirect_url = $this->host . '/search/complete';
        $response = new AuthorizeNetSIM($this->api_login_id, $this->md5_setting);
        if ($response->isAuthorizeNet())
        {
            if ($response->approved)
            {
                $this->do_complete($response);
                //file_put_contents('log/ok_response_'.$response->response['x_order'].'.txt', print_r($response, true));
                $redirect_url .= '?response_code=1&transaction_id=' .$response->transaction_id;
            }
            else
            {
                //file_put_contents('log/response_'.$response->response['x_order'].'.txt', print_r($response, true));
                $redirect_url .= '?x_response_reason_code='.$response->response['x_response_reason_code'].'&response_code='.$response->response_code . '&response_reason_text=' . $response->response_reason_text;
            }
            echo AuthorizeNetDPM::getRelayResponseSnippet($redirect_url);
        }
        else
        {
            echo "Error. Check your MD5 Setting.";
        }
    }

    //支付完成处理逻辑1,主要是增加session验证并更新order状态
    private function do_complete($response){
        
        $res = $response->response;
        if(!empty($res['x_order']) && !empty($response->transaction_id)){
            $this->bm->update_order($res['x_order'], $response->transaction_id);
            //$this->session->set_userdata('akai_transaction_key', md5($this->transaction_key) . md5($res['x_order']));
            //file_put_contents('log/ok_response_'.$res['x_order'].'.txt', "Set akai_transaction_key value:".md5($this->transaction_key) ."****". md5($res['x_order']), FILE_APPEND);
        }
    }

    private function getTranStation($line_id){
        $line_id = explode('|',$line_id);
        $sql = "select * from station where line_id = {$line_id[0]} and is_transfer = 1";    
        $query = $this->db->query($sql);
        $rs = $query->row_array();
        return $rs['id'];
    }

    private function getTranRoute($station_id){
        $sql = "select * from routeinfo where station_id = {$station_id}";    
        $query = $this->db->query($sql);
        $rs = $query->row_array();
        return $rs;
    }

    //支付完成处理逻辑2
    public function complete(){
        $data['user'] = $this->session->userdata('user');
        $oid= $this->session->userdata('oid');
        
        $response_code = $this->input->get('response_code');
        $transaction_id = $this->input->get('transaction_id');

        if(!$oid){
            echo "<script>alert('session timeout,Please choose again'); window.location.href='/'</script>";
            exit;
        }
        $akai_transaction_key = $this->session->userdata('akai_transaction_key');
        //echo $akai_transaction_key;

        //测试模式不需要真正认证
        if(!$this->isTestMode or 1){
            $new_akai_transaction_key = md5($this->transaction_key) . md5($oid);
            file_put_contents("log/ok_response_test_{$transaction_id}.txt", "\r\n response_code:{$response_code}\r\n transaction_id:{$transaction_id} \r\n new_akai_transaction_key Value:{$new_akai_transaction_key} \r\n oid = {$oid}", FILE_APPEND);
            //if($_GET['response_code'] != 1 ){// or ($akai_transaction_key != $new_akai_transaction_key)){
            if($response_code != "1" ){// or ($akai_transaction_key != $new_akai_transaction_key)){
                $data['error'] = $_GET['response_reason_text'];
                $this->load->view('pay_error', $data);
                return false;
            }
            /*
            if(!$oid){
                $data['error'] = 'Connection timeout, please login again';
                $this->load->view('pay_error', $data);
                return false;
            }
             */
        }
        $customer = $this->session->userdata('cdata');

        $data['bpost'] = unserialize($this->session->userdata('search'));
        $data['order'] = $this->bm->get_order_by_id($oid);

        file_put_contents('log/order_response_1.txt', print_r($data['order'], true), FILE_APPEND);

        if($data['order'][0]['transaction_id'] != $transaction_id){
            $data['error'] = 'Illegal operation';
            $this->load->view('pay_error', $data);
            return false;
        }

        $trip_type = ($data['bpost']['trip_type'] == 1) ? "Roundtrip" : "One Way";

        foreach($data['order'] as $key => $order){
            if($order['is_transfer']){
                $tmp_to_id = $order['to_station_id'];
                $order['to_station_id'] = $this->getTranStation($order['line_id']);
                $route = $this->getTranRoute($order['to_station_id']);
                //$order['to_station_id'] = $this->getTranStation($order['line_id']);
                $tmp_return_time = $order['return_time'];
                $order['return_time'] = $route['return_time'];
                unset($route);
            }

            if($this->isTestMode){
                print_r($order);
            }

            $ticketdata[0]['order'] = $order;

            $ticketdata[0]['depart_station'] = $this->bm->get_route_by_rid($order['depart_on_bus']);

            $qrcode = "Confirmation Number:{$order['o_number']}\nDEPARTURE:  {$data['station'][$order['from_station_id']]}\nto\n {$data['station'][$order['to_station_id']]}\n{$trip_type}\nDeparture:  {$order['departing_date']} {$order['departing_time']}\nRETURN:     {$order['return_date']} {$order['return_time']}";
            
            $ticketdata[0]['qrcode'] = $this->generateQRfromGoogle($qrcode);

            $ticketdata[0]['passenger'] = "";
            $ticketdata[0]['first_name'] = explode(',', $order['first-name']);
            $ticketdata[0]['last_name'] = explode(',', $order['last-name']);

            //换乘信息,多出一张票
            if($order['is_transfer']){
                //$ticketdata[1]['tran_station'] = $this->get_tran_station_by_lineid($order['tran_line']);
                $order['from_station_id'] = $order['to_station_id'];
                $order['to_station_id'] = $tmp_to_id;
                $route = $this->getTranRoute($order['from_station_id']);
                $order['depart_on_bus'] = $route['id'];
                $order['departing_time'] = $route['departing_time'];
                $order['return_time'] = $tmp_return_time;

                $ticketdata[1]['order'] = $order;
                $ticketdata[1]['depart_station'] = $this->bm->get_route_by_rid($order['depart_on_bus']);

                $qrcode = "Confirmation Number:{$order['o_number']}\nDEPARTURE:  {$data['station'][$order['from_station_id']]}\nto\n {$data['station'][$order['to_station_id']]}\n{$trip_type}\nDeparture:  {$order['departing_date']} {$order['departing_time']}\nRETURN:     {$order['return_date']} {$order['return_time']}";
                
                $ticketdata[1]['qrcode'] = $this->generateQRfromGoogle($qrcode);

                $ticketdata[1]['passenger'] = "";
                $ticketdata[1]['first_name'] = explode(',', $order['first-name']);
                $ticketdata[1]['last_name'] = explode(',', $order['last-name']);
            }
        }

        $viewdata['ticketdata'] = $ticketdata;
        $viewdata['bpost'] = $data['bpost'];
        $viewdata['station'] =  $this->bm->get_station(false);
        $viewdata['o_number'] = $data['order'][0]['o_number'];
        $viewdata['email'] = $customer['email'];
        $this->load->view('complete', $viewdata);

        $issend = $this->session->userdata('issend');

        if($issend != $oid or $this->isTestMode){
            $line_ids = explode("|", $data['order'][0]['line_id']);
            
            if($this->isTestMode){
                print_r($line_ids);
            }

            foreach($line_ids as $lk=>$lid){

                //客户邮件
                $content = "Thank you for purchasing bus ticket at AKAILLC.com.<br>your order information：<br>Confirmation Number:{$data['order'][0]['o_number']}<br>first-name:{$customer['first-name']},last-name:{$customer['last-name']}<br>Departing:".$viewdata['station'][$data['order'][0]['from_station_id']]." to ".$viewdata['station'][$data['order'][0]['to_station_id']] . "<br> Departing Time:{$data['order'][0]['departing_date']} {$data['order'][0]['departing_time']}<br>{$ticketdata[$lk]["qrcode"]}<br>Any Question? 803-579-9120(Every Day 9:00AM - 7:00PM EST)    AKAILLC.COM Enjoying Your Ride!";

                $subject = 'AKAI bus Tickets Order confirmed';
                $this->sendmail($customer, $content, $subject); 
                log_message('debug', '发送成功:'. $content . '\r\nmail to:' . $customer['email']);
            
                //售票点邮件
                $content = "User information：<br>Confirmation Number:{$data['order'][0]['o_number']}<br>first-name:{$customer['first-name']},last-name:{$customer['last-name']}<br>Tel:{$customer['tel']}, Email:{$customer['email']}<br>State:{$customer['state']},Town or city:{$customer['city']}<br>address and zip code{$customer['address']}-{$customer['zipcode']}<br>Departing:".$viewdata['station'][$data['order'][0]['from_station_id']]." to ".$viewdata['station'][$data['order'][0]['to_station_id']] . "<br> Departing Time:{$data['order'][0]['departing_date']} {$data['order'][0]['departing_time']}<br>{$ticketdata[$lk]["qrcode"]}<br>Any Question? 803-579-9120(Every Day 9:00AM - 7:00PM EST)    AKAILLC.COM Enjoying Your Ride!";

                if($this->isTestMode){
                    echo "<br>{$content}<br>";
                }

                $line = $this->bm->get_line_by_id($lid);
                
                $customer['email'] = $line['mail'];

                //票数统计
                $today = date("Y-m-d");
                
                //需要换乘
                if($data['order'][0]['is_transfer'] == 1){
                    //$tline = $this->bm->get_line_by_id($data['order'][0]['tran_line']);
                    $cond = "(departing_date = '{$today}' or return_date = '{$today}')";
                    $sql = "select sum(quantity) as sale from b_order where (line_id={$line['id']} or line_id like '{$line['id']}|%' or line_id like '%|{$line['id']}') and is_pay=1 and is_transfer = 1 and {$cond}";
                    $res = $this->db->query($sql);
                    $rs= $res->row_array();

                    $rest = $line['total_tickets'] - $rs['sale'];
                    $subject = ",transfer:".date("Y-m-d H:i:s") . "," . $line['name'] . ',' . 'Sold:' . $rs['sale'] . 'Rest:' . $rest;
                }
                else{
                    $cond = "(departing_date = '{$today}' or return_date = '{$today}')";
                    $sql = "select sum(quantity) as sale from b_order where line_id={$line['id']} and is_pay=1 and is_transfer = 0 and {$cond}";
                    $res = $this->db->query($sql);
                    $rs= $res->row_array();
                    $rest = $line['total_tickets'] - $rs['sale'];
                    $subject = date("Y-m-d H:i:s") . "," . $line['name'] . ',' . 'Sold:' . $rs['sale'] . 'Rest:' . $rest;
                    
                }

                if($this->isTestMode){
                    echo "<br>subject:{$subject}<br>content:{$content}<br>";
                }
                $this->sendmail($customer, $content, $subject); 
                log_message('debug', '发送成功:'. $content . '\r\nmail to:' . $customer['email']);
            }
            
            $this->session->set_userdata('issend', $oid);
        }
    }

    function testmail(){
        require_once("lib/phpmailer/class.phpmailer.php"); //下载的文件必须放在该文件所在目录
        $config = $this->bm->getConfig();
        $mail = new PHPMailer(); //建立邮件发送类
        //$address = 'yangyuweb@gmail.com';//$address;
        $address = '1315068148@qq.com';//$address;
        print_r($config);
        $mail->SMTPDebug  = 2;    
        //$mail->SMTPSecure = "tls"; 
        $mail->IsSMTP(); // 使用SMTP方式发送
        $mail->IsHTML(true); 

        $mail->Host = $config['host']; // 您的企业邮局域名
        //$mail->SMTPAuth = true; // 启用SMTP验证功能
        //$mail->Username = $config['username']; // 邮局用户名(请填写完整的email地址)
        //$mail->Password = $config['password'];// 邮局密码
        $mail->Port = $config['port'];
        $mail->From = $config['fromaddress']; //邮件发送者email地址
        $mail->AddAddress("$address", "a");//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
        $mail->Subject = "PHPMailer测试邮件"; //邮件标题
        $mail->Body = "Hello,这是测试邮件"; //邮件内容

        if(!$mail->Send())
        {
            echo "邮件发送失败. <p>";
            echo "错误原因: " . $mail->ErrorInfo;
            exit;
        }

        echo "邮件发送成功";
    }

    private function sendmail($customer, $content, $subject){
        require_once("lib/phpmailer/class.phpmailer.php"); //下载的文件必须放在该文件所在目录
        $config = $this->bm->getConfig();
        $mail = new PHPMailer(); //建立邮件发送类
        $address = $customer['email'];
        $mail->IsSMTP(); // 使用SMTP方式发送
        $mail->IsHTML(true); 
        $mail->Host = $config['host']; // 您的企业邮局域名
        //$mail->SMTPAuth = true; // 启用SMTP验证功能
        //$mail->Username = $config['username']; // 邮局用户名(请填写完整的email地址)
        //$mail->Password = $config['password'];// 邮局密码
        $mail->Port = $config['port'];
        $mail->From = $config['fromaddress']; //邮件发送者email地址
        $mail->FromName = $config['fromname'];
        /*
        $mail->Host = "smtp.bizmail.yahoo.com"; // 您的企业邮局域名
        $mail->SMTPAuth = true; // 启用SMTP验证功能
        $mail->Username = "akaibus@mcpos.com"; // 邮局用户名(请填写完整的email地址)
        $mail->Password = "bus2013@ADS";// 邮局密码
        $mail->Port=25;
        $mail->From = "akaibus@mcpos.com"; //邮件发送者email地址
        $mail->FromName = "Akai bus";
         */
        /*
        $mail->Host = "smtp.126.com"; // 您的企业邮局域名
        $mail->SMTPAuth = true; // 启用SMTP验证功能
        $mail->Username = "rainyang2012@126.com"; // 邮局用户名(请填写完整的email地址)
        $mail->Password = "geomedia";// 邮局密码
        $mail->Port=25;
        $mail->From = "rainyang2012@126.com"; //邮件发送者email地址
        $mail->FromName = "Akai bus";
         */

        $mail->AddAddress($address, $customer['first-name'].$customer['last-name']);//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")

        $mail->Subject = $subject; //邮件标题
        $mail->Body = $content; //邮件内容

        if(!$mail->Send())
        {
            log_message('debug', '发送失败:'. $content . '\r\nmail to:' . $customer['email']. 'info:'.$mail->ErrorInfo);
            return false;
        }

    }


    public function map(){
        $address = $this->input->post('address');
        $data['address'] = $address;
		$this->load->view('map', $data);
    }

    function generateQRfromGoogle($chl,$widhtHeight ='150',$EC_level='L',$margin='0') 
    { 
        $chl = urlencode($chl); 
        return '<img src="http://chart.apis.google.com/chart?chs='.$widhtHeight.'x'.$widhtHeight.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$chl.'" alt="QR code" widhtHeight="'.$widhtHeight.'" widhtHeight="'.$widhtHeight.'"/>'; 
    } 

    
    function ltestmail(){
        /*
        $this->load->library('email');
        $this->email->from('akaibus@yahoo.com','AKAI bus');
        $this->email->to('yangyuweb@gmail.com');
        $this->email->subject('yangyu');
        $this->email->message('look up');
        $this->email->send();
        echo  $this->email->print_debugger();
         */
        require("lib/phpmailer/class.phpmailer.php"); //下载的文件必须放在该文件所在目录
        $mail = new PHPMailer(); //建立邮件发送类
        $address ="yangyuweb@gmail.com";
        $address ="1315068148@qq.com";
        $mail->IsSMTP(); // 使用SMTP方式发送
        $mail->Host = "smtp.bizmail.yahoo.com"; // 您的企业邮局域名
        $mail->SMTPAuth = true; // 启用SMTP验证功能
        $mail->Username = "akaibus@mcpos.com"; // 邮局用户名(请填写完整的email地址)
        $mail->Password = "bus2013@ADS";// 邮局密码
        $mail->Port=25;
        $mail->From = "akaibus@yahoo.com"; //邮件发送者email地址
        $mail->FromName = "yangyu";
        $mail->AddAddress("$address", "a");//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
        //$mail->AddReplyTo("", "");

        //$mail->AddAttachment("/var/tmp/file.tar.gz"); // 添加附件
        //$mail->IsHTML(true); // set email format to HTML //是否使用HTML格式

        $mail->Subject = "PHPMailer测试邮件"; //邮件标题
        $mail->Body = "Hello,这是测试邮件"; //邮件内容
        $mail->AltBody = "This is the body in plain text for non-HTML mail clients"; //附加信息，可以省略

        if(!$mail->Send())
        {
            echo "邮件发送失败. <p>";
            echo "错误原因: " . $mail->ErrorInfo;
            exit;
        }

        echo "邮件发送成功";

    }


    function register(){
        $this->load->helper('captcha');

        $vals = array(
            'word' => 'Random word',
            'img_path' => './static/captcha/',
            'img_url' => 'http://bus.cn/static/captcha/',
            'img_width' => '150',
            'img_height' => 30,
            'expiration' => 7200
            );

        $cap = create_captcha($vals);
        echo $cap['image'];
        //exit;
        //$this->load->view('register', $data);
    }
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */
