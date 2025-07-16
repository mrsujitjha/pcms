<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Schedule','schedule');	
		
	}
	public function index()
	{
		$a = "R00";	
		if($this->session->has_userdata('roadid')){$a =$this->session->userdata('roadid');}
		$data['get_schedule']=$this->schedule->get_schedule($a);
		$data['get_roadlist']=$this->schedule->get_road();
		$data['get_itemlist']=$this->schedule->get_item();
		//$data['get_tcslist']=$this->schedule->get_tcslist();
		$data['content']="v_schedule";		
	//	$from = $this->uri->segment(3);
		//$this->pagination->initialize($data);	
		$this->load->view('template', $data, FALSE);
	}
	public function add()
	{
		if ($this->input->post('save')) {
			if ($this->schedule->save_schedule()) {
				$this->session->set_flashdata('message', 'schedule Added Successfully');
				redirect('Schedule','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Schedule','refresh');
			}
		}
	}
	public function Approve()
	{	
		if ($this->schedule->Approve_schedule()) {
			$this->session->set_flashdata('message', 'schedule approved Successfully');
			redirect('Schedule','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to approved');
			redirect('Schedule','refresh');
		}
	}
	public function get_scheduleid($id)	{		
		
		$rnow=$this->schedule->maxscheduleid($id);		
		echo json_encode($rnow);
	}
	
	public function find_schedule($id)	{
		$data=$this->schedule->detail($id);
		echo json_encode($data);
	}
	public function save_roadno(){	
		if ($this->input->post('show')) {
			if ($this->schedule->save_saveroadno()) {
				//$this->session->set_flashdata('message', 'Tcscode save Successfully');
				redirect('Schedule','refresh');
			} else {
				//$this->session->set_flashdata('message', 'Failed to store tcsid');
				redirect('Schedule','refresh');
			}
		}
		
	}
	public function schedule_update()
	{
		if ($this->input->post('edit')) {
			if ($this->schedule->edit_schedule()) {
				$this->session->set_flashdata('message', 'Successfully Updated');
				redirect('Schedule','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Schedule','refresh');
			}
		}
		
		if ($this->input->post('btprog')) {
			if ($this->schedule->edit_progress()) {
				$this->session->set_flashdata('message', 'Progress Successfully Updated');
				redirect('Schedule','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Schedule','refresh');
			}
		}


	}

	public function hapus($id='')
	{
		if ($this->schedule->hapus_schedule($id)) {
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect('Schedule','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('Schedule','refresh');
		}
	}

}
