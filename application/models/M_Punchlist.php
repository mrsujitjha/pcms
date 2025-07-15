<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Punchlist extends CI_Model {
	public function get_punchlist($a)
	{ 
		if($a==""){$tm_project=$this->db->get('tabpunchlist')->result();}else
		{$myquery="SELECT tabpunchlist.*,tabitemcode.name FROM tabpunchlist LEFT JOIN tabitemcode ON tabitemcode.itemid =substring(tabpunchlist.ricode,4,3) WHERE tabpunchlist.ricode LIKE '".$a."%'";
			$tm_project = $this->db->query($myquery)->result();
		return $tm_project;
		}
	}
	public function get_road()
	{	$data=array();
		$i=0;
		$rlist=$this->session->userdata('rlist');
		$myquery="SELECT * FROM `tabroad` WHERE LENGTH(pcerti)>1 AND  LENGTH(fcerti)=0";
		$tm_project = $this->db->query($myquery)->result_array();
		if (strlen($rlist) ==0){ return $tm_project;}else{
			$rid=explode(',', $rlist);
			foreach ($rid as $r) {
				foreach ($tm_project as $road) {
					if ($road["rid"]==$r){
						$rowv=array('rid'=> $road["rid"],'rname'=> $road["rname"],'sc'=> $road["sc"]);
						$data[]=$rowv;
					break;
					}
				}
			}
			return $data;}
	}
	
	public function get_item()
	{
		return $this->db->WHERE('punch', "YES")
		->get('tabitemcode')
		->result();	
	}

	public function save_punchlist()
	{
		$object=array(
				'ricode'=>$this->input->post('sechid'),
				'mdays'=>$this->input->post('mdays'),
				'lactivity'=>$this->input->post('mactivity'),
				'rem'=>$this->input->post('rem')
			);
		return $this->db->insert('tabpunchlist', $object);
	}
	
	public function detail($a)
	{ $b = explode(':', $a);
		$this->session->set_userdata('mypage',$b[1]);
		$this->db->select('tabpunchlist.*');
		$this->db->from('tabpunchlist');
		$this->db->where('tabpunchlist.ricode', $b[0]);
		$query = $this->db->get()->row();
		return $query;
	}

	public function maxpunchlistid($a)
	{		
		return $this->db->select_max('ricode')
		->like('ricode',$a)
		->from('tabpunchlist')
		->get()->row();
	}

	public function save_saveroadno(){
		$rtext =$this->input->post('proid');
		$b=$this->input->post('selitem');
		$a = explode(':', $rtext);
		$this->session->set_userdata('roadid',$a[0]);
		$this->session->set_userdata('itemname',$b);	

		return true;
		
	}

	public function edit_punchlist()
	{
		$object=array(
			'mdays'=>$this->input->post('mdays2'),
			'lactivity'=>$this->input->post('mactivity2'),
			'rem'=>$this->input->post('rem2')
			);
		return $this->db->where('ricode', $this->input->post('user_code_lama'))->update('tabpunchlist',$object);
	}
	public function progress_punchlist()
	{
		$object=array(			
			'lcdate'=>$this->input->post('ladate'),
			'plandate'=>$this->input->post('icdate'),
			'compdate'=>$this->input->post('comdate')
			);
		return $this->db->where('ricode', $this->input->post('user_code_lama2'))->update('tabpunchlist',$object);
	}
	public function hapus_punchlist($id='')
	{
		return $this->db->where('ricode', $id)->delete('tabpunchlist');
	}
	
	

}
