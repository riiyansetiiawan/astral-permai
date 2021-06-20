<?php
class CSRF_Protection {

	private $CI;
	private static $token_name = 'li_token';
	private static $token;
	public function __construct() {
		$this->CI =& get_instance();
	}

	public function generate_token() {
		$this->CI->load->library('session');

		if ($this->CI->session->userdata(self::$token_name) === FALSE) {
			self::$token = md5(uniqid() . microtime() . rand());

			$this->CI->session->set_userdata(self::$token_name, self::$token);
		} else {
			self::$token = $this->CI->session->userdata(self::$token_name);
		}
	}

	public function validate_tokens() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$posted_token = $this->CI->input->post(self::$token_name);
			if ($posted_token === FALSE || $posted_token != $this->CI->session->userdata(self::$token_name)) {
				show_error('Request was invalid. Tokens did not match.', 400);
			}
		}
	}

	public function inject_tokens() {
		$output = $this->CI->output->get_output();
		$output = preg_replace('/(<(form|FORM)[^>]*(method|METHOD)="(post|POST)"[^>]*>)/',
			'$0<input type="hidden" name="' . self::$token_name . '" value="' . self::$token . '">', 
			$output);
		$output = preg_replace('/(<\/head>)/',
			'<meta name="csrf-name" content="' . self::$token_name . '">' . "\n" . '<meta name="csrf-token" content="' . self::$token . '">' . "\n" . '$0', 
			$output);
		$this->CI->output->_display($output);
	}
}
?>