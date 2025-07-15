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
							  for ($i=0;$i< count($mheader);$i++){?>
								<td><?= $mheader[$i]?></td>
							<?php  
							 }        
							?>
						</tr>
					</thead>
					<tbody >
						<?php $tprog=0; $fheader=explode(",",$this->session->userdata('fheader')); $myhead="-";$j=count($fheader)?>
						<?php $no=0; foreach ($Mydata as $data) : $no++;
							$sn = explode(',',$data['stages']);
							$sname = explode(',',$data['stage']);
							$prog = explode(',',$data['status']);
							for ($j=0;$j<count($sn);$j++){
						?>
							<tr>							
								<td><?=$no?></td>
								<?php 							
								for ($i=0;$i< count($mheader);$i++){?>
									<?php $mn=$fheader[$i];
										$cellval=$data[$mn];
										if($mn=='chainage'){$cellval=changein_chainage($data[$mn]);}
										if($mn=='stages'){$cellval=$sname [$sn[$j]-1];}
										if($mn=='stage'){
											if( $sname [$sn[$j]-1]=='Foundation'){$cellval=$data['span']+1;}else{
												if( $sname [$sn[$j]-1]=='Span'){$cellval=$data['span'];}else{$cellval=1;}
											}
											$scope=$cellval;
										}
										if($mn=='status'){$cellval=$prog[$j];}
										
									?>
									<td><?=$cellval;?></td>
								<?php  
								}        
								?>						
							</tr>
							<?php  
								}        
							?>	
							
						<?php endforeach ?>
						<?php  if ($tprog>0){ ?>
						<tr align="Right">	
							<td colspan="6" ><span style="font-weight:bold">Total Physical progress in terms of % =</span></td>
							<td colspan="6" ><span style="font-weight:bold"><?=round($tprog,3)?></span></td>
							
						</tr>	
						<?php } ?>	
					</tbody>
				</table>
			</div>
		</div>
		</div>
	</div>	
</div>

<?php
function changein_chainage($a)
{	$b=(int)$a;
	$c=($a-$b)*1000; 
	$c=sprintf('%03d',$c);
	$d="Ch ".$b."+".$c;
	return$d;
}

?>