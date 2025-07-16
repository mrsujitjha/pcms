<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Payment Condition management</h2>
  </div>
</header>

<div class="table-agile-info">	
	<div class="container-fluid">
		<?php $mauth=$this->session->userdata('autho') ;if ($this->session->flashdata('message')!=null) {
		echo "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>"
			.$this->session->flashdata('message')."<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span>
			</button> </div>";
		} ?>
		<br>
		<div class="card rounded-0 shadow">
			<div class="card-header">
			<?php if (strpos($mauth,'221')>-1)  { ?>
				<a href="#add" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add Payment Condition</a>
				<?php } ?>
			</div>
			<br>
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
							<td>Id</td>
							<td>Condition node</td>	
							<td>Description</td>							
							<td>Action</td>
						</tr></thead>
					<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_paycon as $flow) : $no++;?>

						<tr>
							<td><?=$flow->cid?></td>
							<td><?=$flow->pname?></td>
							<td><?=$flow->detail?></td>
							<td>
							<?php if (strpos($mauth,'222')>-1)  { ?>
								<a href="#edit" onclick="edit('<?= $flow->cid ?>')" class="btn btn-success btn-sm" data-toggle="modal">Edit</a>
							<?php } if (strpos($mauth,'223')>-1)  { ?>	
								<a href="<?=base_url('index.php/Paycondition/hapus/'.$flow->cid)?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm">Delete</a>
							<?php } ?>	
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			</div>	
		</div>

		<div class="modal" id="add">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Add New Condition
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Paycondition/add')?>" method="post">
						<div class="modal-body">
						<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Condition Index</label></div>
								<div class="col-sm-7">
									<input type="text" name="pname" id="pname" required class="form-control">
								</div>
							</div>											
							
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Description</label></div>
								<div class="col-sm-7">
								<textarea name="pdetail" id="pdetail" required class="form-control" rows="4"></textarea>
								</div>
							</div>											
							
							<input type="text" name="plogic" id="plogic" required class="form-control">
								
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>							
							<input type="submit" name="save" value="Save" class="btn btn-success">							
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="edit">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Update Payment Condition
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Paycondition/flow_update')?>" method="post">
					<div class="modal-body">	
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Condition Index</label></div>
							<div class="col-sm-7">
								<input type="text" name="pname1" id="pname1" required class="form-control">
							</div>																
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Description</label></div>
							<div class="col-sm-7">
							<textarea name="pdetail1" id="pdetail1" required class="form-control" rows="4"></textarea>
							</div>
						</div>	
						<input type="text" name="plogic1" id="plogic1" required class="form-control">
					</div>	
					<input type="hidden" name="user_code_lama" id="user_code_lama" class="form-control">					
					<div class="modal-footer justify-content-between">		
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>							
						<input type="submit" name="edit" value="Save" class="btn btn-success">
					</div>
					</form>
				</div>				
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		$('#example').DataTable();
	}
	);
	function edit(a) {	
		var table = $('#example').DataTable();
		var i=(table.page.info().page);	
		var info = a+ ":"+i;
			//alert(info);
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Paycondition/find_condition/"+info,
			dataType:"json",
			success:function(data){	
				$("#pname1").val(data.pname);
				$("#pdetail1").val(data.detail);
				$("#plogic1").val(data.logic);			
				$("#user_code_lama").val(data.cid);
			}
		});	
		
	}
	
	

</script>

