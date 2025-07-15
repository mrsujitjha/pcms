<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_physicalreport','physical');	
		
	}
	public function index()
		{ 	
		
		$data['get_roadlist']=$this->physical->get_road();
		$data['get_pkglist']=$this->physical->get_package();
		$data['get_itemlist']=$this->physical->get_item();	
		$data['content']="v_genreports";		
		$this->load->view('template', $data, FALSE);		
	}
	public function display()	{
		$this->physical->save_reportsearch();
		$b =$this->session->userdata('selrepo');
		$d =$this->session->userdata('roadname');
		switch ($b) {
			case 1:
				$c='Report_phy1'; 				
			break;
			case 2:
				$c='Monthly_report/Show_report/'.'S1';       
			
			break;
			case 3:
				$c='Report_phy2';
								
			  break;
			case 4:
				$c='Monthly_report/Show_report/'.'M1';
				$this->session->set_userdata('subheading',"Road Name: ".$d  ); 
				break;
			case 5:
				$c='Monthly_report/Show_report/'.'M2';
				$this->session->set_userdata('subheading',"Road Name: ".$d ); 
			  break;	
			case 6:
			   $c='Monthly_report/Show_report/'.'M3';
			   $this->session->set_userdata('subheading',"Road Name: ".$d  ); 			
			break;		
			case 7:
				$c='Monthly_report/Show_report/'.'M4';
				$this->session->set_userdata('subheading',"Road Name: ".$d  ); 			
			 break;		
			case 8:
				$this->session->set_userdata('subheading',"Amount in Cr." ); 
				$c='Monthly_report/Show_report/'.'M5';			
			 break;		
			 case 9:
				$this->session->set_userdata('subheading',"Amount in Cr." ); 
				$c='Monthly_report/Show_report/'.'M6';			
			 break;				 			
			 case 10:
				$this->session->set_userdata('subheading',"Road Name: ".$d );  		
				$c='Monthly_report/Show_report/'.'M7';			
			 break;	
			 case 11:	
				$this->session->set_userdata('subheading',"Road Name: ".$d );  						
				$c='Export_monthly_format/Monthly_format/1';			
			 break;	
			 case 12:			
				$this->session->set_userdata('subheading',"Road Name: ".$d );  				
				$c='Export_monthly_format/Monthly_format/0';			
			 break;	
		  }
		 
		if ($this->input->post('viewstrip')) {$this->session->set_userdata('stripplan',"Monthly");redirect('Stripplan','refresh');}
		if ($this->input->post('stripplan')) {$this->session->set_userdata('stripplan',"All");redirect('Stripplan','refresh');}	
		
		if ($this->input->post('viewrepo')) {redirect($c,'refresh');}

	  }
	  public function get_roadlist($a)
	   { 
		  $this->session->set_userdata('pkgid',$a);
		  $data=$this->physical->get_Road();
		  echo json_encode($data);		 
	  }
	  public function show_strip($a){
		$y=date("Y")-2023;
		$m=date("m");	
		$b=explode (":", $a); 
     	
		$this->session->set_userdata('phyroadid',$b[0]);
		$this->session->set_userdata('seclength',$b[1]); // splitted length 72-30-40 (3 section)
		$this->session->set_userdata('selsection','0'); //first section  selected 
		$this->session->set_userdata('phyyear',$y);
        $this->session->set_userdata('phymonth',$m);
		$this->session->set_userdata('stripplan',"All");

		$data= $this->physical->get_road_name($b[0]);
		echo $data;

	  }
	  public function show_tranchelist($a){
		if($a=='clear'){unset($_SESSION['tranche']);}else{$this->session->set_userdata('tranche',$a);}
		echo $a;	
	  }
	  public function savemapoption($a){
		$this->session->set_userdata('mapoption',$a);
		echo $a;	
	  }
	  public function saveroadselsection($a){
		$b=$a+1;
		$this->session->set_userdata('selsection',$a);
		$this->session->set_userdata('physec','H'.$b);
		
		echo $a;	
	  }
	  public function displayentry($a)
	  { 		
		 $data=$this->physical->get_selected_secction_itementry($a);
		 echo json_encode($data);		 
	 }
}
