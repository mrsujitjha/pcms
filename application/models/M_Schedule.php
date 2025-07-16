<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_schedule extends CI_Model {

	public function get_schedule($a)

	{ 
		$b =$this->session->userdata('itemname');
		if($a==""){$tm_project=$this->db->get('tabschedule')->result();}else
		{$tm_project=$this->db->Like('itemcode',$a,'after')
			->Like('itemsize',$b)
			->get('tabschedule')->result();}
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
		return $this->db->WHERE('unit', "No")
		->get('tabitemcode')
		->result();	
	}

	public function save_schedule()
	{$a= $this->session->userdata('userid');
		$cdate = date('ymd');
		$object=array(
				'itemcode'=>$this->input->post('sechid'),
				'chainage'=>$this->input->post('ch'),
				'descrip'=>$this->input->post('descrip'),
				'itemsize'=>$this->input->post('item'),
				'rem'=>$this->input->post('rem'),
				'aadetails'=>$a.'-'.$cdate.'-0',
				'wdone'=>'0',
				'progress'=>'NOT STARTED'
			);
		return $this->db->insert('tabschedule', $object);
	}
	
	public function detail($a)
	{ $b = explode(':', $a);
		$this->session->set_userdata('mypage',$b[1]);
		$this->db->select('tabschedule.*');
		$this->db->from('tabschedule');
		$this->db->where('tabschedule.itemcode', $b[0]);
		$query = $this->db->get()->row();
		return $query;
	}

	public function maxscheduleid($a)
	{		
			
	return $this->db->like('itemcode',$a)
				->from('tabschedule')
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

	public function edit_schedule()
	{$a= $this->session->userdata('userid');
		$cdate = date('ymd');
		$object=array(			
			'chainage'=>$this->input->post('ch2'),
			'descrip'=>$this->input->post('descrip2'),
			'itemsize'=>$this->input->post('item2'),
			'rem'=>$this->input->post('rem2'),
			'aadetails'=>$this->input->post('aadetails').':'.$a.'-'.$cdate.'-1',
			'wdone'=>'1',
			'latlng'=>$this->input->post('latlng')
			);
		return $this->db->where('itemcode', $this->input->post('user_code_lama'))->update('tabschedule',$object);
	}
	public function Approve_schedule()
	{$a= $this->session->userdata('userid');
		$cdate =':'.$a.'-'.date('ymd').'-2' ;
		$myquery="UPDATE tabschedule SET aadetails= CONCAT(aadetails, '".$cdate."'),wdone= 2";
		$getqresult = $this->db->query($myquery);
		return $getqresult;
	}
	public function edit_progress()
	{ 	$a=$this->input->post('yrm');
		$b = explode(':', $a);
       if (count($b) >1){
		$this->db->where('schid', $this->input->post('progcode'))
		->where('edate',$b[0])
		->delete('tabplantation');
		$object=array(					
			'schid'=>$this->input->post('progcode'),
			'edate'=>$b[0],	
			'planted'=>$this->input->post('pper')*$b[1]/100,
			'survival'=>$this->input->post('sur')
			);
			$this->db->insert('tabplantation', $object);
	   } 
		$object=array(					
			'progress'=>$this->input->post('prog'),
			'percent'=>$this->input->post('pper'),	
			'yrm'=>$b[0]
			);
		return $this->db->where('itemcode', $this->input->post('progcode'))->update('tabschedule',$object);
	}
	public function hapus_schedule($id='')
	{
		return $this->db->where('itemcode', $id)->delete('tabschedule');
	}
	public function get_schedule_progress_repo(){ 
    
		$r =$this->session->userdata('phyroadid');	
		$b =$this->session->userdata('phyyear')+2023;
        $c =$this->session->userdata('phymonth');	
		if ($c<10) {$a=$b."0".$c;}else{$a=$b.$c;}		
		$this->session->set_userdata('reporttype',"Progress of Structure Reporting Month : ".$b."-".$c );
		$myquery="SELECT A.*,B.c2,B.d2,(COALESCE(A.c1,0)+COALESCE(B.c2,0))as c3,(COALESCE(A.d1,0)+COALESCE(B.d2,0)) as d3,
(A.scope-COALESCE(A.c1,0)-COALESCE(B.c2,0)-COALESCE(A.d1,0)-COALESCE(B.d2,0)) as e3 
FROM 
(SELECT S.itemsize,S.scope,C.comp as c1,I.inprog as d1 FROM (SELECT itemsize, count( itemsize ) as scope FROM `tabschedule` Where itemcode Like'".$r."%' GROUP BY itemsize) as S LEFT JOIN (SELECT itemsize, count( itemsize ) as inprog FROM `tabschedule` Where progress ='IN PROGRESS'and yrm <'".$a."' and itemcode Like'".$r."%' GROUP BY itemsize)as I ON S.itemsize=I.itemsize LEFT JOIN (SELECT itemsize, count( itemsize ) as comp FROM `tabschedule` Where progress ='COMPLETED'and yrm<'".$a."' and itemcode Like'".$r."%' GROUP BY itemsize)as C ON S.itemsize=C.itemsize) as A
RIGHT JOIN 
(SELECT S.itemsize,S.scope,I.inprog as d2,C.comp as c2 FROM (SELECT itemsize, count( itemsize ) as scope FROM `tabschedule` Where itemcode Like'".$r."%' GROUP BY itemsize) as S LEFT JOIN (SELECT itemsize, count( itemsize ) as inprog FROM `tabschedule` Where progress ='IN PROGRESS' and itemcode Like'".$r."%' and yrm='".$a."' GROUP BY itemsize)as I ON S.itemsize=I.itemsize
LEFT JOIN (SELECT itemsize, count( itemsize ) as comp FROM `tabschedule` Where progress ='COMPLETED'and yrm='".$a."' and itemcode Like'".$r."%' GROUP BY itemsize)as C ON S.itemsize=C.itemsize) as B 
ON A.itemsize=B.itemsize";
		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}
	public function get_schedule_progress_item(){ 
        $rname=$this->session->userdata('roadname');
		$r =$this->session->userdata('phyroadid');	
		$item=$this->session->userdata('schitem');	
		$this->session->set_userdata('reporttype',"Progress of Structure" );
		$this->session->set_userdata('subheading',"Road Name:".$rname. " / Selected Item : ". $item ); 
		$myquery="SELECT * FROM `tabschedule` WHERE itemcode LIKE '" .$r."%' and itemsize='".$item."' ORDER BY Chainage";
		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}
	

}
