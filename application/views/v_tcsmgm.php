<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">TCS CODE LIST</h2>
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
			<?php if (strpos($mauth,'141')>-1)  { ?>
				<a href="#add"  onclick="add()" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add TCS and Others Item</a>
			<?php } ?>	
				<form action="<?=base_url('index.php/Tcsmgm/save_roadno')?>" method="post">	
					<div class="form-group row">
						<div class="col-sm-2 "><label>Road Name</label></div>
						<div class="col-sm-7">
							<select name="proid" id="proid" required="form-control" class="form-control" >							
							<?php foreach ($get_roadlist as $road):?>
									<option value="<?=$road["rid"]?>"
									<?php $a = $this->session->userdata('roadid');
									if($road["rid"]==$a){?>selected<?php }
									?>
									> <?=$road["rid"]. ":".$road["rname"] ?>									
									</option> 
								<?php endforeach ?>
							</select>
						</div>
						<div class="col-sm-2">
							<input type="submit" name="show" value="show" class="btn btn-success">
						</div>
					</div>
				</form>
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
						
							<td>Name</td>					
							<td>Description</td>
							<td>Group Text</td>									
							<td>Action</td>
						</tr></thead>
					<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_tcsmgm as $item) : $no++;?>

						<tr>
							<td><?=$item->name?></td>
							<td><?=$item->descrip?></td>
							<td><?=$item->gtext?></td>							
							<td>
							<?php if (strpos($mauth,'142')>-1)  { ?>
								<a href="#edit" onclick="edit('<?=$item->itemid?>')" class="btn btn-success btn-sm" data-toggle="modal">Edit</a>
							<?php } if (strpos($mauth,'143')>-1)  {?>	
								<a href="<?=base_url('index.php/tcsmgm/hapus/'.$item->itemid)?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm">Delete</a>
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
						Add New Item
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/tcsmgm/add')?>" method="post">
						<div class="modal-body">							
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Description</label></div>
								<div class="col-sm-7">	
								<textarea id="descrip" name="descrip" rows="4" cols="30">	</textarea>							
								</div>
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Name</label></div>
								<div class="col-sm-7">
								<?php if (strpos($mauth,'210')>-1)  { ?>
									<input type="text" name="tcsname" id="tcsname"  class="form-control">
								<?php } else { ?>
										<input type="text" name="tcsname" id="tcsname" readonly class="form-control">
						
								<?php } ?>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Grouping Text</label></div>
								<div class="col-sm-7">
									<input type="text" name="gtext"  class="form-control">
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
						Update Item Detail
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/tcsmgm/tcsmgm_update')?>" method="post">
						<div class="modal-body">
							<input type="hidden" name="user_code_lama" id="user_code_lama">						
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Description</label></div>
								<div class="col-sm-7">									
								<textarea id="descrip2" name="descrip2" rows="4" cols="30">	</textarea>	
								</div>
							</div>
							
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Name</label></div>
								<div class="col-sm-7">
									<input type="text" name="tcsname2" id="tcsname2" readonly class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Grouping Text</label></div>
								<div class="col-sm-7">
									<input type="text" name="gtext2"  id="gtext2"   class="form-control">
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
	$(document).ready(function(){
		$('#example').DataTable();
	}
	);
	function add() {
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Tcsmgm/get_Tcscode",
			dataType:"json",
			success:function(data){		
				data=data+1;			
				if (data <10){data="TCS-0"+data;}else{data="TCS-"+data;}		
				$("#tcsname").val(data);	
			}
		});
	}
	function edit(a) {
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Tcsmgm/find_tcsmgm/"+a,
			dataType:"json",
			success:function(data){				
				$("#descrip2").val(data.descrip);
				$("#tcsname2").val(data.name);
				$("#user_code_lama").val(data.itemid);
			}
		});
	}
</script>

