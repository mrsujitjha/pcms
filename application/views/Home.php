<!DOCTYPE html>  
<html>  
<head>  
</head>  
<body>   

<div class="container-fluid">    
    <?php if ($this->session->flashdata('message')!=null) {
		echo "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>"
			.$this->session->flashdata('message')."<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span>
			</button> </div>";
		} ?>
    <div class="row">
        <div class="card rounded-0 shadow" >   
            <div class="card-body">               
                <table class="table-responsive  table w-auto small table-bordered table-sm" style="width:100%;height:100%;overflow-y:auto" >                    
                    <thead style="background-color: #464b58; color:white;">
                        <tr>	
                            <td>#</td> 
                            <td>Project/Scheme</td>  
                            <td>Total Package</td> 
                            <td>Total Roads</td> 
                            <td>Total Cost</td>  
                            <td>Total length</td>
                            <td>Completed length</td>		
                            <td>Physical Progress %</td>
                            <td>Financial Progress %</td>
                            <td>Completed Package</td>
                            <td>Completed Roads</td>
                        </tr>
                    </thead>
                    <tbody >
                        <?php $no=0; foreach ($overallprogress as $project) : $no++;?>                
                        <tr  data-toggle="collapse" data-target="#d<?=$no?>" class="accordion-toggle"> 
                            <td><button class="btn btn-info btn-sm"  onclick="changesign(<?=$no?>)"><span id="sp<?=$no?>">+</span></button></td>  
                            <td><?=$project->tranche?></td>                                                 							
                            <td><?=$project->pn?></td>	
                            <td><?=$project->rn?></td>	
                            <td><?=$project->acost?></td>	
                            <td><?=$project->T?></td>	
                            <td><?=$project->L?></td>	
                            <td><?=$project->P?></td>	                  	
                            <td><?=$project->F?></td>
                            <td><?=$project->CP?></td>	
                            <td><?=$project->CR?></td>		
                        </tr> 
                        <tr>
                            <td colspan="12" >
                                <div class="accordian-body collapse" id="d<?=$no?>" > 
                                    <table class="table table-striped">
                                        <thead style="background-color: #464b58; color:white;">
                                            <tr class="info">  
                                                <td>#</td>     
                                                <td>Package</td>                                                    
                                                <td>Road Name</td>	
                                                <td>Awarded cost</td>                        
                                                <td>Awarded Length</td>
                                                <td>Completed Length</td>  
                                                <td>Physical Progress (%)</td>
                                                <td>Financial Progress (%)</td>
                                                <td>View Milestone</td>  
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $pk=0; foreach ( $pkg_progress as $pkgpro ) : $pk++;?>
                                        <?php if ( $project->tranche==$pkgpro->tranche) { 
                                        if($pkgpro->tn==1) {  ?>
                                        <tr>
                                            <td> <?=$pk?></td>                                                               
                                            <td> <?=$pkgpro->pkg?></td>
                                            <td><a href="#" onclick="refreshdata('<?=$pkgpro->rid.':'.$pkgpro->sc?>')"><?=$pkgpro->rname?></a></td>                                               							
                                            <td><?=$pkgpro->acost?></td>	
                                            <td><?=$pkgpro->rlength?></td>	
                                            <td><?=$pkgpro->cl?></td>	
                                            <td><?=$pkgpro->pp?></td>	                  	
                                            <td><?=$pkgpro->fp?></td>	
                                            <td><a href="#milestone" onclick="milestone('<?=$pkgpro->pkgsn?>')" class="btn btn-primary btn-sm rounded-0" data-toggle="modal"><i class="fa fa-calendar"></i></a> </td>
                                        </tr> 
                                        <?php } else {?>  
                                        <tr  data-toggle="collapse" data-target="#p<?=$pk?>" class="accordion-toggle">  
                                                <td><button class="btn btn-warning btn-sm"  onclick="changesign2(<?=$pk?>)"><span id="pk<?=$pk?>">+</span></button></td>  
                        
                                            <td> <?=$pkgpro->pkg?></td>
                                            <td> Number of Roads in Package are = <?=$pkgpro->tn?></td>                                    
                                            <td><?=$pkgpro->acost?></td>	
                                            <td><?=$pkgpro->rlength?></td>	
                                            <td><?=$pkgpro->cl?></td>	
                                            <td><?=$pkgpro->pp?></td>	                  	
                                            <td><?=$pkgpro->fp?></td>	
                                            <td><a href="#milestone" onclick="milestone('<?=$pkgpro->pkgsn?>')" class="btn btn-primary btn-sm rounded-0" data-toggle="modal"><i class="fa fa-calendar"></i></a> </td>
                            
                                        </tr>                                 
                                        <tr>
                                            <td colspan="12" >
                                                <div class="accordian-body collapse" id="p<?=$pk?>" > 
                                                    <table class="table table-striped">
                                                        <thead style="background-color: #464b58; color:white;">
                                                            <tr class="rinfo">                                                       
                                                                <td>Road Name</td>	   
                                                                <td>Awarded cost</td>                            
                                                                <td>Awarded Length</td>
                                                                <td>Completed Length</td>  
                                                                <td>Physical Progress (%)</td>
                                                                <td>Financial Progress (%)</td> 
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach ($road_progress as $rpro) :?>
                                                        <?php if($pkgpro->pkg==$rpro->pkg) { ?>
                                                            <tr>                                                                                    
                                                                <td><a href="#" onclick="refreshdata('<?=$rpro->rid.':'.$rpro->sc?>')"><?=$rpro->rname?></a></td>                                                  							
                                                                <td><?=$rpro->acost?></td>	
                                                                <td><?=$rpro->rlength?></td>	
                                                                <td><?=$rpro->cl?></td>	
                                                                <td><?=$rpro->pp?></td>	                  	
                                                                <td><?=$rpro->fp?></td>	
                                                            </tr>
                                                        <?php } ?>    
                                                        <?php  endforeach ?>
                                                        </tbody> 
                                                    </table>             
                                                </div> 
                                            </td>	      
                                        </tr>                                
                                        <?php } } ?>                                   
                                        <?php  endforeach ?>
                                        </tbody> 
                                    </table>             
                                </div> 
                            </td>	      
                        </tr>               
                        <?php endforeach ?>               
                    </tbody>                           
                </table>         
            </div>
        </div>  
    </div>   
    <div class="row">  
        <div class="col-sm-6">
            <div  class="card rounded-0 shadow" >
            <div class="card-header">
            <h5 class="card-title">
            <a href="#Progress" data-toggle="modal"><i class="fa fa-list" title="Line Item Progress" style='color:blue'></i></a> 
            Overall Progress (%) Of Major Items </h5>
            </div>               
                <div class="card-body">                   
                <canvas id="myChart"  height="200"></canvas>
                </div>
            </div>  
        </div>
        <div class="col-sm-6">
            <div  class="card rounded-0 shadow" >
            <div class="card-header">    
             <h5 class="card-title"  style="margin-left: 20px;">    
                <?php  $mauth=$this->session->userdata('autho') ;if (strpos($mauth,'280')>-1)  { ?>
                <span class="left-icon position-absolute" style="left: 0;margin-left: 10px">
                <a href="#newmessage" data-toggle="modal"><i class="fa fa-bell" title="Message" style='color:red'></i></a> 
                </span>
                <span class="right-icon position-absolute" style="right: 0;margin-right: 10px">
                    <a href="#Progress_entry" data-toggle="modal"><i class="fa fa-calendar" title="Progress" style='color:Green'></i></a> 
                </span>
               
                <?php }?> Plan V/S Achievement Till Date</h5>  
        </div>     
                <div class="card-body">  
                <canvas id="pvsachart"  height="200"></canvas>
                </div>
            </div>  
        </div> 
      
    </div>  
    <div class="modal fade" id="Progress">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">                        
                    <div> 
                     <h5> Overall Progress Of Major Items</h5>                    
                    </div> 
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                    </button>
                </div>
                <table class="table-responsive  table w-auto small table-bordered table-sm" style="width:100%;height:100%;overflow-y:auto" >                    
                <thead style="background-color: #464b58; color:white;">
                    <tr>
                        <td>Item</td>
                        <td>Scope</td>
                        <td>Completed</td>
                        <td>Unit</td>
                        <td>Progress %</td>
                    </tr></thead>
                    <tbody >                      
                    <?php foreach ($viewprogress as $m) :?>
                    <tr>												
                        <td><?=$m->name?></td>	
                        <td><?=$m->s?></td>	
                        <td><?=$m->p?></td>	 
                        <td><?=$m->unit?></td>
                        <td><?=round($m->p/$m->s*100,2)?></td>	                         
                    </tr>
                    <?php  endforeach ?>                        
                    </tbody>
                </table>  
            </div>			
        </div>
	</div> 
    <div class="modal fade" id="newmessage">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">                        
                    <div> 
                     <h5> Message</h5>                    
                    </div> 
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                    </button>
                </div>
                <table class="table-responsive  table w-auto small table-bordered table-sm" style="width:100%;height:100%;overflow-y:auto" >                    
                <thead style="background-color: #464b58; color:white;">
                    <tr>
                        <td>Package</td>
                        <td>Milestone</td>
                        <td>Planned Date</td>
                        <td>Acheived date</td>
                        <td>Planned Progress %</td>
                        <td>Acheived Progress %</td>
                        <td>Message</td>
                    </tr></thead>
                    <tbody >                      
                    <?php $pkg=$this->session->userdata('pkglist');
                    foreach ($popupmessage as $m) :
                    if((strpos($pkg ,$m->pkg)>-1) || $pkg==''){
                    ?>
                    <tr>												
                        <td><?=$m->pkg?></td>	
                        <td><?=$m->milestone?></td>	
                        <td><?=$m->tdate?></td>	 
                        <td><?=$m->adate?></td>
                        <td><?=$m->per?></td>
                        <td><?=$m->c?></td>	 
                        <?php  
                        $msg ='';
                        $mdate= (substr($m->tdate,6,4)*100+substr($m->tdate,3,2))*100+substr($m->tdate,0,2);
                        $cdate= (date("Y")*100+date("m"))*100+date("d");
                        if(strlen($m->adate)==10){$msg="Project data entry is missing.";}
                        if($m->per <= $m->c && strlen($m->adate)!=10){$msg="Milestone complition date is missing.";}
                        if($cdate >$mdate && strlen($m->adate)!=10 && $msg==''){$msg="Milestone EOT date is missing.";}
                        ?>   
                         <td><?=$msg?></td>	                   
                    </tr>
                    <?php } endforeach ?>                        
                    </tbody>
                </table>  
            </div>			
        </div>
	</div> 
     <div class="modal fade" id="Progress_entry">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">                        
                    <div> 
                     <h5> Progress Entry Month</h5>                    
                    </div> 
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                    </button>
                </div>
                <table class="table-responsive  table w-auto small table-bordered table-sm" style="width:100%;height:100%;overflow-y:auto" >                    
                <thead style="background-color: #464b58; color:white;">
                    <tr>
                        <td>Road ID</td>
                        <td>Road Name</td>
                        <td>Schedule Item </td>
                        <td>Stage Item</td>
                        <td>TCS </td>
                    </tr></thead>
                    <tbody >                      
                    <?php foreach ($latestentry as $m) : ?>
                    <tr>												
                        <td><?=$m->rid?></td>	
                        <td><?=$m->rname?></td>	
                        <td><?= substr($m->t1, 0, 4) . '-' . substr($m->t1, 4, 2) ?></td>
                        <td><?= substr($m->t2, 0, 4) . '-' . substr($m->t2, 4, 2) ?></td>
                        <td><?= substr($m->t3, 0, 4) . '-' . substr($m->t3, 4, 2) ?></td> 
                    </tr>
                    <?php  endforeach ?>                        
                    </tbody>
                </table>  
            </div>			
        </div>
	</div> 
    <div class="modal fade" id="milestone">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					Project Milestone Status
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
					<div class="modal-body">		
						<div class="form-group row">
							<div class="col-sm-3 "><label>Milestones</label></div>
							<div class="col-sm-3 "><label>TARGET PROGRESS</label></div>
							<div class="col-sm-3 "><label>PLANNED DATE</label></div>
							<div class="col-sm-3 "><label>ACHEIVED DATE</label></div>
						</div>	
						<div class="form-group row">
							<div class="col-sm-3"><label>Milestone-1</label></div>
							<div class="col-sm-3">
								<input type="text" id="pd1" name="pd1"  class="form-control">
							</div>								
							<div class="col-sm-3">
								<input type="text" id="dd1" name="dd1"   class="form-control">
							</div>
							<div class="col-sm-3">
								<input type="text" id="ed1" name="ed1" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3"><label>Milestone-2</label></div>
							<div class="col-sm-3">
								<input type="text" id="pd2" name="pd2"    class="form-control">
							</div>											
							<div class="col-sm-3">
								<input type="text" id="dd2" name="dd2"    class="form-control">
							</div>
							<div class="col-sm-3">
								<input type="text" id="ed2" name="ed2"    class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3"><label>Milestone-3</label></div>
							<div class="col-sm-3">
								<input type="text" id="pd3" name="pd3"  class="form-control">
							</div>											
							<div class="col-sm-3">
								<input type="text" id="dd3" name="dd3"   class="form-control">
							</div>
							<div class="col-sm-3">
								<input type="text" id="ed3" name="ed3"  class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 "><label>Milestone-4</label></div>
							<div class="col-sm-3">
								<input type="text" id="pd4" name="pd4"    class="form-control">
							</div>										
							<div class="col-sm-3">
								<input type="text" id="dd4" name="dd4"   class="form-control">
							</div>
							<div class="col-sm-3">
								<input type="text" id="ed4" name="ed4"    class="form-control">
							</div>
						</div>
						
					</div>		
			</div>			
		</div>
	</div>	
</div>                
<script type="text/javascript">
   display_chart1();
   display_chart2();              
    function refreshdata(a) {                 
        $.ajax({
            type:"post",
            url:"<?=base_url()?>index.php/Report/show_strip/"+a,
            dataType:"Text",
            success:function(data){  
              window.location.href = '<?php echo base_url('index.php/Pkgdashboard');?>';
            }});
        }      
    function changesign(a) {      
            var mspan = document.getElementById("sp"+a);
            var x=mspan.textContent;    
           if (x=='+'){mspan.textContent="-";}else{mspan.textContent="+";}
        }
    function changesign2(a) {      
            var mspan = document.getElementById("pk"+a);
            var x=mspan.textContent;    
           if (x=='+'){mspan.textContent="-";}else{mspan.textContent="+";}
        }
    function display_chart1() {     
        var vitem="";
        var pper="";
        //generate random color= '#' + Math.random().toString(16).substr(-6) 
        var bgcolor=""; 
        var linecolor="";       
        <?php foreach ($viewprogress as $m) :?>	
            if(vitem=="") {vitem ='<?=$m->name?>' + '(' + '<?=$m->unit?>'+')';} else { vitem = vitem + ':' + '<?=$m->name?>' + '(' + '<?=$m->unit?>'+')';}
            if(pper=="") {pper ='<?=round($m->p/$m->s*100,2)?>';} else { pper = pper + ':' + '<?=round($m->p/$m->s*100,2)?>';}
            var rgb = [Math.random() * 255, Math.random() * 256, Math.random() * 256];
            if(bgcolor=="") {bgcolor='rgba('+ rgb +',0.3)';}else{bgcolor = bgcolor + ':' + 'rgba('+ rgb +',0.3)';}
            if(linecolor=="") {linecolor='rgba('+ rgb +',1)';}else{linecolor = linecolor + ':' + 'rgba('+ rgb +',1)';}
        <?php endforeach ?>	  
        var ctx = document.getElementById('myChart').getContext('2d');
        var xValues =vitem.split(":");
        var yValues =pper.split(":");
        var barColorsbg = bgcolor.split(":");
        var barColors = linecolor.split(":"); 
         var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: xValues,
            datasets: [{
                data: yValues,
                backgroundColor:barColorsbg,
                borderColor:barColors,
                borderWidth: 1
            }]
        },
            options: {
                legend: {display: false},        
                scales: {yAxes: [{ticks: {beginAtZero: true}}]},
                title: { display: false, text: ""}
            }
        });
    }

    function display_chart2() {     
        var vitem="";
        var aper="";
        var pper="";
        //generate random color= '#' + Math.random().toString(16).substr(-6) 
        var bgplan=""; 
        var bgacheive=""; 
        var linecolor=""; 
        var rgb = [Math.random() * 255, Math.random() * 256, Math.random() * 256];
        var rgb1 = [Math.random() * 255, Math.random() * 256, Math.random() * 256];
        <?php foreach ($overallprogress as $m) :?>	
            if(vitem=="") {vitem ='<?=$m->tranche?>' ;} else { vitem = vitem + ':'+ '<?=$m->tranche?>';}
            if(aper=="") {aper ='<?=$m->P?>';} else { aper = aper + ':' + '<?=$m->P?>';}
            if(pper=="") {pper ='<?=$m->yc?>';} else { pper = pper + ':' + '<?=$m->yc?>';}
           
            if(bgplan=="") {bgplan='rgba('+ rgb +',0.3)';}else{bgplan = bgplan + ':' + 'rgba('+ rgb +',0.3)';}
            if(bgacheive=="") {bgacheive='rgba('+ rgb1 +',0.5)';}else{bgacheive = bgacheive + ':' + 'rgba('+ rgb1 +',0.5)';}
            if(linecolor=="") {linecolor='rgba('+ rgb +',1)';}else{linecolor = linecolor + ':' + 'rgba('+ rgb +',1)';}

        <?php endforeach ?>	  
        var ctx = document.getElementById('pvsachart').getContext('2d');
        var xValues =vitem.split(":");
        var yacheive =aper.split(":");
        var yplan =pper.split(":");
        var barColorsbgp = bgplan.split(":");
        var barColorsbga = bgacheive.split(":");
        var barColors = linecolor.split(":"); 
        var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: xValues,
            datasets: [
            {
            label: 'Acheived',
            data: yacheive,
            backgroundColor:barColorsbga,
            borderColor:barColors,
            borderWidth: 1
            },
            {
            label: 'Planned',
            data: yplan,
            backgroundColor:barColorsbgp,
            borderColor:barColors,
            borderWidth: 1
            }
        ]
        },
            options: {
                legend: {display: true},        
                scales: {yAxes: [{ticks: {beginAtZero: true}}]},
                title: { display: false, text: ""}
            }
        });
    }
    function milestone(a) {		
		var b =a.split(":");
		var eotd=b[2];
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Project/load_completedmilestone/"+b[0],// all milestone
			dataType:"json",
			success:function(data){					
				$("#pd1").val(data[0].per);
				$("#dd1").val(data[0].tdate);
				$("#ed1").val(data[0].adate);	
				$("#pd2").val(data[1].per);
				$("#dd2").val(data[1].tdate);
				$("#ed2").val(data[1].adate);
				$("#pd3").val(data[2].per);
				$("#dd3").val(data[2].tdate);
				$("#ed3").val(data[2].adate);
				$("#pd4").val(data[3].per);
				$("#dd4").val(data[3].tdate);
				$("#ed4").val(data[3].adate);
			}
		});		
	}
</script>
</body>  
</html>
