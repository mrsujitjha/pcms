<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Financial Payment Flow management</h2>
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
				<a href="#add" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add Payment flow</a>
				<?php } ?>
				<div class="col-sm-2">
				<li><a href="<?php echo base_url('index.php/Paycondition');?>"><span>Payment Condition Management</span></a></li>
				</div>
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
							<td>Package Id</td>
							<td>Flow list</td>						
							<td>Action</td>
						</tr></thead>
					<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_flow as $flow) : $no++;?>

						<tr>
							<td><?=$flow->pkgid?></td>
							<td><?=$flow->flow?></td>
							<td>
							<?php if (strpos($mauth,'222')>-1)  { ?>
								<a href="#edit" onclick="edit('<?= $flow->flowid . ':'. $flow->flow ?>')" class="btn btn-success btn-sm" data-toggle="modal">Edit</a>
							<?php } if (strpos($mauth,'223')>-1)  { ?>	
								<a href="<?=base_url('index.php/Payflow/hapus/'.$flow->flowid)?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm">Delete</a>
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
						Add New flow
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Payflow/add')?>" method="post">
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Package list</label></div>							
								<div class="col-sm-7">
									<select name="pkgid" id="pkgid" required="form-control" class="form-control" >							
									<?php foreach ($get_pkglist as $road):?>
											<option> <?=$road["pkgsn"]. ":".$road["pkg"] ?></option> 
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Flow list</label></div>
								<div class="col-sm-7">
									<input type="text" name="flowlist" id="flowlist" required class="form-control">
								</div>
							</div>
											
							<div class="form-group row">
								<div class="col-sm-3 offset-1">
									<select name = 'userlist' id="userlist" size=10 multiple onclick="javascript:selection()";>
										<?php foreach ($get_user as $user): ?>
											<option value="<?=$user->user_code?>"><?= $user->fullname.'('.$user->level.')' ?></option>
										<?php endforeach ?>									
									</select>
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
						Update flow Detail
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Payflow/flow_update')?>" method="post">
						<div class="modal-body">
							<input type="hidden" name="user_code_lama" id="user_code_lama">						
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Flow List</label></div>
								<div class="col-sm-7">
									<input type="text" name="flowlist2" id="flowlist2" required class="form-control">
								</div>
							</div>
							<div class="col-sm-10 offset-1">
								<select name = 'userlist2' id="userlist2" size=10 multiple onclick="javascript:selection2()";>
									<?php foreach ($get_user as $user): ?>
										<option value="<?=$user->user_code?>"><?= $user->fullname.'('.$user->level.')' ?></option>
									<?php endforeach ?>									
								</select>
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
	function edit(a) {		
		var b =a.split(":")	;	
		$("#flowlist2").val(b[1]);
		$("#user_code_lama").val(b[0]);
	}
	function selection() {
	
	var sel = document.getElementById("userlist");
	var listLength = sel.length;
	var myselection="";
	
	var flist = document.getElementById("flowlist").value;
	
	for(var i=0;i<listLength;i++){
	if(sel.options[i].selected)
			
	if (myselection=="") {
		myselection= sel.options[i].value;
	} else {
		myselection= myselection+ "," +sel.options[i].value;
	}
}	
if (flist.length >0){document.getElementById("flowlist").value=flist + "," + myselection;}else{document.getElementById("flowlist").value=myselection;}

	
}
function selection2() {
	
	var sel = document.getElementById("userlist2");
	var listLength = sel.length;
	var myselection="";
	var flist = document.getElementById("flowlist2").value

	for(var i=0;i<listLength;i++){
	if(sel.options[i].selected)
			
	if (myselection=="") {
		myselection= sel.options[i].value;
	} else {
		myselection= myselection+ "," +sel.options[i].value;
	}
}	
	if (flist.length >0){document.getElementById("flowlist2").value=flist + "," + myselection;}else{document.getElementById("flowlist2").value=myselection;}

	
}
</script>

