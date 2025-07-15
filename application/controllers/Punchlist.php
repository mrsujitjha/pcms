<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Punchlist extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Punchlist','punchlist');	
		
	}
	public function index()
	{
		$a = "R00";	
		if($this->session->has_userdata('roadid')){$a =$this->session->userdata('roadid');}
		$data['get_punchlist']=$this->punchlist->get_punchlist($a);
		$data['get_roadlist']=$this->punchlist->get_road();
		$data['get_itemlist']=$this->punchlist->get_item();
		//$data['get_tcslist']=$this->punchlist->get_tcslist();
		$data['content']="v_punchlist";		
	//	$from = $this->uri->segment(3);
		//$this->pagination->initialize($data);	
		$this->load->view('template', $data, FALSE);
	}
	public function add()
	{
		if ($this->input->post('save')) {
			if ($this->punchlist->save_punchlist()) {
				$this->session->set_flashdata('message', 'punchlist Added Successfully');
				redirect('punchlist','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('punchlist','refresh');
			}
		}
	}
	public function get_punchlistid($id)	{		
		
		$rnow=$this->punchlist->maxpunchlistid($id);		
		echo json_encode($rnow);
	}
	
	public function find_punchlist($id)	{
		$data=$this->punchlist->detail($id);
		echo json_encode($data);
	}
	public function save_roadno(){	
		if ($this->input->post('show')) {
			if ($this->punchlist->save_saveroadno()) {
				//$this->session->set_flashdata('message', 'Tcscode save Successfully');
				redirect('punchlist','refresh');
			} else {
				//$this->session->set_flashdata('message', 'Failed to store tcsid');
				redirect('punchlist','refresh');
			}
		}
		
	}
	public function punchlist_update()
	{
		if ($this->input->post('edit')) {
			if ($this->punchlist->edit_punchlist()) {
				$this->session->set_flashdata('message', 'Successfully Updated');
				redirect('punchlist','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('punchlist','refresh');
			}
		}
		if ($this->input->post('progress')) {
			if ($this->punchlist->progress_punchlist()) {
				$this->session->set_flashdata('message', 'progress Successfully Updated');
				redirect('punchlist','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Progress Update Failed');
				redirect('punchlist','refresh');
			}
		}
	}

	public function hapus($id='')
	{
		if ($this->punchlist->hapus_punchlist($id)) {
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect('punchlist','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('punchlist','refresh');
		}
	}

}
