<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_item extends CI_Model {

	public function get_item()
	{
		$tm_user=$this->db->get('tabitemcode')->result();
		return $tm_user;		
	}
	public function save_item()
	{
		$object=array(
				'itemid'=>$this->input->post('itemid'),
				'name'=>$this->input->post('descrip'),
				'unit'=>$this->input->post('unit'),
				'dash'=>$this->input->post('dash'),
				'punch'=>$this->input->post('punch'),
				'draw'=>$this->input->post('draw'),
				'sitem'=>$this->input->post('sitem')
			);
		return $this->db->insert('tabitemcode', $object);
	}
	public function save_stage()
	{$i=$this->getstage_maxid();	
		$object=array(
				'id'=>$i['id']+1,
				'itemid'=>$this->input->post('istage'),
				'descrip'=>$this->input->post('stgid')
			);
		return $this->db->insert('tabstage', $object);
	}
	
	public function save_rfiitem()
	{ $a=$this->input->post('isitem');
		$this->db->where('itemid', $a)->delete('tabrfiitem');
		$myString = $this->input->post('selitem');	
	if (strlen($myString) >0) {
		$x=explode(',',$myString );
		$object = [];
		$i=count($x);		
			for ($j = 0; $j <$i; $j++) {
				$object[]=array(
						'id'=>$j+1,
						'itemid'=>$a,
						'descrip'=>$x[$j]
					);
		
				}		
		return $this->db->insert_batch('tabrfiitem',$object);}else{ return false;}
	}
	public function save_draw()
	{ $a=$this->input->post('idraw');
		$this->db->where('itemid', $a)->delete('tabdraw');
		$myString = $this->input->post('seldraw');	
	if (strlen($myString) >0) {
		$x=explode(',',$myString );
		$object = [];
		$i=count($x);		
			for ($j = 0; $j <$i; $j++) {
				$object[]=array(
						'id'=>$j+1,
						'itemid'=>$a,
						'descrip'=>$x[$j]
					);
		
				}		
		return $this->db->insert_batch('tabdraw',$object);}else{ return false;}
	}
	public function detail($a)
	{
		$b = explode(':', $a);
		$this->session->set_userdata('mypage',$b[1]);
		return $this->db->where('itemid', $b[0])
						->from('tabitemcode')
						->get()
						->row();
	}
	public function getstagedetail($a)
	{
		$b = explode(':', $a);
		$this->session->set_userdata('mypage',$b[1]);
		return $this->db->where('itemid', $b[0])
						->from('tabstage')
						->get()
						->result_array();	
	}
	
	public function find_rfiitem($a)
	{	
		return $this->db->order_by('id', 'ASC')
						->where('itemid', $a)
						->from('tabrfiitem')						
						->get()
						->result_array();	
	}
	public function find_drawing($a)
	{
		$b = explode(':', $a);
		$this->session->set_userdata('mypage',$b[1]);
		return $this->db->where('itemid', $b[0])
						->from('tabdraw')
						->get()
						->result_array();	
	}
	public function get_maxid()
	{

		return $this->db->select_max('itemid')
					->from('tabitemcode')
					->get()
					->row();
	}
	public function getstage_maxid()	{
		return $this->db->select_max('id')
					->from('tabstage')
					->get()
					->row_array();
	}
	public function getrfiitem_maxid()	{
		return $this->db->select_max('id')
					->from('tabrfiitem')
					->get()
					->row_array();
	}
	
	public function edit_item()
	{
		$object=array(			
			'name'=>$this->input->post('descrip2'),
			'unit'=>$this->input->post('unit2'),
			'dash'=>$this->input->post('dash2'),
			'punch'=>$this->input->post('punch2'),
			'draw'=>$this->input->post('draw2'),
			'sitem'=>$this->input->post('sitem2')
			);
		return $this->db->where('itemid', $this->input->post('user_code_lama'))->update('tabitemcode',$object);
	}
	public function Edit_stage()
	{
		$object=array(			
			'descrip'=>$this->input->post('stgid')
			);
		return $this->db->where('descrip', $this->input->post('mstages'))->update('tabstage',$object);
	}
	
	public function hapus_item($id='')
	{
		return $this->db->where('itemid', $id)->delete('tabitemcode');
	}
	
	

}
