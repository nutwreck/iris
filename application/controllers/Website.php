<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* if (file_exists(APPPATH . 'vendor/autoload.php')) {
    require_once(APPPATH . 'vendor/autoload.php');
} elseif (file_exists(APPPATH . '../vendor/autoload.php')) {
    require_once(APPPATH . '../vendor/autoload.php');
} 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; */

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
        $data['team'] = $this->input->post('team', TRUE);
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

        if($type_button == 1){ //Submit
            $this->search_data_report($data['region_id'], str_replace('/', '-', $split[0]), str_replace('/', '-', $split[1]));
        } else { //Export Excel
            $get_data = $this->website->get_search_data_report($data);
            $this->export_report($get_data);
        }
    }

    private function export_report($get_data){
        $year = $get_data[0]['year'];
        $region = $get_data[0]['region_name'];

        $group_data = array();

        foreach ($get_data as $value_group) {
            $group_data[$value_group['month_year']][$value_group['week']][] = $value_group;
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
                        ->setCellValue('A5', 'Day')
                        ->setCellValue('B5', 'Date')
                        ->setCellValue('C5', 'Time')
                        ->setCellValue('D5', 'Brand')
                        ->setCellValue('E5', 'Name')
                        ->setCellValue('F5', 'Activity Type')
                        ->setCellValue('G5', 'Activity Detail')
                        ->setCellValue('H5', 'Agenda')
                        ->setCellValue('I5', 'Remarks')
                        ->setCellValue('J5', 'Photo');

                $sheet = $spreadsheet->setActiveSheetIndex($active_sheet);

                //Height Column
                $sheet->getRowDimension('1')->setRowHeight(25);
                $sheet->getRowDimension('5')->setRowHeight(15);

                $styleArray_border = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                $styleArray_head = array(
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'rotation' => 90,
                        'startColor' => [
                            'argb' => 'FFBDD7EE',
                        ],
                        'endColor' => [
                            'argb' => 'FFBDD7EE',
                        ],
                    ],
                );

                //Color Bg cell Header
                $sheet->getStyle('A5:J5')->applyFromArray($styleArray_head);
                $sheet->getStyle('A1')->applyFromArray($styleArray_head);

                //Header Top Font Size
                $sheet->getStyle('A1')->getFont()->setSize(15);

                //Border
                $sheet->getStyle('A1:J5')->applyFromArray($styleArray_border);

                //Middle Align
                $sheet->getStyle('A1')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1')
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A2')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('A3')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('A4')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('B2')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('B3')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('B4')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('A5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A5')
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('B5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('C5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('G5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('H5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('I5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('J5')
                    ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    
                //Fill data
                $row = 6;
                $startRowDay = -1;
                $previousKeyDay = '';
                $startRowDate = -1;
                $previousKeyDate = '';

                foreach($val_week as $index => $val_report) {
                    //Fill Data
                    //Merge Day
                    if($startRowDay == -1){
                        $startRowDay = $row;
                        $previousKeyDay = $val_report['day'];
                    }
                    $sheet->setCellValue('A' . $row, ucwords($val_report['day']));
                    $nextKeyDay = isset($val_week[$index+1]) ? $val_week[$index+1]['day'] : null;
                        if($row >= $startRowDay && (($previousKeyDay <> $nextKeyDay) || ($nextKeyDay == null))){
                            $cellToMergeDay = 'A'.$startRowDay.':A'.$row;
                            $spreadsheet->getActiveSheet()->mergeCells($cellToMergeDay);
                            $startRowDay = -1;
                        }
                    
                    //Merge Date
                    if($startRowDate == -1){
                        $startRowDate = $row;
                        $previousKeyDate = $val_report['full_date'];
                    }
                    $sheet->setCellValue('B' . $row, format_indo($val_report['full_date']));
                    $nextKeyDate = isset($val_week[$index+1]) ? $val_week[$index+1]['full_date'] : null;
                        if($row >= $startRowDate && (($previousKeyDate <> $nextKeyDate) || ($nextKeyDate == null))){
                            $cellToMergeDate = 'B'.$startRowDate.':B'.$row;
                            $spreadsheet->getActiveSheet()->mergeCells($cellToMergeDate);
                            $startRowDate = -1;
                        }

                    $sheet->setCellValue('C' . $row, $val_report['full_time']);
                    $sheet->setCellValue('D' . $row, $val_report['brand_name']);
                    $sheet->setCellValue('E' . $row, $val_report['team']);
                    $sheet->setCellValue('F' . $row, $val_report['activity_name']);
                    $sheet->setCellValue('G' . $row, $val_report['activity_detail']);
                    $sheet->setCellValue('H' . $row, $val_report['agenda']);
                    $sheet->setCellValue('I' . $row, $val_report['notes']);

                    //File photo report
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $drawing->setName('File Report');
                    $drawing->setDescription('File Report');
                    $drawing->setPath('storage/website/report_image/'.$val_report['file']);
                    $drawing->setCoordinates('J'.$row);
                    $drawing->setResizeProportional(false);
                    $drawing->setWidth(200);
                    $drawing->setHeight(100);
                    $drawing->setWorksheet($sheet);
                    //End Fill Data

                    //Height Column
                    $sheet->getRowDimension($row)->setRowHeight(75);
                    
                    //Width Column
                    $sheet->getColumnDimension('A')->setWidth(10);
                    $sheet->getColumnDimension('B')->setWidth(14);
                    $sheet->getColumnDimension('C')->setWidth(6);
                    $sheet->getColumnDimension('D')->setWidth(12);
                    $sheet->getColumnDimension('E')->setWidth(50);
                    $sheet->getColumnDimension('F')->setWidth(14);
                    $sheet->getColumnDimension('G')->setWidth(20);
                    $sheet->getColumnDimension('H')->setWidth(25);
                    $sheet->getColumnDimension('I')->setWidth(75);
                    $sheet->getColumnDimension('J')->setWidth(28.5); //Untuk ukuran kolom photo

                    //Wrap Text
                    $sheet->getStyle('D'. $row)->getAlignment()->setWrapText(true);
                    $sheet->getStyle('E'. $row)->getAlignment()->setWrapText(true);
                    $sheet->getStyle('G'. $row)->getAlignment()->setWrapText(true);
                    $sheet->getStyle('H'. $row)->getAlignment()->setWrapText(true);
                    $sheet->getStyle('I'. $row)->getAlignment()->setWrapText(true);

                    //Middle Align
                    $sheet->getStyle('A'. $row)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('B'. $row)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('C'. $row)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('D'. $row)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('E'. $row)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('F'. $row)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('G'. $row)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('H'. $row)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $sheet->getStyle('I'. $row)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                    $sheet->getStyle('A'.$row.':J'.$row)->applyFromArray($styleArray_border);

                    $row++;
                }
                
                //Logo Iris
                $drawing2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing2->setName('Logo Report');
                $drawing2->setDescription('Logo Report');
                $drawing2->setPath('assets/general/favicon/favicon.png');
                $drawing2->setCoordinates('I2');
                $drawing2->setResizeProportional(false);
                $drawing2->setOffsetX(300);
                $drawing2->setOffsetY(5);
                $drawing2->setWidth(100);
                $drawing2->setHeight(50);
                $drawing2->setWorksheet($sheet);

                $active_sheet++; //Active Sheet
            }
        }

        //Remove initial sheet
        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Worksheet 1')
        );
        $spreadsheet->removeSheetByIndex($sheetIndex);

        //Sheet aktif diawal
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORT DOCUMENTATION - DOR_WOR_MOR SAMPLING '.$year.' '.strtoupper($region).'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function search_data_report($region_id, $start_date, $end_date){
        $datas = array(
            'region_id' => $region_id,
            'start_date' => $start_date.' 00:00:00',
            'end_date' => $end_date.' 23:59:59'
        );

        $this->load->library('pagination');
        //konfigurasi pagination
        $config['base_url'] = site_url('Website/search_data_report/'.$region_id.'/'.trim($start_date).'/'.trim($end_date)); //site url
        $config['total_rows'] = $this->website->count_data_report($datas); //total row
        $config['per_page'] = 5;  //show record per halaman
        $config["uri_segment"] = 6;  // uri parameter
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
 
        // Membuat Style pagination untuk BootStrap v4
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-left"><nav><ul class="pagination justify-content-left">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
 
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
        
        //for passing data to view
        $data['content']['region'] = $this->website->get_region_enable();
        $data['content']['all_data'] = $config['total_rows'];
        $data['content']['data'] = $this->website->get_report_data($config["per_page"], $page, $datas);
        $data['content']['pagination'] = $this->pagination->create_links();
        $data['title_header'] = ['title' => 'Report Page'];

        //for load view
        $view['css_additional'] = 'report_data/css';
        $view['content'] = 'report_data/content';
        $view['js_additional'] = 'report_data/js';

        //get function view website
        $this->_generate_view($view, $data);
    }
    
}