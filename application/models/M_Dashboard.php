<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Dashboard extends CI_Model {

	public function get_roadlength_sl(){
		return $this->db->select('slength')
					    ->get('tabroad')
					    ->result();
	}

	public function get_roadlength_al(){
		return $this->db->select('rid')
					    ->get('tabroad')
					    ->result();
	}
	public function get_trench1_progress(){
		$mquery="SELECT A.itemid,A.name,B.L,A.Q FROM (SELECT tabitemcode.itemid,tabitemcode.name,Sum(tabphysical.qyt) as Q ,tabproject.tranche FROM tabphysical JOIN tabroad ON tabroad.rid=SUBSTRING(tabphysical.phycode,1,3) JOIN tabproject ON tabroad.pkg=tabproject.pkg JOIN tabitemcode ON tabitemcode.itemid =tabphysical.item WHERE tabproject.tranche='Tranche-1' AND tabphysical.item < 109 GROUP BY tabphysical.item) as A JOIN (SELECT tabproject.tranche,Sum(tabroad.rlength) as L FROM `tabproject` JOIN tabroad ON tabroad.pkg=tabproject.pkg GROUP BY tabproject.tranche) as B ON A.tranche=B.tranche UNION SELECT C.itemcode ,C.itemsize,count(itemsize)as 'N', SUM(IF(C.progress='COMPLETED', 1, 0))as 'M' FROM (SELECT A.*,B.tranche FROM (SELECT SUBSTRING(itemcode,1,3) as rid,itemsize,progress,itemcode FROM `tabschedule`) as A JOIN (SELECT tabproject.tranche,tabroad.rid FROM `tabproject` JOIN tabroad ON tabroad.pkg=tabproject.pkg WHERE tabproject.tranche='Tranche-1' ) as B ON A.rid=B.rid) as C GROUP BY itemsize";
	$tm_project = $this->db->query($mquery)->result();
	return $tm_project;

	}
	public function get_latestentry(){
		$mquery="SELECT rid,rname,F1.t1,F2.t2,F3.t3  FROM tabroad Left JOIN (SELECT Substring(itemcode,1,3)R,Max(yrm)t1 FROM tabschedule  GROUP BY Substring(itemcode,1,3))F1 ON tabroad.rid = F1.r  LEFT JOIN (SELECT Substring(rid,1,3)R,Max(`yrm`)t2 FROM `tabstgp`  GROUP BY Substring(rid,1,3))F2 ON tabroad.rid = F2.r LEFT JOIN (SELECT Substring(`phycode`,1,3)R,Max(`yrm`)t3 FROM `tabphysical`  GROUP BY Substring(`phycode`,1,3))F3  ON tabroad.rid = F3.r ";
	$tm_project = $this->db->query($mquery)->result();
	return $tm_project;

	}
	public function prepare_message(){
	$mquery="SELECT * FROM (SELECT * FROM (SELECT T1.pkgsn,F.pkg,T1.milestone,T1.per,T1.tdate,T1.adate,Round((F.a/F.b*100),2)c FROM (Select* FROM(SELECT * FROM tabmilestone)A WHERE A.eot=(Select count(`milestone`)/4-1 FROM tabmilestone WHERE pkgsn=A.pkgsn))as T1 JOIN (SELECT Sum(coalesce(tabroad.pp*tabroad.rcost/100,0))a,sum(tabroad.rcost)b,tabproject.pkgsn,tabroad.pkg FROM tabroad JOIN tabproject ON tabproject.pkg=tabroad.pkg GROUP BY tabproject.pkgsn) F ON F.pkgsn=T1.pkgsn ORDER BY T1.pkgsn,T1.milestone) T2 where ((T2.per>T2.c AND Length(T2.adate)=10) OR (Length(T2.adate)!=10))) as T3";
	$tm_project = $this->db->query($mquery)->result();
	return $tm_project;
	}
	public function get_pkglist()
	{	$data="";
		$rlist=$this->session->userdata('rlist');
		$tm_project=$this->db->get('tabroad')->result_array();
		if (strlen($rlist) >0){
			$rid=explode(',', $rlist);
			foreach ($rid as $r) {
				foreach ($tm_project as $road) {
					if	($road["rid"]==$r){
						$data= $data .":".$road["pkg"];
					break;
					}
				}
			}	
	}	
	$this->session->set_userdata('pkglist',$data);	
	}
public function get_trench2_progress(){
	$mquery="SELECT A.itemid,A.name,B.L,A.Q FROM (SELECT tabitemcode.itemid,tabitemcode.name,Sum(tabphysical.qyt) as Q ,tabproject.tranche FROM tabphysical JOIN tabroad ON tabroad.rid=SUBSTRING(tabphysical.phycode,1,3) JOIN tabproject ON tabroad.pkg=tabproject.pkg JOIN tabitemcode ON tabitemcode.itemid =tabphysical.item WHERE tabproject.tranche='Tranche-2'AND tabphysical.item < 109 GROUP BY tabphysical.item) as A JOIN (SELECT tabproject.tranche,Sum(tabroad.rlength) as L FROM `tabproject` JOIN tabroad ON tabroad.pkg=tabproject.pkg GROUP BY tabproject.tranche) as B ON A.tranche=B.tranche
UNION SELECT C.itemcode ,C.itemsize,count(itemsize)as 'N', SUM(IF(C.progress='COMPLETED', 1, 0))as 'M' FROM (SELECT A.*,B.tranche FROM (SELECT SUBSTRING(itemcode,1,3) as rid,itemsize,progress,itemcode FROM `tabschedule`) as A JOIN (SELECT tabproject.tranche,tabroad.rid FROM `tabproject` JOIN tabroad ON tabroad.pkg=tabproject.pkg WHERE tabproject.tranche='Tranche-2' ) as B ON A.rid=B.rid) as C GROUP BY itemsize";
$tm_project = $this->db->query($mquery)->result();
return $tm_project;

}
	
	public function get_road_progress_to_view()	{	
		$a="R01";
		if($this->session->has_userdata('phyroadid')){$a =$this->session->userdata('phyroadid');}
		$tm_project = $this->db->query("SELECT F.name,F.unit,if(length(F.g)=3,round(F.s,2),(SELECT count(tabstageitem.id)FROM tabstageitem WHERE tabstageitem.id LIKE '".$a."%' and substring(id,6,3)=F.a GROUP BY substring(id,6,3)))scope,Round(if(length(F.g)=3,F.prog,(SELECT sum(if((length(status)-length(REPLACE(status,',','')))*10-length(status)+9=0,1,0)) as c FROM tabstageitem WHERE tabstageitem.id LIKE '".$a."%' and substring(id,6,3)=F.a)),2)prog,F.Per FROM (SELECT tabitemcode.name,tabitemcode.unit,sum(M.T)s,sum(M.qyt)prog,sum(Round((M.qyt/M.T*M.wp*M.mw/100),3)) as Per,M.a,M.g FROM (SELECT Sum(C.T)T,Sum(C.qyt)qyt,D.wp,D.mw,substring(C.itemid,1,3) as a,if(Length(C.itemid)>5,substring(C.itemid,1,3),C.itemid)g FROM (SELECT A.pid,A.rid,tabitemcode.itemid,A.qyt,A.rlength as T FROM (SELECT itemcode as pid,Substring(itemcode,1,3) as rid,itemsize,if(rem='%',descrip,count(itemsize)) as rlength,if(rem='%',Round(percent*descrip/100,0),Sum(if(progress='COMPLETED',1,0))) as qyt FROM tabschedule GROUP BY  Substring(itemcode,1,3),itemsize)As A JOIN tabitemcode ON tabitemcode.name=A.itemsize
		UNION
		SELECT rid as pid ,substring(rid,1,3) as rid,stageid,Sum(if(status='COMPLETED',1,0)) qyt,Count(stageid) T FROM tabstgp GROUP BY substring(rid,1,5),stageid 
		UNION                                   
		SELECT B.pid,B.rid,B.itemid,B.qyt,(SELECT sum(toch-fromch) FROM tabsection WHERE substring(roadid,1,length(roadid)-5)=substring(B.pid,1,length(B.pid)-5) AND length(tcsid)-length(replace(tcsid,B.item,''))>0 AND substring(roadid,Length(roadid)-3,1)!='R') as T FROM (SELECT phycode as pid,substring(phycode,1,3)as rid,concat(item,substring(phycode,6,length(phycode)-10))as itemid,sum(qyt) as qyt,item FROM tabphysical WHERE substring(phycode,Length(phycode)-3,1)!='R' GROUP BY rid,substring(phycode,1,length(phycode)-5),itemid) as B JOIN  tabroad ON tabroad.rid=B.rid) as C LEFT JOIN
		(SELECT tabsubweight.*,tabweightage.mw,tabweightage.roadid FROM `tabsubweight` JOIN tabweightage ON tabweightage.id=tabsubweight.wid) as D ON D.roadid=C.rid  AND D.itemid=C.itemid WHERE  D.roadid='".$a."'GROUP BY D.mw,D.wp,a) as M  JOIN tabitemcode ON tabitemcode.itemid=M.a GROUP BY M.a) as F ")->result();
		return $tm_project;
	}
	public function get_progress_Dashboardview(){	
		$tm_project = $this->db->query("SELECT E.* FROM (SELECT B.item as id,B.name,B.p,(SELECT sum(toch-fromch) FROM tabsection WHERE length(tcsid)-length(replace(tcsid,B.item,''))>0 AND substring(roadid,Length(roadid)-3,1)!='R') as s,B.unit FROM (SELECT tabitemcode.unit,tabitemcode.name,tabphysical.item,sum(tabphysical.qyt) as p FROM tabphysical JOIN tabitemcode ON tabitemcode.itemid=tabphysical.item WHERE tabitemcode.dash='YES' and substring(tabphysical.phycode,Length(tabphysical.phycode)-3,1)!='R'  GROUP BY tabphysical.item) as B 
UNION
SELECT A.* FROM (SELECT tabitemcode.itemid as id,itemsize as 'name',if(rem='%',Round(percent*descrip/100,0),Sum(if(progress='COMPLETED',1,0))) as p,if(rem='%',descrip,count(itemsize)) as s ,tabitemcode.unit FROM tabschedule JOIN tabitemcode ON tabitemcode.name=tabschedule.itemsize WHERE tabitemcode.dash='YES'and tabitemcode.unit='NO' GROUP BY  itemsize) as A
UNION 
SELECT C.id,C.name,sum(C.p) as p,Count(C.id) as s,tabitemcode.unit FROM (SELECT itemid as id,itemname as 'name', if((length(stages)-length(replace(stages,',','')))+1 -(length(status)-length(replace(status,'COMPLETED','')))/9=0,1,0) as p FROM tabstageitem) as C JOIN tabitemcode ON tabitemcode.itemid=C.id WHERE tabitemcode.dash='YES' GROUP BY C.id) as E ORDER BY E.id")->result();
		return $tm_project;
	}
	public function road_Payment()	{	
		$a =$this->session->userdata('pkgid');	
		//	$tm_project = $this->db->query("SELECT q.*,tabroad.rname FROM (SELECT *,substring(fincode,Locate('-',fincode)+1,3) as a FROM `tabfinance` WHERE `pkgid`='".$a."' and `toid`='Paid')as q JOIN tabroad ON tabroad.rid=q.a")->result();
		$tm_project = $this->db->query("SELECT q.*,tabroad.rname FROM (SELECT *,substring(fincode,Locate('-',fincode)+1,3) as a FROM `tabfinance` WHERE `pkgid`='".$a."' and `toid`='Paid')as q JOIN tabroad ON tabroad.rid=q.a")->result();
	
		return $tm_project;
	}
	public function get_road_progress()	{	
		$tm_project = $this->db->query("SELECT tabroad.rid,tabroad.rname,tabroad.pkg,tabroad.slength,tabroad.alength,tabroad.rlength,tabroad.scost,tabroad.acost,tabroad.sc,tabroad.rcost,Round((tabroad.pp),2) as pp,tabroad.fp,tabroad.pcerti,tabroad.fcerti,A.cl FROM tabroad LEFT JOIN (SELECT sum(qyt) as cl,substring(`phycode`,1,3) as rid FROM `tabphysical` where (item=106 or item=107)AND substring(phycode,Length(phycode)-3,1)!='R' GROUP BY substring(`phycode`,1,3))as A ON A.rid=tabroad.rid ")->result();
		return $tm_project;
	}
	public function get_package_progress()	{	
		$tm_project = $this->db->query("SELECT Q.* FROM(SELECT tabproject.pkgsn,tabproject.tranche,count(F.pkg) tn, F.rid,F.rname,F.pkg,sum(F.slength)slength,sum(F.alength)alength,Sum(F.rlength)rlength,Sum(F.scost)scost,Sum(F.acost)acost,F.sc,sum(F.rcost)rcost,Round(sum(cc)/sum(F.rcost),2) pp,round(sum(F.fc)/sum(F.rcost),2)fp,F.pcerti,F.fcerti,Sum(F.cl)cl,Sum(F.cc)cc,Sum(F.fc)fc FROM (SELECT tabroad.rid,tabroad.rname,tabroad.pkg,tabroad.slength,tabroad.alength,tabroad.rlength,tabroad.scost,tabroad.acost,tabroad.sc,tabroad.rcost,tabroad.pcerti,tabroad.fcerti,A.cl,Round(tabroad.pp*tabroad.rcost,2) as cc,Round(tabroad.fp*tabroad.rcost,2) as fc FROM tabroad LEFT JOIN (SELECT sum(qyt) as cl,substring(`phycode`,1,3) as rid FROM `tabphysical` where (item=106 or item=107)AND substring(phycode,Length(phycode)-3,1)!='R' GROUP BY substring(`phycode`,1,3))as A ON A.rid=tabroad.rid)F JOIN tabproject ON tabproject.pkg=F.pkg  GROUP BY F.pkg ) as Q")->result();
		return $tm_project;
	}

	public function get_overall_progress_old_withoutmilestone(){
		$mquery="Select Z.*,X.CP FROM (SELECT A.tranche,Count(A.pkg) as rn,Count(DISTINCT A.pkg) as pn,sum(A.rcost) acost,sum(A.rlength) T,Sum(A.cl)L,Round(Sum(A.pp)/Sum(A.rcost),2)P ,Sum(A.rcost)C ,Round(Sum(A.fp)/Sum(A.rcost),2)F,sum(A.CR) as CR FROM (SELECT tabproject.tranche,tabroad.rlength,tabroad.rcost,round((tabroad.rcost*tabroad.pp),2) as pp,round(tabroad.rcost*tabroad.fp,2) fp,A.cl,if(tabroad.pp=100,1,0) as CR,tabroad.pkg FROM tabroad LEFT JOIN (SELECT sum(qyt) as cl,substring(`phycode`,1,3) as rid FROM `tabphysical` where (item=106 or item=107)AND substring(phycode,Length(phycode)-3,1)!='R' GROUP BY substring(`phycode`,1,3))as A ON A.rid=tabroad.rid JOIN tabproject ON tabproject.pkg=tabroad.pkg) as A GROUP BY A.tranche) as Z JOIN (SELECT sum(N.c)CP,N.tranche FROM (SELECT if((sum(if(tabroad.pp=100,1,0))-count(tabroad.pkg))=0,1,0) as c,tabproject.tranche FROM tabroad JOIN tabproject ON tabproject.pkg=tabroad.pkg  GROUP BY tabroad.pkg) as N GROUP BY N.tranche) AS X ON X.tranche=Z.tranche";
	$tm_project = $this->db->query($mquery)->result();
	return $tm_project;
	
	}
	public function get_overall_progress(){
		$y=date("Y");
		$m=date("m");
		$ym=$y*100+$m;
		$mquery="SELECT T5.*,T4.yc FROM (Select Z.*,X.CP FROM (SELECT A.tranche,Count(A.pkg) as rn,Count(DISTINCT A.pkg) as pn,sum(A.rcost) acost,sum(A.rlength) T,Sum(A.cl)L,Round(Sum(A.pp)/Sum(A.rcost),2)P ,Sum(A.rcost)C ,Round(Sum(A.fp)/Sum(A.rcost),2)F,sum(A.CR) as CR FROM (SELECT tabproject.tranche,tabroad.rlength,tabroad.rcost,round((tabroad.rcost*tabroad.pp),2) as pp,round(tabroad.rcost*tabroad.fp,2) fp,A.cl,if(length(tabroad.pcerti)>0,1,0) as CR,tabroad.pkg FROM tabroad LEFT JOIN (SELECT sum(qyt) as cl,substring(`phycode`,1,3) as rid FROM `tabphysical` where (item=106 or item=107)AND substring(phycode,Length(phycode)-3,1)!='R' GROUP BY substring(`phycode`,1,3))as A ON A.rid=tabroad.rid JOIN tabproject ON tabproject.pkg=tabroad.pkg) as A GROUP BY A.tranche) as Z JOIN (SELECT sum(N.c)CP,N.tranche FROM (SELECT if((sum(if(length(tabroad.pcerti)>0,1,0))-count(tabroad.pkg))=0,1,0) as c,tabproject.tranche FROM tabroad JOIN tabproject ON tabproject.pkg=tabroad.pkg  GROUP BY tabroad.pkg) as N GROUP BY N.tranche) AS X ON X.tranche=Z.tranche) T5 JOIN 
(SELECT T3.tranche,Round((sum(if(T3.c=100,T3.acost,Round((T3.ymd*(T3.e-T3.c)/T3.g+T3.c)*T3.acost/100,2)))/sum(T3.acost))*100,2) as yc FROM (SELECT*,((".$y."-substring(T2.h,1,4)) *12+ ".$m."-substring(T2.h,5,2))*30 as ymd FROM (SELECT *,CASE When b=4 then 100 when b=0 then 0 else substring(p,(b-1)*3+1,2) end as c,CASE When b=4 then 0 When b=3 then 100 else substring(p,(b)*3+1,2) end as e,if(b=4,0,substring(d,(b)*4+1,3)) as g,if(b=0,0,substring(yd,(b-1)*7+1,6)) as h FROM (SELECT *,(LENGTH(a)-LENGTH(REPLACE(a,'x',''))) as b FROM (SELECT Z.pkgsn,GROUP_CONCAT(Z.per)as p,GROUP_CONCAT(Z.days) as d,GROUP_CONCAT(Z.y) as yd,tabproject.tranche,M.acost,GROUP_CONCAT(if(y>".$ym.",y,'x')) a FROM (SELECT pkgsn,milestone,per,days,max(y) as y FROM(SELECT *,(substring(tdate,7,4)*100+substring(tdate,4,2))as y FROM `tabmilestone`) Q GROUP BY Q.pkgsn,Q.milestone) Z JOIN tabproject ON tabproject.pkgsn=Z.pkgsn  JOIN (SELECT sum(tabroad.rcost) as acost,pkg FROM tabroad GROUP BY pkg ) as M ON M.pkg=tabproject.pkg GROUP BY Z.pkgsn) as F) as T1)T2)T3 Group by T3.tranche)T4 ON T4.tranche=T5.tranche";
	$tm_project = $this->db->query($mquery)->result();
	return $tm_project;
	
	}
	public function get_road_structure(){
		$tm_project = $this->db->query("select * from tabschedule WHERE length(latlng)>0 AND SUBSTRING(itemcode,1,3)='".$this->session->userdata('phyroadid')."'")->result();
		return $tm_project;
	}
	public function road_images(){
		$tm_project = $this->db->query("select * from tabimages WHERE latlng <> ''  AND rid='".$this->session->userdata('phyroadid')."'")->result();
		return $tm_project;
	}
	public function get_project()
	{
		$tm_project = $this->db->query("select * from tabproject ORDER BY pkgsn")->result();
		return $tm_project;
	}
	public function road_plantation()
	{if($this->session->has_userdata('phyroadid')){$a =$this->session->userdata('phyroadid');}
		$tm_project = $this->db->query("select * from tabplantation WHERE schid LIKE '".$a."%' ORDER BY edate")->result();
		return $tm_project;
	}
	public function count_project(){
		return $this->db->get('tabproject')->num_rows();
	}
	public function get_kml(){			
	
		if($this->session->has_userdata('phyroadid')){$a =$this->session->userdata('phyroadid');}
		$this->db->select('*');
		$this->db->from('tabroadkml');
		$this->db->join('tabroad', 'tabroad.rid = tabroadkml.roadid');
		$this->db->WHERE('roadid', $a);		
		$query = $this->db->get()->result();	
		return $query;
	}
	public function get_kml_selected($a){			
		$this->db->select('*');
		$this->db->from('tabroadkml');
		$this->db->join('tabroad', 'tabroad.rid = tabroadkml.roadid');
		$this->db->join('tabproject', 'tabroad.pkg = tabproject.pkg');
		$this->db->WHERE('tranche', $a);		
		$query = $this->db->get()->result();	
		return $query;
	}
	public function get_kml_all(){			
		$this->db->select('*');
		$this->db->from('tabroadkml');
		$this->db->join('tabroad', 'tabroad.rid = tabroadkml.roadid');
		$query = $this->db->get()->result();	
		return $query;
	}
	public function road_images_all(){
		$tm_project = $this->db->query("select * from tabimages WHERE latlng IS NOT NULL")->result();
		return $tm_project;
	}
	public function road_images_selected($a){
		$tm_project = $this->db->query("select tabimages.* from tabimages JOIN tabroad ON tabroad.rid=tabimages.rid JOIN tabproject ON tabproject.pkg=tabroad.pkg WHERE tabimages.latlng IS NOT NULL and tabproject.tranche='".$a."'")->result();
		return $tm_project;
	}
	public function get_road_structure_all(){
		$tm_project = $this->db->query("select * from tabschedule WHERE length(latlng)>0")->result();
		return $tm_project;
	}
	public function get_road_structure_selected($a){
		$tm_project = $this->db->query("select tabschedule.* from tabschedule JOIN tabroad ON tabroad.rid=Substring(tabschedule.itemcode,1,3) JOIN tabproject ON tabproject.pkg=tabroad.pkg WHERE tabschedule.latlng>0 and tabproject.tranche='".$a."'")->result();
		return $tm_project;
	}
	public function get_tranche()
	{
		$tm_project = $this->db->query("select tranche from tabproject GROUP BY tranche")->result();
		return $tm_project;
	}
	public function road_hidrance(){
		$tm_project = $this->db->query("select * from tabhindrance WHERE rid='".$this->session->userdata('phyroadid')."'")->result();
		return $tm_project;
	}
	public function Completed_chainage(){ //for H1 section only
		$tm_project = $this->db->query("SELECT fromch,toch FROM `tabphysical` WHERE phycode LIKE '".$this->session->userdata('phyroadid')."H1%' AND (item='107' OR item='106') AND substring(phycode,Length(phycode)-3,1)!='R' Group BY fromch")->result();
		return $tm_project;
	}
}
?>