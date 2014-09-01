<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

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


	public function register()
	{
        $data = '';
		$this->load->view('reg', $data);
	}

    public function is_register(){
        $username = $this->input->post('username');
        $user = $this->bm->get_customer_by_username($username); 
        echo count($user);
    }

	public function do_register()
	{
        $post = $_POST;
        unset($post['password2']);
        $post['password'] = md5($post['password']);
        $post = array_map("addslashes", $post);
        //echo $_SERVER['HTTP_REFERER'];
        $this->bm->add_customer($post);
        $user = $this->bm->get_customer_by_username($post['username'], $post['password']);
        $this->session->set_userdata('user', $user);
        redirect('/', 'refresh');
	}

	public function login()
	{
		$this->load->view('login');
	}

    public function signup(){
        $this->session->unset_userdata('user');
        redirect('/', 'refresh');
    }

    function ajax_login(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $password = md5($password);
        $user = $this->bm->get_customer_by_username($username, $password);

        if(!$user){
            echo "no";
        }
        else{
            $this->session->set_userdata('user', $user);
            echo "ok";
        }
    }

	public function do_login()
	{
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $password = md5($password);
        
        $user = $this->bm->get_customer_by_username($username, $password);
        print_r($user);
        if(empty($user)){
            echo '<script>alert("user or password error");history.go(-1)</script>';
            exit;
            return;
        }
        $this->session->set_userdata('user', $user);
        redirect('/');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
