<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contractor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Contractor','Contractor');
	}
	public function index()
	{
		$data['get_con']=$this->Contractor->get_Contractor();
		$data['content']="v_Contractor";
		$this->load->view('template', $data);
		
	}
	public function add()
	{
		if ($this->input->post('save')) {
			if ($this->Contractor->save_Contractor()) {
				$this->session->set_flashdata('message', 'Contractor Added Successfully');
				redirect('Contractor','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Contractor','refresh');
			}
		}
	}	
	
	public function find_Contractor($id)
	{
		$data=$this->Contractor->detail($id);
		echo json_encode($data);
	}
	public function get_Contractorcode()
	{
		$data=$this->Contractor->get_maxid();
		echo json_encode($data);
	}
		
	public function Contractor_update()
	{
		if ($this->input->post('edit')) {
			if ($this->Contractor->edit_Contractor()) {
				$this->session->set_flashdata('message', 'Successfully Updated');
				redirect('Contractor','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Contractor','refresh');
			}
		}
	}

	public function hapus($id='')
	{
		if ($this->Contractor->hapus_Contractor($id)) {
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect('Contractor','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('Contractor','refresh');
		}
	}

}
