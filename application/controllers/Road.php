<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Road extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Road','Road');
	}
	public function index()
	{
		$this->load->library('pagination');
		$data['get_Road']=$this->Road->get_Road();		
		$data['get_pkg']=$this->Road->get_pkg();		
		$data['content']="v_road";
		$this->pagination->initialize($data);
		//$data["links"] = $this->pagination->create_links();
		$this->load->view('template', $data, FALSE);
		
		
	}
	public function add()
	{
		$this->form_validation->set_rules('rname', 'rname', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {			
			if ($this->Road->save_Road()) {
				$this->session->set_flashdata('message', 'Road has been added successfully');
			} else {
				$this->session->set_flashdata('message', 'Road has failed to Add');
			}
			redirect('Road','refresh');
		} else {
		$this->session->set_flashdata('message', validation_errors());
		redirect('Road','refresh');
	}
	}

	public function edit_Road($Roadid)
	{
		$data=$this->Road->Road_detail($Roadid);
		echo json_encode($data);
		
	}
	public function get_roadcode()
	{
		//$data=$this->Road->get_maxroadid();
		$data=$this->Road->count_Road();
		echo json_encode($data);
	}
	public function Road_update()
	{
		if ($this->input->post('save')) {
			
				if ($this->Road->update_Road()) {
					$this->session->set_flashdata('message', 'Road Details has been updated successfully.');
					redirect('Road');
				} else {
					$this->session->set_flashdata('message', 'Failed to update');
					redirect('Road');
				}
			
		}
		if ($this->input->post('savekml')) {
			
			if ($this->Road->update_Roadkml()) {
				$this->session->set_flashdata('message', 'Road kml has been updated successfully.');
				redirect('Road');
			} else {
				$this->session->set_flashdata('message', 'Failed to update kml');
				redirect('Road');
			}
		}
			if ($this->input->post('clearkml')) {
			
				if ($this->Road->clear_kmlRoad()) {
					$this->session->set_flashdata('message', 'Road kml has been clear successfully.');
					redirect('Road');
				} else {
					$this->session->set_flashdata('message', 'Failed to clear kml.');
					redirect('Road');
				}
		}
			if ($this->input->post('exportkml')) {
				
				if ($this->Road->download_kmlRoad()) {
					$this->session->set_flashdata('message', 'Road kml has been Downloaded successfully.');
					redirect('Road');
				} else {
				$this->session->set_flashdata('message', 'Failed to Export kml.');
					redirect('Road');
				}
		}
			
	}

	public function hapus($Roadid='')
	{
		if ($this->Road->delete_Road($Roadid)) {
			$this->session->set_flashdata('message', 'Road has been deleted successfully.');
			redirect('Road','refresh');
		} else {
			$this->session->set_flashdata('message', 'Delete Failed');
			redirect('Road','refresh');
		}
	}
	
}

