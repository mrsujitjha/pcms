<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stage extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Stage','Stage');	
		
	}
	public function index()
	{
		$a = "R00";	
		if($this->session->has_userdata('roadid')){$a =$this->session->userdata('roadid');}
		$data['get_stagedetail']=$this->Stage->get_stageitems($a);
		$data['get_roadlist']=$this->Stage->get_road();
		$data['get_stageitem']=$this->Stage->get_item();
		$data['content']="v_stage";		
		$this->load->view('template', $data, FALSE);
	}
	public function add()
	{
		if ($this->input->post('save')) {
			if ($this->Stage->save_Stage()) {
				$this->session->set_flashdata('message', 'Stage Item Added Successfully');
				redirect('Stage','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Stage','refresh');
			}
		}
	}
	public function Approve()
	{	
		if ($this->Stage->Approve_Stage()) {
			$this->session->set_flashdata('message', 'Section approved Successfully');
			redirect('Stage','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to approved');
			redirect('Stage','refresh');
		}
	}
	public function get_stageitemid($id)	{		
		
		$rnow=$this->Stage->maxStageid($id);		
		echo json_encode($rnow);
	}
	public function find_roaditemstage($id)	{			
		$rnow=$this->Stage->find_roaditemstage($id);		
		echo json_encode($rnow);
	}

	public function get_mytcslist($id)	{		
		$data=$this->Stage->get_tcslist($id);		
		echo json_encode($data);
	}
	public function find_Stage($id)	{
		$data=$this->Stage->detail($id);
		echo json_encode($data);
	}
	public function find_allStages($id)	{
		$data=$this->Stage->get_stagelist($id);		
		echo json_encode($data);
	}
	public function save_roadno(){	
		if ($this->input->post('show')) {
			if ($this->Stage->save_saveroadno()) {
				//$this->session->set_flashdata('message', 'Tcscode save Successfully');
				redirect('Stage','refresh');
			} else {
				//$this->session->set_flashdata('message', 'Failed to store tcsid');
				redirect('Stage','refresh');
			}
		}
		
	}
	public function Stage_update()
	{
		if ($this->input->post('edit')) {
			if ($this->Stage->edit_Stage()) {
				$this->session->set_flashdata('message', 'Successfully Updated');
				redirect('Stage','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Stage','refresh');
			}
		}
		if ($this->input->post('btprog')) {
			if ($this->Stage->edit_progress()) {
				$this->session->set_flashdata('message', 'Progress Successfully Updated');
				redirect('Stage','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Stage','refresh');
			}
		}


	}

	public function hapus($id='')
	{
		if ($this->Stage->hapus_Stage($id)) {
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect('Stage','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('Stage','refresh');
		}
	}

}
