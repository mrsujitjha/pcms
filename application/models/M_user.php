<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

	public function get_user()
	{
		$tm_user=$this->db->get('user')->result();
		return $tm_user;
	}
	public function save_user()
	{
		$object=array(
				'user_code'=>$this->input->post('user_code'),
				'fullname'=>$this->input->post('fullname'),
				'username'=>$this->input->post('username'),
				'password'=>md5($this->input->post('password')),
				'email'=>$this->input->post('email'),
				'level'=>$this->input->post('level'),
				'autho'=>$this->input->post('selectedmenu')
			);
		return $this->db->insert('user', $object);
	}
	public function detail($a)
	{
		return $this->db->where('user_code', $a)
						->get('user')
						->row();
	}
	public function edit_user()
	{
		$object=array(
				'fullname'=>$this->input->post('fullname2'),
				'username'=>$this->input->post('uname'),
				//'password'=>md5($this->input->post('password')),
				'email'=>$this->input->post('email2'),
				'level'=>$this->input->post('level2'),
				'autho'=>$this->input->post('selectedmenu2')
			);
		return $this->db->where('user_code', $this->input->post('user_code_lama'))->update('user',$object);
	}
	public function update_password()
	{
		$object=array(
				'password'=>md5($this->input->post('npassword'))
			);
		return $this->db->where('user_code',$this->session->userdata('userid'))->update('user',$object);
	}
	public function asign_user()
	{
		$object=array(				
				'rlist'=>$this->input->post('pkglist')
			);
		return $this->db->where('user_code', $this->input->post('user_code_lama2'))->update('user',$object);
	}
	public function hapus_user($id='')
	{
		return $this->db->where('user_code', $id)->delete('user');
	}

	public function get_road()
	{
		$tm_project=$this->db->get('tabroad')->result();
		return $tm_project;
	}

}

/* End of file M_user.php */
/* Location: ./application/models/M_user.php */