<header class="page-header">
  <div class="container-fluid">   
	<h2 class="text-center">Monthly Progress Report</h2>	
	<div class="d-flex h-100" > 
		<h4 class="no-margin-bottom">Report Type: <?=$this->session->userdata('reporttype');?></h4>		
		<div class="align-self-end ml-auto"> 
			<a href="<?=base_url('index.php/export_to_xl/exporttoxl')?>" onclick="return confirm('Are you sure to export it?')" class="btn btn-default btn-sm">Export to Excel</a>
		</div>
	</div>
	<h5 ><?=$this->session->userdata('subheading');?></h5>	
  </div>
</header>

<div class="table-agile-info">
	<div class="container-fluid">		
		<div class="card rounded-0 shadow">	
		<div class="card-body">		
			<div class=col-md-12 style="overflow-x: auto">
				<table class="table table-hover table-bordered  table-sm" id="example">					
					<thead style="background-color: #464b58; color:white;">
						<tr>    
							<td>#</td>
							<?php 
							 $mheader=explode(",",$this->session->userdata('mheader'));
							 $link=0;
							  for ($i=0;$i< count($mheader);$i++){
							?>
								<td><?= $mheader[$i]?></td>
							<?php  
							 }        
							?>
						</tr>
					</thead>
					<tbody >
						<?php if( strpos($this->session->userdata('fheader'),'TCS')) {$link=1;} ; $tprog=0;	 $fheader=explode(",",$this->session->userdata('fheader')); $myhead="-";$j=count($fheader)?>
						
						<?php $no=0; foreach ($Mydata as $data) : $no++;

						if(count($mheader)<>$j ){
							$k=$j-1;
							if ($myhead<>$data[$fheader[$k]]){ ?>	
							<tr align="center" >
							<td colspan="12" ><span style="font-weight:bold"><?=$data[$fheader[$k]]?></span></td>
							</tr>	
						<?php	}
					    $myhead=$data[$fheader[$k]]; }
						?>
						<tr>							
							<td><?=$no?></td>
							<?php 													
							  for ($i=0;$i< count($mheader);$i++){?>
							    <?php $mn=$fheader[$i];
									$cellval=$data[$mn];
									if($mn=='chainage'){$cellval=changein_chainage($data[$mn]);}
									if($mn=='name' && $link==1){?>
									<td><a href="#" onclick="showentrylist('<?=$data['item'].':'.$data[$fheader[$k]]?>')"><?=$cellval?></a></td> <?php  } else { ?>
								<td><?=$cellval;?></td>
							<?php  
							 } }       
							?>						
						</tr>

						<?php endforeach ?>
						<?php  if ($tprog>0){ ?>
						<tr align="Right">	
							<td colspan="6" ><span style="font-weight:bold">Total Physical progress in terms of % =</span></td>
							<td colspan="6" ><span style="font-weight:bold"><?=round($tprog,3)?></span></td>
							 
						</tr>	
						<?php  
							 }        
							?>
					</tbody>
				</table>
			</div>
		</div>
		</div>
		<div class="modal fade" id="Progress">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">                        
                    <div> 
                     <h5>Sectionwise data entry list</h5>
                     <h6>ROAD NAME:<?=$this->session->userdata('roadname')?></h6> 
                    </div> 
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                    </button>
                </div>
         		  
				<div class=col-md-12 style="overflow-x: auto">
					<table class="table table-hover table-bordered" id="example2">
					
					</table>
                </div>	               
            </div>			
        </div>
	</div> 


	</div>	
</div>
<script type="text/javascript">
function showentrylist(a) {   
	let tlength =0;
	let rlength =0;
	var table_data = '';

      $('#example2').empty();  
	        
      	$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Report/displayentry/"+a,
			dataType:"json",
			success:function(data){		
				var k = Object.keys(data).length;	
				//alert(data[0].phycode) ; 
				table_data += '<thead style="background-color: #464b58; color:white;">';
				table_data += '<tr>';
				table_data += '<td>Section ID</td>';							
				table_data += '<td>From Chainage</td>';
				table_data += '<td>To Chainage</td>';
				table_data += '<td>Length (Km.)</td>';	
				table_data += '<td>Entry Date</td>';
				table_data += '</tr></thead>';
				table_data += '<tbody style="background-color: white;">';				
				for (var i=0;i<k;i++){						
				table_data += '<tr>';
					table_data += '<td>' + data[i].phycode + '</td>';
					table_data += '<td>' + data[i].fromch + '</td>';
					table_data += '<td>' + data[i].toch + '</td>';
					table_data += '<td>' + data[i].qyt + '</td>';
					table_data += '<td>' + data[i].yrm + '</td>';
				table_data += '</tr>';
				tlength= tlength + Number(data[i].qyt);
				var lr= data[i].phycode;
				lr=lr.substring(a.length-3,a.length-2);
				//alert(lr);
				if (lr=='R'){rlength= rlength + Number(data[i].qyt);}
				}	
				
			
				table_data += '<tr>';
				table_data += '<td>' + 'Total Completed Length :'+ Math.round(tlength*100)/100 + '</td>';					
				table_data += '<td>' + 'Left side Length :'+ Math.round((tlength-rlength)*100)/100 + '</td>';
				table_data += '<td>' + 'Right side Length :'+ Math.round(rlength*100)/100 + '</td>';
					
				table_data += '</tr>';
				table_data += '</tbody>'; 		
				//alert(table_data) ; 
				$('#example2').append(table_data);
				$('#Progress').modal('show');
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