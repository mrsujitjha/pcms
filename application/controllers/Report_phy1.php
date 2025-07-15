<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_phy1 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_physicalreport','physical');	
		
	}
	public function index()
	{ 	$a = "Noselection";	
		if($this->session->has_userdata('phyroadid')){$a =$this->session->userdata('phyroadid');}
		$this->load->library('pagination');	
		$data['get_roadlist']=$this->physical->get_road();
		$data['get_status']=$this->physical->get_status_scheduleitem($a);
		$data['content']="v_repo_phy1";	
	
		$this->pagination->initialize($data);
		$this->load->view('template', $data, FALSE);		
	}
	

}
