<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapfull extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Dashboard');
	}
	
	public function index()
	{
		if($this->session->userdata('logged_in') == TRUE){
			if ($this->session->userdata('mapoption')!=null){$mapoption=$this->session->userdata('mapoption');}else{$mapoption='0::0::0::0::Selected';}
			$mopt=explode("::",$mapoption);				
			if ($mopt[3]==0){
				$data['rall']=$this->M_Dashboard->get_kml();
				$data['sall']=$this->M_Dashboard->get_road_structure();
				$data['iall']=$this->M_Dashboard->road_images();
				$data['Compchlist']=$this->M_Dashboard->Completed_chainage();
			}
			if ($mopt[3]==1){
				$data['rall']=$this->M_Dashboard->get_kml_all();
				$data['sall']=$this->M_Dashboard->get_road_structure_all();
				$data['iall']=$this->M_Dashboard->road_images_all();
			}
			if ($mopt[3]>1){
				$data['rall']=$this->M_Dashboard->get_kml_selected($mopt[4]);
				$data['sall']=$this->M_Dashboard->get_road_structure_selected($mopt[4]);
				$data['iall']=$this->M_Dashboard->road_images_Selected($mopt[4]);
				
			}
			$data['get_tranche']=$this->M_Dashboard->get_tranche();	
			$data['viewprogress']=$this->M_Dashboard->get_road_progress_to_view();
			$data['content'] = 'Mapfv';		
			$this->load->view('template', $data, FALSE);
		} else {
			redirect('admin/login');
		}
	}
	
	
}

?>