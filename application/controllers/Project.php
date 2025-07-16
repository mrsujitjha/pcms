<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_project','project');
	}
	public function index()
	{
		$data['get_project']=$this->project->get_project();	
		$data['conlist']=$this->project->get_conlist();		
		$data['content']="v_project";
		$this->load->view('template', $data, FALSE);
	}
	public function add()
	{
		//$this->form_validation->set_rules('rname', 'rname', 'trim|required');
		
	//	if ($this->form_validation->run() == TRUE) {			
			if ($this->project->save_project()) {
				$this->session->set_flashdata('message', 'Project has been added successfully');
			} else {
				$this->session->set_flashdata('message', 'Project has failed to Add');
			}
			redirect('project','refresh');
	//	} else {
	//	$this->session->set_flashdata('message', validation_errors());
	//	redirect('project','refresh');
	//}
	}

	public function edit_project($projectid)
	{
		$data=$this->project->project_detail($projectid);
		echo json_encode($data);
		
	}
	public function load_milestone($projectid)
	{
		$data=$this->project->milestone_detail($projectid);
		echo json_encode($data);
		
	}
	public function load_completedmilestone($projectid)
	{
		$data=$this->project->Completed_detail($projectid);
		echo json_encode($data);
		
	}
	public function get_projectid()
	{
		$data=$this->project->get_maxid();
		echo json_encode($data);
		
	}
	public function project_update()
	{
		if ($this->input->post('save')) {			
			if ($this->project->update_project()) {
				$this->session->set_flashdata('message', 'project Details has been updated successfully.');
				redirect('project');
			} else {
				$this->session->set_flashdata('message', 'Failed to update');
				redirect('project');
			}			
		}
		if ($this->input->post('update')) {			
			if ($this->project->update_milestone()) {
				$this->session->set_flashdata('message', 'Milestone has been updated successfully.');
				redirect('project');
			} else {
				$this->session->set_flashdata('message', 'Failed to update milestone.');
				redirect('project');
			}		
		}
		if ($this->input->post('awarded')) {			
			if ($this->project->update_project_award()) {
				$this->session->set_flashdata('message', 'Awarded details has been updated successfully.');
				redirect('project');
			} else {
				$this->session->set_flashdata('message', 'Failed to update award.');
				redirect('project');
			}		
		}
	}

	public function hapus($projectid='')
	{
		if ($this->project->delete_project($projectid)) {
			$this->session->set_flashdata('message', 'Project has been deleted successfully.');
			redirect('project','refresh');
		} else {
			$this->session->set_flashdata('message', 'Delete Failed');
			redirect('project','refresh');
		}
	}

}

