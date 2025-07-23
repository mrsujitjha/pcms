<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payflow extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_flow', 'flow');
	}
	public function index()
	{
		$data['get_flow'] = $this->flow->get_flow();
		$data['content'] = "v_paymentflow";
		$data['get_pkglist'] = $this->flow->get_pkg();
		$data['get_user'] = $this->flow->get_user();
		$this->load->view('template', $data);
	}
	public function add()
	{
		if ($this->input->post('save')) {
			if ($this->flow->save_flow()) {
				$this->session->set_flashdata('message', 'flow Added Successfully');
				redirect('Payflow', 'refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Payflow', 'refresh');
			}
		}
	}

	public function flow_update()
	{
		if ($this->input->post('edit')) {
			if ($this->flow->edit_flow()) {
				$this->session->set_flashdata('message', 'Successfully Updated');
				redirect('Payflow', 'refresh');
			} else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Payflow', 'refresh');
			}
		}
	}

	public function hapus($id = '')
	{
		if ($this->flow->hapus_flow($id)) {
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect('Payflow', 'refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('Payflow', 'refresh');
		}
	}
}
