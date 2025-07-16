<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Package Details</h2>
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
					
					<thead class="thead-light">
						<tr>            
							<td>SN</td>	
							<td>Package Name</td>
							<td>Contract Amount</td>							
							<td>Appointed date</td>							
							<td>Contract Amount(COS)</td>
							<td>Date of Complition</td>
							<td>Extended date of Complition</td>
							<td>Awarded Length</td>
							<td>Awarded Length(COS)</td>
						</tr>
					</thead>
					<tbody >
						<?php $no=0; foreach ($get_project as $project) : $no++;?>
						<tr>							
							<td><?=$project->pkgsn?></td>
							<td><?=$project->pkg?></td>
							<td><?=$project->camt?></td>							
							<td><?=$project->aptdate?></td>
							<td><?=$project->cosamt?></td>
							<td><?=$project->comdate?></td>
							<td><?=$project->excomdate?></td>
							<td><?=$project->awlength?></td>
							<td><?=$project->coslength?></td>							
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
</div>


<script type="text/javascript">
	$(document).ready(function(){
			$('#example').DataTable();
		}
	);
	
</script>