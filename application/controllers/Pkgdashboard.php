<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pkgdashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Dashboard');
	}
	
	public function index()	{
	
			$data['road_alignment']=$this->M_Dashboard->get_kml();
			$data['Compchlist']=$this->M_Dashboard->Completed_chainage();
			$data['get_hindlist']=$this->M_Dashboard->road_hidrance();
			$data['get_Payment']=$this->M_Dashboard->road_Payment();
			$data['road_structure']=$this->M_Dashboard->get_road_structure();	
			$data['road_images']=$this->M_Dashboard->road_images();	
			$data['viewprogress']=$this->M_Dashboard->get_road_progress_to_view();
			$data['plantation']=$this->M_Dashboard->road_plantation();	
			$data['content'] = 'v_roaddash';
			$this->load->view('template', $data, FALSE);
		
	}
	
	
}

?>