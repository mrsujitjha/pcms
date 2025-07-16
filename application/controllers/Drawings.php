<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drawings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Drawings','Drawings');	
		
	}
	public function index()
	{
		$a = "R00";	
		if($this->session->has_userdata('roadid')){$a =$this->session->userdata('roadid');}
		$data['get_Drawings']=$this->Drawings->get_Drawings($a);
		$data['get_roadlist']=$this->Drawings->get_road();
		$data['get_itemlist']=$this->Drawings->get_item();
		$data['content']="v_Drawings";	
		$this->load->view('template', $data, FALSE);
	}
	public function add()
	{
		if ($this->input->post('save')) {
			if ($this->Drawings->save_Drawings()) {
				$this->session->set_flashdata('message', 'Drawings Added Successfully');
				redirect('Drawings','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Drawings','refresh');
			}
		}
	}
	public function get_Drawingsid($id)	{		
		
		$rnow=$this->Drawings->maxDrawingsid($id);		
		echo json_encode($rnow);
	}
	
	public function find_Drawings($id)	{
		$data=$this->Drawings->detail($id);
		echo json_encode($data);
	}
	public function list_Drawings($id)	{
		$data=$this->Drawings->alldrawing($id);
		echo json_encode($data);
	}
	public function save_roadno(){	
		if ($this->input->post('show')) {
			if ($this->Drawings->save_saveroadno()) {
				//$this->session->set_flashdata('message', 'Tcscode save Successfully');
				redirect('Drawings','refresh');
			} else {
				//$this->session->set_flashdata('message', 'Failed to store tcsid');
				redirect('Drawings','refresh');
			}
		}
		
	}
	public function Drawings_update()
	{
		if ($this->input->post('edit')) {
			if ($this->Drawings->edit_Drawings()) {
				$this->session->set_flashdata('message', 'Successfully Updated');
				redirect('Drawings','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Drawings','refresh');
			}
		}
		if ($this->input->post('progress')) {
			if ($this->Drawings->progress_Drawings()) {
				$this->session->set_flashdata('message', 'progress Successfully Updated');
				redirect('Drawings','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Progress Update Failed');
				redirect('Drawings','refresh');
			}
		}
	}

	public function hapus($id='')
	{
		if ($this->Drawings->hapus_Drawings($id)) {
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect('Drawings','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('Drawings','refresh');
		}
	}

}
