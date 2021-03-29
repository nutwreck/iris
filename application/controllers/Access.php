<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller {

    private $tbl_user = 'v_user';
    private $tbl_users = 'user';

    public function __construct(){
        parent::__construct();
        $this->load->library('encryption');
        $this->load->model('General_model','general');
        $this->load->model('Website_model','website');
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

    private function input_end($input, $urly, $urlx){
        if(!empty($input)){
            $this->session->set_flashdata('success', 'Data berhasil ditambahkan');
		    redirect($urly);
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan!');
		    redirect($urlx);
        }
    }

    private function update_end($update, $urly, $urlx){
        if(!empty($update)){
            $this->session->set_flashdata('success', 'Data berhasil diedit');
		    redirect($urly);
        } else {
            $this->session->set_flashdata('error', 'Data gagal terupdate!');
		    redirect($urlx);
        }
    }

    private function delete_end($delete, $urly, $urlx){
        if(!empty($delete)){
            $this->session->set_flashdata('success', 'Data berhasil dinonaktifkan');
		    redirect($urly);
        } else {
            $this->session->set_flashdata('error', 'Data gagal ternonaktifkan!');
		    redirect($urlx);
        }
    }

    private function active_end($active, $urly, $urlx){
        if(!empty($active)){
            $this->session->set_flashdata('success', 'Data berhasil diaktifkan');
		    redirect($urly);
        } else {
            $this->session->set_flashdata('error', 'Data gagal diaktifkan!');
		    redirect($urlx);
        }
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
            $this->session->set_flashdata('success', 'Selamat Datang Administrator');
            
			$newdata = array(
					'id' => $data['login_admin'][0]['id'],
					'username' => $data['login_admin'][0]['username'],
					'has_login' => 1
			);

			$this->session->set_userdata($newdata);
			session_start();

			redirect("admin");
		}else{
			$this->session->set_flashdata('error', 'Email atau password salah!');
			redirect("admin/login");
		}
    }

    public function access_user()
	{
        $tbl = $this->tbl_user;
    
         //for passing data to view
        $data['content']['akses_user'] = $this->general->get_all_data($tbl);
        $data['title_header'] = ['title' => 'Login Page'];

        //for load view
        $view['css_additional'] = 'akses_user/css';
        $view['content'] = 'akses_user/content';
        $view['js_additional'] = 'akses_user/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function add_access_user(){
        //for passing data to view
        $tbl_role = 'role_user';
        $data['content']['role'] = $this->general->get_all_data_enable($tbl_role);
        $data['title_header'] = ['title' => 'Login Page'];

        //for load view
        $view['css_additional'] = 'akses_user/css';
        $view['content'] = 'akses_user/add';
        $view['js_additional'] = 'akses_user/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function submit_add_access_user(){
        $data['role_id'] = $this->input->post('role', TRUE);
        $data['username'] = $this->input->post('username', TRUE);
        $data['password'] = $this->encryption->encrypt($this->input->post('password', TRUE));
        $data['name'] = ucwords($this->input->post('name', TRUE));
        $data['email'] = $this->input->post('email', TRUE);
        $data['created_datetime'] = date('Y-m-d H:i:s');

        $cek_username = $this->website->get_username($data['username']);
        if(!empty($cek_username)){
            $this->session->set_flashdata('warning', 'Username sudah ada yang pakai!');
			redirect("access-user");
        } else {
            $tbl = $this->tbl_users;
            $input = $this->general->input_data($tbl, $data);

            $urly = 'access-user';
            $urlx = 'add-user';
            $this->input_end($input, $urly, $urlx);
        }
    }

    public function submit_update_access_user()
	{
        $id = $this->input->post('id', TRUE);
        $data['username'] = $this->input->post('username', TRUE);
        $data['password'] = $this->encryption->encrypt($this->input->post('password', TRUE));
        $tbl = $this->tbl_user;
        $update = $this->core->update_data($tbl, $data, $id);

        $urly = 'akses-user';
        $urlx = 'akses-user';
        $this->update_end($update, $urly, $urlx);
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect("login");
    }

}