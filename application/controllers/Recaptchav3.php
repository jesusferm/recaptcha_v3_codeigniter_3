<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recaptchav3 extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('pagination');
		$this->load->library('user_agent');
		$this->load->helper('url');
	}

	public function index(){
		$data['title'] 	= 'Recaptcha & ajax | LiNuXiToS';
		$data['tab'] 	= 'index';
		$this->load->view('common/head', $data);
		$this->load->view('common/navbar', $data);
		$this->load->view('recaptchav3', $data);
		$this->load->view('common/foot');
	}

	public function login(){
		$register = array(
			'password'	=> $this->input->post('txt-password'),
			'email'		=> trim($this->input->post('txt-email')),
		);
		
		$secret 			= $this->config->item('secret_key');
		$recaptchaResponse 	= $this->input->post('g-recaptcha-response') ? trim($this->input->post('g-recaptcha-response')) : "off";
		$userIp 			= $this->input->ip_address();
		$secret 			= $this->config->item('secret_key');
		$url 				= "https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;
		$ch 				= curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output 			= curl_exec($ch);
		curl_close($ch);
		$status 			= json_decode($output, true);

		if($recaptchaResponse != "off"){
			if ($status['success']) {
				$msg = array("tipo" 	=> 'success',
								"icon" 	=> 'fa fa-check',
								"msg" 	=> 'Validación correcta.');
			}else{
				$msg = array("tipo" 	=> 'danger',
								"icon" 	=> 'fa fa-exclamation-circle',
								"msg" 	=> 'Verifica que no eres un robot.');
			}
		}else{
			$msg = array("tipo" 	=> 'danger',
							"icon" 	=> 'fa fa-exclamation-circle',
							"msg" 	=> 'Por favor verifica que no eres un robot.');
		}
		echo json_encode($msg);
	}

	public function validate(){
		$email 		= trim($this->input->post('email'));
		$password 	= trim($this->input->post('password'));
		$captcha 	= trim($this->input->post('token'));

		if(!$captcha){
			$msg = array("tipo" => 'danger',
						"icon" 	=> 'fa fa-exclamation-circle',
						"msg" 	=> 'Verifica que no eres un robot.');
		}		
		$secretKey 	= $this->config->item('secret_key_v3');
		$ip 		= $_SERVER['REMOTE_ADDR'];

		$url 				= "https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip;
		$ch 				= curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output 			= curl_exec($ch);
		curl_close($ch);
		$status 			= json_decode($output, true);

		header('Content-type: application/json');
		if($status["success"]) {
			$msg = array("tipo" => 'success',
						"icon" 	=> 'fa fa-check',
						"msg" 	=> 'Validación correcta.');
		}else{
			$msg = array("tipo" => 'danger',
						"icon" 	=> 'fa fa-exclamation-circle',
						"msg" 	=> 'Verifica que no eres un robot.');
		}

		echo json_encode($msg);
	}
}
