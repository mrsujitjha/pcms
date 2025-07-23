<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('M_admin');
	}

	public function index()
	{
		if ($this->session->userdata('login') == FALSE) {
			$this->load->view('login');
		} else {
			redirect('Dashboard');
		}
	}
	public function password_reset()
	{
		if ($this->input->post('save')) {
			if ($this->M_admin->resetpassword()) {
				$this->session->set_flashdata('message', 'Successfully reset password');
				redirect('admin/index');
			} else {
				$this->session->set_flashdata('message', 'reset Failed');
				redirect('admin/index');
			}
		}
		if ($this->input->post('mail')) {
			if ($this->M_admin->sendmail()) {
				$this->session->set_flashdata('message', 'OTP Sent on mail');
				redirect('admin/index');
			} else {
				$this->session->set_flashdata('message', 'OTP not send process Failed');
				redirect('admin/index');
			}
		}
	}

	public function proses_login()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_rules('username', 'username', 'trim|required');
			$this->form_validation->set_rules('password', 'password', 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				if ($this->M_admin->get_login() == TRUE) {
					$this->overallprogress();
					redirect('Dashboard');
				} else {
					$this->session->set_flashdata('message', 'Wrong Username and Password');
					redirect('admin/index');
				}
			} else {
				$this->session->set_flashdata('message', 'Username or Password must be filled!!');
				redirect('admin/index');
			}
		}
		if ($this->input->post('guest')) {
			$this->M_admin->get_login_guest();
			$this->overallprogress();
			redirect('Dashboard');
		}
	}


	public function register()
	{
		if ($this->session->userdata('login') == FALSE) {
			$this->load->view('register');
		} else {
			redirect('Dashboard');
		}
	}

	public function proses_register()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_rules('username', 'username', 'trim|required');
			$this->form_validation->set_rules('password', 'password', 'trim|required');
			$this->form_validation->set_rules('fullname', 'fullname', 'trim|required');
			$this->form_validation->set_rules('level', 'level', 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				if ($this->M_admin->get_register() == TRUE) {
					redirect('admin/index');
				} else {
					$this->session->set_flashdata('message', 'Wrong Username and Password');
					redirect('admin/register');
				}
			} else {
				$this->session->set_flashdata('message', 'Username or Password must be filled!!');
				redirect('admin/register');
			}
		}
	}

	public function logout()
	{
		$this->M_admin->save_logindetail($this->session->userdata('username'), 'Logout');
		$this->session->sess_destroy();
		redirect('admin/index', 'refresh');
	}
	public function overallprogress()
	{
		$myquery = "UPDATE tabroad Inner JOIN (SELECT M.rid,sum(Round((M.qyt/M.T*M.wp*M.mw/100),3))p FROM (SELECT Sum(C.T)T,Sum(C.qyt)qyt,D.wp,D.mw,C.rid,substring(C.itemid,1,3) as a FROM (SELECT A.pid,A.rid,tabitemcode.itemid,A.qyt,A.rlength as T FROM (SELECT itemcode as pid,Substring(itemcode,1,3) as rid,itemsize,if(rem='%',descrip,count(itemsize)) as rlength,if(rem='%',Round(percent*descrip/100,0),Sum(if(progress='COMPLETED',1,0))) as qyt FROM tabschedule GROUP BY  Substring(itemcode,1,3),itemsize)As A JOIN tabitemcode ON tabitemcode.name=A.itemsize
		UNION
		SELECT rid as pid ,substring(rid,1,3) as rid,stageid,Sum(if(status='COMPLETED',1,0)) qyt,Count(stageid) T FROM tabstgp GROUP BY substring(rid,1,6),stageid 
		UNION                                   
		SELECT B.pid,B.rid,B.itemid,B.qyt,(SELECT sum(toch-fromch)FROM tabsection WHERE substring(roadid,1,length(roadid)-5)=substring(B.pid,1,length(B.pid)-5) AND length(tcsid)-length(replace(tcsid,B.item,''))>0 AND substring(roadid,Length(roadid)-3,1)!='R') as T FROM (SELECT phycode as pid,substring(phycode,1,3)as rid,concat(item,substring(phycode,6,length(phycode)-10))as itemid,sum(qyt) as qyt,item FROM tabphysical WHERE substring(phycode,Length(phycode)-3,1)!='R' GROUP BY rid,substring(phycode,1,length(phycode)-5),itemid) as B JOIN  tabroad ON tabroad.rid=B.rid) as C LEFT JOIN
		(SELECT tabsubweight.*,tabweightage.mw,tabweightage.roadid FROM `tabsubweight` JOIN tabweightage ON tabweightage.id=tabsubweight.wid) as D ON D.roadid=C.rid  AND D.itemid=C.itemid GROUP BY D.mw,D.wp,a) as M GROUP BY M.rid 
      ) as tableA ON tabroad.rid = tableA.rid SET tabroad.pp=tableA.p";

		$this->db->query($myquery);
		$fquery = "UPDATE tabroad Inner JOIN (SELECT A.rid,if(A.mode='HAM',sum(amount)*2,sum(amount)) as m  FROM (SELECT substring(fincode,length(fincode)-11,3) rid,amount,substring(fincode,length(fincode)-7,3) as t,tabproject.mode FROM `tabfinance`  JOIN tabproject ON tabproject.pkg=tabfinance.pkgid WHERE toid='Paid') as A WHERE (A.t!='WSC'AND A.t!='OHD')  GROUP BY A.rid)  as B ON tabroad.rid = B.rid SET tabroad.fp=Round((B.m/tabroad.rcost)*100,2)";
		$this->db->query($fquery);
	}
}
