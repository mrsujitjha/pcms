<!DOCTYPE html>  
<html>  
<head>  
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
</head>  
<body>   

<div class="container-fluid">    
    <div class="card rounded-0 shadow"> 
        <div class="card-header">
            <?php if ($this->session->userdata('mapoption')!=null){$mapoption=$this->session->userdata('mapoption');}else{$mapoption='0::0::0::0::Selected';}
               $chopt=explode('::', $mapoption);
            ?> 
            <div style="height:2vh"> 
                               
                    <input type="checkbox" name="ch1" id="ch1"<?php if ($chopt[0]==1) echo "checked='checked'"; ?>/>
                    <label for="ch1">Structure</label>
                    <input type="checkbox" name="ch2" id="ch2"<?php if ($chopt[1]==1) echo "checked='checked'"; ?>/>
                    <label for="ch2">Photo</label>
                    <input type="checkbox" name="ch3" id="ch3"<?php if ($chopt[2]==1) echo "checked='checked'"; ?>/>
                    <label for="ch3">Progress</label> &nbsp; &nbsp;&nbsp;   
                    <label>Road to View</label>                								
                            <select name="prog" id="prog" onchange="javascript:mapopt(1)";>
                            <option <?php if($chopt[3]==0){?>selected<?php }?>>Selected</option>
                            <option <?php if($chopt[3]==1){?>selected<?php }?>>All</option>                  
                            <?php $i=2;foreach ($get_tranche as $road):?>
                                <option <?php if($chopt[3]==$i){ ?>selected<?php }?>><?=$road->tranche?></option> 
                            <?php $i=$i+1; endforeach ?>							
                            </select>
                        
                    <input type="hidden" name="mapoption" id="mapoption" value=<?=$mapoption?>>	 &nbsp;&nbsp;
                    <a href="<?php echo base_url('index.php/Stripplan');?>" class="btn btn-success btn-sm" ><i class="fa fa-credit-card" title="Strip Plan" style='color:brown'></i>Strip Plan</a>&nbsp;&nbsp;
                    <a href="#Progress" class="btn btn-success btn-sm" data-toggle="modal"><i class="fa fa-columns" title="All Activity" style='color:blue'></i>Progress %</a> &nbsp;&nbsp;
                    <a href="#Lineitem" class="btn btn-success btn-sm" data-toggle="modal"><i class="fa fa-list" title="Line Item Progress" style='color:blue'></i>Linear progess %</a> &nbsp;&nbsp;
                    <a href="#pointitem" class="btn btn-success btn-sm" data-toggle="modal"><i class="fa fa-industry" title="Point Item Progress" style='color:pink'>Point Progress %</i></a> &nbsp;&nbsp;
                    <a href="#Stageitem" class="btn btn-success btn-sm" data-toggle="modal"><i class='fa fa-file' title="Stage Item Progress" style='color:yellow;'>Stage Progress %</i></a> &nbsp;&nbsp;                   
                    <a href="<?php echo base_url('index.php/Dashboard');?>" class="btn btn-success btn-sm" >Exit<i class="fa fa-times-circle" title="Dashboard" ></i></a> 
                    <h4 >Road Name :<?=$this->session->userdata('roadname');?> </h4>
              
            </div>  
        </div>  
        <div class="card-body" style="height:100vh" >
            <div class="border border-primary" id="osmMapbig" style="width:100%;height:100%;"></div>
            <script>  const culvert='<?php echo base_url();?>assets/img/culvert.png'; </script> 
            <script> const junction='<?php echo base_url();?>assets/img/junction.png'; </script> 
            <script> const general='<?php echo base_url();?>assets/img/avatar.png'; </script>
            <script> const picture='<?php echo base_url();?>assets/img/image.png'; </script>
            <script> const picpath='<?php echo base_url();?>assets/photo/'; </script>                 
            <script  src="<?php echo base_url();?>assets/js/bigmap.js"></script>    
            <script>   
                <?php  foreach ($rall as $kml) : ?>                  
                    var z ='<?=$kml->descrip?>';
                    var n ='<?=$kml->rname?>';
                    var y=z.split('::');                            
                    for (var j=0;j<y.length;j++) {  //y= multi section array
                        var lat1=0;
                        var lat2=0;
                        var lng1=0;
                        var lng2=0;
                        var x = y[j].split(' ');  //x= coordinate array                              
                        var cor=[] ;
                        var completed=[];    
                        var f=x[0].split(','); // f = x,y,z coordinate
                        lat1=f[1];
                        lng1=f[0]; 
                        var ch=0;
                        var altype=0;
                        var plotaln=0;  
                        var secchf=0;
                        var seccht=0;
                       
                        for (var i=1;i<x.length-1;i++) {   
                            var p=x[i].split(',');
                            lat2=p[1];
                            lng2=p[0];                            
                            <?php if ($chopt[2]==1){ ?>  
                                var nlength=get_distance_all(lat1,lat2,lng1,lng2);                                                                                                          
                                ch= ch + nlength;
                                altype=2;
                                <?php foreach ($Compchlist as $kml) : ?>
                                    var stch ='<?=$kml->fromch?>';
                                    var toch ='<?=$kml->toch?>';                                                     
                                    if (ch<=toch*1000 && ch>=stch*1000) {                                       
                                        altype=1;secchf=stch; if(seccht<toch){seccht=toch;}                                      
                                       var d1=ch-stch*1000; 
                                       var d2=nlength-d1;    
                                       var x0=(d2*lat1+d1*lat2)/nlength;
                                       var y0=(d2*lng1+d1*lng2)/nlength;
                                    }                                
                                <?php endforeach ?>  
                                
                                if(plotaln==0){plotaln=altype;}
                                if (altype==1 && plotaln==altype){
                                    if(completed.length ==0){ completed.push([lat1,lng1]);}   
                                    if(plotaln==altype){completed.push([lat2,lng2]);}else{completed.push([x0,y0]);}
                                    }else{
                                    if(cor.length ==0){ cor.push([lat1,lng1]);}    
                                    cor.push([lat2,lng2]); 
                                }
                                
                                if(plotaln!=altype){                                      
                                    if(plotaln==1){                               
                                        draw_polylineall(completed,"Completed("+ secchf+"-"+seccht +")",'blue');
                                        plotaln=2;
                                        cor=[];
                                       cor.push([lat1,lng1]);
                                    }else{                                                
                                        draw_polylineall(cor,n,'red');
                                        plotaln=1;
                                        seccht=0;
                                        completed=[];
                                        completed.push([lat2,lng2]);
                                    }
                                }
                                lat1=lat2;
                                lng1=lng2;  
                            <?php } else{ ?> 
                                if(cor.length >0) {cor.push([lat2,lng2]);}else{cor.push([lat1,lng1]);}
                            <?php } ?>     
                        } 
                        if(cor.length >0) {draw_polylineall(cor,n,'red');}
                        if(completed.length >0) {draw_polylineall(completed,"Completed ("+ secchf+"-"+seccht +")",'blue');} 
                    }
                        
                <?php endforeach ?>   
                <?php if ($chopt[0]==1){ ?>
                        // alert("structure ticked");
                    var stcor=[] ; 
                    var details=[] ; 
                    <?php foreach ($sall as $str) :?>
                        var latlng ='<?=$str->latlng?>';
                        var sdetail='<?=$str->chainage.':'.$str->itemsize.':'.$str->progress?>';
                        var p=latlng.split(','); 
                        stcor.push([p[0],p[1]]);
                        details.push([sdetail]);
                    <?php endforeach ?>   
                    place_structureall(stcor,details); 
                <?php } ?>  
                <?php if ($chopt[1]==1){ ?>
                    //  alert("images ticked");
                    var stcor=[] ; 
                    var details=[] ; 
                    var pname=[] ; 
                    <?php foreach ($iall as $str) :?>
                        var latlng ='<?=$str->latlng?>';
                        var sdetail='<?=$str->descrip?>';
                        var mpath='<?=$str->pname?>';
                        var p=latlng.split(','); 
                        stcor.push([p[0],p[1]]);
                        details.push([sdetail]);
                        pname.push([mpath]); 
                    <?php endforeach ?>   
                    place_imagesall(stcor,details,pname); 
                <?php } ?>    
            </script>                
        </div>
    </div>
    <div class="modal fade" id="Progress">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">                        
                    <div> 
                     <h5>Physical Progress details</h5>
                     <h6>ROAD NAME:<?=$this->session->userdata('roadname')?></h6> 
                    </div> 
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                    </button>
                </div>
         		  
                <div class=col-md-12 style="overflow-x: auto">
                    <table class="table table-hover table-bordered" id="example5">                       
                        <thead style="background-color: #464b58; color:white;">
						<tr>
							<td>#</td>
							<td>Item</td>
							<td>Scope</td>
							<td>Completed</td>
                            <td>Progress (%)</td>
							<td>Weightage (%)</td>
						</tr></thead>
                        <tbody >                      
                        <?php $tprog=0;$no=0; foreach ($viewprogress as $m) : $no++;?>
						<tr>
							<td><?=$no?></td>							
							<td><?=$m->name?></td>	
							<td><?=$m->scope?></td>	
							<td><?=$m->prog?></td>	
                            <td><?=Round($m->prog/$m->scope*100,2)?></td>			
							<td><?=$m->Per?></td>
						</tr>
						<?php $tprog=$tprog+$m->Per; endforeach ?>
                        <?php  if ($tprog>0){ ?>                       
                        <tr align="Right">	
                            <td colspan="3" ><span style="font-weight:bold">Total Physical progress in terms of Weightage % =</span></td>
                            <td colspan="3" ><span style="font-weight:bold"><?=round($tprog,3)?></span></td>							 
                        </tr>	
                        <?php  
                            }        
                            ?>
                        </tbody>
                    </table>
                </div>	               
            </div>			
        </div>
	</div> 
    <div class="modal fade" id="Lineitem">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">                        
                    <div> 
                     <h5>Physical Progress details(Line Item)</h5>
                     <h6>ROAD NAME:<?=$this->session->userdata('roadname')?></h6> 
                    </div> 
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                    </button>
                </div>
         		  
                <div class=col-md-12 style="overflow-x: auto">
                    <table class="table table-hover table-bordered" id="example5">                       
                        <thead style="background-color: #464b58; color:white;">
						<tr>
							<td>#</td>
							<td>Item</td>
							<td>Scope</td>
							<td>Completed</td>
                            <td>Progress (%)</td>
							<td>Weightage (%)</td>
						</tr></thead>
                        <tbody >                      
                        <?php $tprog=0;$no=0; foreach ($viewprogress as $m) : $no++;?>
						<tr>
                        <?php if($m->unit=='Km'){ ?>
							<td><?=$no?></td>							
							<td><?=$m->name?></td>	
							<td><?=$m->scope?></td>	
							<td><?=$m->prog?></td>	
                            <td><?=Round($m->prog/$m->scope*100,2)?></td>		
							<td><?=$m->Per?></td>
                        <?php $tprog=$tprog+$m->Per;} ?>
						</tr>
						<?php  endforeach ?>
                        <?php  if ($tprog>0){ ?>                       
                        <tr align="Right">	
                            <td colspan="3" ><span style="font-weight:bold">Total Physical progress in terms of Weightage % =</span></td>
                            <td colspan="3" ><span style="font-weight:bold"><?=round($tprog,3)?></span></td>							 
                        </tr>	
                        <?php  
                            }        
                            ?>
                        </tbody>
                    </table>
                </div>	               
            </div>			
        </div>
	</div> 
    <div class="modal fade" id="pointitem">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">                        
                    <div> 
                     <h5>Physical Progress details (Point Item)</h5>
                     <h6>ROAD NAME:<?=$this->session->userdata('roadname')?></h6> 
                    </div> 
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                    </button>
                </div>
         		  
                <div class=col-md-12 style="overflow-x: auto">
                    <table class="table table-hover table-bordered" id="example5">                       
                        <thead style="background-color: #464b58; color:white;">
						<tr>
							<td>#</td>
							<td>Item</td>
							<td>Scope</td>
							<td>Completed</td>
                            <td>Progress (%)</td>
							<td>Weightage (%)</td>
						</tr></thead>
                        <tbody >                      
                        <?php $tprog=0;$no=0; foreach ($viewprogress as $m) : $no++;?>
						<tr>
                        <?php if($m->unit=='No'){ ?>
							<td><?=$no?></td>							
							<td><?=$m->name?></td>	
							<td><?=$m->scope?></td>	
							<td><?=$m->prog?></td>	
                            <td><?=Round($m->prog/$m->scope*100,2)?></td>		
							<td><?=$m->Per?></td>
                            
                        <?php $tprog=$tprog+$m->Per;} ?>
						</tr>
						<?php  endforeach ?>
                        <?php  if ($tprog>0){ ?>                       
                        <tr align="Right">	
                            <td colspan="3" ><span style="font-weight:bold">Total Physical progress in terms of Weightage % =</span></td>
                            <td colspan="3" ><span style="font-weight:bold"><?=round($tprog,3)?></span></td>							 
                        </tr>	
                        <?php  
                            }        
                            ?>
                        </tbody>
                    </table>
                </div>	               
            </div>			
        </div>
	</div> 
    <div class="modal fade" id="Stageitem">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">                        
                    <div> 
                     <h5>Physical Progress details (Stage Item)</h5>
                     <h6>ROAD NAME:<?=$this->session->userdata('roadname')?></h6> 
                    </div> 
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                    </button>
                </div>
         		  
                <div class=col-md-12 style="overflow-x: auto">
                    <table class="table table-hover table-bordered" id="example5">                       
                        <thead style="background-color: #464b58; color:white;">
						<tr>
							<td>#</td>
							<td>Item</td>
							<td>Scope</td>
							<td>Completed</td>
                            <td>Progress (%)</td>
							<td>Weightage (%)</td>
						</tr></thead>
                        <tbody >                      
                        <?php $tprog=0;$no=0; foreach ($viewprogress as $m) : $no++;?>
						<tr>
                        <?php if($m->unit=='Stage'){ ?>
							<td><?=$no?></td>							
							<td><?=$m->name?></td>	
							<td><?=$m->scope?></td>	
							<td><?=$m->prog?></td>		
                            <td><?=Round($m->prog/$m->scope*100,2)?></td>	
							<td><?=$m->Per?></td>                            
                        <?php $tprog=$tprog+$m->Per;} ?>
						</tr>
						<?php  endforeach ?>
                        <?php  if ($tprog>0){ ?>                       
                        <tr align="Right">	
                            <td colspan="3" ><span style="font-weight:bold">Total Physical progress in terms of Weightage % =</span></td>
                            <td colspan="3" ><span style="font-weight:bold"><?=round($tprog,3)?></span></td>							 
                        </tr>	
                        <?php  
                            }        
                            ?>
                        </tbody>
                    </table>
                </div>	               
            </div>			
        </div>
	</div> 
</div>
<script type="text/javascript">
    $('input[name="ch1"]').change(function () {if (this.checked) {mapopt(10); }else{mapopt(11);}});
    $('input[name="ch2"]').change(function () {if (this.checked) {mapopt(20); }else{mapopt(21);}});
    $('input[name="ch3"]').change(function () {if (this.checked) {mapopt(30); }else{mapopt(31);}});
    $('input[name="ch3"]').change(function () {if (this.checked) {mapopt(30); }else{mapopt(31);}});
   
   function mapopt(a){  
    var setmapopt = document.getElementById("mapoption").value;
    var roption = document.getElementById("prog");
    var sv=setmapopt.split('::');
    var m1=sv[0];
    var m2=sv[1];
    var m3=sv[2]; 
    var m4=roption.selectedIndex; 
    var m5= roption.options[roption.selectedIndex].text;
    if(a==10){m1=1;}
    if(a==20){m2=1;}
    if(a==30){m3=1;}
    if(a==11){m1=0;}
    if(a==21){m2=0;}
    if(a==31){m3=0;}
    var setmapopt=m1+'::'+m2+'::'+m3+'::'+m4+'::'+ m5;    
    $("#mapoption").val(setmapopt);
   
    refress();
   }
   function refress(){
    var setmapopt = document.getElementById("mapoption").value;
    $.ajax({
        type:"post",
        url:"<?=base_url()?>index.php/Report/savemapoption/"+setmapopt,
        dataType:"Text",
        success:function(data){                    	
            location.reload();
           // alert(data);
           }
    });
   }
   
</script>
</body>  
</html>
