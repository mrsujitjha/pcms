<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Weightage extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Weightage','flow');
	}
	public function index()
	{$a = "R001";	//not to load in starting
		if($this->session->has_userdata('roadid')){$a =$this->session->userdata('roadid');}	
		$data['get_paycon']=$this->flow->get_condition();	
		$data['get_weightlist']=$this->flow->get_weightlist($a);
		$data['get_Tcslist']=$this->flow->get_tcslist($a);
		$data['content']="v_weightage";		
		$data['get_roadlist']=$this->flow->get_road();
		$data['get_item']=$this->flow->get_item();
		$data['get_stage_list']=$this->flow->find_roaditemstage($a);
		$this->load->view('template', $data);
		
	}
	public function add()
	{
		if ($this->input->post('save')) {
			if ($this->flow->save_weightage()) {
				$this->session->set_flashdata('message', 'Weightage Added Successfully');
				redirect('Weightage','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Weightage','refresh');
			}
		}
	}
	public function Approve()
	{	
		if ($this->flow->Approve_weitage()) {
			$this->session->set_flashdata('message', 'Weightage approved Successfully');
			redirect('Weightage','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to approved');
			redirect('Weightage','refresh');
		}
	}
	public function get_detail($a)
	{
		$data=$this->flow->detail($a);
		echo json_encode($data);
		
	}
	public function get_itemdetails($a)
	{
		$data=$this->flow->itemoftcs($a);
		echo json_encode($data);
		
	}
	public function find_proitem($id)	{
		$data=$this->flow->proitem($id);
		echo json_encode($data);
	}
	public function edit_weightage()
	{
		if ($this->input->post('edit')) {
			if ($this->flow->e_weightage()) {
				//$this->session->set_flashdata('message', 'Successfully Updated');
				redirect('Weightage','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Weightage','refresh');
			}
		}
		if ($this->input->post('weight')) {
			if ($this->flow->sub_weightage()) {
				//$this->session->set_flashdata('message', 'Successfully Updated');
				redirect('Weightage','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Weightage','refresh');
			}
		}
	}
	public function save_roadno(){	
		if ($this->input->post('show')) {
			if ($this->flow->save_saveroadno()) {
				//$this->session->set_flashdata('message', 'Tcscode save Successfully');
				redirect('Weightage','refresh');
			} else {
				//$this->session->set_flashdata('message', 'Failed to store tcsid');
				redirect('Weightage','refresh');
			}
		}
		
	}
	public function hapus($id='')
	{
		if ($this->flow->hapus_flow($id)) {
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect('Weightage','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('Weightage','refresh');
		}
	}
	public function refresh()
	{$this->flow->overallprogress();
		//if ($this->flow->overallprogress()) {
		//	$this->session->set_flashdata('message', 'Successfully Deleted');
		//	redirect('Dashboard','refresh');
		//} else {
		//	$this->session->set_flashdata('message', 'Failed to delete');
		//	redirect('Dashboard','refresh');
	//	}
		
	}
}
