<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_phy2 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_physicalreport','physical');	
		
	}
	public function index()
	{ 	$a = "P01:2024-1";	
		if($this->session->has_userdata('phyroadid')){
			$a =$this->session->userdata('phyroadid');
			$b =$this->session->userdata('phyyear')+2023;
			$c =$this->session->userdata('phymonth');		
			if ($c<10) {$d=$a.":".$b."0".$c;}else{$d=$a.":".$b.$c;}	
		}
		$this->load->library('pagination');
		$countrow = $this->physical->count_Row_schedule();
		$data['get_roadlist']=$this->physical->get_road();
		//$data['get_status']=$this->physical->get_status_sectionwise("R15:2024-2");
		$data['get_status']=$this->physical->get_status_sectionwise($d);	
		$data['content']="v_repo_phy2";

		$this->load->view('template', $data, FALSE);		
	}
	

}
