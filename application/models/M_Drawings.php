<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Drawings extends CI_Model {
	public function get_Drawings($a)
	{ 
		if($a==""){$tm_project=$this->db->get('tabdrawings')->result();}else
		{$myquery="SELECT tabdrawings.* FROM tabdrawings WHERE tabdrawings.didn LIKE '".$a."%'";
			$tm_project = $this->db->query($myquery)->result();
		return $tm_project;
		}
	}
	
	public function get_road()
	{	$data=array();
		$i=0;
		$rlist=$this->session->userdata('rlist');
		$myquery="SELECT * FROM `tabroad`";
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

	public function save_Drawings()
	{	$i=$this->maxsn();	
		$b =$this->session->userdata('username');
		$uploads_dir ='./assets/drawings';		
        $tmp_name = $_FILES["mydoc"]["tmp_name"];       
        $name = basename($_FILES["mydoc"]["name"]);
		$ext=explode(".",$name);
		//$n=$ext.count();
		$mdate=date("Y").'-'.date("m").'-'.date("d");
		$name=$this->input->post('sechid').'_'.date("Y").date("m").date("d").date("h").date("i").date("s").'.'.$ext[1];	
       $upl= move_uploaded_file($tmp_name, "$uploads_dir/$name");
	   if($upl){
		$object=array(
				'didn'=>$this->input->post('sechid'),
				'dtype'=>$this->input->post('itype'),
				'TCS'=>$this->input->post('tcslist'),
				'Status'=>'Submited for review.',
				'userid'=>$b,
				'rem'=>$this->input->post('rem'),
				'fname'=>$name
			);
		$object2=array(
			'sn'=>$i['sn']+1,
			'didn'=>$this->input->post('sechid'),
			'Status'=>'Submited for review.',
			'userid'=>$b,
			'rem'=>$this->input->post('rem'),
			'fname'=>$name,
			'date'=>$mdate
		);
		$t1=$this->db->insert('tabdrawings', $object);
		$t2= $this->db->insert('tabdrawlist', $object2);
		if ($t1 && $t2){return true ;}else{return false;}
	   }else{return false;}
	}
	public function progress_Drawings()
	{	$i=$this->maxsn();	
		$b =$this->session->userdata('username');
		$c=$this->input->post('mstatus');
		$upl=true;
		$mdate=date("Y").'-'.date("m").'-'.date("d");
		if ($c=='Approved'){$name= $this->input->post('attach');}else{
		$uploads_dir ='./assets/drawings';		
        $tmp_name = $_FILES["myattach"]["tmp_name"];       
        $name = basename($_FILES["myattach"]["name"]);
		$ext=explode(".",$name);
		
		$n=$ext.count();		
		$name=$this->input->post('dcode').'_'.date("Y").date("m").date("d").date("h").date("i").date("s").'.'.$ext[1];	
		$upl= move_uploaded_file($tmp_name, "$uploads_dir/$name");
		} 		
	   if($upl){
		$object=array(				
			'Status'=>$c,
			'userid'=>$b,
			'rem'=>$this->input->post('remany'),
			'fname'=>$name
			);
		$object2=array(
			'sn'=>$i['sn']+1,
			'didn'=>$this->input->post('dcode'),
			'Status'=>$c,
			'userid'=>$b,
			'rem'=>$this->input->post('remany'),
			'fname'=>$name,
			'date'=>$mdate
		);
		$t1= $this->db->where('didn', $this->input->post('dcode'))->update('tabdrawings',$object);
		$t2= $this->db->insert('tabdrawlist', $object2);
		if ($t1 && $t2){return true ;}else{return false;}
	   }else{return false;}
	}
	public function detail($a)
	{ $b = explode(':', $a);
		$this->session->set_userdata('mypage',$b[1]);
		$this->db->select('tabdrawings.*');
		$this->db->from('tabdrawings');
		$this->db->where('tabdrawings.didn', $b[0]);
		$query = $this->db->get()->row();
		return $query;
	}
	public function alldrawing($a)
	{ 
		$myquery="SELECT tabdrawlist.*,tabdrawings.dtype,tabdrawings.TCS FROM tabdrawlist LEFT JOIN tabdrawings ON tabdrawings.didn=tabdrawlist.didn WHERE tabdrawlist.didn='".$a."' ORDER BY tabdrawlist.sn DESC";
			$tm_project = $this->db->query($myquery)->result();
		return $tm_project;
	}
	public function maxDrawingsid($a)
	{		
		return $this->db->select_max('didn')
		->like('didn',$a)
		->from('tabdrawings')
		->get()->row();
	}
	public function maxsn()
	{		
		return $this->db->select_max('sn')
		->from('tabdrawlist')
		->get()->row_array();
	}
	public function save_saveroadno(){
		$rtext =$this->input->post('proid');
		$b=$this->input->post('selitem');
		$a = explode(':', $rtext);
		$this->session->set_userdata('roadid',$a[0]);
		$this->session->set_userdata('itemname',$b);	

		return true;
		
	}

	public function edit_Drawings()
	{
		$object=array(
			'TCS'=>$this->input->post('tcslist2'),
			'rem'=>$this->input->post('rem2')
			);
		$object2=array(			
			'rem'=>$this->input->post('rem2')
			);
		$t1= $this->db->where('didn', $this->input->post('user_code_lama'))
		->where('status', 'Submited for review.')
		->update('tabdrawlist',$object2);
		$t2= $this->db->where('didn', $this->input->post('user_code_lama'))->update('tabdrawings',$object);
		if ($t1 && $t2){return true ;}else{return false;}	
	}
	
	public function hapus_Drawings($id='')
	{
		$t1= $this->db->where('didn', $id)->delete('tabdrawings');
		$t2=$this->db->where('didn', $id)->delete('tabdrawlist');
		if ($t1 && $t2){return true ;}else{return false;}
	}
	
	

}
