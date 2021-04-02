<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Website extends CI_Controller {
    
    private $tbl_report = 'report';

    function __construct(){
        parent::__construct();
        if (!$this->session->has_userdata('has_login')){
            redirect('login');
        }
        $this->load->model('Website_model','website');
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

    public function resizeImage($filename) {
        $source_path = FCPATH.'storage/website/report_image/raw/' . $filename;
        $target_path = FCPATH.'storage/website/report_image/';
        $config_compress = array(
            'image_library' => 'gd2',
            'source_image' => $source_path,
            'new_image' => $target_path,
            'maintain_ratio' => TRUE,
            'quality' => '70%',
            'width' => 700
        );
    
        $this->load->library('image_lib');
        $this->image_lib->initialize($config_compress);  

        if (!$this->image_lib->resize()) {
            /* echo $this->image_lib->display_errors();
            die(); */
            return null;
        }
    
        $this->image_lib->clear();
        return 1;
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

    public function submit_upload_data(){
        $data = [];
        $region = $this->input->post('region', TRUE);
        $activity_type = $this->input->post('activity_type', TRUE);
        $user_upload = $this->session->userdata('name_user');

        $region_implode = explode("|", $region);
        $activity_type_implode = explode("|", $activity_type);
        $user_upload_no_space = str_replace(' ','_',$user_upload); 

        $date_time = $this->input->post('datetime', TRUE);
        $input_date = date("Y-m-d H:i", strtotime($date_time));  

        $data['region_id'] = $region_implode[0];
        $data['region_name'] = $region_implode[1];
        $data['activity_id'] = $activity_type_implode[0];
        $data['activity_name'] = $activity_type_implode[1];
        $data['activity_detail'] = $this->input->post('activity', TRUE);
        $data['datetime'] = $input_date;
        $data['agenda'] = $this->input->post('agenda', TRUE);
        $data['brand_name'] = $this->input->post('brand', TRUE);
        $data['notes'] = $this->input->post('note', TRUE);

        $dname = explode(".", $_FILES['report_image']['name']);
        $ext = end($dname);
        $new_name                   = 'iris_'.time().'_'.date('Ymd').'_'.$user_upload_no_space.'.'.$ext;
        $config['file_name']        = $new_name;
        $config['upload_path']      = FCPATH.'storage/website/report_image/raw/';
        $config['allowed_types']    = 'jpeg|jpg|png';
        $config['overwrite']        = FALSE;
        $_upload_path = $config['upload_path'];

        if(!file_exists($_upload_path)){
            mkdir($_upload_path,0777);
        }
        
        $this->load->library('upload', $config);

        if(!empty($_FILES['report_image']['name'])){
            if (!$this->upload->do_upload('report_image')){
                /* $error = $this->upload->display_errors();
                show_error($error, 500, 'File Upload Error');
                exit(); */
                if($ext != 'png' || $ext != 'jpg' || $ext != 'jpeg'){
                    $this->session->set_flashdata('warning', 'Jenis gambar tidak sesuai ketentuan, Ulangi kembali');
                    redirect('upload-data');
                } else {
                    $this->session->set_flashdata('warning', 'Gambar gagal disimpan, Ulangi kembali');
                    redirect('upload-data');
                }
            } else {
                $file_name = $this->upload->data('file_name');
                $compress_image = $this->resizeImage($file_name);//lakukkan kompresi gambar

                //jika sudah terupload/gagal kompresinya, maka file asli dihapus
                $path = FCPATH.'storage/website/report_image/raw/'.$file_name;
                chmod($path, 0777);
                unlink($path);
                
                if($compress_image){// Jika kompresi gambar sukses
                    $data['file'] = $file_name;
                } else {
                    $this->session->set_flashdata('warning', 'Error saat kompresi gambar, Ulangi kembali');
		            redirect('upload-data');
                }
            }
        }

        $data['created_by'] = $this->session->userdata('id_user');
        $data['created_datetime'] = date('Y-m-d H:i:s');

        $tbl = $this->tbl_report;
        $input = $this->general->input_data($tbl, $data);

        $urly = 'upload-data';
        $urlx = 'upload-data';
        $this->input_end($input, $urly, $urlx);
    }

    public function report(){
        //for passing data to view
        $data['content']['region'] = $this->website->get_region_enable();
        $data['title_header'] = ['title' => 'Report Page'];

        //for load view
        $view['css_additional'] = 'report_data/css';
        $view['content'] = 'report_data/content';
        $view['js_additional'] = 'report_data/js';

        //get function view website
        $this->_generate_view($view, $data);
    }

    public function search_report(){
        $data = [];

        $type_button = $this->input->post('typebutton', TRUE); //1 Submit 2 Export Excel
        
        $region = $this->input->post('region_name', TRUE);
        $region_raw = explode("|", $region);

        $daterange = $this->input->post('daterange', TRUE);
        $split = explode('-', $daterange);

        #check make sure have 2 elements in array
        $count = count($split);
        if($count <> 2){ #invalid data
            $this->session->set_flashdata('warning', 'Error saat memproses tanggal report, ulangi kembali!');
            redirect('report');
        }

        $data['region_id'] = $region_raw[0];
        $data['region_name'] = $region_raw[1];
        $data['start_date'] = str_replace('/', '-', $split[0]).' 00:00:00';
        $data['end_date'] = str_replace('/', '-', $split[1]).' 23:59:59';

        $get_data = $this->website->get_search_data_report($data);

        if($type_button == 1){ //Submit

        } else { //Export Excel
            $this->export_report($get_data);
        }
    }

    private function export_report($get_data){
        $year = $get_data[0]['year'];
        $region = $get_data[0]['region_name'];

        $group_data = array();

        foreach ($get_data as $value_group) {
            $group_data[$value_group['month_year']][$value_group['week']][$value_group['full_date']][$value_group['day']][] = $value_group;
        }

        $spreadsheet = new Spreadsheet;

        $active_sheet = 0;
        foreach($group_data as $key_month => $val_month){
            $month_year = $key_month;
            foreach($val_month as $key_week => $val_week){
                //Create sheet
                $spreadsheet->createSheet();
                $spreadsheet->setActiveSheetIndex($active_sheet);
                $spreadsheet->getActiveSheet()->setTitle('WEEK '.$key_week);
                
                //Create merge cells
                $spreadsheet->getActiveSheet()->mergeCells('A1:J1')
                        ->mergeCells('B2:H2')
                        ->mergeCells('B3:H3')
                        ->mergeCells('B4:H4')
                        ->mergeCells('I2:J4');
    
                //Header cells
                $spreadsheet->setActiveSheetIndex($active_sheet)
                        ->setCellValue('A1', 'Report Documentation')
                        ->setCellValue('A2', 'Region')
                        ->setCellValue('A3', 'Week')
                        ->setCellValue('A4', 'Month')
                        ->setCellValue('B2', ucwords($region))
                        ->setCellValue('B3', $key_week)
                        ->setCellValue('B4', $month_year)
                        ->setCellValue('A5', 'Month')
                        ->setCellValue('B5', 'Month')
                        ->setCellValue('C5', 'Month')
                        ->setCellValue('D5', 'Month');
    
                //Fill data
                $kolom = 6;
                foreach($val_week as $val_report) {
    
                    $spreadsheet->setActiveSheetIndex($active_sheet)
                                ->setCellValue('A' . $kolom, ucwords($val_report['activity_name']))
                                ->setCellValue('B' . $kolom, ucwords($val_report['region_name']))
                                ->setCellValue('C' . $kolom, ucwords($val_report['activity_detail']))
                                ->setCellValue('D' . $kolom, ucwords($val_report['brand_name']));
    
                    $kolom++;
    
                }
                
                $active_sheet++;
            }
        }

        //Remove initial sheet
        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Worksheet 1')
        );
        $spreadsheet->removeSheetByIndex($sheetIndex);

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORT DOCUMENTATION - DOR_WOR_MOR SAMPLING '.$year.' '.strtoupper($region).'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}