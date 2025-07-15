<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom"> Hindrance management</h2>	
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
			<?php if (strpos($mauth,'231')>-1)  { ?>	
				<a href="#add" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add Hindrance</a>
			<?php } ?>	
				<form action="<?=base_url('index.php/Hindrance/save_roadno')?>" method="post">	
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
							<td>Description</td>
							<td>Location</td>
							<td>Reporting Date</td>
							<td>Remarks</td>
							<td>Action</td>
						</tr></thead>
					<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_hindlist as $mphoto) : $no++;?>
						<tr>
							<td><?=$no?></td>							
							<td><?=$mphoto->descrip?></td>	
							<td><?=$mphoto->location?></td>	
							<td><?=$mphoto->entryd?></td>		
							<td><?=$mphoto->Rem?></td>											
							<td>	
							<?php if (strpos($mauth,'232')>-1)  { ?>					
								<a href="#edit" onclick="edit('<?=$mphoto->id?>')" class="btn btn-success btn-sm" data-toggle="modal">Edit</a>
							<?php } if (strpos($mauth,'233')>-1)  { ?>		
								<a href="<?=base_url('index.php/Hindrance/hapus/'.$mphoto->id)?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm">Delete</a>
							<?php } ?>				
							</td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="modal fade" id="add">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Add new Hindrances 
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Hindrance/addeditdetails')?>" method="post" enctype="multipart/form-data">
						<div class="form-group row">
							<div class="col-sm-2 offset-1"><label>Description:</label></div>
							<div class="col-sm-8">								
								<textarea id="descrip" name="descrip" rows="4" cols="30">	</textarea>							
							</div>
						</div>		
						<div class="form-group row">
							<div class="col-sm-2 offset-1"><label>Location From :</label></div>
							<div class="col-sm-8">
								<input type="text" name="location1" id="location1">							
							</div>
						</div>		
						<div class="form-group row">
							<div class="col-sm-2 offset-1"><label>Location To :</label></div>
							<div class="col-sm-8">
								<input type="text" name="location2" id="location2">							
							</div>
						</div>						
						<div class="form-group row">
							<div class="col-sm-2 offset-1"><label>Remarks</label></div>
							<div class="col-sm-8">
								<input type="text" name="rem" id="rem">							
							</div>
						</div>										
						<div class="modal-footer justify-content-end">
							<input type="submit" name="save" value="Save" class="btn btn-primary btn-sm rounded-0">
							<button type="button" class="btn btn-default btn-sm border rounded-0" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>		
			</div>		
		</div>		
		<div class="modal fade" id="edit">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Edit picture details
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Hindrance/addeditdetails')?>" method="post" enctype="multipart/form-data">
						
						<input type="hidden" name="id" id="id">							
						<div class="form-group row">
							<div class="col-sm-2 offset-1"><label>Description:</label></div>
							<div class="col-sm-8">								
								<textarea id="descrip2" name="descrip2" rows="4" cols="30">	</textarea>							
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-2 offset-1"><label>Location From:</label></div>
							<div class="col-sm-8">
								<input type="text" name="location3" id="location3">							
							</div>
						</div>	
						<div class="form-group row">
							<div class="col-sm-2 offset-1"><label>Location To:</label></div>
							<div class="col-sm-8">
								<input type="text" name="location4" id="location4">							
							</div>
						</div>	
						<div class="form-group row">
							<div class="col-sm-2 offset-1"><label>Remarks</label></div>
							<div class="col-sm-8">
								<input type="text" name="rem2" id="rem2">							
							</div>
						</div>											
						<div class="modal-footer justify-content-end">
							<input type="submit" name="edit" value="Edit" class="btn btn-primary btn-sm rounded-0">
							<button type="button" class="btn btn-default btn-sm border rounded-0" data-dismiss="modal">Close</button>
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
	$(document).ready(function(){
			$('#example').DataTable({'displayStart':i});
		}
	);
	
function edit(a) {
		var table = $('#example').DataTable();
		var i=(table.page.info().page);	
		var info = a+ ":"+i;
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Hindrance/find_hindrance/"+info,
			dataType:"json",
			success:function(data){				
				$("#descrip2").val(data.descrip);				
				var txt=data.location
				var ft=txt.split('-');
				var f=ft[0].replace('From ','');
				var t=ft[1].replace(' To ','');
				$("#location3").val(f);
				$("#location4").val(t);	
				$("#rem2").val(data.Rem);	
				$("#id").val(data.id);
			}
		});
	}
</script>



