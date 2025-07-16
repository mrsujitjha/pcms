<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Hindrance extends CI_Model {
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
	public function detail($a)
	{
		$b = explode(':', $a);
		$this->session->set_userdata('mypage',$b[1]);
		return $this->db->where('id', $b[0])
						->from('tabhindrance')
						->get()
						->row();
	}
	public function hapus_Hindrance($id='')
	{ 	
		return $this->db->where('id', $id)->delete('tabhindrance');
	}
	public function road_hidrance(){
		$tm_project = $this->db->query("select * from tabhindrance WHERE rid='".$this->session->userdata('roadid')."'")->result();
		return $tm_project;
	}
	public function upload_selected_Hindrance(){
		$i=$this->get_maxid();
		$ymd=Date('Y').'-'.Date('m').'-'.Date('d');
		$fr='From '.$this->input->post('location1').' - To '.$this->input->post('location2');
		$object=array(
			'id'=>$i['id']+1,
			'rid'=>$this->session->userdata('roadid'),
			'descrip'=>$this->input->post('descrip'),
			'location'=>$fr,
			'entryd'=>$ymd,
			'Rem'=>$this->input->post('rem')
		);
			return $this->db->insert('tabhindrance', $object);
	}
	public function get_maxid()	{
		return $this->db->select_max('id')->from('tabhindrance')->get()->row_array();
	}
	public function edit_Hindrance_details(){	
		$a=	$this->input->post('id');
		$fr='From '.$this->input->post('location3').' - To '.$this->input->post('location4');
		$object=array(
			'descrip'=>$this->input->post('descrip2'),
			'location'=>$fr,
			'Rem'=>$this->input->post('rem2')
		);			
		return $this->db->where('id', $a)->update('tabhindrance',$object);
	}

}
