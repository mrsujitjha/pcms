<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paycondition extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_paycon','flow');
	}
	public function index()
	{
		$data['get_paycon']=$this->flow->get_condition();
		$data['content']="v_paycondition";
		$this->load->view('template', $data);
		
	}
	public function add()
	{
		if ($this->input->post('save')) {
			if ($this->flow->save_paycon()) {
				$this->session->set_flashdata('message', 'Condition Added Successfully');
				redirect('Paycondition','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Paycondition','refresh');
			}
		}
	}
	public function find_condition($id)
	{
		$data=$this->flow->condition_logic($id);
		echo json_encode($data);
	}
	public function flow_update()
	{
		if ($this->input->post('edit')) {
			if ($this->flow->edit_paycon()) {
				$this->session->set_flashdata('message', 'Condition Successfully Updated');
				redirect('Paycondition','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Paycondition','refresh');
			}
		}
	}

	public function hapus($id='')
	{
		if ($this->flow->hapus_flow($id)) {
			$this->session->set_flashdata('message', 'Condition Successfully Deleted');
			redirect('Paycondition','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('Paycondition','refresh');
		}
	}

}
