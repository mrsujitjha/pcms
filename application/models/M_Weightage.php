<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_weightage extends CI_Model {

	public function get_weightlist($a)
	{
		if($a==""){$tm_project=$this->db->get('tabweightage')->result();}else
		{$tm_project=$this->db->WHERE('roadid',$a)
			->get('tabweightage')->result();}
		return $tm_project;
		
	}
	public function get_condition()
	{
		$allcond=$this->db->get('tabpaycon')->result();
		return $allcond;		
	}
	public function get_tcslist($a)
	{
		if($a==""){$tm_project=$this->db->get('tabtcsmgm')->result();}else
		{$tm_project=$this->db->WHERE('roadid',$a)			
			->order_by('itemid','desc')
			->get('tabtcsmgm')
			->result();}
		return $tm_project;

	}
public function Approve_weitage()
	{$a= $this->session->userdata('userid');
		$cdate =':'.$a.'-'.date('ymd').'-2' ;
		$myquery="UPDATE tabweightage SET aadetails= CONCAT(aadetails, '".$cdate."'),wdone=2";
		$getqresult = $this->db->query($myquery);
		return $getqresult;
	}
	public function find_roaditemstage($a)
	{
		//$tm_project=$this->db->Like('id',$a,'after')
			//->get('tabstageitem')->result();
		//return $tm_project;

		$myquery="SELECT B.*,A.stage FROM (SELECT * FROM `tabstageitem` WHERE `id` LIKE '".$a."%') as B  JOIN (SELECT itemid,GROUP_CONCAT(descrip) as stage FROM `tabstage` Group By itemid ) as A ON A.itemid=B.itemid";
		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}
	public function itemoftcs($a)
	{$r =$this->session->userdata('roadid');
		//$myquery="SELECT * FROM `tabitemcode`";
		$b=explode(':',$a);				
		if($b[0]=='0'){
			$myquery="SELECT A.*,tabitemcode.unit,tabitemcode.itemid FROM (SELECT distinct(`itemsize`) as name FROM `tabschedule` WHERE `itemcode` LIKE '".$r."%') as A JOIN tabitemcode ON tabitemcode.name=A.name";
		}
		if($b[0]=='1'){
			$myquery="SELECT A.*,tabitemcode.unit,tabitemcode.itemid FROM (SELECT distinct(`itemname`) as name FROM `tabstageitem` WHERE `id` LIKE '".$r."%') as A JOIN tabitemcode ON tabitemcode.name=A.name";
		}
		if($b[0]=='2'){
			$myquery="SELECT A.rid,GROUP_CONCAT(A.item) as itemid FROM (SELECT distinct(tcsid) as item,substring(roadid,1,3) as rid FROM `tabsection` WHERE roadid LIKE '".$r."%' AND substring(roadid,6,length(roadid)-10)='".$b[1]."') as A GROUP BY A.rid";
		}
	
		$getqresult = $this->db->query($myquery)->result();	
		return $getqresult;
	}
	public function get_item()
	{
		$tm_user=$this->db->get('tabitemcode')->result();
		return $tm_user;
		
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

	public function save_weightage()
	{	$a= $this->session->userdata('userid');
		$cdate = date('ymd');
		$r =$this->session->userdata('roadid');	
		$i=$this->get_maxid();		
		$object=array(		
					'id'=>$i['id']+1,
					'roadid'=>$r,
					'item'=>$this->input->post('item'),
					'descrip'=>$this->input->post('sitem'),
					'mw'=>$this->input->post('mw'),
					'aadetails'=>$a.'-'.$cdate.'-0',
					'wdone'=>'0',
					'subitem'=>$this->input->post('subi')
			);
		return $this->db->insert('tabweightage', $object);
	}
	public function e_weightage()	{	
		$object=array(					
					'item'=>$this->input->post('item2'),
					'descrip'=>$this->input->post('sitem2'),
					'mw'=>$this->input->post('mw2'),
					'aadetails'=>$this->input->post('aadetails').':'.$a.'-'.$cdate.'-1',
					'wdone'=>'1',
					'subitem'=>$this->input->post('subi2')
			);
		return $this->db->where('id', $this->input->post('user_code_lama'))->update('tabweightage',$object);
	}
	public function sub_weightage()
	{	$data = [];
		$r =$this->input->post('tn');
		$b=$this->input->post('P0');
		$d=$this->input->post('C0');	
		for($i=1;$i<$r;$i++){
			$a='P'.$i;
			$b=$b.",".$this->input->post($a);
			$c='C'.$i;
			$d=$d.",".$this->input->post($c);		
		}			
		$object=array('sw'=>$b,'pcon'=>$d);
		$this->db->where('id',$this->input->post('un'))->update('tabweightage',$object);
		$this->db->where('wid',$this->input->post('un'))->delete('tabsubweight');
		$tm_project=$this->db->where('id',$this->input->post('un'))->get('tabweightage')->result_array();		
		foreach ($tm_project as $road) {
			$itemid=explode(",",$road["subitem"]);
			$swv=explode(",",$road["sw"]);
			$selec=explode(",",$road["pcon"]);
			for($i=0;$i<count($itemid);$i++){
				$data[]=array('wid'=>$this->input->post('un'),'itemid'=>$itemid[$i],'wp'=>$swv[$i],'condition'=>$selec[$i]);
			}
		}
		return $this->db->insert_batch('tabsubweight', $data);
	}			
	public function proitem($a)	{ 
		return $this->db->where('itemid',$a)
						->get('tabitemcode')
						->row();
	}
	public function detail($a)
	{	
		$b = explode(':', $a);
		$this->session->set_userdata('mypage',$b[1]);
		return $this->db->where('id',$b[0])
		->get('tabweightage')
		->row();					
	}
	public function get_maxid()
	{
		return $this->db->select_max('id')
					->from('tabweightage')
					->get()
					->row_array();
	}
	
	public function hapus_flow($id='')
	{
		return $this->db->where('id', $id)->delete('tabweightage');
	}

	public function get_physical_progress_weightage(){ 
		$myquery="";
		$r =$this->session->userdata('phyroadid');	
		$b =$this->session->userdata('phyyear')+2023;
        $c =$this->session->userdata('phymonth');	
		if (strlen($c)<2) {$a=$b."0".$c;}else{$a=$b.$c;}		
		$this->session->set_userdata('reporttype',"Physical Progress with Weightage % Reporting Month : ".$b."-".$c );
			$myquery="SELECT B.item,D.name,D.scope,(COALESCE(B.c3,0)-COALESCE(A.c2,0)) as c1,A.c2,B.c3,(COALESCE(D.scope,0)-COALESCE(B.c3,0)) as d3 ,(B.c3/D.scope) 'w%' FROM (SELECT item,sum(qyt) as c2,Substring(phycode,1,length(phycode)-5) as TCS FROM `tabphysical` WHERE yrm=".$a." and phycode like '".$r."%' GROUP BY item,Substring(phycode,1,length(phycode)-5))as A RIGHT JOIN (SELECT item,sum(qyt) as c3, Substring(phycode,1,length(phycode)-5) as TCS FROM `tabphysical` WHERE yrm<=".$a." and phycode like '".$r."%' GROUP BY item,Substring(phycode,1,length(phycode)-5))as B ON A.TCS=B.TCS AND A.item=B.Item JOIN (SELECT *,(SELECT sum(toch-fromch)FROM tabsection WHERE roadid LIKE '".$r."%'  and length(tcsid)-length(replace(tcsid,itemid,''))>0) scope FROM `tabitemcode` ) as D ON D.itemid=B.item GROUP BY D.itemid";
			$getqresult = $this->db->query($myquery)->result();
		//$this->session->set_flashdata('message', $r.'-'.$b.'-'.$c);
		return $getqresult;
	}
	public function get_weightage_old(){ 		
		$r =$this->session->userdata('phyroadid');	
		$myquery="SELECT * FROM `tabweightage` WHERE `roadid`='".$r."'";		
		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}
	public function get_weightage(){ 		
		$r =$this->session->userdata('phyroadid');	
		$myquery="SELECT * FROM `tabweightage` WHERE `roadid`='".$r."'";
		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}
	public function get_schedule_progress_repo(){ 
    
		$r =$this->session->userdata('phyroadid');	
		$b =$this->session->userdata('phyyear')+2023;
        $c =$this->session->userdata('phymonth');	
		if ($c<10) {$a=$b."0".$c;}else{$a=$b.$c;}		
		$this->session->set_userdata('reporttype',"Progress of Structure with Weightage % Reporting Month : ".$b."-".$c );
		$myquery="SELECT M.*,(M.c3/M.scope) 'n%',tabitemcode.itemid FROM (SELECT A.*,B.c2,(COALESCE(A.c1,0)+COALESCE(B.c2,0))as c3 FROM (SELECT S.itemsize,S.scope,C.comp as c1 FROM (SELECT itemsize, count( itemsize ) as scope FROM `tabschedule` Where itemcode Like'".$r."%' GROUP BY itemsize) as S LEFT JOIN (SELECT itemsize, count( itemsize ) as comp FROM `tabschedule` Where progress ='COMPLETED'and yrm<'".$a."' and itemcode Like'".$r."%' GROUP BY itemsize)as C ON S.itemsize=C.itemsize) as A
Left JOIN (SELECT S.itemsize,S.scope,C.comp as c2 FROM (SELECT itemsize, count( itemsize ) as scope FROM `tabschedule` Where itemcode Like'".$r."%' GROUP BY itemsize) as S 
LEFT JOIN (SELECT itemsize, count( itemsize ) as comp FROM `tabschedule` Where progress ='COMPLETED'and yrm='".$a."' and itemcode Like'".$r."%' GROUP BY itemsize)as C ON S.itemsize=C.itemsize) as B 
ON A.itemsize=B.itemsize) as M JOIN tabitemcode ON tabitemcode.name=M.itemsize";
		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}

	public function get_stage_progress_repo(){ 
    
		$r =$this->session->userdata('phyroadid');	
		$b =$this->session->userdata('phyyear')+2023;
        $c =$this->session->userdata('phymonth');	
		if ($c<10) {$a=$b."0".$c;}else{$a=$b.$c;}		
		$this->session->set_userdata('reporttype',"Stage wise Progress of Structure with Weightage %  Month : ".$b."-".$c );
		
		$myquery="SELECT B.itemid,B.itemname , B.chainage,B.span,(B.span+1) 'Foundation',B.stages,B.status,A.stage,(LENGTH(B.status) - LENGTH(REPLACE(B.status, ',', '')))+1 as 's%' FROM (SELECT * FROM `tabstageitem` WHERE `id` LIKE '".$r."%') as B  JOIN (SELECT itemid,GROUP_CONCAT(descrip) as stage FROM `tabstage` Group By itemid ) as A ON A.itemid=B.itemid";
		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}

	

}
