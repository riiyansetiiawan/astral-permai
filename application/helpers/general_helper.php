<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function initialize_elfinder($value=''){
	$CI =& get_instance();
	$CI->load->helper('path');
	$opts = array(
	    //'debug' => true, 
		'roots' => array(
			array( 
				'driver' => 'LocalFileSystem', 
				'path'   => './uploads/files_manager/', 
				'URL'    => site_url('uploads/files_manager').'/'
			) 
		)
	);
	return $opts;
}

if ( ! function_exists('get_kategori_karyawan_cuti'))
{
	function get_kategori_karyawan_cuti($id_nums,$karyawan_id) {
		$CI =&	get_instance();
		$sql = "select e.kategoris_cuti,e.user_id,l.type_cuti_id,l.days_per_year,l.type_name from umb_karyawans as e, umb_type_cuti as l where l.type_cuti_id IN ($id_nums) and e.user_id = $karyawan_id";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}

if ( ! function_exists('get_sub_departments'))
{
	function get_sub_departments($id) {
		$CI =&	get_instance();
		$sql = "select * from umb_sub_departments where department_id = $id";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}

if ( ! function_exists('get_main_departments_karyawans'))
{
	function get_main_departments_karyawans() {
		$CI =&	get_instance();
		$sql = "select d.*,e.* from umb_departments as d, umb_karyawans as e where d.department_id = e.department_id";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}

if ( ! function_exists('get_sub_departments_karyawans'))
{
	function get_sub_departments_karyawans($id,$krywnid) {
		$CI =&	get_instance();
		$sql = "select d.*,e.* from umb_sub_departments as d, umb_karyawans as e where d.sub_department_id = e.sub_department_id and e.department_id = '".$id."' and e.karyawan_id!= '".$krywnid."' group by e.sub_department_id";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}

if ( ! function_exists('get_sub_departments_penunjukans'))
{
	function get_sub_departments_penunjukans($id,$krywnid,$mainid) {
		$CI =&	get_instance();
		$sql = "select d.*,e.* from umb_penunjukans as d, umb_karyawans as e where d.penunjukan_id = e.penunjukan_id and e.karyawan_id!= '".$krywnid."' and e.karyawan_id!= '".$mainid."' and e.penunjukan_id = '".$id."'";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}

if ( ! function_exists('get_main_chart_perusahaans'))
{
	function get_main_chart_perusahaans() {
		$CI =&	get_instance();
		$sql = "select * from umb_perusahaans";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}

if ( ! function_exists('get_main_chart_location_perusahaans'))
{
	function get_main_chart_location_perusahaans($perusahaan_id) {
		$CI =&	get_instance();
		$sql = "select * from umb_location_kantor where perusahaan_id = '".$perusahaan_id."'";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}

if ( ! function_exists('get_location_head_departments_karyawans'))
{
	function get_location_head_departments_karyawans($location_id) {
		$CI =&	get_instance();
		$sql = "select * from umb_departments where location_id = '".$location_id."'";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}

if ( ! function_exists('get_main_head_departments_karyawans'))
{
	function get_main_head_departments_karyawans() {
		$CI =&	get_instance();
		$sql = "select * from umb_departments";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}

if ( ! function_exists('hrastral_roles'))
{
	function hrastral_roles() {
		$CI =&	get_instance();
		$sql = "select * from umb_user_roles";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}

if ( ! function_exists('hrastral_shift_kantor'))
{
	function hrastral_shift_kantor() {
		$CI =&	get_instance();
		$sql = "select * from umb_shift_kantor";
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}

if ( ! function_exists('get_departments_penunjukans'))
{
	function get_departments_penunjukans($department_id,$karyawan_id) {
		$CI =&	get_instance();
		$CI->db->query("SET SESSION sql_mode = ''");
		$sql = "select d.*,e.* from umb_penunjukans as d, umb_karyawans as e where d.department_id= '".$department_id."' and d.penunjukan_id = e.penunjukan_id";
		$CI->db->group_by("d.penunjukan_id");
		$query = $CI->db->query($sql);
		$result = $query->result();
		return $result;
	}
}

if ( ! function_exists('total_bayar_gajii'))
{
	function total_bayar_gajii() {
		$CI =&	get_instance();
		$CI->db->from('umb_gaji_slipgajii');
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->gaji_bersih;
			}
			return $tinc;
		}else{
			return 0;
		}
	}

}

if ( ! function_exists('hrastral_payroll'))
{
	function hrastral_payroll($gaji_bulan) {
		$CI =&	get_instance();
		$CI->db->from('umb_gaji_slipgajii');
		$CI->db->where('gaji_bulan',$gaji_bulan);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->gaji_bersih;
			}
			return $tinc;
		}else{
			return 0;
		}
	}

}

if ( ! function_exists('ihrastral_user_payroll'))
{
	function ihrastral_user_payroll($gaji_bulan,$karyawan_id) {
		$CI =&	get_instance();
		$CI->db->from('umb_gaji_slipgajii');
		$CI->db->where('gaji_bulan',$gaji_bulan);
		$CI->db->where('karyawan_id',$karyawan_id);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->gaji_bersih;
			}
			return $tinc;
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('hrastral_payroll_this_month'))
{
	function hrastral_payroll_this_month() {
		$CI =&	get_instance();
		$CI->db->from('umb_gaji_slipgajii');
		$CI->db->where('gaji_bulan',date('Y-m'));
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->gaji_bersih;
			}
			return $tinc;
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('hrastral_user_payroll_this_month'))
{
	function hrastral_user_payroll_this_month($karyawan_id) {
		$CI =&	get_instance();
		$CI->db->from('umb_gaji_slipgajii');
		$CI->db->where('gaji_bulan',date('Y-m'));
		$CI->db->where('karyawan_id',$karyawan_id);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->gaji_bersih;
			}
			return $tinc;
		}else{
			return 0;
		}
	}

}

if ( ! function_exists('hrastral_payroll_6_bulan_terakhir'))
{
	function hrastral_payroll_6_bulan_terakhir() {
		$CI =&	get_instance();
		$fn = 0;
		for ($i = 0; $i <= 5; $i++)  {
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$CI->db->from('umb_gaji_slipgajii');
			$CI->db->where('gaji_bulan',$months);
			$query=$CI->db->get();
			$tinc = 0;
			$result = $query->result();
			foreach($result as $inc){
				$tinc += $inc->gaji_bersih;
			}
			$fn += $tinc;			
		}
		return $fn;
	}
}

if ( ! function_exists('hrastral_user_payroll_6_bulan_terakhir'))
{
	function hrastral_user_payroll_6_bulan_terakhir($karyawan_id) {
		$CI =&	get_instance();
		$fn = 0;
		for ($i = 0; $i <= 5; $i++)  {
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$CI->db->from('umb_gaji_slipgajii');
			$CI->db->where('gaji_bulan',$months);
			$CI->db->where('karyawan_id',$karyawan_id);
			$query=$CI->db->get();
			$tinc = 0;
			$result = $query->result();
			foreach($result as $inc){
				$tinc += $inc->gaji_bersih;
			}
			$fn += $tinc;			
		}
		return $fn;
	}
}

if ( ! function_exists('hrastral_payroll_1_tahun_terakhir'))
{
	function hrastral_payroll_1_tahun_terakhir() {
		$CI =&	get_instance();
		$fn = 0;
		for ($i = 0; $i <= 11; $i++)  {
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$CI->db->from('umb_gaji_slipgajii');
			$CI->db->where('gaji_bulan',$months);
			$query=$CI->db->get();
			$tinc = 0;
			$result = $query->result();
			foreach($result as $inc){
				$tinc += $inc->gaji_bersih;
			}
			$fn += $tinc;			
		}
		return $fn;
	}
}

if ( ! function_exists('hrastral_user_payroll_1_tahun_terakhir'))
{
	function hrastral_user_payroll_1_tahun_terakhir($karyawan_id) {
		$CI =&	get_instance();
		$fn = 0;
		for ($i = 0; $i <= 11; $i++)  {
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$CI->db->from('umb_gaji_slipgajii');
			$CI->db->where('gaji_bulan',$months);
			$CI->db->where('karyawan_id',$karyawan_id);
			$query=$CI->db->get();
			$tinc = 0;
			$result = $query->result();
			foreach($result as $inc){
				$tinc += $inc->gaji_bersih;
			}
			$fn += $tinc;			
		}
		return $fn;
	}
}

if ( ! function_exists('hrastral_payroll_2_tahun_terakhir'))
{
	function hrastral_payroll_2_tahun_terakhir() {
		$CI =&	get_instance();
		$fn = 0;
		for ($i = 0; $i <= 23; $i++)  {
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$CI->db->from('umb_gaji_slipgajii');
			$CI->db->where('gaji_bulan',$months);
			$query=$CI->db->get();
			$tinc = 0;
			$result = $query->result();
			foreach($result as $inc){
				$tinc += $inc->gaji_bersih;
			}
			$fn += $tinc;			
		}
		return $fn;
	}
}

if ( ! function_exists('hrastral_user_payroll_2_tahun_terakhir'))
{
	function hrastral_user_payroll_2_tahun_terakhir($karyawan_id) {
		$CI =&	get_instance();
		$fn = 0;
		for ($i = 0; $i <= 23; $i++)  {
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$CI->db->from('umb_gaji_slipgajii');
			$CI->db->where('gaji_bulan',$months);
			$CI->db->where('karyawan_id',$karyawan_id);
			$query=$CI->db->get();
			$tinc = 0;
			$result = $query->result();
			foreach($result as $inc){
				$tinc += $inc->gaji_bersih;
			}
			$fn += $tinc;			
		}
		return $fn;
	}
}

if ( ! function_exists('hrastral_payroll_2_tahun_terakhir'))
{
	function hrastral_payroll_2_tahun_terakhir() {
		$CI =&	get_instance();
		$fn = 0;
		for ($i = 0; $i <= 35; $i++)  {
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$CI->db->from('umb_gaji_slipgajii');
			$CI->db->where('gaji_bulan',$months);
			$query=$CI->db->get();
			$tinc = 0;
			$result = $query->result();
			foreach($result as $inc){
				$tinc += $inc->gaji_bersih;
			}
			$fn += $tinc;			
		}
		return $fn;
	}
}

if ( ! function_exists('hrastral_user_payroll_3_tahun_terakhir'))
{
	function hrastral_user_payroll_3_tahun_terakhir($karyawan_id) {
		$CI =&	get_instance();
		$fn = 0;
		for ($i = 0; $i <= 35; $i++)  {
			$months = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
			$CI->db->from('umb_gaji_slipgajii');
			$CI->db->where('gaji_bulan',$months);
			$CI->db->where('karyawan_id',$karyawan_id);
			$query=$CI->db->get();
			$tinc = 0;
			$result = $query->result();
			foreach($result as $inc){
				$tinc += $inc->gaji_bersih;
			}
			$fn += $tinc;			
		}
		return $fn;
	}
}

if ( ! function_exists('total_invoices_bayar'))
{
	function total_invoices_bayar() {
		$CI =&	get_instance();
		$CI->db->from('umb_keuangan_transaksi');
		$CI->db->where('type_transaksi','pendapatan');
		$CI->db->where('dr_cr','cr');	
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->jumlah;
			}
			return $tinc;
		}else{
			return 0;
		}
	}

}

if ( ! function_exists('count_info_cutii'))
{
	function count_info_cutii($type_cuti_id,$karyawan_id) {
		$CI =&	get_instance();
		$CI->db->from('umb_applications_cuti');
		$CI->db->where('karyawan_id',$karyawan_id);
		$CI->db->where('type_cuti_id',$type_cuti_id);
		$CI->db->where('status=',2);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$ifrom_date =  $inc->from_date;
				$ito_date =  $inc->to_date;
				$datetime1 = new DateTime($ifrom_date);
				$datetime2 = new DateTime($ito_date);
				$interval = $datetime1->diff($datetime2);
				if(strtotime($inc->from_date) == strtotime($inc->to_date)){
					$tinc +=1;
				} else {
					$tinc += $interval->format('%a') + 1;
				}
			}
			return $tinc;
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('total_tickets'))
{
	function total_tickets() {
		$CI =&	get_instance();
		$CI->db->from('umb_support_tickets');
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('total_open_tickets'))
{
	function total_open_tickets() {
		$CI =&	get_instance();
		$CI->db->from('umb_support_tickets');
		$CI->db->where('status_ticket',1);
		$query = $CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('total_closed_tickets'))
{
	function total_closed_tickets() {
		$CI =&	get_instance();
		$CI->db->from('umb_support_tickets');
		$CI->db->where('status_ticket',2);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('active_karyawans'))
{
	function active_karyawans() {
		$CI =&	get_instance();
		$CI->db->from('umb_karyawans');
		$CI->db->where('is_active',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('inactive_karyawans'))
{
	function inactive_karyawans() {
		$CI =&	get_instance();
		$CI->db->from('umb_karyawans');
		$CI->db->where('is_active',0);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('completed_tugass'))
{
	function completed_tugass() {
		$CI =&	get_instance();
		$CI->db->from('umb_tugass');
		$CI->db->where('status_tugas',2);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('inprogress_tugass'))
{
	function inprogress_tugass() {
		$CI =&	get_instance();
		$CI->db->from('umb_tugass');
		$CI->db->where('status_tugas',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('total_saldo_accounts'))
{
	function total_saldo_accounts() {
		$CI =&	get_instance();
		$CI->db->from('umb_keuangan_bankcash');
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->saldo_account;
			}
			return $tinc;
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('system_settings_info'))
{
	function system_settings_info($id) {
		$CI =&	get_instance();
		$CI->db->from('umb_system_setting');
		$CI->db->where('setting_id',$id);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}else{
			return "";
		}
	}
}

if ( ! function_exists('umb_info_perusahaan'))
{
	function umb_info_perusahaan($id) {
		$CI =&	get_instance();
		$CI->db->from('umb_info_perusahaan');
		$CI->db->where('info_perusahaan_id',$id);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}else{
			return "";
		}
	}

}

if ( ! function_exists('read_record_invoice'))
{
	function read_record_invoice($id) {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_invoices');
		$CI->db->where('invoice_id',$id);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->row();
			return $result;
		}else{
			return "";
		}
	}
}

if ( ! function_exists('get_record_transaksi_invoice'))
{
	function get_record_transaksi_invoice($id) {
		$CI =&	get_instance();
		$CI->db->from('umb_keuangan_transaksi');
		$CI->db->where('type_transaksi','pendapatan');
		$CI->db->where('invoice_id',$id);
		$query=$CI->db->get();
		return $query;
	}
}

if ( ! function_exists('system_currency_sign'))
{
	function system_currency_sign($number) {
		
		$system_setting = system_settings_info(1);
		if($system_setting->show_currency=='code'){
			$ar_sc = explode(' -',$system_setting->default_currency_symbol);
			$sc_show = $ar_sc[0];
		} else {
			$ar_sc = explode('- ',$system_setting->default_currency_symbol);
			$sc_show = $ar_sc[1];
		}
		if($system_setting->currency_position=='Prefix'){
			$sign_value = $sc_show.''.$number;
		} else {
			$sign_value = $number.''.$sc_show;
		}
		return $sign_value;
	}
}

if ( ! function_exists('clients_count_bayar_invoice'))
{
	function clients_count_bayar_invoice($cid) {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_invoices');
		$CI->db->where('client_id',$cid);
		$CI->db->where('status',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('count_all_bayar_invoice'))
{
	function count_all_bayar_invoice() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_invoices');
		$CI->db->where('status',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('count_all_invoice_belum_dibayar'))
{
	function count_all_invoice_belum_dibayar() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_invoices');
		$CI->db->where('status',0);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('count_invoice_clients_belum_dibayar'))
{
	function count_invoice_clients_belum_dibayar($cid) {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_invoices');
		$CI->db->where('client_id',$cid);
		$CI->db->where('status',0);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('clients_project_inprogress'))
{
	function clients_project_inprogress($cid) {
		$CI =&	get_instance();
		$CI->db->from('umb_projects');
		$CI->db->where('client_id',$cid);
		$CI->db->where('status',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('clients_project_completed'))
{
	function clients_project_completed($cid) {
		$CI =&	get_instance();
		$CI->db->from('umb_projects');
		$CI->db->where('client_id',$cid);
		$CI->db->where('status',2);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('clients_project_belum_mulai'))
{
	function clients_project_belum_mulai($cid) {
		$CI =&	get_instance();
		$CI->db->from('umb_projects');
		$CI->db->where('client_id',$cid);
		$CI->db->where('status',0);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('clients_project_deffered'))
{
	function clients_project_deffered($cid) {
		$CI =&	get_instance();
		$CI->db->from('umb_projects');
		$CI->db->where('client_id',$cid);
		$CI->db->where('status',3);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('clients_jumlah_bayar_invoice'))
{
	function clients_jumlah_bayar_invoice($cid) {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_invoices');
		$CI->db->where('client_id',$cid);
		$CI->db->where('status',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->grand_total;
			}
			return $tinc;
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('all_jumlah_bayar_invoice'))
{
	function all_jumlah_bayar_invoice() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_invoices');
		$CI->db->where('status',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->grand_total;
			}
			return $tinc;
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('all_jumlah_invoice_belum_dibayar'))
{
	function all_jumlah_invoice_belum_dibayar() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_invoices');
		$CI->db->where('status',0);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->grand_total;
			}
			return $tinc;
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('clients_jumlah_invoice_belum_dibayar'))
{
	function clients_jumlah_invoice_belum_dibayar($cid) {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_invoices');
		$CI->db->where('client_id',$cid);
		$CI->db->where('status',0);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->grand_total;
			}
			return $tinc;
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('client_info_invoice_terakhir'))
{
	function client_info_invoice_terakhir() {
		$CI =&	get_instance();
		$sql = 'SELECT * FROM umb_hrastral_invoices order by invoice_id desc limit 1';
		$query = $CI->db->query($sql);		
		if ($query->num_rows() > 0) {
			$inv = $query->result();
			if(!is_null($inv)) {
				return $invid = $inv[0]->invoice_id;
			} else {
				return $invid = 0;
			}
		} else {
			return $invid = 0;
		}
	}
}

if ( ! function_exists('total_biaya_perjalanan'))
{
	function total_biaya_perjalanan() {
		$CI =&	get_instance();
		$CI->db->from('umb_perjalanans_karyawan');
		$CI->db->where('status',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->actual_budget;
			}
			return $tinc;
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('total_perjalanan'))
{
	function total_perjalanan() {
		$CI =&	get_instance();
		$CI->db->from('umb_perjalanans_karyawan');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('pending_perjalanan'))
{
	function pending_perjalanan() {
		$CI =&	get_instance();
		$CI->db->from('umb_perjalanans_karyawan');
		$CI->db->where('status',0);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('pending_permintaan_cuti'))
{
	function pending_permintaan_cuti() {
		$CI =&	get_instance();
		$CI->db->from('umb_applications_cuti');
		$CI->db->where('status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('accepted_permintaan_cuti'))
{
	function accepted_permintaan_cuti() {
		$CI =&	get_instance();
		$CI->db->from('umb_applications_cuti');
		$CI->db->where('status',2);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('rejected_permintaan_cuti'))
{
	function rejected_permintaan_cuti() {
		$CI =&	get_instance();
		$CI->db->from('umb_applications_cuti');
		$CI->db->where('status',3);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('rejected_permintaan_cuti'))
{
	function rejected_permintaan_cuti() {
		$CI =&	get_instance();
		$CI->db->from('umb_applications_cuti');
		$CI->db->where('status',3);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_shifts_karyawan'))
{
	function total_shifts_karyawan() {
		$CI =&	get_instance();
		$CI->db->from('umb_shift_kantor');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('accepted_perjalanan'))
{
	function accepted_perjalanan() {
		$CI =&	get_instance();
		$CI->db->from('umb_perjalanans_karyawan');
		$CI->db->where('status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('rejected_perjalanan'))
{
	function rejected_perjalanan() {
		$CI =&	get_instance();
		$CI->db->from('umb_perjalanans_karyawan');
		$CI->db->where('status',2);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_training'))
{
	function total_training() {
		$CI =&	get_instance();
		$CI->db->from('umb_training');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_pending_training'))
{
	function total_pending_training() {
		$CI =&	get_instance();
		$CI->db->from('umb_training');
		$CI->db->where('status_training',0);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_training'))
{
	function total_training() {
		$CI =&	get_instance();
		$CI->db->from('umb_training');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_started_training'))
{
	function total_started_training() {
		$CI =&	get_instance();
		$CI->db->from('umb_training');
		$CI->db->where('status_training',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_completed_training'))
{
	function total_completed_training() {
		$CI =&	get_instance();
		$CI->db->from('umb_training');
		$CI->db->where('status_training',2);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_assets'))
{
	function total_assets() {
		$CI =&	get_instance();
		$CI->db->from('umb_assets');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_projects'))
{
	function total_projects() {
		$CI =&	get_instance();
		$CI->db->from('umb_projects');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_projects_terakhir'))
{
	function total_projects_terakhir() {
		$CI =&	get_instance();
		$CI->db->from('umb_projects');
		$CI->db->order_by("project_id", "desc");
		$CI->db->limit(3);
		$query=$CI->db->get();
		return $query->result();
	}
}

if ( ! function_exists('total_tugass_terakhir'))
{
	function total_tugass_terakhir() {
		$CI =&	get_instance();
		$CI->db->from('umb_tugass');
		$CI->db->order_by("tugas_id", "desc");
		$CI->db->limit(3);
		$query=$CI->db->get();
		return $query->result();
	}
}

if ( ! function_exists('total_invoices_terakhir'))
{
	function total_invoices_terakhir() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_invoices');
		$CI->db->order_by("invoice_id", "desc");
		$CI->db->limit(4);
		$query=$CI->db->get();
		return $query->result();
	}
}

if ( ! function_exists('total_cutii_terakhir'))
{
	function total_cutii_terakhir() {
		$CI =&	get_instance();
		$CI->db->from('umb_applications_cuti');
		$CI->db->order_by("cuti_id", "desc");
		$CI->db->limit(5);
		$query=$CI->db->get();
		return $query->result();
	}
}

if ( ! function_exists('total_liburan_terakhir'))
{
	function total_liburan_terakhir() {
		$CI =&	get_instance();
		$CI->db->from('umb_liburan');
		$CI->db->order_by("libur_id", "desc");
		$CI->db->limit(2);
		$query=$CI->db->get();
		return $query->result();
	}
}

if ( ! function_exists('total_permintaan_lembur_terakhir'))
{
	function total_permintaan_lembur_terakhir() {
		$CI =&	get_instance();
		$CI->db->from('umb_permintaan_waktu_kehadiran');
		$CI->db->order_by("permintaan_waktu_id", "desc");
		$CI->db->limit(2);
		$query=$CI->db->get();
		return $query->result();
	}
}

if ( ! function_exists('total_last_estimates'))
{
	function total_last_estimates() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_quotes');
		$CI->db->order_by("quote_id", "desc");
		$CI->db->limit(4);
		$query=$CI->db->get();
		return $query->result();
	}
}

if ( ! function_exists('total_5_pembayarans_invoice_terakhir'))
{
	function total_5_pembayarans_invoice_terakhir() {
		$CI =&	get_instance();
		$CI->db->from('umb_keuangan_transaksi');
		$CI->db->order_by("transaksi_id", "desc");
		$CI->db->where('invoice_id!=','');
		$CI->db->limit(5);
		$query=$CI->db->get();
		return $query->result();
	}
}

if ( ! function_exists('total_clients_terakhir'))
{
	function total_clients_terakhir() {
		$CI =&	get_instance();
		$CI->db->from('umb_clients');
		$CI->db->order_by("client_id", "desc");
		$CI->db->limit(3);
		$query=$CI->db->get();
		return $query->result();
	}
}
if ( ! function_exists('total_leads_terakhir'))
{
	function total_leads_terakhir() {
		$CI =&	get_instance();
		$CI->db->from('umb_leads');
		$CI->db->order_by("client_id", "desc");
		$CI->db->limit(3);
		$query=$CI->db->get();
		return $query->result();
	}
}

if ( ! function_exists('total_5_qprojects_terakhir'))
{
	function total_5_qprojects_terakhir() {
		$CI =&	get_instance();
		$CI->db->from('umb_quoted_projects');
		$CI->db->order_by("project_id", "desc");
		$CI->db->limit(5);
		$query=$CI->db->get();
		return $query->result();
	}
}

if ( ! function_exists('get_status_projects'))
{
	function get_status_projects() {
		$CI =&	get_instance();
		$CI->db->query("SET SESSION sql_mode = ''");
		$CI->db->from('umb_projects');
		$CI->db->group_by("status");
		$query=$CI->db->get();
		return $query;
	}
}

if ( ! function_exists('get_client_status_projects'))
{
	function get_client_status_projects($client_id) {
		$CI =&	get_instance();
		$CI->db->query("SET SESSION sql_mode = ''");
		$CI->db->from('umb_projects');
		$CI->db->where('client_id',$client_id);
		$CI->db->group_by("status");
		$query=$CI->db->get();
		return $query;
	}
}

if ( ! function_exists('get_status_tugass'))
{
	function get_status_tugass() {
		$CI =&	get_instance();
		$CI->db->query("SET SESSION sql_mode = ''");
		$CI->db->from('umb_tugass');
		$CI->db->group_by("status_tugas");
		$query=$CI->db->get();
		return $query;
	}
}

if ( ! function_exists('get_user_status_projects'))
{
	function get_user_status_projects($karyawan_id) {
		$CI =&	get_instance();
		$CI->db->query("SET SESSION sql_mode = ''");
		$sql = "SELECT * FROM `umb_projects` where assigned_to like '%$karyawan_id,%' or assigned_to like '%,$karyawan_id%' or assigned_to = '$karyawan_id' group by status";
		
		$query = $CI->db->query($sql);
		//$CI->db->group_by("status");
		//$query=$CI->db->get();
		return $query;
	}
}

if ( ! function_exists('total_user_status_projects'))
{
	function total_user_status_projects($status) {
		$CI =&	get_instance();
		$sql = "SELECT * FROM `umb_projects` where status = '$status'";
		//$CI->db->group_by("status");
		$query = $CI->db->query($sql);
		//$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('get_user_status_tugass'))
{
	function get_user_status_tugass($karyawan_id) {
		$CI =&	get_instance();
		$CI->db->query("SET SESSION sql_mode = ''");		
		$sql = "SELECT * FROM `umb_tugass` where assigned_to like '%$karyawan_id,%' or assigned_to like '%,$karyawan_id%' or assigned_to = '$karyawan_id' group by status_tugas";		
		$query = $CI->db->query($sql);
		return $query;
	}
}

if ( ! function_exists('total_user_status_tugass'))
{
	function total_user_status_tugass($status,$karyawan_id) {
		$CI =&	get_instance();
		//$CI->db->from('umb_tugass');
		$sql = "SELECT * FROM `umb_tugass` where status_tugas = '$status'";
		$query = $CI->db->query($sql);
		return $query->num_rows();
	}
}

if ( ! function_exists('total_status_projects'))
{
	function total_status_projects($status) {
		$CI =&	get_instance();
		$CI->db->from('umb_projects');
		$CI->db->where('status',$status);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_client_status_projects'))
{
	function total_client_status_projects($status,$client_id) {
		$CI =&	get_instance();
		$CI->db->from('umb_projects');
		$CI->db->where('client_id',$client_id);
		$CI->db->where('status',$status);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_status_tugass'))
{
	function total_status_tugass($status) {
		$CI =&	get_instance();
		$CI->db->from('umb_tugass');
		$CI->db->where('status_tugas',$status);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_tugass'))
{
	function total_tugass() {
		$CI =&	get_instance();
		$CI->db->from('umb_tugass');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_completed_tugass'))
{
	function total_completed_tugass() {
		$CI =&	get_instance();
		$CI->db->from('umb_tugass');
		$CI->db->where('status_tugas',2);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_inprogress_tugass'))
{
	function total_inprogress_tugass() {
		$CI =&	get_instance();
		$CI->db->from('umb_tugass');
		$CI->db->where('status_tugas',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_cancelled_projects'))
{
	function total_cancelled_projects() {
		$CI =&	get_instance();
		$CI->db->from('umb_projects');
		$CI->db->where('status',3);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_completed_projects'))
{
	function total_completed_projects() {
		$CI =&	get_instance();
		$CI->db->from('umb_projects');
		$CI->db->where('status',2);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_clients'))
{
	function total_clients() {
		$CI =&	get_instance();
		$CI->db->from('umb_clients');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_leads'))
{
	function total_leads() {
		$CI =&	get_instance();
		$CI->db->from('umb_leads');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_leads_converted'))
{
	function total_leads_converted() {
		$CI =&	get_instance();
		$CI->db->from('umb_leads');
		$CI->db->where('is_changed',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_invoices'))
{
	function total_invoices() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_invoices');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_yang_dibayarkan_invoices'))
{
	function total_yang_dibayarkan_invoices() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_invoices');
		$CI->db->where('status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_belum_dibayar_invoices'))
{
	function total_belum_dibayar_invoices() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_invoices');
		$CI->db->where('status',0);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_estimate'))
{
	function total_estimate() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_quotes');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_estimate_converted'))
{
	function total_estimate_converted() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_quotes');
		$CI->db->where('status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_quoted_projects'))
{
	function total_quoted_projects() {
		$CI =&	get_instance();
		$CI->db->from('umb_quoted_projects');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_assets_working'))
{
	function total_assets_working() {
		$CI =&	get_instance();
		$CI->db->from('umb_assets');
		$CI->db->where('sedang_bekerja',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('total_assets_not_working'))
{
	function total_assets_not_working() {
		$CI =&	get_instance();
		$CI->db->from('umb_assets');
		$CI->db->where('sedang_bekerja',0);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('cr_quote_quoted'))
{
	function cr_quote_quoted() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_quotes');
		$CI->db->where('status',0);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('cr_quote_project_created'))
{
	function cr_quote_project_created() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_quotes');
		$CI->db->where('status',1);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('cr_quote_inprogress'))
{
	function cr_quote_inprogress() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_quotes');
		$CI->db->where('status',2);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('cr_quote_project_completed'))
{
	function cr_quote_project_completed() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_quotes');
		$CI->db->where('status',3);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('cr_quote_invoiced'))
{
	function cr_quote_invoiced() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_quotes');
		$CI->db->where('status',4);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('cr_quote_bayar'))
{
	function cr_quote_bayar() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_quotes');
		$CI->db->where('status',5);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('cr_quote_deffered'))
{
	function cr_quote_deffered() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_quotes');
		$CI->db->where('status',6);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('karyawan_cal_cuti_setengahari'))
{
	function karyawan_cal_cuti_setengahari($type_cuti_id,$karyawan_id) {
		$CI =&	get_instance();
		$CI->db->from('umb_applications_cuti');
		$CI->db->where('karyawan_id',$karyawan_id);
		$CI->db->where('type_cuti_id',$type_cuti_id);
		$CI->db->where('is_half_day',1);
		$CI->db->where('status=',2);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}else{
			return $query->result();
		}
	}
}

if ( ! function_exists('karyawan_permintaan_cutii'))
{
	function karyawan_permintaan_cutii() {
		$CI =&	get_instance();
		$CI->db->from('umb_applications_cuti');
		//$CI->db->where('status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}
if ( ! function_exists('karyawan_liburan'))
{
	function karyawan_liburan() {
		$CI =&	get_instance();
		$CI->db->from('umb_liburan');
		//$CI->db->where('status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('karyawan_published_liburan'))
{
	function karyawan_published_liburan() {
		$CI =&	get_instance();
		$CI->db->from('umb_liburan');
		$CI->db->where('is_publish',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('karyawan_unpublished_liburan'))
{
	function karyawan_unpublished_liburan() {
		$CI =&	get_instance();
		$CI->db->from('umb_liburan');
		$CI->db->where('is_publish',0);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('karyawan_permintaan_lembur'))
{
	function karyawan_permintaan_lembur() {
		$CI =&	get_instance();
		$CI->db->from('umb_permintaan_waktu_kehadiran');
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('karyawan_approved_permintaan_lembur'))
{
	function karyawan_approved_permintaan_lembur() {
		$CI =&	get_instance();
		$CI->db->from('umb_permintaan_waktu_kehadiran');
		$CI->db->where('is_approved',2);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('karyawan_pending_permintaan_lembur'))
{
	function karyawan_pending_permintaan_lembur() {
		$CI =&	get_instance();
		$CI->db->from('umb_permintaan_waktu_kehadiran');
		$CI->db->where('is_approved',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('karyawan_rejected_permintaan_lembur'))
{
	function karyawan_rejected_permintaan_lembur() {
		$CI =&	get_instance();
		$CI->db->from('umb_permintaan_waktu_kehadiran');
		$CI->db->where('is_approved',3);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('dashboard_total_sales'))
{
	function dashboard_total_sales() {
		$CI =&	get_instance();
		$CI->db->from('umb_keuangan_transaksi');
		$CI->db->where('type_transaksi','pendapatan');
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$tinc = 0;
			foreach($result as $inc){
				$tinc += $inc->jumlah;
			}
			return $tinc;
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('dashboard_total_biaya'))
{
	function dashboard_total_biaya() {
		$CI =&	get_instance();
		$CI->db->from('umb_keuangan_transaksi');
		$CI->db->where('type_transaksi','biaya');
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			$texp = 0;
			foreach($result as $exp){
				$texp += $exp->jumlah;
			}
			return $texp;
		}else{
			return 0;
		}
	}
}

if ( ! function_exists('dashboard_total_penerima_pembayarans'))
{
	function dashboard_total_penerima_pembayarans() {
		$CI =&	get_instance();
		$CI->db->from("umb_keuangan_penerima_pembayarans");
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('dashboard_total_pembayars'))
{
	function dashboard_total_pembayars() {
		$CI =&	get_instance();
		$CI->db->from("umb_keuangan_pembayars");
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('dashboard_bayar_invoices'))
{
	function dashboard_bayar_invoices() {
		$CI =&	get_instance();
		$CI->db->from("umb_hrastral_invoices");
		$CI->db->where('status',1);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('dashboard_belum_dibayar_invoices'))
{
	function dashboard_belum_dibayar_invoices() {
		$CI =&	get_instance();
		$CI->db->from("umb_hrastral_invoices");
		$CI->db->where('status',0);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('dashboard_cancelled_invoices'))
{
	function dashboard_cancelled_invoices() {
		$CI =&	get_instance();
		$CI->db->from("umb_hrastral_invoices");
		$CI->db->where('status',2);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('dashboard_dua_invoices_terakhir'))
{
	function dashboard_dua_invoices_terakhir() {
		$CI =&	get_instance();
		$CI->db->from('umb_hrastral_invoices');
		$CI->db->order_by('invoice_id','desc');
		$CI->db->limit(2);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}
}

if ( ! function_exists('dashboard_bankcash'))
{
	function dashboard_bankcash() {
		$CI =&	get_instance();
		$CI->db->from("umb_keuangan_bankcash");
		$CI->db->order_by('bankcash_id','asc');
		$CI->db->limit(6);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}
}

if ( ! function_exists('dashboard_lima_pendapatan_terakhir'))
{
	function dashboard_lima_pendapatan_terakhir() {
		$CI =&	get_instance();
		$CI->db->from('umb_keuangan_transaksi');
		$CI->db->where('type_transaksi','pendapatan');
		$CI->db->order_by('transaksi_id','desc');
		$CI->db->limit(4);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}

}

if ( ! function_exists('dashboard_lima_biaya_terakhir'))
{
	function dashboard_lima_biaya_terakhir() {
		$CI =&	get_instance();
		$CI->db->from('umb_keuangan_transaksi');
		$CI->db->where('type_transaksi','biaya');
		$CI->db->order_by('transaksi_id','desc');
		$CI->db->limit(4);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}

}

if ( ! function_exists('record_transaksi_pendapatan'))
{
	function record_transaksi_pendapatan() {
		$CI =&	get_instance();
		$CI->db->from('umb_keuangan_transaksi');
		$CI->db->where('type_transaksi','pendapatan');
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}

}

if ( ! function_exists('record_transaksi_awards'))
{
	function record_transaksi_awards() {
		$CI =&	get_instance();
		$CI->db->from('umb_awards');
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}
}

if ( ! function_exists('record_transaksi_perjalanan'))
{
	function record_transaksi_perjalanan() {
		$CI =&	get_instance();
		$CI->db->from('umb_perjalanans_karyawan');
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}
}

if ( ! function_exists('record_transaksi_payroll'))
{
	function record_transaksi_payroll() {
		$CI =&	get_instance();
		$CI->db->from('umb_gaji_slipgajii');
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}
}

if ( ! function_exists('record_transaksi_training'))
{
	function record_transaksi_training() {
		$CI =&	get_instance();
		$CI->db->from('umb_training');
		$CI->db->where('status_training',2);
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}
}

if ( ! function_exists('record_transaksi_pembayarans_invoice'))
{
	function record_transaksi_pembayarans_invoice() {
		$CI =&	get_instance();
		$CI->db->from('umb_keuangan_transaksi');
		$CI->db->where('type_transaksi','pendapatan');
		$CI->db->where('description','Invoice Pembayaran');
		$query=$CI->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result();
			return $result;
		}else{
			$result = $query->result();
			return $result;
		}
	}
}

if ( ! function_exists('get_laporans_to'))
{
	function get_laporans_to() {
		$CI =&	get_instance();
		$CI->db->from("umb_karyawans");
		$CI->db->where('user_role_id!=',1);
		$query=$CI->db->get();
		return $query->result();
	}
}

if ( ! function_exists('get_data_laporans_team'))
{
	function get_data_laporans_team($laporans_to) {
		$CI =&	get_instance();
		$CI->db->from("umb_karyawans");
		$CI->db->where('laporans_to',$laporans_to);
		$query=$CI->db->get();
		return $query->num_rows();
	}
}

if ( ! function_exists('hrastral_team'))
{
	function hrastral_team() {
		$CI =&	get_instance();
		$CI->db->from("umb_karyawans");
		$CI->db->where('laporans_to!=',0);
		//$CI->db->group_by('laporans_to'); 
		$query=$CI->db->get();
		return $query->result();
	}
}
?>