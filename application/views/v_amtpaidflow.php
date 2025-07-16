<header class="page-header">
  <div class="container-fluid">   
	<h2 class="text-center">Payment Flow status Report</h2>	
	<div class="d-flex h-100" > 
		<h4 class="no-margin-bottom">Report Type: <?=$this->session->userdata('reporttype');?></h4>		
		<div class="align-self-end ml-auto"> 
			<a href="<?=base_url('index.php/export_to_xl/exporttoxl/'.'M1')?>" onclick="return confirm('Are you sure to export it?')" class="btn btn-default btn-sm">Export to Excel</a>
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
							  for ($i=0;$i<count($mheader);$i++){?>
								<td><?= $mheader[$i]?></td>
							<?php  
							 }        
							?>
						</tr>
					</thead>
					<tbody >
						<?php $fheader=explode(",",$this->session->userdata('fheader'));?>					
						<?php $no=0;foreach ($Mydata as $data):$no++;?>
						<tr>							
							<td><?=$no?></td>
							<?php 
							  for ($i=0;$i<count($fheader);$i++){
								if($i==0){$a=$data[$fheader[$i]];}else{
									$a=$a.":".$data[$fheader[$i]];
								}
							  }	
								$h=explode(":",$a);								
								?>
								<td><?=$h[0]?></td>
								<td><a href="#display" onclick="mydisplay('<?=$h[1]?>')" class="btn btn-success btn-sm" data-toggle="modal"><?=$h[1]?></a></td>
								<?php 
								$k=(count($h)-2)/3;
							  for($j=0;$j<$k;$j++){$i=$j+2;?>								
								<td><?=$h[$i]?></td>
								<td><?=$h[$i+$k]?></td>
								<td><?=$h[$i+$k*2]?></td>
							<?php 
								}
							?>
							
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
		</div>
		<div class="modal fade" id="display">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						Invoce processing View
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

<?php
function changein_chainage($a)
{	$b=(int)$a;
	$c=($a-$b)*1000; 
	$c=sprintf('%03d',$c);
	$d="Ch ".$b."+".$c;
	return$d;
}

?>
<script type="text/javascript">
function mydisplay(c) {
		var table_data = '';
      $('#example2').empty();
		
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Financial/savesessionspcid/"+c,
			dataType:"json",
			success:function(data){	
				var k = Object.keys(data).length;	
				var toval="";			
				//alert(data[i].fincode);				
				table_data += '<thead style="background-color: #464b58; color:white;">';
				table_data += '<tr>';
				table_data += '<td>SPS/IPC ID</td>';							
				table_data += '<td>Date</td>';
				table_data += '<td>Description</td>';
				table_data += '<td>Amount (Cr.)</td>';	
				table_data += '<td>Action</td>';	
				table_data += '<td>From</td>';
				table_data += '<td>To</td>';	
				table_data += '</tr></thead>';
				table_data += '<tbody style="background-color: white;">';				
				for (var i=0;i<k;i++){	
					if(data[i].toid !=='Paid'){toval=data[i].tuser;}else{toval='Paid';}
				table_data += '<tr>';
					table_data += '<td>' + data[i].fincode + '</td>';
					table_data += '<td>' + data[i].mdate + '</td>';
					table_data += '<td>' + data[i].descrip + '</td>';
					table_data += '<td>' + data[i].amount + '</td>';
					table_data += '<td>' + data[i].status + '</td>';
					table_data += '<td>' + data[i].fuser + '</td>';
					table_data += '<td>' + toval + '</td>';
				table_data += '</tr>';
				}			
				table_data += '</tbody>'; 		
		
				$('#example2').append(table_data);
		
   			 }	

		});
	}

</script>