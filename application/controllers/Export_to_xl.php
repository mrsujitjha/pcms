<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 require_once('vendor/autoload.php'); 
use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 

class Export_to_xl extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
	}
 
	public function exporttoxl(){       
   
    $b =$this->session->userdata('selrepo');
    $cname= explode(",","A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z");
    $mheader= explode(",",$this->session->userdata('mheader'));
    $fheader= explode(",",$this->session->userdata('fheader'));  
       switch ($b) {
        case 1:
          $c='Report_phy1'; 
          $fname= "Overall Structure status.xlsx";	  				
           break;
        case 2:
          $this->load->model('M_Schedule','exmodel'); 
          $data=$this->exmodel->get_schedule_progress_Item();        
          $c='Monthly_report/Show_report/'.'S1';
          $fname= "Monthly progress of selected structure.xlsx";	  	
           break;
        case 3:
          $c='Report_phy2';  
          $fname= "Overall physical progress sectionwise.xlsx";	                  
          break;       
        case 4:
          $this->load->model('M_Schedule','exmodel'); 
          $data=$this->exmodel->get_schedule_progress_repo();
          $c='Monthly_report/Show_report/'.'M1';	
          $fname= "Monthly Structure progress sheet.xlsx";	        
           break;
        case 5:
          $this->load->model('M_Section','exmodel'); 
          $data=$this->exmodel->get_physical_progress_tcs();
          $c='Monthly_report/Show_report/'.'M2';
          $fname= "Monthly Physical progress TCS wise.xlsx";			  
          break;
        case 6:
          $this->load->model('M_Section','exmodel'); 
          $data=$this->exmodel->get_physical_progress_summary();	
          $c='Monthly_report/Show_report/'.'M3';
          $fname= "Monthly Physical progress summary.xlsx";	      
          break;
        case 7:
          $this->load->model('M_Section','exmodel'); 
          $data=$this->exmodel->get_physical_progress_groupwise();	 
          $c='Monthly_report/Show_report/'.'M4';	
          $fname= "Physical Groupwise summary.xlsx";	  
          break;
        case 8:
          $this->load->model('M_Section','exmodel'); 
				$data=$this->exmodel->get_Financial_flow_progress();  
        $c='Monthly_report/Show_report/'.'M5';	
        $fname= "Financial Payment Process.xlsx";	 
          break;
        case 9:
          $this->load->model('M_Financial','exmodel'); 
          $data=$this->exmodel->get_Financial_progress_summary();	 
          $c='Monthly_report/Show_report/'.'M6';
          $fname= "Financial packagewise summary.xlsx";	
          break;
        
       }      
    
      $mdata = json_decode(json_encode($data), true);   
      $spreadsheet = new Spreadsheet();  
      $sheet = $spreadsheet->getActiveSheet(); 
      $sheet->setCellValue('A1','SN');
      for ($i=0;$i< count($mheader);$i++){
        $sheet->setCellValue($cname[$i+1].'1', $mheader[$i]);
      }

     $j=count($fheader);

      $rows = 2; 
      $sn=1;
      foreach ($mdata as $val){    
        if((count($mheader)<>$j )){
          $k=$j-1;        
					if ($myhead<>$val[$fheader[$k]]){ $sheet->setCellValue('A' . $rows,  "");$sheet->setCellValue($cname[$i+1].$rows, $val[$fheader[$k]]);$rows++; $myhead=$val[$fheader[$k]]; $sn=1; }
        }
        $sheet->setCellValue('A' . $rows,  $sn); 
        for ($i=0;$i< count($mheader);$i++){
          $sheet->setCellValue($cname[$i+1].$rows, $val[$fheader[$i]]);
        }
        $sn++;
        $rows++;
      }       
      $writer = new Xlsx($spreadsheet); 
      $writer->save($fname); 
      $this->load->helper('download');
      force_download($fname, null);
     redirect($c,'refresh');
    }

}
