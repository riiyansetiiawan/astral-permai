<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Performance_variable_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_kpi_variable($user_id) {
        $year = date('Y');
        return $query = $this->db->query("SELECT * FROM umb_kpi_variable where user_id = $user_id AND year_created = $year");
    }

    public function get_variable_quarterly($user_id, $quarter, $year) {
        if ($quarter == 'All') {
            return $query = $this->db->query("SELECT * FROM umb_kpi_variable WHERE user_id='$user_id' AND year_created='$year'");   
        } else {
            return $query = $this->db->query("SELECT * FROM umb_kpi_variable WHERE  (user_id='$user_id' AND 
                quarter='$quarter' AND
                year_created='$year') OR
                (user_id='$user_id' AND 
                quarter <= '$quarter' AND
                status <= '2' AND
                year_created='$year')");
        }
    }

    public function get_variable_statistic($user_id, $quarter, $year) {
        if($quarter == 'All'){
            $query = $this->db->query("SELECT * FROM umb_kpi_variable WHERE user_id='$user_id' AND year_created='$year'");
        } else {
            $query = $this->db->query("SELECT * FROM umb_kpi_variable WHERE user_id='$user_id' AND quarter='$quarter' AND year_created='$year'");
        }
        return $query;
    }

    public function get_all_variable_statistic($user_id) {
        $query = $this->db->query("SELECT * FROM umb_kpi_variable WHERE user_id='$user_id'");
        return $query;
    }

    public function add($data){
        $this->db->insert('umb_kpi_variable', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_record_variable($id){
        $this->db->where('id', $id);
        $this->db->delete('umb_kpi_variable');
    }

    public function read_informasi_variable($id) {

        $condition = "id =" . "'" . $id . "'";
        $this->db->select('*');
        $this->db->from('umb_kpi_variable');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function update_record_variable($data, $id){
        $this->db->where('id', $id);
        if( $this->db->update('umb_kpi_variable',$data)) {
            return true;
        } else {
            return false;
        }       
    }  

    public function approve_variable($id){
        $this->db->where('id', $id);
        $this->db->set('approve_status', 'approved');
        if( $this->db->update('umb_kpi_variable')) {
            return true;
        } else {
            return false;
        }       
    }
}