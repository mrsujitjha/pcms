<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tcsmgm extends CI_Model {

	public function get_tcsmgm($a)
	{
		if($a==""){$tm_project=$this->db->get('tabtcsmgm')->result();}else
		{$tm_project=$this->db->Like('roadid',$a,'after')			
			->order_by('itemid','desc')
			->get('tabtcsmgm')
			->result();}
		return $tm_project;

	}
	public function count_Row(){
		return $this->db->get('tabtcsmgm')->num_rows();
	}
	public function get_road()
	{	$data=array();
		$i=0;
		$rlist=$this->session->userdata('rlist');
		$tm_project=$this->db->get('tabroad')->result_array();
		if (strlen($rlist) ==0){ return $tm_project;}else{
			$rid=explode(',', $rlist);
			foreach ($rid as $r) {
				foreach ($tm_project as $road) {
					if	($road["rid"]==$r){
						$rowv=array('rid'=> $road["rid"],'rname'=> $road["rname"]);
						$data[]=$rowv;
					break;
					}
				}
			}
		
			return $data;}
			
	}
	public function save_saveroadno(){
		$rtext =$this->input->post('proid');
		$a = explode(':', $rtext);
		$this->session->set_userdata('roadid',$a[0]);
		return true;		
	}

	public function save_tcsmgm()
	{$r =$this->session->userdata('roadid');	
		$i=$this->get_record();	
		$tcs=str_replace(" ","-",$this->input->post('tcsname'));
		$object=array(
				'itemid'=>$i['itemid']+1,
				'roadid'=>$r,
				'descrip'=>$this->input->post('descrip'),
				'gtext'=>$this->input->post('gtext'),
				'name'=>$tcs
			);
		return $this->db->insert('tabtcsmgm', $object);
	}
	public function detail($a)
	{
		return $this->db->where('itemid', $a)
						->from('tabtcsmgm')
						->get()
						->row();
	}
	public function get_maxid()
	{$a =$this->session->userdata('roadid');
		return $this->db->where('roadid', $a)
		->from('tabtcsmgm')
		->get()
		->num_rows();
	}
	public function get_record()
	{return $this->db->select_max('itemid')
		->from('tabtcsmgm')
		->get()
		->row_array();
	}
	public function edit_tcsmgm()
	{$r =$this->session->userdata('roadid');
		$tcs=str_replace(" ","-",$this->input->post('tcsname2'));
		$object=array(	
			'roadid'=>$r,		
			'descrip'=>$this->input->post('descrip2'),
			'gtext'=>$this->input->post('gtext2'),
			'name'=>$tcs
			);
		return $this->db->where('itemid', $this->input->post('user_code_lama'))->update('tabtcsmgm',$object);
	}
	public function hapus_tcsmgm($id='')
	{
		return $this->db->where('itemid', $id)->delete('tabtcsmgm');
	}

	

}
