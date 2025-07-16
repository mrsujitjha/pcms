<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_project extends CI_Model {

	public function get_project()
	{
		//$tm_project=$this->db->get('tabproject')->result();
		$tm_project = $this->db->query("select * from tabproject ORDER BY pkgsn")->result();
		return $tm_project;
	}
	public function milestone_detail($a)
	{$tm_project = $this->db->query("SELECT * FROM tabmilestone WHERE pkgsn=".$a." ORDER BY eot,milestone")->result();
		return $tm_project;
		
	}
	public function Completed_detail($a)
	{$tm_project = $this->db->query("SELECT * FROM tabmilestone WHERE pkgsn=".$a." and eot=(Select count(`milestone`)/4-1 FROM tabmilestone WHERE pkgsn=".$a.") ORDER BY milestone")->result();
		return $tm_project;
		
	}
	public function get_project_report()
	{
		//$query = $this->db->query("SELECT tabproject.pkgsn, tabproject.tranche,tabproject.mode,tabproject.pkg,count(tabproject.roadno) roadno,sum(tabroad.slength) slength,sum(tabroad.alength) alength,sum(tabroad.rlength) rlength,sum(tabroad.scost) scost,sum(tabroad.acost) acost,sum(tabroad.rcost) rcost FROM tabproject JOIN tabroad ON tabroad.rid=tabproject.roadno GROUP BY tabproject.pkg ORDER BY tabproject.pkgsn")
		$query = $this->db->query("select * from tabproject")
		->result();
		return $query;
	}
	public function get_conlist()
	{	$query = $this->db->query("select * from tabcontractor")
		->result();
		return $query;
	}
	public function save_project()
	{
		$object=array(		
			'pkgsn'=>$this->input->post('pkgsn'),	
			'tranche'=>$this->input->post('tranche'),
			'mode'=>$this->input->post('mode'),
			'pkg'=>$this->input->post('pkg')
		);
		return $this->db->insert('tabproject', $object);
	}

	public function project_detail($a)
	{
		return $this->db->where('pkgsn',$a)
		->get('tabproject')
		->row();
	}
	public function get_maxid()
	{
		return $this->db->select_max('pkgsn')
					->from('tabproject')
					->get()
					->row();
	}
	public function update_project()
	{
		$object=array(
			'tranche'=>$this->input->post('tranche'),
			'mode'=>$this->input->post('mode'),
			'pkg'=>$this->input->post('pkg')				
			);
		return $this->db->where('pkgsn', $this->input->post('editproid'))->update('tabproject',$object);
	}
	public function update_project_award()
	{
		$object=array(			
			'camt'=>$this->input->post('e1'),			
			'aptdate'=>$this->input->post('e2'),
			'cosamt'=>$this->input->post('e3'),
			'comdate'=>$this->input->post('e4'),
			'excomdate'=>$this->input->post('e5'),
			'awlength'=>$this->input->post('e6'),
			'coslength'=>$this->input->post('e7'),	
			'pguar'=>$this->input->post('e8'),
			'insu'=>$this->input->post('e9'),
			'cname'=>$this->input->post('conid')
			);
		return $this->db->where('pkgsn', $this->input->post('awardid'))->update('tabproject',$object);
	}
	
	public function delete_project($projectid='')
	{
		return $this->db->where('pkgsn', $projectid)->delete('tabproject');
	}
	public function update_milestone()
	{	$object = [];
		$md=explode(":",$this->input->post('pkgid'));	
		$a = $md[1];
		$pkg= $md[0];

		$this->db->where('pkgsn', $pkg)
		->where('eot', $a)
		->delete('tabmilestone');

		$mname="Milestone1";
		$mdays=$this->input->post('md1');
		$mper=$this->input->post('pd1');
		$pdate=$this->input->post('dd1');
		$adate=$this->input->post('ed1');
		$object[] = array('pkgsn'=>$pkg,'milestone'=>$mname,'days'=>$mdays,'per'=>$mper,'tdate'=>$pdate,'adate'=>$adate,'eot'=>$a);			
		$mname="Milestone2";
		$mdays=$this->input->post('md2');
		$mper=$this->input->post('pd2');
		$pdate=$this->input->post('dd2');
		$adate=$this->input->post('ed2');
		$object[] = array('pkgsn'=>$pkg,'milestone'=>$mname,'days'=>$mdays,'per'=>$mper,'tdate'=>$pdate,'adate'=>$adate,'eot'=>$a);			
		$mname="Milestone3";
		$mdays=$this->input->post('md3');
		$mper=$this->input->post('pd3');
		$pdate=$this->input->post('dd3');
		$adate=$this->input->post('ed3');
		$object[] = array('pkgsn'=>$pkg,'milestone'=>$mname,'days'=>$mdays,'per'=>$mper,'tdate'=>$pdate,'adate'=>$adate,'eot'=>$a);			
		$mname="Milestone4";
		$mdays=$this->input->post('md4');
		$mper=$this->input->post('pd4');
		$pdate=$this->input->post('dd4');
		$adate=$this->input->post('ed4');
		$object[] = array('pkgsn'=>$pkg,'milestone'=>$mname,'days'=>$mdays,'per'=>$mper,'tdate'=>$pdate,'adate'=>$adate,'eot'=>$a);		
		$x=array('excomdate'=>$this->input->post('dd4'));
		$this->db->where('pkgsn', $pkg)->update('tabproject',$x);
		if (count($object) > 0) {		
		return $this->db->insert_batch('tabmilestone',$object);}else{ return false;}
	}
	
}
