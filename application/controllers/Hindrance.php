<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hindrance extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Hindrance');	
		
	}
	public function index()
	{
		$data['get_hindlist']=$this->M_Hindrance->road_hidrance();
		$data['get_roadlist']=$this->M_Hindrance->get_road();
		$data['content']="v_hindrance";		
		$this->load->view('template', $data, FALSE);
	}
	public function addeditdetails()
	{
		if ($this->input->post('save')) {
			if ($this->M_Hindrance->upload_selected_Hindrance()) {				
				$this->session->set_flashdata('message', 'Hindrance Added Successfully');
				redirect('Hindrance','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add Hindrance');
				redirect('Hindrance','refresh');
			}
		}
		if ($this->input->post('edit')) {
			if ($this->M_Hindrance->edit_Hindrance_details()) {				
				$this->session->set_flashdata('message', 'Hindrance Edited Successfully');
				redirect('Hindrance','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Edit Hindrance');
				redirect('Hindrance','refresh');
			}
		}
	}
	public function find_hindrance($id)
	{
		$data=$this->M_Hindrance->detail($id);
		echo json_encode($data);
	}
	public function save_roadno(){	
		if ($this->input->post('show')) {
			$this->M_Hindrance->save_saveroadno();			
			redirect('Hindrance','refresh');			
		}	
	}
	
	public function hapus($id='')
	{
		if ($this->M_Hindrance->hapus_Hindrance($id)) {
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect('Hindrance','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('Hindrance','refresh');
		}
	}

}
