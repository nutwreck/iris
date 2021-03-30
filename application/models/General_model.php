<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General_model extends CI_Model{

    public function get_all_data($tbl){
        return $this->db->get($tbl)->result();
    }
    public function get_all_data_enable($tbl){
        return $this->db->get_where($tbl, array('is_enable' => 1))->result();
    }
    public function get_data_by_id($tbl, $id){
        return $this->db->get_where($tbl, array('id' => $id))->result();
    }
    public function input_data($tbl, $datas){
        $this->db->trans_start();
        $query = $this->db->insert($tbl, $datas);
        if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return null;
		} else{
			$this->db->trans_commit();
			return $query;
		}
    }
    public function update_data($tbl, $data, $id){
        $this->db->where('id', $id);
        $query = $this->db->update($tbl, $data);
        if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return null;
		} else{
			$this->db->trans_commit();
			return $query;
		}
    }
    public function delete_data($tbl, $id){
        $this->db->trans_start();
        $this->db->set('is_enable', 0);
        $this->db->where('id', $id);
        $query = $this->db->update($tbl);
        if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return null;
		} else{
			$this->db->trans_commit();
			return $query;
		}
    }
    public function active_data($tbl,$id){
        $this->db->trans_start();
        $this->db->set('is_enable', 1);
        $this->db->where('id', $id);
        $query = $this->db->update($tbl);
        if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return null;
		} else{
			$this->db->trans_commit();
			return $query;
		}
    }

    function login_admin($data){
		$query = $this->db->query("
            SELECT  id_user,
                role_id,
                role_name,
                name_user,
                username,
                password
					FROM v_user
					WHERE username = '".$data['username']."'
				");
		$num = $query->num_rows();
		if($num>0){
            return $query->result_array();
        }
        else{
            return false;
        }
	}

}
