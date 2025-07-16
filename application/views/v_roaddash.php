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
    <?php if ($this->session->flashdata('message')!=null) {
		echo "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>"
			.$this->session->flashdata('message')."<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span>
			</button> </div>";
		} ?>
    <div class="row" > 
        <div class="col-sm-12">
            <div class="card text-center"> 
                <div class="card-header">
                    <h3> <p class="text-primary">ROAD NAME:<?=$this->session->userdata('roadname')?></p></h3>
                </div> 
            </div> 
        </div> 
    </div>                 
    <div class="row">      
        <div class="col-sm-3">
            <div class="card rounded-0 shadow" style="height:6vh">  
            <?php $p=0;$s=0;foreach ($plantation as $m) :
            if ($p<$m->planted){$p=$m->planted;} 
            if ($s<$m->survival){$s=$m->survival;} 
           endforeach ?> 
            <a href="#Plantation"  class="btn btn-success" data-toggle="modal">Plantation status ( <?=$p.'/'.$s ?>  )</a>
            </div>      
        </div>  
        <div class="col-sm-3">
            <div class="card rounded-0 shadow" style="height:6vh">                                 
            <a href="#Progress"  class="btn btn-default" data-toggle="modal">Progress</a>
            </div>      
        </div>  
        <div class="col-sm-3">
            <div class="card rounded-0 shadow" style="height:6vh"> 
                <a href="#Payment"  class="btn btn-info" data-toggle="modal">Payment</a>
            </div>      
        </div>  
        <div class="col-sm-3">
            <div class="card rounded-0 shadow" style="height:6vh">                
                    <a href="<?php echo base_url('index.php/Stripplan');?>"  class="btn btn-danger"  >View Strip Plan</a>
            </div>      
        </div>  
    </div>              
    <div class="row">       
        <div class="col-sm-8">
            <div class="card rounded-0 shadow" style="height:70vh">  
            
            <div class="card-body">
                    <div class="border border-secondary"  id="mapcontrol" style="width:100%;height:20px;background-color:lightblue;">
                    
                        <?php if ($this->session->userdata('mapoption')!=null){$mapoption=$this->session->userdata('mapoption');}else{$mapoption='0::0::0::0::Selected';}
                        $chopt=explode('::', $mapoption);
                        ?> 
                            <input type="checkbox" name="ch1" id="ch1"<?php if ($chopt[0]==1) echo "checked='checked'"; ?>/>
                            <label for="ch1"><h6>Structure</h6></label>
                            <input type="checkbox" name="ch2" id="ch2"<?php if ($chopt[1]==1) echo "checked='checked'"; ?>/>
                            <label for="ch2"><h6>Photo</h6></label>
                            <input type="checkbox" name="ch3" id="ch3"<?php if ($chopt[2]==1) echo "checked='checked'"; ?>/>
                            <label for="ch3"><h6>Progress</h6></label> &nbsp; 
                            <input type="hidden" name="mapoption" id="mapoption" value=<?=$mapoption?>>                        
                    </div> 
                    <div class="border border-primary" id="osmMap" style="width:100%;height:98%;"></div>
                    <script> const culvert='<?php echo base_url();?>assets/img/culvert.png'; </script> 
                    <script> const junction='<?php echo base_url();?>assets/img/junction.png'; </script> 
                    <script> const general='<?php echo base_url();?>assets/img/avatar.png'; </script>
                    <script> const picture='<?php echo base_url();?>assets/img/image.png'; </script>
                    <script> const zicon='<?php echo base_url();?>assets/img/fs.png'; </script>
                     
                    <script> const picpath='<?php echo base_url();?>assets/photo/'; </script>  
                    <script> const fullmap='<?php echo base_url('index.php/Mapfull');?>'; </script>   
                    <script> const dashboard='<?php echo base_url('index.php/Dashboard');?>'; </script>      
                    <script  src="<?php echo base_url();?>assets/js/map.js"></script> 
                    <script>                
                        <?php foreach ($road_alignment as $kml) : ?>
                            var z ='<?=$kml->descrip?>';
                            var n ='<?=$kml->rname?>';
                            var y=z.split('::');                            
                            for (var j=0;j<y.length;j++) {  
                                var lat1=0;
                                var lat2=0;
                                var lng1=0;
                                var lng2=0;
                                var x = y[j].split(' ');                                
                                var cor=[] ;
                                var completed=[];    
                                var f=x[0].split(','); 
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
                                        var nlength=get_distance(lat1,lat2,lng1,lng2);                                                                                                          
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
                                                draw_polyline(completed,"Completed ("+ secchf+"-"+seccht +")",'blue');
                                                plotaln=2;
                                                cor=[];
                                                cor.push([lat1,lng1]);
                                            }else{                                                
                                                draw_polyline(cor,n,'red');
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
                                if(cor.length >0) {draw_polyline(cor,n,'red');}
                                if(completed.length >0) {draw_polyline(completed,"Completed ("+ secchf+"-"+seccht +")",'blue');} 
                            }
                         localStorage.setItem("loadedkml", z);
                           
                        <?php endforeach ?>   
                        <?php if ($chopt[0]==1){ ?>
                            //   alert("structure ticked");
                            var stcor=[] ; 
                            var details=[] ; 
                            <?php  foreach ($road_structure as $str) :?>
                                var latlng ='<?=$str->latlng?>';
                                var sdetail='<?=$str->chainage.':'.$str->itemsize.':'.$str->progress?>';
                                var p=latlng.split(','); 
                                stcor.push([p[0],p[1]]);
                                details.push([sdetail]);
                            <?php endforeach ?>   
                            place_structure(stcor,details); 
                        <?php } ?>  
                        <?php if ($chopt[1]==1){ ?>
                            // alert("images ticked");
                            var stcor=[] ; 
                            var details=[] ; 
                            var pname=[] ; 
                            <?php foreach ($road_images as $str) :?>
                                var latlng ='<?=$str->latlng?>';
                                var sdetail='<?=$str->descrip?>';
                                var mpath='<?=$str->pname?>';
                                var p=latlng.split(','); 
                                stcor.push([p[0],p[1]]);
                                details.push([sdetail]);
                                pname.push([mpath]); 
                            <?php endforeach ?>   
                            place_images(stcor,details,pname); 
                        <?php } ?>    
                    </script>
                </div>
            </div> 
        </div> 
        <div class="col-sm-4">
            <div class="card rounded-0 shadow" style="height:70vh">                  
            <?php $a=count($get_hindlist); if ($a>0){$b='Hindrance in Selected Road';}else{$b='No Hindrance in Selected Road';} ?>
                <div class="card-header">  
                 <h5><?=$b?></h5>
                </div>    

                <div class="card-body">  
                    <div class=col-md-12  style="height:60vh">
                    <?php  if ($a>0){ ?>
                        <table class="table-responsive  table w-auto small table-bordered table-sm" style="width:100%;height:100%;overflow-y:auto" >                    
                            <thead style="background-color: #464b58; color:white;">
                                <tr>
                                    <td>#</td>
                                    <td>Description</td>
                                    <td>Location</td>                               
                                    <td>Remarks</td>
                                </tr></thead>
                                <tbody style="background-color: white;">
                                <?php $no=0; foreach ($get_hindlist as $mhind) : $no++;?>
                                <tr>
                                    <td><?=$no?></td>							
                                    <td><?=$mhind->descrip?></td>	
                                    <td><?=$mhind->location?></td>		
                                    <td><?=$mhind->Rem?></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php  } ?>
                    </div>	
                </div>    
            </div>                      
         </div>    
    </div>        
    
    <div class="modal fade" id="Payment" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">                        
                <div> 
                    <h5>Payment in Selected Road</h5>
                    <h6>Package ID:<?=$this->session->userdata('pkgid')?></h6> 
                    <h7>Road name:<?=$this->session->userdata('roadname')?></h7> 
                </div> 
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                    </button>
                </div>
             
                <div class=col-md-12 style="overflow-x: auto">
                    <table class="table table-hover table-bordered" id="example4">
                    <thead style="background-color: #464b58; color:white;">
						<tr>
							<td>#</td>
							<td>Date of Payment</td>
							<td>Description</td>
							<td>Amount (Cr)</td>
						</tr></thead>
					<tbody style="background-color: white;">
						<?php $n=$this->session->userdata('roadname');$tprog=0;$no=0; foreach ($get_Payment as $pay) : if ($n==$pay->rname){$no++; ?>
						<tr>
							<td><?=$no?></td>							
							<td><?=$pay->mdate?></td>
							<td><?=$pay->descrip?></td>	
							<td><?=$pay->amount?></td>
						</tr>
						<?php $tprog=$tprog+$pay->amount;
                        } endforeach ?>
                        <?php  if ($tprog>0){ ?>
						<tr align="Right">	
							<td colspan="2" ><span style="font-weight:bold">Total Payment =</span></td>
							<td colspan="3" ><span style="font-weight:bold"><?=round($tprog,3)?></span></td>							 
						</tr>	
                        <?php } ?>
					</tbody>
                    </table>
                </div>	
            </div>			
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
    <div class="modal fade" id="Plantation">
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
							<td>Date</td>
							<td>Total Plantation</td>
							<td>Survival</td>
						</tr></thead>
                        <tbody >                      
                        <?php $tprog=0;$no=0; foreach ($plantation as $m) : $no++;?>
						<tr>
							<td><?=$no?></td>							
							<td><?=substr($m->edate,0,4).'-'.substr($m->edate,4)?></td>	
							<td><?=$m->planted?></td>	
							<td><?=$m->survival?></td>	
						</tr>
						<?php endforeach ?>
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
    
   function mapopt(a){  
    var setmapopt = document.getElementById("mapoption").value;
    var sv=setmapopt.split('::');
    var m1=sv[0];
    var m2=sv[1];
    var m3=sv[2]; 
    if(a==10){m1=1;}
    if(a==20){m2=1;}
    if(a==30){m3=1;}
    if(a==11){m1=0;}
    if(a==21){m2=0;}
    if(a==31){m3=0;}
    var setmapopt=m1+'::'+m2+'::'+m3+'::0::Selected';    
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

<?php
function changein_chainage($a)
{	$b=(int)$a;
	$c=($a-$b)*1000; 
	$c=sprintf('%03d',$c);
	$d="Ch ".$b."+".$c;
	return$d;
}

?>

</body>  
</html>
