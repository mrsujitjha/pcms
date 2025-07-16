<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
     
class Stripplan extends CI_Controller {  
   
    public function __construct() {  
       parent::__construct();  
       $this->load->model('M_physicalreport','physical');	
    }   
   
    public function index()  
    {  
      $d = "R01H1:202401";	
      if($this->session->has_userdata('phyroadid')){
        $a =$this->session->userdata('phyroadid');
        $b =$this->session->userdata('phyyear')+2023;
        $c =$this->session->userdata('phymonth');
         
        if ($c<10) {$d= $a.":".$b."0".$c;}else{$d=$a.":".$b.$c;}		
      }    
      //leftside and 2 lane   
      $data['sugrade']=$this->physical->get_chainage_detail($d.":102:L");
      $data['subbase']=$this->physical->get_chainage_detail($d.":103:L");
      $data['base']=$this->physical->get_chainage_detail($d.":104:L");
      $data['dbm']=$this->physical->get_chainage_detail($d.":105:L");
      $data['bc']=$this->physical->get_chainage_detail($d.":106:L");
      $data['dlc']=$this->physical->get_chainage_detail($d.":138:L"); 
      $data['pqc']=$this->physical->get_chainage_detail($d.":107:L");
      //rightside and 4 lane
      $data['sugrader']=$this->physical->get_chainage_detail($d.":102:R");
      $data['subbaser']=$this->physical->get_chainage_detail($d.":103:R");
      $data['baser']=$this->physical->get_chainage_detail($d.":104:R");
      $data['dbmr']=$this->physical->get_chainage_detail($d.":105:R");
      $data['bcr']=$this->physical->get_chainage_detail($d.":106:R");
      $data['dlcr']=$this->physical->get_chainage_detail($d.":138:R"); 
      $data['pqcr']=$this->physical->get_chainage_detail($d.":107:R");
      $data['content']="v_stripmap";
      $this->load->view('template', $data, FALSE);	
    }  

    

}  