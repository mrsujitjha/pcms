<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Contractor Management</h2>
  </div>
</header>

<div class="table-agile-info">	
	<div class="container-fluid">
		<?php  $mauth=$this->session->userdata('autho') ;if ($this->session->flashdata('message')!=null) {
		echo "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>"
			.$this->session->flashdata('message')."<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span>
			</button> </div>";
		} ?>
		<br>
		<div class="card rounded-0 shadow">		
			<div class="card-header">
				<?php if (strpos($mauth,'291')>-1)  { ?>
				<a href="#add" onclick="add()" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add New Contractor</a>
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
							<td>Contractor Id</td>
							<td>Name</td>
							<td>Contact person</td>
							<td>Contact no</td>
							<td>Email</td>
							<td>Address</td>
							<td>Action</td>
						</tr></thead>
					<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_con as $item) : $no++;?>
						<tr>
							<td><?=$item->cid?></td>
							<td><?=$item->cname?></td>
							<td><?=$item->cperson?></td>
							<td><?=$item->cphone?></td>
							<td><?=$item->cemail?></td>
							<td><?=$item->caddrs?></td>
							<td>							
							<?php if (strpos($mauth,'292')>-1)  { ?>
								<a href="#edit" onclick="edit('<?=$item->cid?>')" class="btn btn-success btn-sm"  data-toggle="modal">Edit</a>
							<?php } if (strpos($mauth,'293')>-1)  {?>
								<a href="<?=base_url('index.php/Contractor/hapus/'.$item->cid)?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm">Delete</a>
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
						Add New Contractor
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>					
					<form action="<?=base_url('index.php/Contractor/add')?>" method="post">
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Contractor Id</label></div>
								<div class="col-sm-7">
									<input type="text" name="cid" id="cid" readonly required class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Contractor Name</label></div>
								<div class="col-sm-7">
									<input type="text" name="cname" required class="form-control">
								</div>
							</div>
							
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Contact Person</label></div>
								<div class="col-sm-7">
								<input type="text" name="cperson" required class="form-control">
								</div>
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Contact number</label></div>
								<div class="col-sm-7">
								<input type="text" name="cnum" required class="form-control">
								</div>
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Contact Email</label></div>
								<div class="col-sm-7">
								<input type="text" name="cemail" required class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Address</label></div>
								<div class="col-sm-7">
								<input type="text" name="caddrs" required class="form-control">
								</div>
							</div>						
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
						Update Contractor Detail
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/contractor/contractor_update')?>" method="post">
						<div class="modal-body">
							<input type="hidden" name="user_code_lama" id="user_code_lama">						
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Contractor Name</label></div>
								<div class="col-sm-7">
									<input type="text" id="cname1" name="cname1" required class="form-control">
								</div>
							</div>
							
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Contact Person</label></div>
								<div class="col-sm-7">
								<input type="text" id="cperson1" name="cperson1" required class="form-control">
								</div>
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Contact number</label></div>
								<div class="col-sm-7">
								<input type="text" id="cnum1" name="cnum1" required class="form-control">
								</div>
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Contact Email</label></div>
								<div class="col-sm-7">
								<input type="text" id="cemail1" name="cemail1" required class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Address</label></div>
								<div class="col-sm-7">
								<input type="text" id="caddrs1" name="caddrs1" required class="form-control">
								</div>
							</div>			
						</div>			
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
	var a=<?php if($this->session->has_userdata('mypage')){echo($this->session->userdata('mypage'));}else{echo('0');}?>;
	var i =a*10;
	//alert(a);
	$(document).ready(function(){
			$('#example').DataTable({'displayStart':i});		
		}
	);
	function edit(a) {
		var table = $('#example').DataTable();
		var i=(table.page.info().page);	
		var info = a+ ":"+i;
			//alert(info);
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Contractor/find_contractor/"+info,
			dataType:"json",
			success:function(data){	

				$("#cname1").val(data.cname);	
				$("#cperson1").val(data.cperson);	
				$("#cnum1").val(data.cphone);	
				$("#cemail1").val(data.cemail);
				$("#caddrs1").val(data.caddrs);
				$("#user_code_lama").val(data.cid);
			}
		});
	}
	function add() {	
		var cid=1;
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Contractor/get_Contractorcode",
			dataType:"json",
			success:function(data){	
				if(data.cid != null){cid=parseInt(data.cid)+1;}		
				$("#cid").val(cid);	
			}
		});
	}
	
</script>

