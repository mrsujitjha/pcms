<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom"> Resource management</h2>	
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
				<?php if (strpos($mauth,'241')>-1)  { ?>
				<a href="#addpic" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add Resource</a>
				<?php } ?>	
				<form action="<?=base_url('index.php/Photo/save_roadno')?>" method="post">	
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
							<td>Photo Name</td>
							<td>Lat and Long</td>
							<td>Description</td>
							<td>Action</td>
						</tr></thead>
					<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_Photolist as $mphoto) : $no++;?>
						<tr>
							<td><?=$no?></td>
							<td><?=$mphoto->pname?></td>
							<td><?=$mphoto->latlng?></td>	
							<td><?=$mphoto->descrip?></td>										
							<td>					
							<a href="#view" onclick="view('<?=$mphoto->pname?>')" class="btn btn-success btn-sm" data-toggle="modal">View</a>							
							<?php if (strpos($mauth,'242')>-1)  { ?>
								<a href="#editpic" onclick="editpic('<?=$mphoto->pname.':'.$mphoto->latlng.':'.$mphoto->descrip?>')" class="btn btn-success btn-sm" data-toggle="modal">Edit</a>
								<?php } if (strpos($mauth,'243')>-1)  { ?>	
								<a href="<?=base_url('index.php/Photo/hapus/'.$mphoto->pname)?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm">Delete</a>
							<?php } ?>						
							</td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="modal fade" id="addpic">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Upload picture file 
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Photo/addeditpic')?>" method="post" enctype="multipart/form-data">
						<div class="form-group row">
							<div class="col-sm-3 offset-1">							
								<input type="file" id="myFile" name="myFile" />
							</div>
						</div>		
						<div class="form-group row">
							<div class="col-sm-2 offset-1"><label>Latlng:</label></div>
							<div class="col-sm-8">
								<input type="text" name="plat" id="plat">							
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-2 offset-1"><label>Description:</label></div>
							<div class="col-sm-8">
								<input type="text" name="descrip" id="descrip">							
							</div>
						</div>									
						<div class="modal-footer justify-content-end">
							<input type="submit" name="savepic" value="Upload" class="btn btn-primary btn-sm rounded-0">
							<button type="button" class="btn btn-default btn-sm border rounded-0" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>		
			</div>		
		</div>		
		<div class="modal fade" id="editpic">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Edit picture details
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Photo/addeditpic')?>" method="post" enctype="multipart/form-data">
						
						<input type="hidden" name="picname" id="picname">		
						<div class="form-group row">
							<div class="col-sm-2 offset-1"><label>Latlng:</label></div>
							<div class="col-sm-8">
								<input type="text" name="plat2" id="plat2">							
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-2 offset-1"><label>Description:</label></div>
							<div class="col-sm-8">
								<input type="text" name="descrip2" id="descrip2">							
							</div>
						</div>									
						<div class="modal-footer justify-content-end">
							<input type="submit" name="editpic" value="Update" class="btn btn-primary btn-sm rounded-0">
							<button type="button" class="btn btn-default btn-sm border rounded-0" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>		
			</div>		
		</div>	
		<div class="modal fade" id="view">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<div class="form-group row">
					 <div class="col-sm-12 offset-1">					
					 <img id="myImage" src="" width="400" height="450">
					 </div>
					</div>	
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
	function editpic(a) {	
		var allval=a.split(":") ;
		$("#descrip2").val(allval[2]);
		$("#plat2").val(allval[1]);
		$("#picname").val(allval[0]);
}
function view(a) {
	$("#myImage").empty();
	var img = document.getElementById('myImage');	
    img.src = '<?php echo base_url();?>assets/photo/'+a;
}
</script>



