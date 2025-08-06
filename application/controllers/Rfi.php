<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rfi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Rfi', 'Rfi');
	}
	public function index()
	{
		$a = "R00";
		if ($this->session->has_userdata('roadid')) {
			$a = $this->session->userdata('roadid');
		}
		$data['get_Rfi'] = $this->Rfi->get_Rfi($a);
		$data['get_roadlist'] = $this->Rfi->get_road();
		$data['get_itemlist'] = $this->Rfi->get_item();
		// $data['get_userlist'] = $this->Rfi->get_user();
		$data['content'] = "v_Rfi";
		$this->load->view('template', $data, FALSE);
	}
	public function add()
	{
		if ($this->input->post('save')) {
			if ($this->Rfi->save_Rfi()) {
				$this->session->set_flashdata('message', 'Rfi Added Successfully');
				redirect('Rfi', 'refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add');
				redirect('Rfi', 'refresh');
			}
		}
		if ($this->input->post('Action')) {
			if ($this->Rfi->save_Rfi_action()) {
				$this->session->set_flashdata('message', 'Rfi Action added Successfully');
				redirect('Rfi', 'refresh');
			} else {
				$this->session->set_flashdata('message', 'Failed to Add action text');
				redirect('Rfi', 'refresh');
			}
		}
	}
	public function get_chainagelist($id)
	{
		$rnow = $this->Rfi->get_item_remaining_ch($id);
		echo json_encode($rnow);
	}
	public function get_userid()
	{
		$rnow = $this->Rfi->get_userid();
		echo json_encode($rnow);
	}
	public function get_Rfiid($id)
	{

		$rnow = $this->Rfi->maxRfiid($id);
		echo json_encode($rnow);
	}

	public function find_Rfi($id)
	{
		$data = $this->Rfi->detail($id);
		echo json_encode($data);
	}
	public function list_Rfi($id)
	{
		$data = $this->Rfi->get_Rfi_activity($id);
		echo json_encode($data);
	}
	public function verify_drawing($ch, $id)
	{
		$rnow = $this->Rfi->verify_drawing($ch, $id);
		echo json_encode($rnow);
	}
	public function save_roadno()
	{
		if ($this->input->post('show')) {
			if ($this->Rfi->save_saveroadno()) {
				//$this->session->set_flashdata('message', 'Tcscode save Successfully');
				redirect('Rfi', 'refresh');
			} else {
				//$this->session->set_flashdata('message', 'Failed to store tcsid');
				redirect('Rfi', 'refresh');
			}
		}
	}
	public function Rfi_update()
	{
		if ($this->input->post('edit')) {
			if ($this->Rfi->edit_Rfi()) {
				$this->session->set_flashdata('message', 'Successfully Updated');
				redirect('Rfi', 'refresh');
			} else {
				$this->session->set_flashdata('message', 'Update Failed');
				redirect('Rfi', 'refresh');
			}
		}
		if ($this->input->post('progress')) {
			if ($this->Rfi->progress_Rfi()) {
				$this->session->set_flashdata('message', 'progress Successfully Updated');
				redirect('Rfi', 'refresh');
			} else {
				$this->session->set_flashdata('message', 'Progress Update Failed');
				redirect('Rfi', 'refresh');
			}
		}
	}

	public function hapus($id = '')
	{
		if ($this->Rfi->hapus_Rfi($id)) {
			$this->session->set_flashdata('message', 'Successfully Deleted');
			redirect('Rfi', 'refresh');
		} else {
			$this->session->set_flashdata('message', 'Failed to delete');
			redirect('Rfi', 'refresh');
		}
	}

	public function flowlist()
	{
		$rfiid = $this->input->post('main_id');
		$flowUsers = $this->input->post('seluser');

		if (!empty($rfiid) && !empty($flowUsers)) {
			$updated = $this->Rfi->update_rfiflow($rfiid, $flowUsers);

			if ($updated) {
				$this->session->set_flashdata('message', 'Flow list updated successfully.');
			} else {
				$this->session->set_flashdata('message', 'Failed to update flow list.');
			}
		} else {
			$this->session->set_flashdata('message', 'Missing RFI ID or user list.');
		}

		redirect('Rfi', 'refresh');
	}

	public function get_users_from_rfiflow()
	{
		$rfiflow = $this->input->post('rfiflow');
		$loggedin = trim($this->input->post('loggedin'));

		$ids = array_map('trim', explode(",", $rfiflow));
		$current_index = array_search($loggedin, $ids);

		$forward_users = [];

		// If only one user in the list
		if (count($ids) == 1) {
			$forward_users[] = $ids[0];
		} else {
			// If more than one user, forward all
			$forward_users = $ids;
		}

		header('Content-Type: application/json');

		if (!empty($forward_users)) {
			$this->db->where_in('user_code', $forward_users);
			$query = $this->db->get('user');
			echo json_encode($query->result());
		} else {
			echo json_encode([]);
		}
	}

	public function get_user_ajax()
	{
		$rfiid = $this->input->post('rfiid');
		$userlist = $this->Rfi->get_user($rfiid);

		echo json_encode($userlist);
	}

	public function check_rfi_duplicate()
	{
		header('Content-Type: application/json');
		$location = trim($this->input->post('location'));

		if (empty($location)) {
			echo json_encode(['status' => 'ok']);
			return;
		}

		$this->db->select('a.action');
		$this->db->from('tabrfiaction a');
		$this->db->join('tabrfi r', 'r.rfiid = a.rfiid', 'inner');
		$this->db->where('r.location', $location);
		$this->db->order_by('a.mdate DESC, a.mtime DESC');
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$last_action = $query->row()->action;
			if (!empty($last_action) && strtolower(trim($last_action)) === 'rejected') {
				echo json_encode(['status' => 'ok']);
			} else {
				echo json_encode(['status' => 'exists']);
			}
		} else {
			echo json_encode(['status' => 'ok']);
		}
	}
}
