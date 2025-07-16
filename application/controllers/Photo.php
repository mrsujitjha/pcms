<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Photo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Photo');	
		
	}
	public function index()
	{
		$data['get_Photolist']=$this->M_Photo->road_images();
		$data['get_roadlist']=$this->M_Photo->get_road();
		$data['content']="v_photo";		
		$this->load->view('template', $data, FALSE);
	}
	public function addeditpic()
	{
		if ($this->input->post('savepic')) {
			if ($this->M_Photo->upload_selected_photo()) {				
				$this->session->set_flashdata('message', 'Photo Added Successfully');
				redirect('Photo','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add photo');
				redirect('Photo','refresh');
			}
		}
		if ($this->input->post('editpic')) {
			if ($this->M_Photo->edit_photo_details()) {				
				$this->session->set_flashdata('message', 'Photo Edited Successfully');
				redirect('Photo','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Edit photo');
				redirect('Photo','refresh');
			}
		}
	}
	
	public function save_roadno(){	
		if ($this->input->post('show')) {
			$this->M_Photo->save_saveroadno();			
			redirect('Photo','refresh');			
		}	
	}
	
	public function hapus($id='')
	{
		if ($this->M_Photo->hapus_Photo($id)) {
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect('Photo','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('Photo','refresh');
		}
	}

}
