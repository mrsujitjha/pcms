<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financial extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Financial','finance');	
		
	}
	public function index()
	{
		$a = "";	
		if($this->session->has_userdata('pkgid')){$a =$this->session->userdata('pkgid');}

		$data['get_ipc']=$this->finance->get_sps($a);
		$data['get_pkglist']=$this->finance->get_pkg();
		$data['get_roadlist']=$this->finance->get_road();
		//$data['get_ipcall']=$this->finance->get_sps_activity("");
		$data['content']="v_financial";
		$this->load->view('template', $data, FALSE);
	}
	public function add()
	{
		if ($this->input->post('save')) {
			if ($this->finance->save_sps(0)) {
				$this->session->set_flashdata('message', 'SPC Added Successfully');
				redirect('Financial','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Financial','refresh');
			}
		}
		if ($this->input->post('action')) {
			if ($this->finance->save_sps_progress()) {
				$this->session->set_flashdata('message', 'SPC Added Successfully');
				redirect('Financial','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Financial','refresh');
			}
		}
		if ($this->input->post('gen')) {
			if ($this->finance->generate_invoice()) {
				$this->session->set_flashdata('message', 'Auto Generation completed');
				redirect('Financial','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Generate');
				redirect('Financial','refresh');
			}
		}
		if ($this->input->post('osave')) {
			if ($this->finance->save_otherpayment()) {
				$this->session->set_flashdata('message', 'Bill save successfully');
				redirect('Financial','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to save');
				redirect('Financial','refresh');
			}
		}
	}
	public function maxspsid($id)	{	
		
		$rnow=$this->finance->maxspsid($id);		
		echo json_encode($rnow);
		
	}
	public function savesessionspcid($id){			
		$rnow=$this->finance->get_sps_activity($id);
		echo json_encode($rnow);
	}
	public function showsps($id){			
		$rnow=$this->finance->viewselectedsps($id);
		echo json_encode($rnow);
	}
	public function maxprogressid($id)	{	
		
		$rnow=$this->finance->maxprogressid($id);		
		echo json_encode($rnow);
		
	}
	public function find_sps($id)	{
		$data=$this->finance->detail($id);
		echo json_encode($data);
	}
	public function save_pkg(){	
		if ($this->input->post('show')) {
			if ($this->finance->save_pkg()) {
				//$this->session->set_flashdata('message', $this->session->userdata('Camount'));
				redirect('Financial','refresh');
			} else {
				//$this->session->set_flashdata('message', 'Failed to store tcsid');
				redirect('Financial','refresh');
			}
		}
		if ($this->input->post('showall')) {
			if ($this->finance->clean_pkg()) {
				//$this->session->set_flashdata('message', 'Tcscode save Successfully');
				redirect('Financial','refresh');
			} else {
				//$this->session->set_flashdata('message', 'Failed to store tcsid');
				redirect('Financial','refresh');
			}
		}
	}
	public function finance_update()
	{
		if ($this->input->post('edit')) {
			if ($this->finance->edit_finance()) {
				$this->session->set_flashdata('message', 'Successfully Updated');
				redirect('Financial','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Financial','refresh');
			}
		}
		if ($this->input->post('btprog')) {
			if ($this->finance->save_sps()) {
				$this->session->set_flashdata('message', 'Progress Successfully Updated');
				redirect('Financial','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Financial','refresh');
			}
		}


	}

	public function hapus($id='')
	{
		if ($this->finance->hapus_finance($id)) {
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect('Financial','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('Financial','refresh');
		}
	}

}
