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

}