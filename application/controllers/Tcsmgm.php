<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tcsmgm extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_tcsmgm','tcsmgm');
	}
	public function index()
	{	$a = "";	
		if($this->session->has_userdata('roadid')){$a =$this->session->userdata('roadid');}
		$data['get_roadlist']=$this->tcsmgm->get_road();
		$data['get_tcsmgm']=$this->tcsmgm->get_tcsmgm($a);
		$data['content']="v_tcsmgm";		
		$this->load->view('template', $data, FALSE);	
	}
	public function add()
	{
		if ($this->input->post('save')) {
			if ($this->tcsmgm->save_tcsmgm()) {
				$this->session->set_flashdata('message', 'Description Added Successfully');
				redirect('tcsmgm','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('tcsmgm','refresh');
			}
		}
	}
	public function save_roadno(){	
		if ($this->input->post('show')) {
			if ($this->tcsmgm->save_saveroadno()) {
				//$this->session->set_flashdata('message', 'Tcscode save Successfully');
				redirect('tcsmgm','refresh');
			} else {
				//$this->session->set_flashdata('message', 'Failed to store tcsid');
				redirect('tcsmgm','refresh');
			}
		}
		
	}
	public function find_tcsmgm($id)
	{
		$data=$this->tcsmgm->detail($id);
		echo json_encode($data);
	}
	public function get_Tcscode()
	{
		$data=$this->tcsmgm->get_maxid();
		echo json_encode($data);
	}
	public function tcsmgm_update()
	{
		if ($this->input->post('edit')) {
			if ($this->tcsmgm->edit_tcsmgm()) {
				$this->session->set_flashdata('message', 'Successfully Updated');
				redirect('tcsmgm','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('tcsmgm','refresh');
			}
		}
	}

	public function hapus($id='')
	{
		if ($this->tcsmgm->hapus_tcsmgm($id)) {
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect('tcsmgm','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('tcsmgm','refresh');
		}
	}

}
