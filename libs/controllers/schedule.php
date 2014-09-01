<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends CI_Controller {

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


	public function index()
	{
        $data['user'] = $this->session->userdata('user');
        $lines = $this->bm->get_lines();
        foreach($lines as $key => $val){
            $data['lines'][$key]['line'] = $val;
            $stations = $this->bm->get_station_by_line_id($val['id']);
            foreach($stations as  $k => $v){
                $data['lines'][$key]['stations'][$k]['name'] = $v['name'];
                $routes = $this->bm->get_route_by_id($v['id'], $val['id']);
                foreach($routes as $r => $route){
                    $data['lines'][$key]['stations'][$k]['route'][$r] = $route;
                }   
            }
        }

		$this->load->view('schedule', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
