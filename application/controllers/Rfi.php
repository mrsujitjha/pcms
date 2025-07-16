<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rfi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Rfi','Rfi');	
		
	}
	public function index()
	{
		$a = "R00";	
		if($this->session->has_userdata('roadid')){$a =$this->session->userdata('roadid');}
		$data['get_Rfi']=$this->Rfi->get_Rfi($a);
		$data['get_roadlist']=$this->Rfi->get_road();
		$data['get_itemlist']=$this->Rfi->get_item();
		$data['content']="v_Rfi";	
		$this->load->view('template', $data, FALSE);
	}
	public function add()
	{
		if ($this->input->post('save')) {
			if ($this->Rfi->save_Rfi()) {
				$this->session->set_flashdata('message', 'Rfi Added Successfully');
				redirect('Rfi','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Rfi','refresh');
			}
		}
		if ($this->input->post('Action')) {			
			if ($this->Rfi->save_Rfi_action()) {
				$this->session->set_flashdata('message', 'Rfi Action added Successfully');
				redirect('Rfi','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add action text');
				redirect('Rfi','refresh');
			}
		}
	}
	public function get_chainagelist($id)	{
		$rnow=$this->Rfi->get_item_remaining_ch($id);		
		echo json_encode($rnow);
	}
	public function get_userid()	{
		$rnow=$this->Rfi->get_userid();		
		echo json_encode($rnow);
	}
	public function get_Rfiid($id)	{		
		
		$rnow=$this->Rfi->maxRfiid($id);		
		echo json_encode($rnow);
	}
	
	public function find_Rfi($id)	{
		$data=$this->Rfi->detail($id);
		echo json_encode($data);
	}
	public function list_Rfi($id)	{
		$data=$this->Rfi->get_Rfi_activity($id);
		echo json_encode($data);
	}
	public function verify_drawing($ch,$id)	{
		$rnow=$this->Rfi->verify_drawing($ch,$id);		
		echo json_encode($rnow);
	}
	public function save_roadno(){	
		if ($this->input->post('show')) {
			if ($this->Rfi->save_saveroadno()) {
				//$this->session->set_flashdata('message', 'Tcscode save Successfully');
				redirect('Rfi','refresh');
			} else {
				//$this->session->set_flashdata('message', 'Failed to store tcsid');
				redirect('Rfi','refresh');
			}
		}
		
	}
	public function Rfi_update()
	{
		if ($this->input->post('edit')) {
			if ($this->Rfi->edit_Rfi()) {
				$this->session->set_flashdata('message', 'Successfully Updated');
				redirect('Rfi','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Rfi','refresh');
			}
		}
		if ($this->input->post('progress')) {
			if ($this->Rfi->progress_Rfi()) {
				$this->session->set_flashdata('message', 'progress Successfully Updated');
				redirect('Rfi','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Progress Update Failed');
				redirect('Rfi','refresh');
			}
		}
	}

	public function hapus($id='')
	{
		if ($this->Rfi->hapus_Rfi($id)) {
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect('Rfi','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('Rfi','refresh');
		}
	}

}
