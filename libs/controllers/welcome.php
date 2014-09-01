<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct(){
        parent::__construct();
        $this->load->model('bus_model', 'bm');
    }

    //根据出发站查询能到达的站
    public function get_going_station_by_name(){
        $from_name = $this->input->post('name');
        $trip_type = $this->input->post('trip_type');
        
        $rs = $this->bm->get_going_station_by_name($from_name);
        $line = $this->bm->get_line_by_id($rs[0]['line_id']);

        //如果是换乘线路,目的地选择不等于换乘的
        if($rs[0]['line_id'] == 13){
            $sql = "select * from station where line_id <> 13 and line_id<>23";
            $query = $this->db->query($sql);
            $transfers = $query->result_array();
        }
        else{
            if($line['is_need_tran']){
                $transfers = $this->bm->get_transfer_line();
            }
            else{
                $transfers = array();
            }
        }

        //去除重复数据
        $res = $this->array_unique_fb(array_merge($rs, $transfers));

        if($trip_type != 0){
            $sql = "select * from ticket_price where (from_station_id in (SELECT id FROM station 
                WHERE name =  '{$from_name}') or `to_station_id` in (SELECT id FROM station
                WHERE name =  '{$from_name}'))  and `is_allow_return` = 0";
            $query = $this->db->query($sql);
            $noreturn = $query->result_array();

            foreach($noreturn as $val){
                $sql = "select * from station where id={$val['from_station_id']} or id={$val['to_station_id']}";
                $query = $this->db->query($sql);
                $return = $query->result_array();
                foreach($return as $v){
                    if($v['name'] != $from_name){
                        $tmparr[] = array('name' => $v['name']);
                    }    
                }
            }
        }

        foreach($tmparr as $val){
            foreach($res as $k => $v){
                if($v['name'] == $val['name']){
                    unset($res[$k]);
                }
            }
        }
        //print_r(array_merge($rs, $transfers));

        //$res = $rs;

        //print_r($res);

        foreach($res as $val){
            if($val['name'] == $from_name)
                continue;
            echo '<div class="option_citylist" state="Georgia">
                     	<ul>
                             <li class="option_city" city="'.$val["name"].'"><a>'.$val["name"].'</a></li> 
                        </ul>
                      </div>';
        }
    }

    function array_unique_fb($array2D) 
    { 
        $removes = array();
        foreach($array2D as $key => $val){
            $name = $val['name'];
            if(in_array($key, $removes))
                continue;
            foreach($array2D as $k => $v){
                if($name == $v['name'] && $key != $k){
                    array_push($removes, $k);
                    unset($array2D[$k]);
                }
            }
        }
        //print_r($removes);
        return $array2D; 
    } 
    

	public function index()
	{
        $site = $this->bm->get_siteinfo();
        $site['email'] = explode(",", $site['email']);
        $site['images'] = explode(",", $site['images']);
        $data['site'] = $site;
        $data['is_stop'] = file_exists('is_stop.txt') ? 1 : 0;
        $data['stop_info'] = '';
        if($data['is_stop']){
            $data['stop_info'] = file_get_contents('is_stop.txt');
        }
        $data['title'] = 'website stop or start';
        $data['user'] = $this->session->userdata('user');
        $data['station'] = $this->bm->get_station();
		$this->load->view('index', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
