<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    private $tbl_user = 'v_user';
    private $tbl_users = 'user';

    public function __construct(){
        parent::__construct();
        if ($this->session->has_userdata('has_login')){
            redirect('dashboard');
        }
        $this->load->library('encryption');
        $this->load->model('General_model','general');
    }

    private function _generate_view($view, $data){
        $this->load->view('_template/header', $data['title_header']);
        if(!empty($view['css_additional'])) {
            $this->load->view($view['css_additional']);
        }
        $this->load->view('_template/menu');
        $this->load->view($view['content'], $data['content']);
        $this->load->view('_template/js_main');
        if(!empty($view['js_additional'])) {
            $this->load->view($view['js_additional']);
        }
        $this->load->view('_template/footer');
    }
    
    public function index(){
        //for passing data to view
        $data['content'] = [];
        $data['title_header'] = ['title' => 'Login Page'];

        //for load view
        $view['css_additional'] = NULL;
        $view['content'] = 'login/content';
        $view['js_additional'] = NULL;

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function submit_login(){
        $data['username'] = $this->input->post('username', TRUE);
        $data['password'] = $this->input->post('password', TRUE);

		$data['login_admin'] = $this->general->login_admin($data);

        $decode = $this->encryption->decrypt($data['login_admin'][0]['password']);

		if($data['login_admin'] && $decode == $data['password']){

			$newdata = array(
                'id_user' => $data['login_admin'][0]['id_user'],
                'role_id' => $data['login_admin'][0]['role_id'],
                'role_name' => $data['login_admin'][0]['role_name'],
                'name_user' => $data['login_admin'][0]['name_user'],
                'username' => $data['login_admin'][0]['username'],
                'has_login' => 1
			);

			$this->session->set_userdata($newdata);
            session_start();
            
            $this->session->set_flashdata('success', 'Welcome '.$data['login_admin'][0]['name_user'].'!');

			redirect("dashboard");
		}else{
			$this->session->set_flashdata('error', 'Email atau password salah!');
			redirect("login");
		}
    }

}