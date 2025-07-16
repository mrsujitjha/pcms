<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_exportall extends CI_Model {
	public function Table_1($a){ 
		$r =$this->session->userdata('pkgname');	
		if($a==0){
		$myquery="SELECT Replace(tabroad.rid,tabroad.rid,'') as EOT,tabroad.pkg,tabroad.rname,tabroad.alength,tabroad.rlength,tabroad.acost,tabroad.rcost,Round((tabroad.pp),2) as pp,tabroad.fp,Fin.m as COS,tabroad.pcerti,tabroad.fcerti,A.cl,tabproject.aptdate,tabproject.comdate,tabproject.excomdate FROM tabroad LEFT JOIN (SELECT sum(qyt) as cl,substring(`phycode`,1,3) as rid FROM `tabphysical` where (item=106 or item=107)AND substring(phycode,Length(phycode)-3,1)!='R' GROUP BY substring(`phycode`,1,3))as A ON A.rid=tabroad.rid LEFT JOIN tabproject ON tabproject.pkg=tabroad.pkg LEFT JOIN (
SELECT A.rid,sum(amount)m  FROM (SELECT substring(fincode,length(fincode)-11,3) rid,amount,substring(fincode,length(fincode)-7,3) as t,tabproject.mode FROM `tabfinance`  JOIN tabproject ON tabproject.pkg=tabfinance.pkgid WHERE toid='Paid') as A WHERE (A.t!='WSC'AND A.t!='OHD')  GROUP BY A.rid) as Fin ON Fin.rid=tabroad.rid";
		}else{
			$myquery="SELECT Replace(tabroad.rid,tabroad.rid,'') as EOT,tabroad.pkg,tabroad.rname,tabroad.alength,tabroad.rlength,tabroad.acost,tabroad.rcost,Round((tabroad.pp),2) as pp,tabroad.fp,Fin.m as COS,tabroad.pcerti,tabroad.fcerti,A.cl,tabproject.aptdate,tabproject.comdate,tabproject.excomdate FROM tabroad LEFT JOIN (SELECT sum(qyt) as cl,substring(`phycode`,1,3) as rid FROM `tabphysical` where (item=106 or item=107)AND substring(phycode,Length(phycode)-3,1)!='R' GROUP BY substring(`phycode`,1,3))as A ON A.rid=tabroad.rid Right JOIN (SELECT * FROM tabproject  WHERE tabproject.pkg ='".$r."')tabproject ON tabproject.pkg=tabroad.pkg LEFT JOIN (
SELECT A.rid,sum(amount)m  FROM (SELECT substring(fincode,length(fincode)-11,3) rid,amount,substring(fincode,length(fincode)-7,3) as t,tabproject.mode FROM `tabfinance`  JOIN tabproject ON tabproject.pkg=tabfinance.pkgid WHERE toid='Paid') as A WHERE (A.t!='WSC'AND A.t!='OHD')  GROUP BY A.rid) as Fin ON Fin.rid=tabroad.rid";
		}
	
		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}
	
	public function get_schedule_progress_repo(){ 
    
		$r =$this->session->userdata('phyroadid');	
		$b =$this->session->userdata('phyyear')+2023;
        $c =$this->session->userdata('phymonth');	
		if ($c<10) {$a=$b."0".$c;}else{$a=$b.$c;}		
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
	public function get_physical_progress_groupwise(){ 
		$myquery="";
		$r =$this->session->userdata('phyroadid');	
		$b =$this->session->userdata('phyyear')+2023;
        $c =$this->session->userdata('phymonth');	
		if ($c<10) {$a=$b."0".$c;}else{$a=$b.$c;}			
		$myquery="SELECT sum(F.c1)c1,sum(F.c2)c2,sum(F.c3)c3,F.name,sum(F.scope-F.c3) as d3,N.gtext,sum(F.scope)scope,F.TCS FROM (SELECT D.name,B.TCS,(SELECT sum(toch-fromch) FROM tabsection WHERE Substring(roadid,1,length(roadid)-5) =B.TCS and length(tcsid)-length(replace(tcsid,B.item,''))>0 AND substring(roadid,Length(roadid)-3,1)!='R') scope,(B.c3-COALESCE(A.c2,0))as c1,A.c2,B.c3,B.item  FROM (SELECT item,sum(qyt) as c2, Substring(phycode,1,length(phycode)-5) as TCS FROM `tabphysical` WHERE yrm=".$a."  and phycode like'".$r."%' AND substring(phycode,Length(phycode)-3,1)!='R' GROUP BY TCS,item)as A RIGHT JOIN (SELECT item,sum(qyt) as c3, Substring(phycode,1,length(phycode)-5) as TCS,phycode FROM `tabphysical` WHERE yrm<=".$a."   and phycode like '".$r."%' AND substring(phycode,Length(phycode)-3,1)!='R' GROUP BY TCS,item)as B ON A.TCS=B.TCS AND A.item=B.Item JOIN (SELECT * FROM `tabitemcode`) as D ON D.itemid=B.item) AS F Left JOIN (Select name,gtext FROM tabtcsmgm WHERE roadid like '".$r."%')AS N  ON Substring(F.TCS,6)=N.name  GROUP BY N.gtext,F.item ORDER BY  N.gtext";
		$getqresult = $this->db->query($myquery)->result();
		return $getqresult;
	}


public function get_physical_progress_summary(){ 
	$myquery="";
	$r =$this->session->userdata('phyroadid');	
	$b =$this->session->userdata('phyyear')+2023;
	$c =$this->session->userdata('phymonth');	
	if ($c<10) {$a=$b."0".$c;}else{$a=$b.$c;}	
	$myquery="SELECT F.*,(F.scope-F.c3) as d3 FROM (SELECT D.name,(SELECT sum(toch-fromch) FROM tabsection WHERE length(tcsid)-length(replace(tcsid,B.item,''))>0 AND substring(roadid,Length(roadid)-3,1)!='R' and substring(roadid,1,3)='".$r."') scope,(B.c3-COALESCE(A.c2,0))as c1,A.c2,B.c3,B.item  FROM (SELECT item,sum(qyt) as c2 FROM `tabphysical` WHERE yrm=".$a." and phycode like'".$r."%' AND substring(phycode,Length(phycode)-3,1)!='R' GROUP BY item)as A RIGHT JOIN (SELECT item,sum(qyt) as c3,phycode FROM `tabphysical` WHERE yrm<=".$a." and phycode like '".$r."%' AND substring(phycode,Length(phycode)-3,1)!='R' GROUP BY item)as B ON A.item=B.Item JOIN (SELECT * FROM `tabitemcode`) as D ON D.itemid=B.item) AS F";
	
	$getqresult = $this->db->query($myquery)->result();
	return $getqresult;
}
public function get_Financial_progress_summary(){ 
	$myquery="";
	$r =$this->session->userdata('phyroadid');	
	$a =$this->session->userdata('phyyear')+2023;
	$c =$this->session->userdata('phymonth');	
	if ($c<10) {$b=$a."0".$c;}else{$b=$a.$c;}	
	$myquery="SELECT CM.igroup,Round(CM.mw*CM.TC/100,2)f1,Round((CM.T-COALESCE(LM.L,0))*CM.TC/100,2) as f2,Round(CM.T*CM.TC/100,2)f4 ,Round(LM.L*CM.TC/100,2)f3,Round(CM.T/CM.mw*100,2) T FROM (SELECT Sum(F.Per) T,F.mw,F.igroup,(SELECT rcost from tabroad WHERE rid=F.roadid) as TC FROM (SELECT tabitemcode.name,tabitemcode.unit,sum(M.T)s,sum(M.qyt)prog,sum(Round((M.qyt/M.T*M.wp*M.mw/100),3)) as Per,M.a,M.g,M.igroup,M.mw,M.roadid FROM (SELECT Sum(C.T)T,Sum(C.qyt)qyt,D.wp,D.mw,substring(C.itemid,1,3) as a,if(Length(C.itemid)>5,substring(C.itemid,1,3),C.itemid)g,D.igroup,D.roadid FROM (SELECT A.pid,A.rid,tabitemcode.itemid,A.qyt,A.rlength as T FROM (SELECT itemcode as pid,Substring(itemcode,1,3) as rid,itemsize,if(rem='%',descrip,count(itemsize)) as rlength,if(rem='%',Round(percent*descrip/100,0),Sum(if(progress='COMPLETED',1,0))) as qyt FROM tabschedule GROUP BY  Substring(itemcode,1,3),itemsize)As A JOIN tabitemcode ON tabitemcode.name=A.itemsize
		UNION
		SELECT rid as pid ,substring(rid,1,3) as rid,stageid,Sum(if(status='COMPLETED',1,0)) qyt,Count(stageid) T FROM tabstgp GROUP BY substring(rid,1,5),stageid 
		UNION                                   
		SELECT B.pid,B.rid,B.itemid,B.qyt,(SELECT sum(toch-fromch) FROM tabsection WHERE substring(roadid,1,length(roadid)-5)=substring(B.pid,1,length(B.pid)-5) AND length(tcsid)-length(replace(tcsid,B.item,''))>0 AND substring(roadid,Length(roadid)-3,1)!='R') as T FROM (SELECT phycode as pid,substring(phycode,1,3)as rid,concat(item,substring(phycode,6,length(phycode)-10))as itemid,sum(qyt) as qyt,item FROM tabphysical WHERE substring(phycode,Length(phycode)-3,1)!='R' GROUP BY rid,substring(phycode,1,length(phycode)-5),itemid) as B JOIN  tabroad ON tabroad.rid=B.rid) as C LEFT JOIN
		(SELECT tabsubweight.*,tabweightage.mw,tabweightage.roadid,tabweightage.item as igroup FROM `tabsubweight` JOIN tabweightage ON tabweightage.id=tabsubweight.wid) as D ON D.roadid=C.rid  AND D.itemid=C.itemid WHERE  D.roadid='".$r."'GROUP BY D.mw,D.wp,a) as M  JOIN tabitemcode ON tabitemcode.itemid=M.a GROUP BY M.a) as F GROUP BY F.igroup) as CM LEFT JOIN
		(SELECT Sum(F.Per) L,F.mw,F.igroup FROM (SELECT tabitemcode.name,tabitemcode.unit,sum(M.T)s,sum(M.qyt)prog,sum(Round((M.qyt/M.T*M.wp*M.mw/100),3)) as Per,M.a,M.g,M.igroup,M.mw FROM (SELECT Sum(C.T)T,Sum(C.qyt)qyt,D.wp,D.mw,substring(C.itemid,1,3) as a,if(Length(C.itemid)>5,substring(C.itemid,1,3),C.itemid)g,D.igroup FROM (SELECT A.pid,A.rid,tabitemcode.itemid,A.qyt,A.rlength as T FROM (SELECT itemcode as pid,Substring(itemcode,1,3) as rid,itemsize,if(rem='%',descrip,count(itemsize)) as rlength,if(rem='%',Round(percent*descrip/100,0),Sum(if(progress='COMPLETED',1,0))) as qyt FROM tabschedule where yrm=".$b." GROUP BY  Substring(itemcode,1,3),itemsize)As A JOIN tabitemcode ON tabitemcode.name=A.itemsize
		UNION
		SELECT rid as pid ,substring(rid,1,3) as rid,stageid,Sum(if(status='COMPLETED',1,0)) qyt,Count(stageid) T FROM tabstgp Where yrm=".$b." GROUP BY substring(rid,1,5),stageid 
		UNION                                   
		SELECT B.pid,B.rid,B.itemid,B.qyt,(SELECT sum(toch-fromch) FROM tabsection WHERE substring(roadid,1,length(roadid)-5)=substring(B.pid,1,length(B.pid)-5) AND length(tcsid)-length(replace(tcsid,B.item,''))>0 AND substring(roadid,Length(roadid)-3,1)!='R') as T FROM (SELECT phycode as pid,substring(phycode,1,3)as rid,concat(item,substring(phycode,6,length(phycode)-10))as itemid,sum(qyt) as qyt,item FROM tabphysical WHERE substring(phycode,Length(phycode)-3,1)!='R' and yrm=".$b." GROUP BY rid,substring(phycode,1,length(phycode)-5),itemid) as B JOIN  tabroad ON tabroad.rid=B.rid) as C LEFT JOIN
		(SELECT tabsubweight.*,tabweightage.mw,tabweightage.roadid,tabweightage.item as igroup FROM `tabsubweight` JOIN tabweightage ON tabweightage.id=tabsubweight.wid) as D ON D.roadid=C.rid  AND D.itemid=C.itemid WHERE  D.roadid='".$r."'GROUP BY D.mw,D.wp,a) as M  JOIN tabitemcode ON tabitemcode.itemid=M.a GROUP BY M.a) as F GROUP BY F.igroup) as LM  ON LM.igroup=CM.igroup
		";
	
	$getqresult = $this->db->query($myquery)->result();
	return $getqresult;
}
public function get_Financial_packagewise_summary(){ 	
	$r =$this->session->userdata('phyroadid');	
	$b =$this->session->userdata('phyyear')+2023;
	$c =$this->session->userdata('phymonth');	
	if ($c<10) {$a=$b."0".$c;}else{$a=$b.$c;}	
	$myquery="SELECT F.pkg, F.scope,B.amt as c1,D.amt as c2,(COALESCE(B.amt,0)+COALESCE(D.amt,0)) as c3,Round(((COALESCE(B.amt,0)+COALESCE(D.amt,0))/F.scope*100),2) as d1 FROM (SELECT pkg,sum(rcost) as scope FROM `tabroad` GROUP BY pkg)as F Left JOIN
(SELECT A.* FROM (SELECT pkgid,sum(amount) as amt,replace(substring(mdate,1,7),'-','')as md FROM `tabfinance` WHERE toid='Paid' GROUP BY pkgid) as A WHERE A.md<'".$a."') as B ON B.pkgid=F.pkg
Left JOIN
(SELECT C.* FROM (SELECT pkgid,sum(amount) as amt,replace(substring(mdate,1,7),'-','')as md FROM `tabfinance` WHERE toid='Paid' GROUP BY pkgid) as C WHERE C.md='".$a."') as D ON D.pkgid=F.pkg";
	$getqresult = $this->db->query($myquery)->result();
	return $getqresult;
	}
public function road_plantation()
	{$tm_project = $this->db->query("SELECT tabroad.rname,tabplantation.planted,tabplantation.survival FROM (select schid,Max(edate) as a from tabplantation GROUP BY `schid`) as Q LEFT JOIN tabplantation ON Q.schid=tabplantation.schid and Q.a=tabplantation.edate LEFt JOIN tabroad ON tabroad.rid=substring(Q.schid,1,3)")->result();
		return $tm_project;
	}
public function pkg_milestone_status_old()
	{$tm_project = $this->db->query("SELECT tabproject.pkg,A.a,A.milestone,A.tdate,A.adate FROM (SELECT pkgsn,if(eot=0,'Contract Date',CONCAT('EOT-',eot)) a,eot,milestone,tdate,adate FROM tabmilestone)As A JOIN tabproject ON tabproject.pkgsn=A.pkgsn  ORDER BY A.pkgsn,A.eot,A.milestone")->result();
		return $tm_project;
	}
public function pkg_milestone_status()
	{$tm_project = $this->db->query("SELECT tabproject.pkg,M.e,M.m1,M.m2,M.m3,M.m4 FROM (SELECT Q.pkgsn,Q.e,Q.eot,Substring(Q.td,POSITION('Milestone1' IN Q.m),10)m1,Substring(Q.td,POSITION('Milestone2' IN Q.m),10)m2,Substring(Q.td,POSITION('Milestone3' IN Q.m),10)m3,Substring(Q.td,POSITION('Milestone4' IN Q.m),10)m4 FROM (SELECT A.pkgsn,if(A.eot=0,'Contractual',CONCAT('EOT NO-',A.eot))e,A.eot, GROUP_CONCAT(A.milestone)m,GROUP_CONCAT(A.tdate)td FROM (SELECT pkgsn,eot,milestone,tdate,adate FROM tabmilestone ORDER BY pkgsn,eot,milestone)As A GROUP BY A.pkgsn,A.eot)Q UNION SELECT F.pkgsn,'ACHEIVED DATE'e,'a'eot,Substring(F.a,POSITION('Milestone1' IN F.m),10)m1,Substring(F.a,POSITION('Milestone2' IN F.m),10)m2,Substring(F.a,POSITION('Milestone3' IN F.m),10)m3,Substring(F.a,POSITION('Milestone4' IN F.m),10)m4 FROM(SELECT Q.pkgsn,GROUP_CONCAT(Q.milestone)m,GROUP_CONCAT(Q.adate)a FROM (SELECT pkgsn,milestone,CONCAT(substring(adate,9,2),'-',substring(adate,6,2),'-',substring(adate,1,4))adate FROM tabmilestone WHERE COALESCE(adate, '') != '' GROUP BY pkgsn,milestone) as Q GROUP BY Q.pkgsn) as F)as M JOIN tabproject ON tabproject.pkgsn = M.pkgsn ORDER BY M.pkgsn,M.eot")->result();
		return $tm_project;
	}


}