<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monthly_report extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		
	}
	public function Show_report($v_view)	{ 
		
		   switch ($v_view) {
			case "S1":
				$mheader= "Chainage,Description,Remaks,Status";
				$fheader= "chainage,descrip,rem,progress";				
				$this->session->set_userdata('mheader',$mheader);
				$this->session->set_userdata('fheader',$fheader);				
				$this->load->model('M_Schedule','exmodel'); 
				$mdata=$this->exmodel->get_schedule_progress_Item();							
				$data['Mydata']= json_decode(json_encode($mdata), true);  
				$data['content']="v_monthlyreport";	  
			   break;
			case "M1":
				$mheader= "Item,Scope,Completed (Last month),Inprogress (Last month),Completed (This month),Inprogress (This month),Completed (Till Date),Inprogress (Till Date),Not Started (Till Date)";
				$fheader= "itemsize,scope,c1,d1,c2,d2,c3,d3,e3";				
				$this->session->set_userdata('mheader',$mheader);
				$this->session->set_userdata('fheader',$fheader);				
				$this->load->model('M_Schedule','exmodel'); 
				$mdata=$this->exmodel->get_schedule_progress_repo();							
				$data['Mydata']= json_decode(json_encode($mdata), true);
				$data['content']="v_monthlyreport";	    
			   break;
			case "M2":
				$mheader= "Item,Scope,Completed (Last month),Completed (This month),Completed (Till Date),Balance";
				$fheader= "name,scope,c1,c2,c3,d3,TCS";				
				$this->session->set_userdata('mheader',$mheader);
				$this->session->set_userdata('fheader',$fheader);				
				$this->load->model('M_Section','exmodel'); 
				$mdata=$this->exmodel->get_physical_progress_tcs();							
				$data['Mydata']= json_decode(json_encode($mdata), true); 
				$data['content']="v_monthlyreport";	   
			   break;
			   case "M3":
				$mheader= "Item,Scope,Completed (Last month),Completed (This month),Completed (Till Date),Balance";
				$fheader= "name,scope,c1,c2,c3,d3";				
				$this->session->set_userdata('mheader',$mheader);
				$this->session->set_userdata('fheader',$fheader);				
				$this->load->model('M_Section','exmodel'); 
				$mdata=$this->exmodel->get_physical_progress_summary();							
				$data['Mydata']= json_decode(json_encode($mdata), true);  
				$data['content']="v_monthlyreport";	  
			   break;
			   case "M4":
				$mheader= "Item,Scope,Completed (Last month),Completed (This month),Completed (Till Date),Balance";
				$fheader= "name,scope,c1,c2,c3,d3,gtext";				
				$this->session->set_userdata('mheader',$mheader);
				$this->session->set_userdata('fheader',$fheader);				
				$this->load->model('M_Section','exmodel'); 
				$mdata=$this->exmodel->get_physical_progress_groupwise();							
				$data['Mydata']= json_decode(json_encode($mdata), true);  
				$data['content']="v_monthlyreport";	  
			   break;					  
			   case "M5"://flow of payment in linearway							
				$this->load->model('M_Financial','exmodel'); 
				$mdata=$this->exmodel->get_Financial_flow_progress();	
				$fdata=json_decode(json_encode($mdata), true); 						
				$data['Mydata']= $fdata;
				$mheader= "Package,Payment code";			  
				$no=0;
				$newhead=[];
				foreach  ($fdata as $x) : $no++;			
					$newhead= explode(",",$x['a1']);				
				break;
			    endforeach;				
					for($i=0;$i<count($newhead);$i++){
						$mheader=$mheader.",".$newhead[$i]." Date".",".$newhead[$i]." Amount".",".$newhead[$i]." Description";	
					}
				$fheader= "pkgid,fincode,d1,a2,d2";				
				$this->session->set_userdata('mheader',$mheader);
				$this->session->set_userdata('fheader',$fheader);	
				$data['content']="v_amtpaidflow";	
			   break;
			   case "M6":
				$mheader= "Package,Awarded Amount,Payment (Last month),Payment (This month),Payment (Till Date),Financial Progress (%)";
				$fheader= "pkg,scope,c1,c2,c3,d1";				
				$this->session->set_userdata('mheader',$mheader);
				$this->session->set_userdata('fheader',$fheader);				
				$this->load->model('M_Financial','exmodel'); 
				$mdata=$this->exmodel->get_Financial_progress_summary();							
				$data['Mydata']= json_decode(json_encode($mdata), true);  
				$data['content']="v_monthlyreport";	  
			   break;  
			   case "M7":
				$mheader= "Item,Chainage,Subitem,scope,Completed";
				$fheader= "itemname,chainage,stages,stage,status";				
				$this->session->set_userdata('mheader',$mheader);
				$this->session->set_userdata('fheader',$fheader);				
				$this->load->model('M_Weightage','exmodel'); 
				$mdata=$this->exmodel->get_stage_progress_repo();							
				$data['Mydata']= json_decode(json_encode($mdata), true);				
				$data['content']="v_mstagereport";	  
			   break;
			  
		   }	   	
	
		$this->load->view('template', $data, FALSE);

	}
	

}
