<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Section','section');	
		
	}
	public function index()
	{
		$a = "R0001";	// not exist so return blank table for starting
		if($this->session->has_userdata('roadid')){$a =$this->session->userdata('roadid');}
		$data['get_section']=$this->section->get_section($a);
		$data['get_roadlist']=$this->section->get_road();
		$data['get_tcslist']=$this->section->get_tcslist($a);
		$data['get_item']=$this->section->get_item();
		$data['content']="v_section";	
		$this->load->view('template', $data, FALSE);
	}
	public function add()
	{
		if ($this->input->post('save')) {
			if ($this->section->save_section()) {
				$this->session->set_flashdata('message', 'section Added Successfully');
				redirect('Section','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Section','refresh');
			}
		}
	}
	public function Approve()
	{	
		if ($this->section->Approve_section()) {
			$this->session->set_flashdata('message', 'Section approved Successfully');
			redirect('Section','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to approved');
			redirect('Section','refresh');
		}
	}
	public function add_progress($a)
	{
		if ($this->input->post('prog')) {
			if ($this->section->save_physical($a)) {
				$this->session->set_flashdata('message', 'physical progress details added Successfully');
				$this->section->save_physicalsearch();
				redirect('Section','refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Section','refresh');
			}
		}
	}
	public function delphy()
	{   $var1=$this->input->post('recordlist');
		$yrm=explode(":",$var1);			
		if ($this->section->delete_record($yrm[1])) {$this->add_progress($yrm[1]);}
		
	}
	public function get_monthlyentry($a)
	{
		$data=$this->section->load_physicaldata($a);
		echo json_encode($data);
	}
	public function get_sectionid($id)	{		
		
		$rnow=$this->section->maxsectionid($id);		
		echo json_encode($rnow);
	}
	public function get_mytcslist($id)	{		
		$data=$this->section->get_tcslist($id);		
		echo json_encode($data);
	}
	public function get_itemname()
	{
		$data=$this->section->itemdetail();
		echo json_encode($data);
	}
	public function find_section($id)	{
		$data=$this->section->detail($id);
		echo json_encode($data);
	}
	public function save_roadno(){	
		if ($this->input->post('show')) {
			if ($this->section->save_saveroadno()) {
				//$this->session->set_flashdata('message', 'Tcscode save Successfully');
				redirect('Section','refresh');
			} else {
				//$this->session->set_flashdata('message', 'Failed to store tcsid');
				redirect('Section','refresh');
			}
		}
		
	}
	public function section_update()
	{
		if ($this->input->post('edit')) {
			if ($this->section->edit_section()) {
				$this->session->set_flashdata('message', 'Successfully Updated');
				redirect('Section','refresh');
			}
			else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Section','refresh');
			}
		}
	}

	public function hapus($id='')
	{
		if ($this->section->hapus_section($id)) {
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect('Section','refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('Section','refresh');
		}
	}

}
