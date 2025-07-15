<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_item','Item');
	}
	public function index()
	{
		$data['get_item']=$this->Item->get_item();
		$data['content']="v_item";
		$this->load->view('template', $data);
		
	}
	public function add()
	{
		if ($this->input->post('save')) {
			if ($this->Item->save_item()) {
				$this->session->set_flashdata('message', 'Item Added Successfully');
				redirect('Item','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Item','refresh');
			}
		}
	}
	public function addstage()
	{
		if ($this->input->post('save')) {
			if ($this->Item->save_stage()) {
				$this->session->set_flashdata('message', 'stage Added Successfully');
				redirect('Item','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Item','refresh');
			}
		}
		if ($this->input->post('stageEdit')) {
			if ($this->Item->Edit_stage()) {
				$this->session->set_flashdata('message', 'Stage Edited Successfully');
				redirect('Item','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Edit');
				redirect('Item','refresh');
			}
		}
	}
	public function adddrawing()
	{
		if ($this->input->post('savedr')) {
			if ($this->Item->save_draw()) {
				$this->session->set_flashdata('message', 'Drawing Added Successfully');
				redirect('Item','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Item','refresh');
			}
		}
		
	}
	public function rfiitem()
	{
		if ($this->input->post('saverfi')) {
			if ($this->Item->save_rfiitem()) {
				$this->session->set_flashdata('message', 'RFI item Added Successfully');
				redirect('Item','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Item','refresh');
			}
		}		
	}
	public function find_item($id)
	{
		$data=$this->Item->detail($id);
		echo json_encode($data);
	}
	public function get_itemcode()
	{
		$data=$this->Item->get_maxid();
		echo json_encode($data);
	}
	public function find_stageitem($id)
	{
		$data=$this->Item->getstagedetail($id);
		echo json_encode($data);
	}
	public function find_rfiitem($id)
	{
		$data=$this->Item->find_rfiitem($id);
		echo json_encode($data);
	}
	public function find_drawing($id)
	{
		$data=$this->Item->find_drawing($id);
		echo json_encode($data);
	}
	
	public function item_update()
	{
		if ($this->input->post('edit')) {
			if ($this->Item->edit_item()) {
				$this->session->set_flashdata('message', 'Successfully Updated');
				redirect('Item','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Item','refresh');
			}
		}
	}

	public function hapus($id='')
	{
		if ($this->Item->hapus_item($id)) {
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect('Item','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('Item','refresh');
		}
	}

}
