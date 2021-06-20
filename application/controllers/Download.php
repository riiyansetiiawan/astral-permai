<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class download extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url_helper');
	}
	
	public function output_file($file, $name, $mime_type='') {

		if(!is_readable($file)) die('File not found or inaccessible!');
		$size = filesize($file);
		$name = rawurldecode($name);
		$known_mime_types=array(
			"htm" => "text/html",
			"exe" => "application/octet-stream",
			"zip" => "application/zip",
			"doc" => "application/msword",
			"jpg" => "image/jpg",
			"php" => "text/plain",
			"xls" => "application/vnd.ms-excel",
			"ppt" => "application/vnd.ms-powerpoint",
			"gif" => "image/gif",
			"pdf" => "application/pdf",
			"txt" => "text/plain",
			"html"=> "text/html",
			"png" => "image/png",
			"jpeg"=> "image/jpg"
		);

		if($mime_type==''){
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			if(array_key_exists($file_extension, $known_mime_types)){
				$mime_type=$known_mime_types[$file_extension];
			} else {
				$mime_type="application/force-download";
			};
		};
		@ob_end_clean(); 
		if(ini_get('zlib.output_compression'))
			ini_set('zlib.output_compression', 'Off');
		header('Content-Type: ' . $mime_type);
		header('Content-Disposition: attachment; filename="'.$name.'"');
		header("Content-Transfer-Encoding: binary");
		header('Accept-Ranges: bytes');
		if(isset($_SERVER['HTTP_RANGE'])) {
			list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
			list($range) = explode(",",$range,2);
			list($range, $range_end) = explode("-", $range);
			$range=intval($range);
			if(!$range_end) {
				$range_end=$size-1;
			} else {
				$range_end=intval($range_end);
			}

			$new_length = $range_end-$range+1;
			header("HTTP/1.1 206 Partial Content");
			header("Content-Length: $new_length");
			header("Content-Range: bytes $range-$range_end/$size");
		} else {
			$new_length=$size;
			header("Content-Length: ".$size);
		}

		$chunksize = 1*(1024*1024);
		$bytes_send = 0;
		if ($file = fopen($file, 'r')) {
			if(isset($_SERVER['HTTP_RANGE']))
				fseek($file, $range);
			while(!feof($file) && 
				(!connection_aborted()) && 
				($bytes_send<$new_length)
			)
			{
				$buffer = fread($file, $chunksize);
				echo($buffer); 
				flush();
				$bytes_send += strlen($buffer);
			}
			fclose($file);
		} else
		die('Error - can not open file.');
		die();
	}

	public function index() {	
		$type = $this->input->get('type');

		if($type!= '') {
			set_time_limit(0);
			$filename = $this->input->get('filename');
			$file_path='uploads/'.$type.'/'.$filename;
			$this->output_file($file_path, ''.$filename.'', 'text/plain');
		}
	}
}
