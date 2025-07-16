<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Road wise Puinch List</h2>	
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
				<?php if (strpos($mauth,'251')>-1)  { ?>	
				<a href="#add" onclick="add()" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add punchlist</a>
				<?php } ?>
				<form action="<?=base_url('index.php/punchlist/save_roadno')?>" method="post">	
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
						<tr><td>punch list Item</td>
							<td>Days to complete</td>
							<td>Link Activity</td>
							<td>activity complition date</td>
							<td>Plan complition date</td>
							<td>Completed date</td>
							<td>Remarks</td>
							<td>Action</td>
						</tr></thead>
					<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_punchlist as $punchlist) : $no++;?>

						<tr>
							<td><?=$punchlist->name?></td>
							<td><?=$punchlist->mdays?></td>
							<td><?=$punchlist->lactivity?></td>
							<td><?=$punchlist->lcdate?></td>	
							<td><?=$punchlist->plandate?></td>
							<td><?=$punchlist->compdate?></td>	
							<td><?=$punchlist->rem?></td>													
							<td>
								<?php	if (strpos($mauth,'252')>-1)  {  ?>	
									<a href="#edit" onclick="edit('<?=$punchlist->ricode?>')" class="btn btn-success btn-sm" data-toggle="modal"><i class="fa fa-pencil"></i></a>
								<?php	} if (strpos($mauth,'253')>-1)  {  ?>										
									<a href="<?=base_url('index.php/punchlist/hapus/'.$punchlist->ricode)?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
								<?php	} if (strpos($mauth,'254')>-1)  {  ?>										
									<a href="#progress" onclick="progress('<?=$punchlist->ricode?>')" class="btn btn-primary btn-sm" data-toggle="modal">Progress</a>
						
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
						Add Road punchlist
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/punchlist/add')?>" method="post">
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>punchlist ID</label></div>
								<div class="col-sm-5">
									<input type="text" id="sechid" name="sechid" Readonly required class="form-control">
								</div>
							</div>							
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Item Name</label></div>
								<div  class="col-sm-6">
								<select name="item" id="item" required="form-control" class="form-control" onchange="javascript:getnewid()";>
									<?php foreach ($get_itemlist as $item):?>
										<option value =<?= $item->itemid ?>><?= $item->name ?>	</option> 
									<?php endforeach ?>
								</select>
								</div>	
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Day to complete</label></div>
								<div class="col-sm-6">
									<input type="text" name="mdays"  class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Enter Link Activity if any</label></div>
								<div class="col-sm-6">
									<input type="text" name="mactivity"  class="form-control">
								</div>
							</div>		
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Remarks</label></div>
								<div class="col-sm-7">
								<input type="text" name="rem" id="rem" class="form-control">
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
						Update punchlist Detail
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/punchlist/punchlist_update')?>" method="post">
						<div class="modal-body">
							<input type="hidden" name="user_code_lama" id="user_code_lama">						
						
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Day to complete</label></div>
								<div class="col-sm-6">
									<input type="text" name="mdays2" id="mdays2" class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Enter Link Activity if any</label></div>
								<div class="col-sm-6">
									<input type="text" name="mactivity2" id="mactivity2" class="form-control">
								</div>
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Remarks</label></div>
								<div class="col-sm-7">
								<input type="text" name="rem2" id="rem2" class="form-control">
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
		<div class="modal fade" id="progress">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Update progress of punchlist
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/punchlist/punchlist_update')?>" method="post">
						<div class="modal-body">
							<input type="hidden" name="user_code_lama2" id="user_code_lama2">						
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Enter Link Activity if any</label></div>
								<div class="col-sm-6">
									<input type="text" name="mactivity3" id="mactivity3" class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Link Activity complition date</label></div>
								<div class="col-sm-6">
									<input type="date" name="ladate" id="ladate" class="form-control">
								</div>
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Item complition date</label></div>
								<div class="col-sm-6">
									<input type="date" name="icdate" id="icdate" class="form-control">
								</div>
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Complited date</label></div>
								<div class="col-sm-7">
								<input type="date" name="comdate" id="comdate" class="form-control">
								</div>
							</div>
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<input type="submit" name="progress" value="Save" class="btn btn-success">							
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
			url:"<?=base_url()?>index.php/punchlist/find_punchlist/"+info,
			dataType:"json",
			success:function(data){				
				$("#mactivity2").val(data.lactivity);
				$("#mdays2").val(data.mdays);
				$("#rem2").val(data.rem);
				$("#user_code_lama").val(data.ricode);	
			}
		});
		
	}
	function progress(a) {
		var table = $('#example').DataTable();
		var i=(table.page.info().page);	
		var info = a+ ":"+i;
		
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/punchlist/find_punchlist/"+info,
			dataType:"json",
			success:function(data){					
				if (data.lactivity.length >2){
					$("#mactivity3").removeAttr("disabled"); 
					$("#ladate").removeAttr("disabled"); 
					$("#mactivity3").val(data.lactivity);
					$("#ladate").val(data.lcdate);				
				}	else {
					$("#mactivity3").attr("disabled", "disabled"); 
					$("#ladate").attr("disabled", "disabled"); 
				}	
				$("#icdate").val(data.plandate);
				$("#comdate").val(data.compdate);	
				$("#user_code_lama2").val(data.ricode);	
			}
		});
		
	}	
	function add() {	
		getnewid();
	}
	function getnewid() {	
	var list1 =document.getElementById("proid");	
	var a= list1.options[list1.selectedIndex].text.split(":");	
	var list2=document.getElementById("item");
	var b= list2.options[list2.selectedIndex].value;	
	var c=a[0]+b;
	//alert(c);	
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/punchlist/get_punchlistid/"+c,
			dataType:"json",
			success:function(data){	
				if(data.ricode==null){c=c+'01';}else{
					var nv=Number(data.ricode.substring(6,8))+1;
					if (nv < 10){c=c+"0"+nv;}else{c=c+nv;}
				}
				$("#sechid").val(c);
		}
		});	
		
	}
</script>

