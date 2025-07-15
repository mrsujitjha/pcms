<header class="page-header">
  <div class="container-fluid">   
	<h2 class="text-center">Section/TCS Item Progress</h2>
	<h4 class="no-margin-bottom">Road Name: <?=$this->session->userdata('roadname');?></h4>
  </div>
</header>

<div class="table-agile-info">
	<div class="container-fluid">
		<?php if ($this->session->flashdata('message')!=null) {
		echo "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>"
			.$this->session->flashdata('message')."<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span>
			</button> </div>";
		} ?>
		<br>
		<div class="card rounded-0 shadow">
			
			<div class=col-md-12 style="overflow-x: auto">
				<table class="table table-hover table-bordered" id="example" ui-options=ui-options="{
					
					&quot;paging&quot;: {
					&quot;enabled&quot;: true
					},
					&quot;filtering&quot;: {
					&quot;enabled&quot;: true
					},
					&quot;sorting&quot;: {
					&quot;enabled&quot;: true
					}}">
					
					<thead style="background-color: #464b58; color:white;">
						<tr>            
							<td>#</td>	
							<td>From Chainage</td>
							<td>To Chainage</td>
							<td>Item</td>							
							<td>Completed length</td>							
							<td>TCS TYPE</td>
							<td>Status</td>
						</tr>
					</thead>
					<tbody >
					
						<?php $no=0; foreach ($get_status as $project) : $no++;?>
						<tr>							
							<td><?=$no?></td>
							<td><?=changein_chainage($project->fromch)?></td>
							<td><?=changein_chainage($project->toch)?></td>
							<td><?=$project->name?></td>							
							<td><?=$project->qyt?></td>
							<td><?=$project->phycode?></td>
							<td><?=status($project->toch,$project->fromch,$project->qyt)?></td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
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
	//return$a;
}
function status($a,$b,$c)
{	
	$d=$a*1000-$b*1000-$c*1000;
	$e="";
	if($d==0){$e="Completed";}
	if($d>0){$e="In progrss";}
	if($d<0){$e="Error";}
	return$e;
	
}

?>
<script type="text/javascript">
	$(document).ready(function(){
			$('#example').DataTable();
		}
	);	

</script>
