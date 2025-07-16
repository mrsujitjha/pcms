<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projectreport extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_project','project');
	}
	public function index()
	{
		$this->load->library('pagination');
		$countrow = $this->project->count_project();
		$data['get_project']=$this->project->get_project_report();		
		$data['content']="v_projectreport";

		//$data['total_rows'] = $countrow;
		//$data['per_page'] = 1;
		//$from = $this->uri->segment(3);
		//$this->pagination->initialize($data);		
		
		$this->load->view('template', $data, FALSE);
	}
	

}

