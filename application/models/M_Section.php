<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Section extends CI_Model {
	
	public function get_section($a)
	{
		$tm_project=$this->db->Like('roadid',$a,'after')->get('tabsection')->result();
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
		return $this->db->WHERE('unit', "Km")
		->get('tabitemcode')
		->result();	
	}
	public function itemdetail()
	{
		$tm_user=$this->db->get('tabitemcode')->result();
		return $tm_user;
	}
	public function get_tcslist($a)
	{
		if($a==""){$tm_project=$this->db->get('tabtcsmgm')->result();}else
		{$tm_project=$this->db->Like('roadid',$a,'after')			
			->order_by('itemid','desc')
			->get('tabtcsmgm')
			->result();}
		return $tm_project;

	}

	public function save_section()
	{ $u= $this->session->userdata('userid');
		$cdate = date('ymd');
		$a =$this->input->post('lane');
	  $secid=$this->input->post('secid'); 
			
	  if($a=='C'){
		$sid1=str_replace("LR","C", $secid);
		$object=array('roadid'=>$sid1,'fromch'=>$this->input->post('fromch2'),'toch'=>$this->input->post('toch2'),'tcsid'=>$this->input->post('selitem2'), 'aadetails'=>$u.'-'.$cdate.'-0','wdone'=>'0');
		return $this->db->insert('tabsection', $object);}else{
		$object = [];
		$sid1=str_replace("LR","L", $secid);
		$sid2=str_replace("LR","R", $secid);		
		$object[]=array('roadid'=>$sid1,'fromch'=>$this->input->post('fromch2'),'toch'=>$this->input->post('toch2'),'tcsid'=>$this->input->post('selitem2'), 'aadetails'=>$u.'-'.$cdate.'-0','wdone'=>'0');
		$object[]=array('roadid'=>$sid2,'fromch'=>$this->input->post('fromch2'),'toch'=>$this->input->post('toch2'),'tcsid'=>$this->input->post('selitem2'), 'aadetails'=>$u.'-'.$cdate.'-0','wdone'=>'0');
		return $this->db->insert_batch('tabsection',$object);
		}
	}
	public function detail($a)
	{$b=	explode(":",$a);
		$this->session->set_userdata('mypage',$b[1]);
		
		return $this->db->where('roadid', $b[0])
						->get('tabsection')
						->row();
	}


	public function maxsectionid($a)
	{		
			
	return $this->db->like('roadid',$a)
				->from('tabsection')
				->get()
				->num_rows();
	}

	public function save_saveroadno(){
		$rtext =$this->input->post('proid');
		$a = explode(':', $rtext);
		$this->session->set_userdata('roadid',$a[0]);
		return true;
		
	}
	public function save_physicalsearch(){
		$rtext =$this->input->post('filtertext');
		$a = explode(':', $rtext);		
		$this->session->set_userdata('phyroadid',$a[0]);
		$this->session->set_userdata('phyyear',$a[1]);
		$this->session->set_userdata('phymonth',$a[2]);	
		return true;		
	}
	public function save_physical($a)
	{	
	$var1=explode("::",$this->input->post('selyrmonth'));	
	$mcode=	explode(",",$var1[2]);
	$yrm=explode(":",$var1[0]);
	//$newval=$this->get_maxroadid($yrm[0],$yrm[1]);
   // foreach ($myval as $myno){$newval= $myno->recno;}

	$object = [];
	$i = count($mcode)-1;
		for ($x = 0; $x <=$i; $x++) {
			$qyt=$this->input->post($mcode[$x]);
			$fch=$this->input->post("fch".$mcode[$x]);
			$tch=$this->input->post("tch".$mcode[$x]);
			if ($qyt>0) {$object[] = array('item'=> $mcode[$x],'qyt'=>$qyt,'fromch'=>$fch,'toch'=>$tch,'phycode'=>$yrm[0],'yrm'=>$yrm[1],'recno'=>$a);}		
	    	//if ($qyt>0) {{$object[] = array('item'=> $mcode[$x],'qyt'=>$qyt,'fromch'=>$fch,'toch'=>$tch,'phycode'=>$var1[0]);}	}		

		}	
		if (count($object) > 0) {
			return $this->db->insert_batch('tabphysical',$object);}else{  return false;}
		
	}
	public function get_maxroadid($a,$b)
	{ return $this->db->Where('phycode',$a)
		->Where('yrm',$b)	
		->select_max('recno')
		->from('tabphysical')
		->get()
		->row_array();
	}
	public function edit_section()
	{$a= $this->session->userdata('userid');
		$cdate = date('ymd');
		$object=array(			
			'fromch'=>$this->input->post('fromch'),
			'toch'=>$this->input->post('toch'),
			'aadetails'=>$this->input->post('aadetails').':'.$a.'-'.$cdate.'-1',
			'wdone'=>'1',
			'tcsid'=>$this->input->post('selitem')
			);
		return $this->db->where('roadid', $this->input->post('user_code_lama'))->update('tabsection',$object);
	}
	public function Approve_section()
	{$a= $this->session->userdata('userid');
		$cdate =':'.$a.'-'.date('ymd').'-2' ;
		$myquery="UPDATE tabsection SET aadetails= CONCAT(aadetails, '".$cdate."'),wdone= 2";
		$getqresult = $this->db->query($myquery);
		return $getqresult;
	}
	public function hapus_section($id='')
	{$a=$this->db->where('roadid', $id)->delete('tabsection');
		if($a){$this->db->where('phycode', $id)->delete('tabphysical');}
		return $a; 
	}
	public function load_physicaldata($a)
	{$data=[];
		$b=	explode(":",$a);
		$this->session->set_userdata('mypage',$b[2]);
		$data[]=$this->db->Like('phycode',$b[0])	
		->Like('yrm',$b[1])	
		->order_by('recno')		
		->get('tabphysical')->result();

		$data[]=$this->db->Like('phycode',$b[0])			
		->order_by('recno')		
		->get('tabphysical')->result();

		return $data;
	}
	
	public function delete_record($a)
	{
		$var1=explode("::",$this->input->post('selyrmonth'));	
		$yrm=explode(":",$var1[0]);
		$var1=explode("::",$this->input->post('selyrmonth'));		
		return $this->db->where('phycode', $yrm[0])
		->where('yrm', $yrm[1])
		->where('recno',$a)
		->delete('tabphysical');
	}

	public function get_physical_progress_tcs(){ 
		$myquery="";
		$r =$this->session->userdata('phyroadid');	
		$b =$this->session->userdata('phyyear')+2023;
        $c =$this->session->userdata('phymonth');	
		if ($c<10) {$a=$b."0".$c;}else{$a=$b.$c;}	
		
		$this->session->set_userdata('reporttype',"Physical Progress TCS-wise. Reporting Month : ".$b."-".$c );
		$myquery="SELECT F.*,(F.scope-F.c3) as d3 FROM (SELECT D.name,B.TCS,(SELECT sum(toch-fromch) FROM tabsection WHERE Substring(roadid,1,length(roadid)-5) =B.TCS and length(tcsid)-length(replace(tcsid,B.item,''))>0 AND substring(roadid,Length(roadid)-3,1)!='R') scope,(B.c3-COALESCE(A.c2,0))as c1,A.c2,B.c3,B.item  FROM (SELECT item,sum(qyt) as c2, Substring(phycode,1,length(phycode)-5) as TCS FROM `tabphysical` WHERE yrm=".$a."  and phycode like'".$r."%' AND substring(phycode,Length(phycode)-3,1)!='R' GROUP BY TCS,item)as A RIGHT JOIN (SELECT item,sum(qyt) as c3, Substring(phycode,1,length(phycode)-5) as TCS,phycode FROM `tabphysical` WHERE yrm<=".$a."  and phycode like '".$r."%' AND substring(phycode,Length(phycode)-3,1)!='R' GROUP BY TCS,item)as B ON A.TCS=B.TCS AND A.item=B.Item JOIN (SELECT * FROM `tabitemcode`) as D ON D.itemid=B.item) AS F ORDER BY F.TCS";
	
		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}
	public function get_physical_progress_summary(){ 
		$myquery="";
		$r =$this->session->userdata('phyroadid');	
		$b =$this->session->userdata('phyyear')+2023;
        $c =$this->session->userdata('phymonth');	
		if ($c<10) {$a=$b."0".$c;}else{$a=$b.$c;}	
		
		$this->session->set_userdata('reporttype',"Physical Progress Group-wise. Reporting Month : ".$b."-".$c );
			$myquery="SELECT F.*,(F.scope-F.c3) as d3 FROM (SELECT D.name,(SELECT sum(toch-fromch) FROM tabsection WHERE length(tcsid)-length(replace(tcsid,B.item,''))>0 AND substring(roadid,Length(roadid)-3,1)!='R' and substring(roadid,1,3)='".$r."') scope,(B.c3-COALESCE(A.c2,0))as c1,A.c2,B.c3,B.item  FROM (SELECT item,sum(qyt) as c2 FROM `tabphysical` WHERE yrm=".$a." and phycode like'".$r."%' AND substring(phycode,Length(phycode)-3,1)!='R' GROUP BY item)as A RIGHT JOIN (SELECT item,sum(qyt) as c3,phycode FROM `tabphysical` WHERE yrm<=".$a." and phycode like '".$r."%' AND substring(phycode,Length(phycode)-3,1)!='R' GROUP BY item)as B ON A.item=B.Item JOIN (SELECT * FROM `tabitemcode`) as D ON D.itemid=B.item) AS F";
		
		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}
	public function get_physical_progress_groupwise(){ 
		$myquery="";
		$r =$this->session->userdata('phyroadid');	
		$b =$this->session->userdata('phyyear')+2023;
        $c =$this->session->userdata('phymonth');	
		if ($c<10) {$a=$b."0".$c;}else{$a=$b.$c;}	
		
		$this->session->set_userdata('reporttype',"Physical Progress Group-wise. Reporting Month : ".$b."-".$c );
			$myquery="SELECT sum(F.c1)c1,sum(F.c2)c2,sum(F.c3)c3,F.name,sum(F.scope-F.c3) as d3,N.gtext,sum(F.scope)scope,F.TCS FROM (SELECT D.name,B.TCS,(SELECT sum(toch-fromch) FROM tabsection WHERE Substring(roadid,1,length(roadid)-5) =B.TCS and length(tcsid)-length(replace(tcsid,B.item,''))>0 AND substring(roadid,Length(roadid)-3,1)!='R') scope,(B.c3-COALESCE(A.c2,0))as c1,A.c2,B.c3,B.item  FROM (SELECT item,sum(qyt) as c2, Substring(phycode,1,length(phycode)-5) as TCS FROM `tabphysical` WHERE yrm=".$a."  and phycode like'".$r."%' AND substring(phycode,Length(phycode)-3,1)!='R' GROUP BY TCS,item)as A RIGHT JOIN (SELECT item,sum(qyt) as c3, Substring(phycode,1,length(phycode)-5) as TCS,phycode FROM `tabphysical` WHERE yrm<=".$a."   and phycode like '".$r."%' AND substring(phycode,Length(phycode)-3,1)!='R' GROUP BY TCS,item)as B ON A.TCS=B.TCS AND A.item=B.Item JOIN (SELECT * FROM `tabitemcode`) as D ON D.itemid=B.item) AS F Left JOIN (Select name,gtext FROM tabtcsmgm WHERE roadid like '".$r."%')AS N  ON Substring(F.TCS,6)=N.name  GROUP BY N.gtext,F.item ORDER BY  N.gtext";
		
		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}


	}
