<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_flow extends CI_Model
{

	public function get_flow()
	{
		$tm_user = $this->db->get('tabfinprocess')->result();
		return $tm_user;
	}

	public function get_user()
	{
		$tm_user = $this->db->LIKE('level', 'Financial', 'after')
			->get('user')->result();
		return $tm_user;
	}
	public function save_flow()
	{
		$a = explode(':', $this->input->post('pkgid'));

		$object = array(
			'flowid' => $a[0],
			'pkgid' => $a[1],
			'flow' => $this->input->post('flowlist')
		);
		return $this->db->insert('tabfinprocess', $object);
	}
	// public function get_pkg()
	// {	$data=array();
	// 	$i=0;
	// 	$rlist=$this->session->userdata('pkglist');
	// 	$tm_project=$this->db->ORDER_BY ('pkgsn') ->get('tabproject')->result_array();
	// 	if (strlen($rlist) ==0){ return $tm_project;}else{
	// 		$rid=explode(',', $rlist);
	// 		foreach ($rid as $r) {
	// 			foreach ($tm_project as $road) {
	// 				if	($road["pkgsn"]==$r){
	// 					$rowv=array('pkgsn'=> $road["pkgsn"],'pkg'=> $road["pkg"]);
	// 					$data[]=$rowv;
	// 				break;
	// 				}
	// 			}
	// 		}

	// 		return $data;}

	// }

	public function get_pkg()
	{
		$rlist = $this->session->userdata('pkglist');

		if (empty($rlist)) {
			// Return all if no pkglist in session
			return $this->db->order_by('flowid')->get('tabfinprocess')->result_array();
		}

		// Remove leading colon, explode by colon
		$rlist = ltrim($rlist, ':');
		$pkgids = explode(':', $rlist);

		// Get all rows where pkgid in $pkgids
		$tm_project = $this->db
			->order_by('flowid')
			->where_in('pkgid', $pkgids)
			->get('tabfinprocess')
			->result_array();

		return $tm_project;
	}

	public function edit_flow()
	{
		$object = array(
			'flow' => $this->input->post('flowlist2')
		);
		return $this->db->where('flowid', $this->input->post('user_code_lama'))->update('tabfinprocess', $object);
	}
	public function hapus_flow($id = '')
	{
		return $this->db->where('flowid', $id)->delete('tabfinprocess');
	}
}
