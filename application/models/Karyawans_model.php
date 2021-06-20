<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawans_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function get_karyawans() {
		return $this->db->get("umb_karyawans");
	}

	public function get_karyawans_team_saya($cid) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE user_id != ? and laporans_to = ?';
		$binds = array(1,$cid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_karyawans_untuk_lainnya($cid) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE user_id != ? and perusahaan_id = ?';
		$binds = array(1,$cid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_karyawans_untuk_location($cid) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE user_id != ? and location_id = ?';
		$binds = array(1,$cid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_perusahaan_flt_karyawans($cid) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE perusahaan_id = ?';
		$binds = array($cid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_my_team_karyawans($laporans_to) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE laporans_to = ?';
		$binds = array($laporans_to);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_perusahaan_flt_location_karyawans($cid,$lid) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE perusahaan_id = ? and location_id = ?';
		$binds = array($cid,$lid);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_perusahaan_flt_location_department_karyawans($cid,$lid,$dep_id) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE perusahaan_id = ? and location_id = ? and department_id = ?';
		$binds = array($cid,$lid,$dep_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_perusahaan_flt_location_department_penunjukan_karyawans($cid,$lid,$dep_id,$des_id) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE perusahaan_id = ? and location_id = ? and department_id = ? and penunjukan_id = ?';
		$binds = array($cid,$lid,$dep_id,$des_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function get_karyawans_slipgaji() {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE user_role_id != ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	public function get_kehadiran_karyawans() {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE is_active = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function get_kehadiran_location_karyawans($location_id) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE location_id = ? and is_active = ?';
		$binds = array($location_id,1);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function get_total_karyawans() {
		$query = $this->db->get("umb_karyawans");
		return $query->num_rows();
	}
	
	public function read_informasi_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE user_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function check_karyawan_id($id) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}	

	public function check_old_password($old_password,$user_id) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE user_id = ?';
		$binds = array($user_id);
		$query = $this->db->query($sql, $binds);
		//$rw_password = $query->result();
		$options = array('cost' => 12);
		$password_hash = password_hash($old_password, PASSWORD_BCRYPT, $options);
		if ($query->num_rows() > 0) {
			$rw_password = $query->result();
			if(password_verify($old_password,$rw_password[0]->password)){
				return 1;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function check_username_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE username = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	public function check_email_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE email = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}

	public function check_pincode_karyawan($pincode) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE pincode = ?';
		$binds = array($pincode);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	
	public function add($data){
		$this->db->insert('umb_karyawans', $data);
		if ($this->db->affected_rows() > 0) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	public function delete_record($id){
		$this->db->where('user_id', $id);
		$this->db->delete('umb_karyawans');
		
	}
	
	public function update_record($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('umb_karyawans',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function basic_info($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('umb_karyawans',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function change_password($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('umb_karyawans',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function social_info($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('umb_karyawans',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function profile_picture($data, $id){
		$this->db->where('user_id', $id);
		if( $this->db->update('umb_karyawans',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function add_info_kontak($data){
		$this->db->insert('umb_kontaks_karyawan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function info_kontak_update($data, $id){
		$this->db->where('kontak_id', $id);
		if( $this->db->update('umb_kontaks_karyawan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function document_info_update($data, $id){
		$this->db->where('document_id', $id);
		if( $this->db->update('umb_documents_karyawan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function img_document_info_update($data, $id){
		$this->db->where('immigration_id', $id);
		if( $this->db->update('umb_karyawan_immigration',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function add_info_document($data){
		$this->db->insert('umb_documents_karyawan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function immigration_info_add($data){
		$this->db->insert('umb_karyawan_immigration', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}		
	}
	
	
	public function add_info_qualification($data){
		$this->db->insert('umb_karyawan_qualification', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function info_qualification_update($data, $id){
		$this->db->where('qualification_id', $id);
		if( $this->db->update('umb_karyawan_qualification',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function add_info_pengalaman_kerja($data){
		$this->db->insert('umb_karyawan_pengalaman_kerja', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function info_pengalaman_kerja_update($data, $id){
		$this->db->where('pengalaman_kerja_id', $id);
		if( $this->db->update('umb_karyawan_pengalaman_kerja',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function add_info_bank_account($data){
		$this->db->insert('umb_karyawan_bankaccount', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}		
	}
	public function info_security_level_add($data){
		$this->db->insert('umb_karyawan_security_level', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function info_bank_account_update($data, $id){
		$this->db->where('bankaccount_id', $id);
		if( $this->db->update('umb_karyawan_bankaccount',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	public function info_security_level_update($data, $id){
		$this->db->where('security_level_id', $id);
		if( $this->db->update('umb_karyawan_security_level',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function info_kontrak_add($data){
		$this->db->insert('umb_karyawan_kontrak', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function check_current_kontak_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_kontaks_karyawan WHERE karyawan_id = ? and type_kontak = ? limit 1';
		$binds = array($id,'current');
		$query = $this->db->query($sql, $binds);
		
		return $query;		
	}
	
	public function check_kontak_permanent_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_kontaks_karyawan WHERE karyawan_id = ? and type_kontak = ? limit 1';
		$binds = array($id,'permanent');
		$query = $this->db->query($sql, $binds);
		
		return $query;		
	}
	
	public function read_info_kontak_current($id) {
		
		$sql = 'SELECT * FROM umb_kontaks_karyawan WHERE kontak_id = ? and type_kontak = ? limit 1';
		$binds = array($id,'current');
		$query = $this->db->query($sql, $binds);
		
		$row = $query->row();
		return $row;
		
	}
	
	public function read_info_kontak_permanent($id) {
		
		$sql = 'SELECT * FROM umb_kontaks_karyawan WHERE kontak_id = ? and type_kontak = ? limit 1';
		$binds = array($id,'permanent');
		$query = $this->db->query($sql, $binds);
		
		$row = $query->row();
		return $row;
	}
	
	public function info_kontrak_update($data, $id){
		$this->db->where('kontrak_id', $id);
		if( $this->db->update('umb_karyawan_kontrak',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function info_cuti_add($data){
		$this->db->insert('umb_karyawan_cuti', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}		
	}

	public function info_cuti_update($data, $id){
		$this->db->where('cuti_id', $id);
		if( $this->db->update('umb_karyawan_cuti',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function info_shift_add($data){
		$this->db->insert('umb_karyawan_shift', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function info_shift_update($data, $id){
		$this->db->where('emp_shift_id', $id);
		if( $this->db->update('umb_karyawan_shift',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function info_location_add($data){
		$this->db->insert('umb_location_karyawan', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function info_location_update($data, $id){
		$this->db->where('location_kantor_id', $id);
		if( $this->db->update('umb_location_karyawan',$data)) {
			return true;
		} else {
			return false;
		}		
	}
	
	public function all_shifts_kantor() {
		$query = $this->db->query("SELECT * from umb_shift_kantor");
		return $query->result();
	}
	
	public function set_kontaks_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_kontaks_karyawan WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function set_documents_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_documents_karyawan WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function get_all_documents_kadaluarsa() {
		
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from umb_documents_karyawan where tanggal_kadaluarsa < '".$curr_date."' ORDER BY `tanggal_kadaluarsa` asc");
		return $query;
	}

	public function get_user_all_documents_kadaluarsa($karyawan_id) {
		
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from umb_documents_karyawan where karyawan_id = '".$karyawan_id."' and tanggal_kadaluarsa < '".$curr_date."' ORDER BY `tanggal_kadaluarsa` asc");
		return $query;
	}

	public function get_all_img_documents_kadaluarsa() {
		
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from umb_karyawan_immigration where tanggal_kaaluarsa < '".$curr_date."' ORDER BY `tanggal_kaaluarsa` asc");
		return $query;
	}

	public function get_user_all_img_documents_kadaluarsa($karyawan_id) {
		
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from umb_karyawan_immigration where karyawan_id = '".$karyawan_id."' and tanggal_kaaluarsa < '".$curr_date."' ORDER BY `tanggal_kaaluarsa` asc");
		return $query;
	}

	public function all_licence_perusahaan_kadaluarsa() {
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from umb_documents_perusahaan where tanggal_kaaluarsa < '".$curr_date."' ORDER BY `tanggal_kaaluarsa` asc");
		return $query;
	}

	public function get_licence_perusahaan_kadaluarsa($perusahaan_id) {
		
		$curr_date = date('Y-m-d');
		$sql = "SELECT * FROM umb_documents_perusahaan WHERE tanggal_kaaluarsa < '".$curr_date."' and perusahaan_id = ?";
		$binds = array($perusahaan_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	public function all_garansi_assets_kadaluarsa() {
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from umb_assets where tanggal_akhir_garansi < '".$curr_date."' ORDER BY `tanggal_akhir_garansi` asc");
		return $query;
	}

	public function user_all_garansi_assets_kadaluarsa($karyawan_id) {
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from umb_assets where karyawan_id = '".$karyawan_id."' and tanggal_akhir_garansi < '".$curr_date."' ORDER BY `tanggal_akhir_garansi` asc");
		return $query;
	}

	public function all_garansi_assets_perusahaan_kadaluarsa($perusahaan_id) {
		$curr_date = date('Y-m-d');
		$query = $this->db->query("SELECT * from umb_assets where perusahaan_id = '".$perusahaan_id."' and tanggal_akhir_garansi < '".$curr_date."' ORDER BY `tanggal_akhir_garansi` asc");
		return $query;
	}

	public function set_karyawan_immigration($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_immigration WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function set_qualification_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_qualification WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function set_pengalaman_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_pengalaman_kerja WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	
	public function set_bank_account_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_bankaccount WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function set_karyawan_security_level($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_security_level WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function get_karyawan_bank_account_terakhir($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_bankaccount WHERE karyawan_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	public function set_kontrak_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_kontrak WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function set_shift_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_shift WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function set_karyawan_cuti($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_cuti WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	
	public function set_location_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_location_karyawan WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}
	
	public function read_informasi_type_document($id) {
		
		$sql = 'SELECT * FROM umb_type_document WHERE type_document_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_type_kontrak($id) {
		
		$sql = 'SELECT * FROM umb_type_kontrak WHERE type_kontrak_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_kontrak($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_kontrak WHERE kontrak_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_infomasi_shift($id) {
		
		$sql = 'SELECT * FROM umb_shift_kantor WHERE shift_kantor_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function all_types_kontrak() {
		$query = $this->db->query("SELECT * from umb_type_kontrak");
		return $query->result();
	}
	
	public function all_kontrakk() {
		$query = $this->db->query("SELECT * from umb_karyawan_kontrak");
		return $query->result();
	}
	
	public function all_types_document() {
		$query = $this->db->query("SELECT * from umb_type_document");
		return $query->result();
	}
	
	public function all_tingkat_pendidikan() {
		$query = $this->db->query("SELECT * from umb_qualification_tingakat_pendidikan");
		return $query->result();
	}
	
	public function read_informasi_pendidikan($id) {
		
		$sql = 'SELECT * FROM umb_qualification_tingakat_pendidikan WHERE tingkat_pendidikan_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function all_qualification_language() {
		$query = $this->db->query("SELECT * from umb_qualification_language");
		return $query->result();
	}
	
	public function read_informasi_qualification_language($id) {
		
		$sql = 'SELECT * FROM umb_qualification_language WHERE language_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function all_qualification_skill() {
		$query = $this->db->query("SELECT * from umb_qualification_skill");
		return $query->result();
	} 
	
	public function read_informasi_qualification_skill($id) {
		
		$sql = 'SELECT * FROM umb_qualification_skill WHERE skill_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_kontak($id) {
		
		$sql = 'SELECT * FROM umb_kontaks_karyawan WHERE kontak_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_document($id) {
		
		$sql = 'SELECT * FROM umb_documents_karyawan WHERE document_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_imgdocument($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_immigration WHERE immigration_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_qualification($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_qualification WHERE qualification_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_pengalaman_kerja($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_pengalaman_kerja WHERE pengalaman_kerja_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_bank_account($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_bankaccount WHERE bankaccount_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_infomasi_security_level($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_security_level WHERE security_level_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_cuti($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_cuti WHERE cuti_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function read_informasi_shift_krywn($id) {
		
		$sql = 'SELECT * FROM umb_karyawan_shift WHERE emp_shift_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function delete_record_kontak($id){
		$this->db->where('kontak_id', $id);
		$this->db->delete('umb_kontaks_karyawan');
		
	}
	
	public function delete_record_document($id){
		$this->db->where('document_id', $id);
		$this->db->delete('umb_documents_karyawan');
		
	}
	
	public function delete_record_imgdocument($id){
		$this->db->where('immigration_id', $id);
		$this->db->delete('umb_karyawan_immigration');
		
	}
	
	public function delete_record_qualification($id){
		$this->db->where('qualification_id', $id);
		$this->db->delete('umb_karyawan_qualification');
		
	}
	
	public function delete_record_pengalaman_kerja($id){
		$this->db->where('pengalaman_kerja_id', $id);
		$this->db->delete('umb_karyawan_pengalaman_kerja');
		
	}
	
	public function delete_record_bank_account($id){
		$this->db->where('bankaccount_id', $id);
		$this->db->delete('umb_karyawan_bankaccount');
		
	}

	public function delete_record_security_level($id){
		$this->db->where('security_level_id', $id);
		$this->db->delete('umb_karyawan_security_level');
		
	}
	
	public function delete_record_kontrak($id){
		$this->db->where('kontrak_id', $id);
		$this->db->delete('umb_karyawan_kontrak');
		
	}
	
	public function delete_record_cuti($id){
		$this->db->where('cuti_id', $id);
		$this->db->delete('umb_karyawan_cuti');
		
	}
	
	public function delete_record_shift($id){
		$this->db->where('emp_shift_id', $id);
		$this->db->delete('umb_karyawan_shift');
		
	}
	
	public function delete_record_location($id){
		$this->db->where('location_kantor_id', $id);
		$this->db->delete('umb_location_karyawan');
		
	}
	
	public function read_informasi_location($id) {
		
		$sql = 'SELECT * FROM umb_location_karyawan WHERE location_kantor_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function record_count() {
		$sql = 'SELECT * FROM umb_karyawans where user_role_id!=1';
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
	public function record_count_myteam($laporans_to) {
		$sql = 'SELECT * FROM umb_karyawans where user_role_id!=1 and laporans_to = '.$laporans_to.'';
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function get_karyawan_by_department($cid) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE department_id = ?';
		$binds = array($cid);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function record_count_perusahaan_karyawans($cid) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE perusahaan_id = ?';
		$binds = array($cid);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}

	public function record_count_perusahaan_location_karyawans($cid,$lid) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE perusahaan_id = ? and location_id= ?';
		$binds = array($cid,$lid);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}

	public function record_count_perusahaan_location_department_karyawans($cid,$lid,$dep_id) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE perusahaan_id = ? and location_id= ? and department_id= ?';
		$binds = array($cid,$lid,$dep_id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}

	public function record_count_perusahaan_location_department_penunjukan_karyawans($cid,$lid,$dep_id,$des_id) {
		
		$sql = 'SELECT * FROM umb_karyawans WHERE perusahaan_id = ? and location_id= ? and department_id= ? and penunjukan_id= ?';
		$binds = array($cid,$lid,$dep_id,$des_id);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}

	public function fetch_all_team_karyawans($limit, $start) {
		$session = $this->session->userdata('username');
		$this->db->limit($limit, $start);
		$this->db->order_by("penunjukan_id asc");
		//$this->db->where("user_role_id!=",1);
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		$this->db->where("laporans_to",$session['user_id']);
		$this->db->where("user_role_id!=1");
		$query = $this->db->get("umb_karyawans");

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	public function fetch_all_karyawans($limit, $start) {
		$session = $this->session->userdata('username');
		$this->db->limit($limit, $start);
		$this->db->order_by("penunjukan_id asc");
		//$this->db->where("user_role_id!=",1);
		$user_info = $this->Umb_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id!=1){
			$this->db->where("perusahaan_id",$user_info[0]->perusahaan_id);
		}
		$this->db->where("user_role_id!=1");
		$query = $this->db->get("umb_karyawans");

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	public function fetch_all_flt_perusahaan_karyawans($limit, $start,$cid) {
		$session = $this->session->userdata('username');
		$this->db->limit($limit, $start);
		$this->db->order_by("penunjukan_id asc");
		$this->db->where("perusahaan_id",$cid);
		$query = $this->db->get("umb_karyawans");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	public function fetch_all_flt_perusahaan_location_karyawans($limit, $start,$cid,$lid) {
		$session = $this->session->userdata('username');
		$this->db->limit($limit, $start);
		$this->db->order_by("penunjukan_id asc");
		$this->db->where("perusahaan_id=",$cid);
		$this->db->where("location_id=",$lid);
		$query = $this->db->get("umb_karyawans");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	public function fetch_all_flt_perusahaan_location_department_karyawans($limit, $start,$cid,$lid,$dep_id) {
		$session = $this->session->userdata('username');
		$this->db->limit($limit, $start);
		$this->db->order_by("penunjukan_id asc");
		$this->db->where("perusahaan_id=",$cid);
		$this->db->where("location_id=",$lid);
		$this->db->where("department_id=",$dep_id);
		$query = $this->db->get("umb_karyawans");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	public function fetch_all_flt_perusahaan_location_department_penunjukan_karyawans($limit, $start,$cid,$lid,$dep_id,$des_id) {
		$session = $this->session->userdata('username');
		$this->db->limit($limit, $start);
		$this->db->order_by("penunjukan_id asc");
		$this->db->where("perusahaan_id=",$cid);
		$this->db->where("location_id=",$lid);
		$this->db->where("department_id=",$dep_id);
		$this->db->where("penunjukan_id=",$des_id);
		$query = $this->db->get("umb_karyawans");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	
	public function des_fetch_all_karyawans($limit, $start) {
       // $this->db->limit($limit, $start);
		$sql = 'SELECT * FROM umb_karyawans order by penunjukan_id asc limit ?, ?';
		$binds = array($limit,$start);
		$query = $this->db->query($sql, $binds);
      //  $query = $this->db->get("umb_karyawans");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	public function set_tunjanagans_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_gaji_tunjanagans WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function set_komissi_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_gaji_komissi WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function set_karyawan_statutory_potongans($id) {
		
		$sql = 'SELECT * FROM umb_gaji_statutory_potongans WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function set_karyawan_pembayarans_lainnya($id) {
		
		$sql = 'SELECT * FROM umb_gaji_pembayarans_lainnya WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function set_karyawan_lembur($id) {
		
		$sql = 'SELECT * FROM umb_gaji_lembur WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	

	public function set_potongans_karyawan($id) {
		
		$sql = 'SELECT * FROM umb_gaji_pinjaman_potongans WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function set_tunjanagans_karyawan_slipgaji($id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgaji_tunjanagans WHERE slipgaji_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function set_komissi_karyawan_slipgaji($id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgaji_komissi WHERE slipgaji_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function set_karyawan_pembayarans_lainnya_slipgaji($id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgaji_pembayarans_lainnya WHERE slipgaji_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function set_karyawan_statutory_potongans_slipgaji($id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgaji_statutory_potongans WHERE slipgaji_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function set_karyawan_lembur_slipgaji($id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgaji_lembur WHERE slipgaji_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	

	public function set_potongans_karyawan_slipgaji($id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgaji_pinjaman WHERE slipgaji_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}

	public function count_karyawan_tunjanagans_slipgaji($id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgaji_tunjanagans WHERE slipgaji_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}

	public function count_karyawan_komissi_slipgaji($id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgaji_komissi WHERE slipgaji_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}

	public function count_karyawan_statutory_potongans_slipgaji($id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgaji_statutory_potongans WHERE slipgaji_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}

	public function count_karyawan_pembayarans_lainnya_slipgaji($id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgaji_pembayarans_lainnya WHERE slipgaji_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}

	public function count_karyawan_lembur_slipgaji($id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgaji_lembur WHERE slipgaji_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	public function count_karyawan_potongans_slipgaji($id) {
		
		$sql = 'SELECT * FROM umb_gaji_slipgaji_pinjaman WHERE slipgaji_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}

	public function count_karyawan_tunjanagans($id) {
		
		$sql = 'SELECT * FROM umb_gaji_tunjanagans WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}

	public function count_karyawan_komissi($id) {
		
		$sql = 'SELECT * FROM umb_gaji_komissi WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}

	public function count_karyawan_pembayarans_lainnya($id) {
		
		$sql = 'SELECT * FROM umb_gaji_pembayarans_lainnya WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}

	public function count_karyawan_statutory_potongans($id) {
		
		$sql = 'SELECT * FROM umb_gaji_statutory_potongans WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}

	public function count_karyawan_lembur($id) {
		
		$sql = 'SELECT * FROM umb_gaji_lembur WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	public function count_karyawan_potongans($id) {
		
		$sql = 'SELECT * FROM umb_gaji_pinjaman_potongans WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		return $query->num_rows();
	}
	
	public function read_gaji_tunjanagans($id) {
		
		$sql = 'SELECT * FROM umb_gaji_tunjanagans WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_gaji_komissi($id) {
		
		$sql = 'SELECT * FROM umb_gaji_komissi WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_gaji_pembayarans_lainnya($id) {
		
		$sql = 'SELECT * FROM umb_gaji_pembayarans_lainnya WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_gaji_statutory_potongans($id) {
		
		$sql = 'SELECT * FROM umb_gaji_statutory_potongans WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_gaji_lembur($id) {
		
		$sql = 'SELECT * FROM umb_gaji_lembur WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_gaji_pinjaman_potongans($id) {
		
		$sql = 'SELECT * FROM umb_gaji_pinjaman_potongans WHERE karyawan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_single_potongans_pinjaman($id) {
		
		$sql = 'SELECT * FROM umb_gaji_pinjaman_potongans WHERE potongan_pinjaman_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function get_month_diff($start, $end = FALSE) {
		$end OR $end = time();
		$start = new DateTime($start);
		$end   = new DateTime($end);
		$diff  = $start->diff($end);
		return $diff->format('%y') * 12 + $diff->format('%m');
	}

	public function read_single_gaji_tunjanagan($id) {
		
		$sql = 'SELECT * FROM umb_gaji_tunjanagans WHERE tunjanagan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_single_gaji_komissi($id) {
		
		$sql = 'SELECT * FROM umb_gaji_komissi WHERE gaji_komissi_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_single_gaji_statutory_potongan($id) {
		
		$sql = 'SELECT * FROM umb_gaji_statutory_potongans WHERE statutory_potongans_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_single_gaji_pembayaran_lainnya($id) {
		
		$sql = 'SELECT * FROM umb_gaji_pembayarans_lainnya WHERE pembayarans_lainnya_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	public function read_record_gaji_lembur($id) {
		
		$sql = 'SELECT * FROM umb_gaji_lembur WHERE gaji_lembur_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	
	public function add_gaji_tunjanagans($data){
		$this->db->insert('umb_gaji_tunjanagans', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function add_gaji_komissi($data){
		$this->db->insert('umb_gaji_komissi', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function add_gaji_statutory_potongans($data){
		$this->db->insert('umb_gaji_statutory_potongans', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function add_gaji_pembayarans_lainnya($data){
		$this->db->insert('umb_gaji_pembayarans_lainnya', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function add_gaji_pinjaman($data){
		$this->db->insert('umb_gaji_pinjaman_potongans', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function add_gaji_lembur($data){
		$this->db->insert('umb_gaji_lembur', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function delete_record_tunjanagan($id){
		$this->db->where('tunjanagan_id', $id);
		$this->db->delete('umb_gaji_tunjanagans');
		
	}

	public function delete_record_komisi($id){
		$this->db->where('gaji_komissi_id', $id);
		$this->db->delete('umb_gaji_komissi');
		
	}

	public function delete_record_statutory_potongans($id){
		$this->db->where('statutory_potongans_id', $id);
		$this->db->delete('umb_gaji_statutory_potongans');
		
	}

	public function delete_record_pembayaran_lainnya($id){
		$this->db->where('pembayarans_lainnya_id', $id);
		$this->db->delete('umb_gaji_pembayarans_lainnya');
		
	}

	public function delete_record_pinajaman($id){
		$this->db->where('potongan_pinjaman_id', $id);
		$this->db->delete('umb_gaji_pinjaman_potongans');
		
	}

	public function delete_record_lembur($id){
		$this->db->where('gaji_lembur_id', $id);
		$this->db->delete('umb_gaji_lembur');
		
	}

	public function update_record_gaji_tunjanagan($data, $id){
		$this->db->where('tunjanagan_id', $id);
		if( $this->db->update('umb_gaji_tunjanagans',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function update_record_gaji_komissi($data, $id){
		$this->db->where('gaji_komissi_id', $id);
		if( $this->db->update('umb_gaji_komissi',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function update_record_gaji_statutory_potongan($data, $id){
		$this->db->where('statutory_potongans_id', $id);
		if( $this->db->update('umb_gaji_statutory_potongans',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function update_record_gaji_pembayaran_lainnya($data, $id){
		$this->db->where('pembayarans_lainnya_id', $id);
		if( $this->db->update('umb_gaji_pembayarans_lainnya',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function update_record_gaji_pinjaman($data, $id){
		$this->db->where('potongan_pinjaman_id', $id);
		if( $this->db->update('umb_gaji_pinjaman_potongans',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function update_record_gaji_lembur($data, $id){
		$this->db->where('gaji_lembur_id', $id);
		if( $this->db->update('umb_gaji_lembur',$data)) {
			return true;
		} else {
			return false;
		}		
	}

	public function ajax_perusahaan_informasi_shift_kantor($id) {
		
		$sql = 'SELECT * FROM umb_shift_kantor WHERE perusahaan_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
}
?>