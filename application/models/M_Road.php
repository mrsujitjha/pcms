<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Road extends CI_Model {

	public function get_Road()
	{
		$tm_Road=$this->db->get('tabroad')->result();
		return $tm_Road;
	}
	
	public function get_road2()
	{	$data=array();
		$i=0;
		$rlist=$this->session->userdata('rlist');
		$tm_project=$this->db->get('tabroad')->result_array();
		if (strlen($rlist) ==0){ return $tm_project;}else{
			$rid=explode(',', $rlist);
			foreach ($rid as $r) {
				foreach ($tm_project as $road) {
					if	($road["rid"]==$r){
						$rowv=array('rid'=> $road["rid"],'rname'=> $road["rname"],'slength'=> $road["slength"],'rlength'=> $road["rlength"],'scost'=> $road["scost"],'rcost'=> $road["rcost"],'pkg'=> $road["pkg"],'sc'=> $road["sc"]);
						$data[]=$rowv;
					break;
					}
				}
			}		
			return $data;}
	}
	public function get_Road_page($limit, $start) {
        $this->db->limit($limit, $start);
        $tm_Road = $this->db->get('tabroad');
        return $tm_Road->result();
    }
	public function get_pkg()
	{
		$tm_Road=$this->db->get('tabproject')->result();
		return $tm_Road;
	}
	public function count_Road(){
		return $this->db->get('tabroad')->num_rows();
	}
	public function save_Road()
	{
		$object=array(			
			'rid'=>$this->input->post('rid'),			
			'rname'=>$this->input->post('rname'),
			'slength'=>$this->input->post('slength'),
			'alength'=>$this->input->post('alength'),
			'rlength'=>$this->input->post('rlength'),
			'scost'=>$this->input->post('scost'),
			'acost'=>$this->input->post('acost'),
			'rcost'=>$this->input->post('rcost'),
			'sc'=>$this->input->post('rsec'),
			'ssch'=>$this->input->post('rsecsc')
		);
		return $this->db->insert('tabroad', $object);
	}

	public function Road_detail($a)
	{ $b = explode(':', $a);
		$this->session->set_userdata('mypage',$b[1]);
		return $this->db->where('rid',$b[0])
		->get('tabroad')
		->row();
	}
	public function get_maxroadid()
	{
		return $this->db->select_max('rid')
					->from('tabroad')
					->get()
					->row();
	}
	public function update_Road()
	{
		$a=$this->input->post('editroadid');		
		$object=array(				
			'rname'=>$this->input->post('rname2'),
			'slength'=>$this->input->post('slength2'),
			'alength'=>$this->input->post('alength2'),
			'rlength'=>$this->input->post('rlength2'),
			'scost'=>$this->input->post('scost2'),
			'acost'=>$this->input->post('acost2'),
			'rcost'=>$this->input->post('rcost2'),
			'sc'=>$this->input->post('rsec2'),
			'ssch'=>$this->input->post('rsecsc2'),
			'pkg'=>$this->input->post('pkgid2'),			
			'pcerti'=>$this->input->post('pcerti'),			
			'fcerti'=>$this->input->post('fcerti')
			);
		return $this->db->where('rid', $this->input->post('editroadid'))->update('tabroad',$object);
	}
	public function update_Roadkml()
	{$Roadid= $this->input->post('krid');
		$this->db->where('roadid', $Roadid)->delete('tabroadkml');
		$object=array(			
			'roadid'=>$this->input->post('krid'),	
			'descrip'=>$this->input->post('output')
		);
		return $this->db->insert('tabroadkml', $object);
	}
	public function download_kmlRoad()
	{$a= $this->input->post('krid');
		$this->db->select('*');
		$this->db->from('tabroadkml');
		$this->db->WHERE('roadid', $a);		
		$query = $this->db->get()->row_array();
 		$b =$query['descrip'];
		$fname= $a.'.kml';	
		$myfile = fopen($fname, "w") or die("Unable to open file!");
		$mtext ='<?xml version="1.0" encoding="UTF-8"?>';
		fwrite($myfile,$mtext."\n");
		$mtext ='<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2"';
		fwrite($myfile,$mtext."\n");
		$mtext ='xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom">';
		fwrite($myfile,$mtext."\n");
		$mtext ='<Document><Placemark>';
		fwrite($myfile,$mtext."\n");
		$mtext ='<name>'.$fname.'</name>';
		fwrite($myfile,$mtext."\n");
		$mtext ='<LineString><coordinates>';
		fwrite($myfile,$mtext."\n");
		fwrite($myfile, $b."\n");
		$mtext ='</coordinates></LineString></Placemark></Document></kml>';		
		fwrite($myfile,$mtext);
		fclose($myfile);
		
	}
	public function download_kmlRoad_old()
	{$a= $this->input->post('krid');
		$this->db->select('*');
		$this->db->from('tabroadkml');
		$this->db->WHERE('roadid', $a);		
		$query = $this->db->get()->row_array();
 		$b =$query['descrip'];
		$fname= $a.'.kml';	
		$myfile = fopen($fname, "w") or die("Unable to open file!");
		$mtext ='<?xml version="1.0" encoding="UTF-8"?>';
		fwrite($myfile,$mtext."\n");
		$mtext ='<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2"';
		fwrite($myfile,$mtext."\n");
		$mtext ='xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom">';
		fwrite($myfile,$mtext."\n");
		$mtext ='<Document>';
		fwrite($myfile,$mtext."\n");
		$mtext ='<Placemark>';
		fwrite($myfile,$mtext."\n");
		$mtext ='<name>'.$fname.'</name>';
		fwrite($myfile,$mtext."\n");
		$mtext ='<LineString>';
		fwrite($myfile,$mtext."\n");
		$mtext ='<coordinates>';
		fwrite($myfile,$mtext."\n");
		fwrite($myfile, $b."\n");
		$mtext ='</coordinates>';
		fwrite($myfile,$mtext."\n");
		$mtext ='</LineString>';
		fwrite($myfile,$mtext."\n");
		$mtext ='</Placemark>';
		fwrite($myfile,$mtext."\n");
		$mtext ='</Document>';
		fwrite($myfile,$mtext."\n");
		$mtext ='</kml>';
		fwrite($myfile,$mtext);
		fclose($myfile);
		
	}
	public function delete_Road($Roadid='')
	{
		return $this->db->where('rid', $Roadid)->delete('tabroad');
	}
	public function clear_kmlRoad()
	{$Roadid= $this->input->post('krid');		
		return $this->db->where('roadid', $Roadid)->delete('tabroadkml');
	}

}
