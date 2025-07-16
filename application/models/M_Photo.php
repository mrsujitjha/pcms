<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Photo extends CI_Model {

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
	public function hapus_Photo($id='')
	{ 	$photopath ='./assets/photo/'.$id;	
		if (file_exists($photopath)) {unlink($photopath);}
		return $this->db->where('pname', $id)->delete('tabimages');
	}
	public function road_images(){
		$tm_project = $this->db->query("select * from tabimages WHERE latlng IS NOT NULL AND rid='".$this->session->userdata('roadid')."'")->result();
		return $tm_project;
	}
	public function upload_selected_photo(){
		$uploads_dir ='./assets/photo';		
        $tmp_name = $_FILES["myFile"]["tmp_name"];       
        $name = basename($_FILES["myFile"]["name"]);
		$ext=explode(".",$name);
		$name=$this->session->userdata('roadid').date("Y").date("m").date("d").date("h").date("i").date("s").'.'.$ext[1];	
        move_uploaded_file($tmp_name, "$uploads_dir/$name");
		$object=array(
			'rid'=>$this->session->userdata('roadid'),
			'pname'=>$name,
			'latlng'=>$this->input->post('plat'),
			'descrip'=>$this->input->post('descrip')
		);
			return $this->db->insert('tabimages', $object);
	}
	public function edit_photo_details(){	
		$a=	$this->input->post('picname');
		$object=array(
			'latlng'=>$this->input->post('plat2'),
			'descrip'=>$this->input->post('descrip2')
		);			
		return $this->db->where('pname', $a)->update('tabimages',$object);
	}

}
