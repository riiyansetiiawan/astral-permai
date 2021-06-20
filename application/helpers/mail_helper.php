<?php

if( !function_exists('hrastral_mail') ){

	function hrastral_mail($from,$from_name,$to,$subject,$body){
		
		$CI=& get_instance();
		if(email_type()=="codeigniter"){
			$CI->load->library('email');
			$CI->email->set_mailtype("html");
			$CI->email->from($from,$from_name);
			$CI->email->to($to);
			
			$CI->email->subject($subject);
			$CI->email->message($body);
			
			$CI->email->send();
			
			
		} else if(email_type()=="smtp"){
			$CI->load->library('email');
			$CI->email->set_mailtype("html");
			$config['protocol']    = 'smtp';
			$config['smtp_crypto'] = get_smtp_secure();
			$config['smtp_host']    = get_smtp("smtp_host");
			$config['smtp_port']    = get_smtp("smtp_port");
			$config['smtp_timeout'] = '60';
			$config['smtp_user']    = get_smtp("smtp_username");
			$config['smtp_pass']    = get_smtp("smtp_password");
			$config['charset']    = 'utf-8';
			$config['newline']    = "\r\n";
			$config['mailtype'] = "html";
			$config['validation'] = TRUE;
			$CI->email->initialize($config);

			$CI->email->from($from,$from_name);
			$CI->email->to($to); 

			$CI->email->subject($subject);
			$CI->email->message($body);  

			$CI->email->send();
		} else if(email_type()=="phpmail"){

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: ' .$from. "\r\n";
			mail($to,$subject,$body,$headers); 
		}
	}
}

if( !function_exists('hrastral_nama_perusahaan') ){

	function hrastral_nama_perusahaan(){
		$CI=& get_instance();
		$query =  $CI->db->query("SELECT nama_perusahaan FROM umb_info_perusahaan")->row()->nama_perusahaan;
		return $query;
	}
}
if( !function_exists('hrastral_email_perusahaan') ){

	function hrastral_email_perusahaan(){
		$CI=& get_instance();
		$query =  $CI->db->query("SELECT email FROM umb_info_perusahaan")->row()->email;
		return $query;
	}
}

if( !function_exists('email_type') ){

	function email_type(){
		$CI=& get_instance();
		$query =  $CI->db->query("SELECT email_type FROM umb_email_configuration")->row()->email_type;
		return $query;
	}
}

if( !function_exists('get_smtp_secure') ){

	function get_smtp_secure(){
		$CI=& get_instance();
		$query = $CI->db->query("SELECT smtp_secure FROM umb_email_configuration")->row()->smtp_secure;
		return $query;
	}

}

if( !function_exists('get_smtp') ){

	function get_smtp($name){
		$CI=& get_instance();
		$query = $CI->db->query("SELECT $name FROM umb_email_configuration")->row()->$name;
		return $query;
	}
}