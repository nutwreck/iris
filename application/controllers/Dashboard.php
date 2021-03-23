<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct(){
		parent::__construct();
    }

    private function _generate_view($view, $data){
        $this->load->view('_template/header', $data['title_header']);
        if(!empty($view['css_additional'])) {
            $this->load->view($view['css_additional']);
        }
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
        $view['css_additional'] = 'dashboard/css';
        $view['content'] = 'dashboard/content';
        $view['js_additional'] = 'dashboard/js';

        //get function view website
        $this->_generate_view($view, $data);
    }
}