<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Stage extends CI_Model {

	
	public function get_stageitems($a)

	{ 
		$b =$this->session->userdata('itemname');
		if($a==""){$tm_project=$this->db->get('tabstageitem')->result();}else
		{$tm_project=$this->db->Like('id',$a,'after')
			->Like('itemname',$b)
			->get('tabstageitem')->result();}
		return $tm_project;
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
		return $this->db->WHERE('unit', "Stage")
		->get('tabitemcode')
		->result();	
	}
	public function find_roaditemstage($a)
	{$b =$this->session->userdata('roadid');
		$myquery="SELECT * FROM `tabstageitem` WHERE `itemid`=".$a." AND`id` LIKE '".$b."%'";
		$query = $this->db->query($myquery)->result();		
		return $query;
	}

	public function save_Stage()
	{	$a= $this->session->userdata('userid');
		$cdate = date('ymd');
		$data = [];
		$a=	$this->input->post('item');
		$r =$this->session->userdata('roadid');
		$b = explode(':', $a);
		$c = explode(',',$this->input->post('stages'));
		$sector=$this->input->post('scn');
		if($sector==0){$sector=$r.'H1'.$b[0];}else{$sector=$r.'H'.$sector.$b[0];}
		$d=($this->maxStageid($sector))+1;
		if ($d<10){$newval=$sector.'0'.$d;}else{$newval=$sector.$d;}
		$status='NOT STARTED';
		$data[]=array('rid'=>$newval,'stageid'=>$b[0].'-'.$c[0],'status'=>'NOT STARTED');
		for ($i=1;$i<count($c);$i++ ){$status= $status.",".'NOT STARTED';
			$data[]=array('rid'=>$newval,'stageid'=>$b[0].'-'.$c[$i],'status'=>'NOT STARTED');
		}
		$this->db->insert_batch('tabstgp', $data);
		$object=array(
				'id'=>$newval,
				'itemname'=>$b[1],
				'itemid'=>$b[0],
				'chainage'=>$this->input->post('ch'),
				'length'=>$this->input->post('length'),
				'span'=>$this->input->post('span'),
				'descrip'=>$this->input->post('descrip'),
				'stages'=>$this->input->post('stages'),
				'aadetails'=>$a.'-'.$cdate.'-0',
				'wdone'=>'0',
				'status'=>$status
			);
		return $this->db->insert('tabstageitem', $object);

	}
	public function Approve_Stage()
	{$a= $this->session->userdata('userid');
		$cdate =':'.$a.'-'.date('ymd').'-2' ;
		$myquery="UPDATE tabstageitem SET aadetails= CONCAT(aadetails, '".$cdate."'),wdone=2";
		$getqresult = $this->db->query($myquery);
		return $getqresult;
	}
	public function detail($a)
	{ $b = explode(':', $a);
		$this->session->set_userdata('mypage',$b[1]);
		$myquery="SELECT P.*,Q.allstg,Q.idstg FROM (SELECT * FROM tabstageitem WHERE id='".$b[0]."') as P JOIN (SELECT tabitemcode.name,A.idstg,A.allstg FROM (SELECT itemid,GROUP_CONCAT(id) as 'idstg',GROUP_CONCAT(descrip) as 'allstg' FROM tabstage GROUP BY itemid ) as A JOIN tabitemcode ON tabitemcode.itemid=A.itemid) as Q ON P.itemname=Q.name";
		$query = $this->db->query($myquery)->result();		
		return $query;
	}
	public function get_stagelist($a)
	{ 
		$myquery="SELECT itemid,GROUP_CONCAT(id) as 'idstg',GROUP_CONCAT(descrip) as 'allstg' FROM tabstage  WHERE itemid='".$a."' GROUP BY itemid";
		$query = $this->db->query($myquery)->result();		
		return $query;
	}
	public function maxStageid($a)
	{		
			
	return $this->db->like('id',$a)
				->from('tabstageitem')
				->get()
				->num_rows();
	}

	public function save_saveroadno(){
		$rtext =$this->input->post('proid');
		$b=$this->input->post('selitem');
		$a = explode(':', $rtext);
		$this->session->set_userdata('roadid',$a[0]);
		$this->session->set_userdata('itemname',$b);

		return true;
		
	}

	public function edit_Stage()
	{$a= $this->session->userdata('userid');
		$cdate = date('ymd');
		$data = [];
		$nid= $this->input->post('user_code_lama');		
		$b=substr($nid,5,3);
		$c = explode(',',$this->input->post('stages2'));
		$status='NOT STARTED';
		$data[]=array('rid'=>$nid,'stageid'=>$b.'-'.$c[0],'status'=>'NOT STARTED');
		for ($i=1;$i<count($c);$i++ ){$status= $status.",".'NOT STARTED';
			$data[]=array('rid'=>$nid,'stageid'=>$b.'-'.$c[$i],'status'=>'NOT STARTED');
		}
		$this->db->where('rid', $nid)->delete('tabstgp');
		$this->db->insert_batch('tabstgp', $data);
		$object=array(			
			'itemname'=>$this->input->post('item2'),
				'chainage'=>$this->input->post('ch2'),
				'length'=>$this->input->post('length2'),
				'span'=>$this->input->post('span2'),
				'descrip'=>$this->input->post('descrip2'),
				'stages'=>$this->input->post('stages2'),
				'aadetails'=>$this->input->post('aadetails').':'.$a.'-'.$cdate.'-1',
				'wdone'=>'1',
				'status'=>$status
			);
		return $this->db->where('id', $nid)->update('tabstageitem',$object);
	}
	public function edit_progress()
		{ $data = [];
			$status='';
			$a= $this->input->post('progcode');	
			$b=explode(":",$a);
			$d = explode(',',$b[1]);
			$yrm=date("Y")*100+date("m");
			$c=$this->input->post('tn');	
			for ($i=1;$i<=$c;$i++ ){
			$p='P'.$i;
			$s = $this->input->post($p);
			$data[]=array('rid'=> $b[0],'stageid'=>substr($b[0],5,3) .'-'.$d[$i-1],'status'=>$s,'yrm'=>$yrm);
			if ($status==''){$status= $s;}else{$status= $status.",".$s;}}
			$this->db->where('rid', $b[0])->delete('tabstgp');
			$this->db->insert_batch('tabstgp', $data);			
			$object=array(					
			'status'=>$status
			);

		return $this->db->where('id', $b[0])->update('tabstageitem',$object);
	}
	public function hapus_Stage($id='')
	{	$this->db->where('rid', $id)->delete('tabstgp');
		return $this->db->where('id', $id)->delete('tabstageitem');
	}
	
	

}
