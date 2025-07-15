<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_paycon extends CI_Model {


	public function get_condition()
	{
		$allcond=$this->db->get('tabpaycon')->result();
		return $allcond;		
	}
	public function save_paycon()
	{	$i=$this->get_maxid();	
		$object=array(
				'cid'=>$i['cid']+1,
				'pname'=>$this->input->post('pname'),
				'detail'=>$this->input->post('pdetail'),
				'logic'=>$this->input->post('plogic'),
			);
		return $this->db->insert('tabpaycon', $object);
	}
	public function condition_logic($a)
	{ $b = explode(':', $a);
		$this->session->set_userdata('mypage',$b[1]);
		return $this->db->where('cid',$b[0])
		->get('tabpaycon')
		->row();
	}
	
	public function edit_paycon()
	{
		$object=array(			
			'pname'=>$this->input->post('pname1'),
			'detail'=>$this->input->post('pdetail1'),
			'logic'=>$this->input->post('plogic1'),
			);
		return $this->db->where('cid', $this->input->post('user_code_lama'))->update('tabpaycon',$object);
	}
	public function hapus_flow($id='')
	{
		return $this->db->where('cid', $id)->delete('tabpaycon');
	}
	public function get_maxid()
	{ return $this->db->select_max('cid')
					->from('tabpaycon')
					->get()
					->row_array();
	}
	

}
