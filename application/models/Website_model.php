<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website_model extends CI_Model{

    public function get_activity_type_enable(){
        return $this->db->select('id, name')
                    ->order_by('id ASC')
                    ->get_where('activity_type', array('is_enable' => 1))->result();
    }

    public function get_region_enable(){
        return $this->db->select('id, name')
                    ->order_by('id ASC')
                    ->get_where('region', array('is_enable' => 1))->result();
    }

    public function get_username($username){
        return $this->db->select('username')
                    ->get_where('user', array('username' => $username))->result();
    }

    public function get_role_user_selected($id){
        return $this->db->select('id, name')
                    ->get_where('role_user', array('id !=' => $id))->result();
    }  

    public function get_user_by_id($tbl, $id){
        return $this->db->get_where($tbl, array('id_user' => $id))->row();
    }

    public function get_search_data_report($data){
        $this->db->where('region_id', $data['region_id']);
        $this->db->where("datetime BETWEEN '".$data['start_date']."' AND '".$data['end_date']."'","", FALSE);
        return  $this->db->select('*, RANK() OVER ( ORDER BY T1.id ASC ) AS number', FALSE)
                        ->get('v_report')->result_array();
    }

    public function get_report_data($limit, $start, $datas){
        $this->db->where('region_id', $datas['region_id']);
        $this->db->where("datetime BETWEEN '".$datas['start_date']."' AND '".$datas['end_date']."'","", FALSE);
        return  $this->db->select('*, RANK() OVER ( ORDER BY T1.id ASC ) AS number', FALSE)
                        ->get('v_report', $limit, $start)->result_array();
    }

    public function count_data_report($datas){
        return $this->db->where('region_id', $datas['region_id'])
                    ->where("datetime BETWEEN '".$datas['start_date']."' AND '".$datas['end_date']."'","", FALSE)
                    ->where('is_enable', 1)->from("v_report")->count_all_results();
    }

}