<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends CI_Controller {

    public function __construct(){
        parent::__construct();
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

    public function dashboard(){
        //for passing data to view
        $data['content'] = [];
        $data['title_header'] = ['title' => 'Dashboard Page'];

        //for load view
        $view['css_additional'] = 'dashboard/css';
        $view['content'] = 'dashboard/content';
        $view['js_additional'] = 'dashboard/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function upload_data(){
        //for passing data to view
        $data['content']['activity_type_data'] = $this->website->get_activity_type_enable();
        $data['content']['region_data'] = $this->website->get_region_enable();
        $data['title_header'] = ['title' => 'Upload Report Page'];

        //for load view
        $view['css_additional'] = 'upload_data/css';
        $view['content'] = 'upload_data/content';
        $view['js_additional'] = 'upload_data/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function report(){
        //for passing data to view
        $data['content'] = [];
        $data['content'] = [];
        $data['title_header'] = ['title' => 'Report Page'];

        //for load view
        $view['css_additional'] = 'report_data/css';
        $view['content'] = 'report_data/content';
        $view['js_additional'] = 'report_data/js';

        //get function view website
        $this->_generate_view($view, $data);
    }
}