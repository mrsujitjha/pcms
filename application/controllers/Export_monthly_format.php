<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 require_once('vendor/autoload.php'); 
use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;  
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Export_monthly_format extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
	}
 
	public function Monthly_format($a){   
 
    $this->load->model('M_exportall','exmodel'); 
    $fname= "Monthly_report.xlsx";	
    $spreadsheet = new Spreadsheet(); 
    //table-1   
      $mheader= explode(",","Package No,Name of Highways,Contract Amount (INR Cr.),Appointed date,Contract Amount after (COS),Scheduled date of completion,Extended date of completion,EOT ,Total awarded length (km),Total length after COS (km),Completed length (km),Payment made excl. Price Adj. (Rs. Cr.,Physical progress in terms of Financial,Financial Progress based on actual expenditure,Date of completion (Date issue of provisional comp. certificate)");
      $fheader= explode(",","pkg,rname,acost,aptdate,rcost,comdate,excomdate,EOT,alength,rlength,cl,COS,pp,fp,fcerti");   
      $data=$this->exmodel->Table_1($a);	 
      $this-> Export_format($data, $mheader, $fheader,$spreadsheet,$fname,1);      
    //table-2  
      $mheader= explode(",","Item,Scope,Completed (Last month),Inprogress (Last month),Completed (This month),Inprogress (This month),Completed (Till Date),Inprogress (Till Date),Not Started (Till Date)");
      $fheader= explode(",","itemsize,scope,c1,d1,c2,d2,c3,d3,e3");   
      $data=$this->exmodel->get_schedule_progress_repo();	 
      $this-> Export_format($data, $mheader, $fheader,$spreadsheet,$fname,2);
      //table-3  
      $mheader= explode(",","Item,Scope,Completed (Last month),Completed (This month),Completed (Till Date),Balance");
      $fheader= explode(",","name,scope,c1,c2,c3,d3,gtext");   
      $data=$this->exmodel->get_physical_progress_groupwise();	 
      $this-> Export_format($data, $mheader, $fheader,$spreadsheet,$fname,3);
      //table-4 
      $mheader= explode(",","Item,Scope,Completed (Last month),Completed (This month),Completed (Till Date),Balance");
      $fheader= explode(",","name,scope,c1,c2,c3,d3");   
      $data=$this->exmodel->get_physical_progress_summary();	 
      $this-> Export_format($data, $mheader, $fheader,$spreadsheet,$fname,4);
      //table-5  
      $mheader= explode(",","Items,Cost as per schedule H (INR Cr.),Executed till  previous month (INR Cr.),Progress During this month (INR Cr.),Up to this month (INR Cr.),Progress achieved (%)");
      $fheader= explode(",","igroup,f1,f2,f3,f4,T");   
      $data=$this->exmodel->get_Financial_progress_summary();	 
      $this-> Export_format($data, $mheader, $fheader,$spreadsheet,$fname,5);    
      //table-6  
      $mheader= explode(",","Package,Awarded Amount,Payment (Last month),Payment (This month),Payment (Till Date),Financial Progress (%)");
      $fheader= explode(",","pkg,scope,c1,c2,c3,d1");      		 
      $data=$this->exmodel->get_Financial_packagewise_summary();	 
      $this-> Export_format($data, $mheader, $fheader,$spreadsheet,$fname,6);    
      //table-7 
      $mheader= explode(",","Road,Plantation,Survival");
      $fheader= explode(",","rname,planted,survival");      		 
      $data=$this->exmodel->road_plantation();	 
      $this-> Export_format($data, $mheader, $fheader,$spreadsheet,$fname,7);    
      //table-8     
      $mheader= explode(",","Package Name,Description,Milestone1,Milestone2,Milestone3,Milestone4");
      $fheader= explode(",","pkg,e,m1,m2,m3,m4");      		 
      $data=$this->exmodel->pkg_milestone_status();	 
      $this-> Export_format($data, $mheader, $fheader,$spreadsheet,$fname,8);    



    $this->load->helper('download');
    force_download($fname, null);
     redirect('Report','refresh');
    }

    public function Export_format($data,$mheader,$fheader,$spreadsheet,$fname,$sn){  
      $cname= explode(",","A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z");
      $mdata = json_decode(json_encode($data), true);
      $myWorkSheet = new Worksheet($spreadsheet, 'Table-'.$sn);
      $spreadsheet->addSheet($myWorkSheet, $sn);
      $sheet= $spreadsheet->getSheetByName('Table-'.$sn);
      $sheet->setCellValue('A1',$this->session->userdata('subheading'));
      $sheet->setCellValue('A2','SN');
      for ($i=0;$i< count($mheader);$i++){
        $sheet->setCellValue($cname[$i+1].'2', $mheader[$i]);
      }
     $j=count($fheader);
      $rows = 3; 
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


    }


}
