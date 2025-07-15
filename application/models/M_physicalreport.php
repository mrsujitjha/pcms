<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_physicalreport extends CI_Model {

	
	public function get_Road()
	{ 	
		//$tm_Road=$this->db->get('tabroad')->result();
		//return $tm_Road;
		$r=1;
		$r =$this->session->userdata('pkgid');
		$myquery="SELECT tabroad.rid,tabroad.rname,tabproject.pkgsn FROM tabroad JOIN tabproject ON tabproject.pkg=tabroad.pkg where tabproject.pkgsn='".$r."'";
		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}
	public function get_package()
	{	$tm_Road=$this->db->order_by('pkgsn')->get('tabproject')->result();
		return $tm_Road;
	}
	
	public function get_item()
	{
		return $this->db->WHERE('unit', "No")
		->get('tabitemcode')
		->result();	
	}

	
	public function count_Row_schedule(){
		return $this->db->get('tabschedule')->num_rows();
	}
	
	public function get_status_scheduleitem($a)
	{		
		$tm_project=$this->db->Like('itemcode',$a,'after')->get('tabschedule')->result();
		return $tm_project;
	
	}
	public function get_status_sectionwise($a)
	{		
		$b=explode (":", $a);  		
		$querystring="SELECT M.*,tabitemcode.name  FROM (SELECT item,fromch,toch,yrm,qyt,phycode FROM `tabphysical`) as M JOIN tabitemcode ON tabitemcode.itemid=M.item WHERE M.phycode LIKE '".$b[0]."%' AND M.yrm='".$b[1]."' ORDER BY M.fromch";
		$query = $this->db->query($querystring)
		->result();
		return $query;
	
	}
	public function get_selected_secction_itementry($a)
	{		
		$b=explode (":", $a);  		
		$querystring="SELECT * FROM `tabphysical` WHERE `phycode` like '".$b[1]."%' and item =".$b[0]." order by fromch";
		$query = $this->db->query($querystring)
		->result();
		return $query;
	
	}
	public function get_chainage_detail($a)
	{$data=array();
		$b=explode (":", $a); 		
		if($this->session->userdata('selsection')>0){			
			$h=$this->session->userdata('selsection')+1;
			$this->session->set_userdata('physec','H'.$h);			
		}else{$this->session->set_userdata('physec','H1');	}
		$c=$b[0].$this->session->userdata('physec');//'R01H1'
		$seclength =$this->get_Lastchainage($c);
		//echo($this->session->userdata('selsection'));
		if ($b[3]=='R'){
		$querystring="SELECT * FROM `tabphysical` WHERE phycode LIKE '".$c."%' AND item='".$b[2]."' AND substring(phycode,Length(phycode)-3,1)='R'";
		}else{$querystring="SELECT * FROM `tabphysical` WHERE phycode LIKE '".$c."%' AND item='".$b[2]."' AND substring(phycode,Length(phycode)-3,1)!='R'";
		}
		if($this->session->userdata('stripplan')=='All'){$querystring=$querystring." ORDER BY fromch";}else{
		$querystring=$querystring." AND yrm='".$b[1]."' ORDER BY fromch";}		
	
		$query = $this->db->query($querystring);	
		$lastch=0;
		//echo($a);
		if ( $query->num_rows()>0) {
			foreach ($query->result_array() as $row){
				//$j=$j+1;
				$fch= $row["fromch"]*1000;
				$tch= $row["toch"]*1000;
				$sch=($fch-fmod($fch, 50))/1000;//rounding to nearest 50 interval
				$ech=($tch-fmod($tch, 50))/1000;		
				$chl=($ech-$sch)*20;		
				$mstep=round($chl);	
				$dfv=$sch*1000-$lastch;		    
				if ($dfv>0){	
					//echo(" ".$lastch ."  " .$sch*1000);
					$chl2=($sch*1000-$lastch)/50;
					$mstep2=round($chl2);
					$n=0;
					if ($lastch > 0){$n=1;}
					for($i=$n;$i<=$mstep2-1;$i++){	
						$nch2=$lastch+$i*50;					
						$rowv=array('ch'=>$nch2,'status'=>'2');
						$data[]=$rowv;
						}
						$lastch=0;
				}	
				$n=0;
				if ($lastch>0){$n=1;}
				for($i=$n;$i<=$mstep;$i++){	
					$nch=$sch*1000+$i*50;
					$rowv=array('ch'=>$nch,'status'=> '1');
					$data[]=$rowv;
					$lastch=$nch;
					
				}
			}
			//if ($b[2]=="106"){echo($c.':'.$b[3]. " " . $lastch."-".count($data). " ");}

			$endch=$seclength*1000;			
			if ($lastch !== $endch){	
				$chl3=($endch-$lastch)/50;
				$mstep3=round($chl3);
				for($i=1;$i<=$mstep3;$i++){	
					$nch3=$lastch+$i*50;					
					$rowv=array('ch'=>$nch3,'status'=> '2');
					$data[]=$rowv;
					}
			}	
			//if ($b[2]=="106"){echo($endch .'::'.$lastch."-".count($data). " ");}
		}else{
			$chl=$seclength*20;
			$mstep=(int)$chl;
			for($i=0;$i<=$mstep-1;$i++){	
				$nch=$i*50;				
				$rowv=array('ch'=>$nch,'status'=> '2');
				$data[]=$rowv;}
		}
		
	return $data;
	}
	public function save_reportsearch(){
		$rtext =$this->input->post('filtertext');		
		if (strlen($rtext)>0){ 
		$a = explode(':', $rtext);				
		$this->session->set_userdata('phyroadid',$a[0]);
		$this->session->set_userdata('phyyear',$a[1]);
		$this->session->set_userdata('phymonth',$a[2]);
		$this->session->set_userdata('selrepo',$a[3]);
		$this->session->set_userdata('roadname',$a[4]);
		$this->session->set_userdata('pkgname',$a[6]);
		$this->session->set_userdata('schitem',$a[7]);
		$querystring = "SELECT rlength as 'rl' FROM `tabroad` WHERE rid='".$a[0]."'";
		$maxlength = $this->db->query($querystring);
		foreach ($maxlength->result() as $row){$this->session->set_userdata('roadlength',$row->rl);} 
		  

	}
	}
	public function get_road_name($a){	
		$query = $this->db->query("select rname,rlength,pkg from tabroad WHERE rid='".$a."'");
		foreach ($query->result_array() as $row){
				$rname= $row["rname"];
				$rl= $row["rlength"];
				$pkg= $row["pkg"];
		}	
		$this->session->set_userdata('roadname',$rname);
		$this->session->set_userdata('roadlength',$rl);
		$this->session->set_userdata('pkgid',$pkg);	
		return $rname. ":length=".$rl.'Km' ;
	}

	public function get_Lastchainage($a){	
		$querystring = "SELECT Max(`toch`) as l FROM `tabsection` WHERE roadid LIke '".$a."%'";
		$maxlength = $this->db->query($querystring);
		foreach ($maxlength->result() as $row){
			$lch=$row->l;
			$this->session->set_userdata('seclastch',$lch);	
			return $lch ;} 

	}
	

}
