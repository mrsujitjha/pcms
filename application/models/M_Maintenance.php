<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Maintenance extends CI_Model {

	public function get_Maintenance_old($a)
	{ 	$b =$this->session->userdata('itemname');
		if($a==""){$tm_project=$this->db->get('tabmaintenance')->result();}else
		{$tm_project=$this->db->Like('rid',$a,'after')
			->get('tabmaintenance')->result();}
		return $tm_project;
	}
	public function get_Maintenance($a)
	{ 	$y=$this->session->userdata('phyyear')+2023;
		$m=$this->session->userdata('phymonth');
		if ($m< 10){$rdate=$y.'0'.$m;}else{$rdate=$y.$m;}
		//echo $rdate;//value show on page left cornor		
		$myquery="SELECT * FROM `tabmaintenance` WHERE substring(rdate,1,6)=".$rdate." AND `rid` LIKE '".$a."%'";
		return $this->db->query($myquery)->result();;
	}
	public function get_road()
	{	$data=array();
		$i=0;
		$rlist=$this->session->userdata('rlist');
		$myquery="SELECT * FROM `tabroad` WHERE LENGTH(fcerti)>1";
		$tm_project = $this->db->query($myquery)->result_array();
		if (strlen($rlist) ==0){ return $tm_project;}else{
			$rid=explode(',', $rlist);
			foreach ($rid as $r) {
				foreach ($tm_project as $road) {
					if	($road["rid"]==$r){
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
		return $this->db->WHERE('unit', "Maint")
		->get('tabitemcode')
		->result();	
	}

	public function save_Maintenance()
	{$d=str_replace("-","",$this->input->post('rdate'));
		$object=array(
				'rid'=>$this->input->post('icode'),
				'item'=>$this->input->post('item'),
				'chainage'=>$this->input->post('ch'),
				'descrip'=>$this->input->post('descrip'),
				'rdate'=>$d
			);
		return $this->db->insert('tabmaintenance', $object);
	}
	
	public function detail($a)
	{ $b = explode(':', $a);
		$this->session->set_userdata('mypage',$b[1]);
		$this->db->select('tabmaintenance.*');
		$this->db->from('tabmaintenance');
		$this->db->where('tabmaintenance.rid', $b[0]);
		$query = $this->db->get()->row();
		return $query;
	}

	public function maxMaintenanceid($a)
	{	return $this->db->select_max('rid')
		->like('rid',$a)
		->from('tabmaintenance')
		->get()->row();	
	}

	public function save_saveroadno(){
		$rtext =$this->input->post('proid');
		$c=$this->input->post('selitem');
		$a = explode(':', $rtext);
		$y=$this->input->post('pyear');
		$m=$this->input->post('pmonth');
		
		$this->session->set_userdata('phyroadid',$a[0]);
		$this->session->set_userdata('roadid',$a[0]);
		$this->session->set_userdata('itemname',$c);	
		$this->session->set_userdata('phyyear',$y);
        $this->session->set_userdata('phymonth',$m);
		return true;
		
	}

	public function edit_Maintenance()
	{$d=str_replace("-","",$this->input->post('rdate2'));
		$object=array(
			'chainage'=>$this->input->post('ch2'),
			'descrip'=>$this->input->post('descrip2'),
			'rdate'=>$d
			);
		return $this->db->where('rid', $this->input->post('user_code_lama'))->update('tabmaintenance',$object);
	}
	public function edit_progress()	
	{ $d=str_replace("-","",$this->input->post('cdate'));
			$object=array(					
			'status'=>$this->input->post('prog'),
			'rem'=>$this->input->post('rem'),
			'cdate'=>$d
			);
		return $this->db->where('rid', $this->input->post('progcode'))->update('tabmaintenance',$object);
	}
	public function hapus_Maintenance($id='')
	{
		return $this->db->where('rid', $id)->delete('tabmaintenance');
	}
	

}
