<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Dashboard');
	}
	
	public function index()
	{
		if($this->session->userdata('logged_in') == TRUE){	
			if($this->session->has_userdata('phyyear')==FALSE){
			$y=date("Y")-2023;
			$m=date("m");
			$this->session->set_userdata('phyroadid','R01');
			$this->session->set_userdata('physec','H1');
			
			$this->session->set_userdata('phyyear',$y);
			$this->session->set_userdata('phymonth',$m);
			$this->session->set_userdata('stripplan',"All");
			}
			$this->M_Dashboard->get_pkglist();	
			$data['popupmessage']=$this->M_Dashboard->prepare_message();			
			$data['pkg_progress']=$this->M_Dashboard->get_package_progress();			
			$data['road_progress']=$this->M_Dashboard->get_road_progress();			
			$data['overallprogress']=$this->M_Dashboard->get_overall_progress();
			$data['viewprogress']=$this->M_Dashboard->get_progress_Dashboardview();	
			$data['latestentry']=$this->M_Dashboard->get_latestentry();			
			$data['content'] = 'Home';		
			$this->load->view('template', $data, FALSE);
		} else {
			redirect('admin/login');
		}
	}
	
	
}

?>