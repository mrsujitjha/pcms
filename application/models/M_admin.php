<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_admin extends CI_Model
{

	public function get_login()
	{
		$query = $this->db->where('username', $this->input->post('username'))
			->where('password', md5($this->input->post('password')))
			->get('user');
		if ($query->num_rows() > 0) {
			$array = $query->row();
			$a = $array->level;
			$this->save_logindetail($array->username, 'Logged in');
			$data = array(
				'logged_in' => TRUE,
				'username' => $array->username,
				'password' => md5($array->password),
				'fullname' => $array->fullname,
				'level' => $a,
				'rlist' => $array->rlist,
				'userid' => $array->user_code,
				'autho' => $array->autho
			);

			$this->session->set_userdata($data);

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
		unset($_SESSION['some_name']);
	}
	public function get_login_guest()
	{
		$this->save_logindetail('Guest', 'Logged In');
		$data = array(
			'logged_in' => TRUE,
			'username' => 'Guest',
			'fullname' => 'Guest',
			'level' => 'Guest',
			'rlist' => '',
			'pkglist' => '',
			'userid' => '0',
			'autho' => '01'
		);
		$this->session->set_userdata($data);
		unset($_SESSION['some_name']);
	}
	public function sendmail()
	{
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$otp = substr(str_shuffle($str_result), 0, 5);

		$this->load->library('email');
		/*
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'ssl://smtp.gmail.com';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'sksoft2003@gmail.com';
		$config['smtp_pass']    = 'Abesh2003';
		$config['charset']    = 'utf-8';
		$config['newline']    = "\r\n";
		$config['mailtype'] = 'text'; // or html
		$config['validation'] = TRUE; // bool whether to validate email or not    
		$this->email->initialize($config);
	*/
		$this->email->from('PCMS@RSHA.com', 'PCMS');
		$this->email->to($this->input->post('email'));
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');
		$this->email->subject('OTP from PCMS-Admin');
		$this->email->message('OTP for password reset is ' . $otp);
		$sentmail =  $this->email->send();
		if ($sentmail) {
			return $this->register_otp($otp);
		} else {
			return false;
		}
	}
	public function resetpassword()
	{
		$query = $this->db->where('email', $this->input->post('email'))
			->where('otp', ($this->input->post('otp')))
			->get('tabotp')
			->row();
		$dtval = $query->datetime;
		$dtvalnew = date("Y-m-d") . "-" . date("H", time());
		if (strcmp($dtval, $dtval) == 0) {
			$object = array(
				'password' => md5($this->input->post('password'))
			);
			$this->save_logindetail($this->input->post('email'), 'Password re-set');
			return $this->db->where('email', $this->input->post('email'))->update('user', $object);
		} else {
			return false;
		}
	}
	public function get_register()
	{
		$this->save_logindetail($this->input->post('username'), 'Registered');
		$regis = array(
			'username'  => $this->input->post('username'),
			'password'  => md5($this->input->post('password')),
			'fullname'	=> $this->input->post('fullname'),
			'level' 	=> $this->input->post('level')
		);

		return $this->db->insert('user', $regis);
	}
	public function register_otp($otp)
	{
		$dtval = date("Y-m-d") . "-" . date("H", time());
		$regis = array('email' => $this->input->post('email'), 'datetime' => $dtval, 'otp' => $otp);
		return $this->db->insert('tabotp', $regis);
	}
	// Function to get the client IP address

	public function save_logindetail($a, $c)
	{
		// if user from the share internet   
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$b = $_SERVER['HTTP_CLIENT_IP'];
		}
		//if user is from the proxy   
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$b = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//if user is from the remote address   
		else {
			$b = $_SERVER['REMOTE_ADDR'];
		}
		$object = array(
			'uid' => $a,
			'datetime' => date("d-m-Y h:i:s"),
			'ipinfo' => $b,
			'remarks' => $c
		);
		$this->db->insert('tablog', $object);
	}
}
