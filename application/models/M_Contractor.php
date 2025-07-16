<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Contractor extends CI_Model {

	public function get_Contractor()
	{
		$tm_user=$this->db->get('tabcontractor')->result();
		return $tm_user;		
	}
	public function save_Contractor()
	{
		$object=array(
				'cid'=>$this->input->post('cid'),
				'cname'=>$this->input->post('cname'),
				'cperson'=>$this->input->post('cperson'),
				'cphone'=>$this->input->post('cnum'),
				'cemail'=>$this->input->post('cemail'),
				'caddrs'=>$this->input->post('caddrs')
			);
		return $this->db->insert('tabcontractor', $object);
	}
	
	public function detail($a)
	{
		$b = explode(':', $a);
		$this->session->set_userdata('mypage',$b[1]);
		return $this->db->where('cid', $b[0])
						->from('tabcontractor')
						->get()
						->row();
	}
	
	
	public function get_maxid()
	{
		return $this->db->select_max('cid')
					->from('tabcontractor')
					->get()
					->row();
	}
	
	public function edit_Contractor()
	{
		$object=array(			
			'cname'=>$this->input->post('cname1'),
				'cperson'=>$this->input->post('cperson1'),
				'cphone'=>$this->input->post('cnum1'),
				'cemail'=>$this->input->post('cemail1'),
				'caddrs'=>$this->input->post('caddrs1')
			);
		return $this->db->where('cid', $this->input->post('user_code_lama'))->update('tabcontractor',$object);
	}
	
	
	public function hapus_Contractor($id='')
	{
		return $this->db->where('cid', $id)->delete('tabcontractor');
	}
	
	

}
