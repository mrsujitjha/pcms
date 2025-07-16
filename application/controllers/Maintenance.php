<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Maintenance','Maintenance');	
		
	}
	public function index()
	{
		$a = "R00";	
		if($this->session->has_userdata('roadid')){$a =$this->session->userdata('roadid');}
		$data['get_Maintenance']=$this->Maintenance->get_Maintenance($a);
		$data['get_roadlist']=$this->Maintenance->get_road();
		$data['get_itemlist']=$this->Maintenance->get_item();
		$data['content']="v_maintenance";	
		$this->load->view('template', $data, FALSE);
	}
	public function add()
	{
		if ($this->input->post('save')) {
			if ($this->Maintenance->save_Maintenance()) {
				$this->session->set_flashdata('message', 'Maintenance Added Successfully');
				redirect('Maintenance','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Maintenance','refresh');
			}
		}
	}
	public function get_Maintenanceid($id)	{		
		
		$rnow=$this->Maintenance->maxMaintenanceid($id);		
		echo json_encode($rnow);
	}

	public function find_Maintenance($id)	{
		$data=$this->Maintenance->detail($id);
		echo json_encode($data);
	}
	public function save_roadno(){	
		if ($this->input->post('show')) {
			if ($this->Maintenance->save_saveroadno()) {
				//$this->session->set_flashdata('message', $this->session->userdata('itemname'));
				redirect('Maintenance','refresh');
			} else {
				//$this->session->set_flashdata('message', 'Failed to store tcsid');
				redirect('Maintenance','refresh');
			}
		}
		
	}
	public function Maintenance_update()
	{
		if ($this->input->post('edit')) {
			if ($this->Maintenance->edit_Maintenance()) {
				$this->session->set_flashdata('message', 'Successfully Updated');
				redirect('Maintenance','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Maintenance','refresh');
			}
		}
		
		if ($this->input->post('btprog')) {
			if ($this->Maintenance->edit_progress()) {
				$this->session->set_flashdata('message', 'Progress Successfully Updated');
				redirect('Maintenance','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Maintenance','refresh');
			}
		}


	}

	public function hapus($id='')
	{
		if ($this->Maintenance->hapus_Maintenance($id)) {
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect('Maintenance','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('Maintenance','refresh');
		}
	}

}
