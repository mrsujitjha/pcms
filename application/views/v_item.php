<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Road Item and sub item For Stage progress</h2>
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
				<?php if (strpos($mauth,'121')>-1)  { ?>
				<a href="#add" onclick="add()" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add Road Item</a>
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
							<td>Item Id</td>
							<td>Description</td>
							<td>Measurement</td>
							<td>Action</td>
						</tr></thead>
					<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_item as $item) : $no++;?>
						<tr>
							<td><?=$item->itemid?></td>
							<td><?=$item->name?></td>
							<td><?=$item->unit?></td>
							<td>							
							<?php if (strpos($mauth,'122')>-1)  { ?>
								<a href="#edit" onclick="edit('<?=$item->itemid?>')" class="btn btn-success btn-sm"  data-toggle="modal">Edit</a>
							<?php if ($item->unit == 'Stage') { ?>	
								<a href="#Stage" onclick="Stage('<?=$item->itemid?>')" class="btn btn-secondary btn-sm" data-toggle="modal">Stage</a>
							<?php } if ($item->draw == 'YES') { ?>	
								<a href="#Draw" onclick="Drawing('<?=$item->itemid?>')" class="btn btn-info btn-sm" data-toggle="modal">Drawing</a>
							<?php } if ($item->sitem == 'YES') { ?>	
								<a href="#Subitem" onclick="Subitem('<?=$item->itemid?>')" class="btn btn-primary btn-sm" data-toggle="modal">RFI-Item</a>
							
								<?php }} if (strpos($mauth,'123')>-1)  {?>
								<a href="<?=base_url('index.php/item/hapus/'.$item->itemid)?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm">Delete</a>
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
					<form action="<?=base_url('index.php/item/add')?>" method="post">
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Item ID</label></div>
								<div class="col-sm-7">
									<input type="text" name="itemid" id="itemid" readonly required class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Description</label></div>
								<div class="col-sm-7">
									<input type="text" name="descrip" required class="form-control">
								</div>
							</div>
							
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>unit</label></div>
								<div class="col-sm-7">
									<select type="text" name="unit" required class="form-control">
										<option>Km</option>
										<option>No</option>
										<option>Stage</option>
										<option>Maint</option>						
									</select> 
								</div>
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Show on dashboard</label></div>
								<div class="col-sm-7">
								<select type="text" name="dash" id="dash" required class="form-control">
										<option>NO</option>
										<option>YES</option>
									</select>
								</div>
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Include in Punch List</label></div>
								<div class="col-sm-7">
									<select type="text" name="punch" id="punch" required class="form-control">
										<option>NO</option>
										<option>YES</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Drawing Required</label></div>
								<div class="col-sm-7">
									<select type="text" name="draw" id="draw" required class="form-control">
										<option>NO</option>
										<option>YES</option>
									</select>
								</div>	
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Sub Item for RFI exist</label></div>
								<div class="col-sm-7">
									<select type="text" name="sitem" id="sitem" required class="form-control">
										<option>NO</option>
										<option>YES</option>
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
		<div class="modal" id="Stage">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Add Stages of the Selected Item
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/item/addstage')?>" method="post">
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Item ID</label></div>
								<div class="col-sm-7">
									<input type="text" name="istage" id="istage" readonly required class="form-control">
								</div>
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Add new stage</label></div>
								<div class="col-sm-7">
									<input type="text" name="stgid" id="stgid"  required class="form-control">
								</div>
							</div>				
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Stages</label></div>
								<div class="col-sm-7">
									<select type="text" name="mstages" id="mstages" size=10 multiple  class="form-control" onclick="javascript:enable(0)";>
																		
									</select> 
								</div>
							</div>							
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<input type="submit" name="save" value="Save" class="btn btn-success">
							<input type="submit" name="stageEdit" id="stageEdit" value="Edit" disabled class="btn btn-success">
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal" id="Subitem">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Add Sub-Item under Selected Item
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/item/rfiitem')?>" method="post">
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Item ID</label></div>
								<div class="col-sm-7">
									<input type="text" name="isitem" id="isitem" readonly required class="form-control">
								</div>
							</div>	
							<input type="hidden" name="selitem" id="selitem"  class="form-control">
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Add new Subitem</label></div>
								<div class="col-sm-6">
									<input type="text" name="sitemid" id="sitemid"  class="form-control">
								</div>
								<div class="col-sm-2">
								<input type="button" name="badd" value="ADD" class="btn btn-success" onclick="javascript:add_itemsublist()";>
								</div>
							</div>				
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Sub-Item List</label></div>
								<div class="col-sm-7">
									<select type="text" name="slist" id="slist" size=10 multiple  class="form-control" onclick="javascript:remove_list(2)">
																		
									</select> 
								</div>
							</div>							
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<input type="submit" name="saverfi" value="Save" class="btn btn-success">
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal" id="Draw">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Add Drawing type under Selected Item
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/item/adddrawing')?>" method="post">
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-4 offset-1"><label>Item ID</label></div>
								<div class="col-sm-7">
									<input type="text" name="idraw" id="idraw" readonly required class="form-control">
								</div>
							</div>	
							<input type="hidden" name="seldraw" id="seldraw"  class="form-control">														
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>All Drawing List</label></div>							
								<div class="col-sm-8">	
								<select name = 'dtype' id="dtype" size=10 multiple class="form-control" onclick="javascript:add_list()";>
									<option>Plan and Profile - Linear</option>
									<option>Culverts - Point</option>
									<option>Major Bridges- Point</option>
									<option>Minor Bridges- Point</option>
									<option>VUP/CUP/PUP/VOP- Point</option>
									<option>ROB - Point</option>
									<option>Typical Cross-sections - Typical</option>
									<option>Toll Plaza- Point</option>
									<option>ATMS - Typical</option>
									<option>Drainage Plan- Linear</option>
									<option>Drain design- Linear</option>
									<option>Major Junction – Point</option>
									<option>Minor Junction – Point</option>
									<option>Grade separated Junctions - Point</option>
									<option>Street Lighting - Linear</option>
									<option>Project facilities provided</option>
									<option>Pedestrian Crossing - Typical</option>
									<option>Landscaping and horticulture - Linear</option>
									<option>Drawing of typical details slope protection wall measures - Typical</option>
									<option>traffic diversion plans - Point</option>
									<option>road furniture items - Typical</option>
									<option>Others </option>
								</select>	
								</div>	
							</div>								
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Selected Drawing List</label></div>
								<div class="col-sm-8">
									<select type="text" name="dlist" id="dlist" size=10 multiple  class="form-control" onclick="javascript:remove_list(1)";>
																		
									</select> 
								</div>
							</div>								
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<input type="submit" name="savedr" value="Save" class="btn btn-success">
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
					<form action="<?=base_url('index.php/item/item_update')?>" method="post">
						<div class="modal-body">
							<input type="hidden" name="user_code_lama" id="user_code_lama">						
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Description</label></div>
								<div class="col-sm-7">
									<input type="text" name="descrip2" id="descrip2" required class="form-control">
								</div>
							</div>
							
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>unit</label></div>
								<div class="col-sm-7">
									<select type="text" name="unit2" id="unit2" required class="form-control">
										<option>Km</option>
										<option>No</option>
										<option>Stage</option>
										<option>Maint</option>	
									</select>
								</div>					
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Show on dashboard</label></div>
								<div class="col-sm-7">
								<select type="text" name="dash2" id="dash2" required class="form-control">
										<option>NO</option>
										<option>YES</option>
									</select>
								</div>
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Include in Punch List</label></div>
								<div class="col-sm-7">
									<select type="text" name="punch2" id="punch2" required class="form-control">
										<option>NO</option>
										<option>YES</option>
									</select>
								</div>
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Drawing Required</label></div>
								<div class="col-sm-7">
									<select type="text" name="draw2" id="draw2" required class="form-control">
										<option>NO</option>
										<option>YES</option>
									</select>
								</div>	
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Sub Item for RFI exist</label></div>
								<div class="col-sm-7">
									<select type="text" name="sitem2" id="sitem2" required class="form-control">
										<option>NO</option>
										<option>YES</option>
									</select>
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
			url:"<?=base_url()?>index.php/Item/find_item/"+info,
			dataType:"json",
			success:function(data){	
				$("#descrip2").val(data.name);
				$("#unit2").val(data.unit);
				$("#dash2").val(data.dash);
				$("#punch2").val(data.punch);
				$("#draw2").val(data.draw);	
				$("#sitem2").val(data.sitem);		
				$("#user_code_lama").val(data.itemid);
			}
		});
	}
	function add() {	
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Item/get_itemcode",
			dataType:"json",
			success:function(data){				
				$("#itemid").val(parseInt(data.itemid)+1);	
			}
		});
	}
	function enable(i) {	
	if(i==0){document.getElementById("stageEdit").disabled = false;	}
	}
	function Stage(a) {	
		$("#istage").val(a);	
		var table = $('#example').DataTable();
		var i=(table.page.info().page);	
		var info = a+ ":"+i;
		var prolist =document.getElementById("mstages");
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Item/find_stageitem/"+info,
			dataType:"json",
			success:function(data){	
				$("#mstages").empty();
				for (var l = 0; l < 10; l++) {
					var option = document.createElement("option");
					option.id = l+1;
					option.text = data[l].descrip;
					prolist.add(option);
				}
			}
		});	
	}
	function Subitem(a) {	
		$("#isitem").val(a);	
		var table = $('#example').DataTable();
		var i=(table.page.info().page);	
		var info = a+ ":"+i;
		var prolist =document.getElementById("slist");
		var allitem =document.getElementById("selitem");
		var x ="";
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Item/find_rfiitem/"+info,
			dataType:"json",
			success:function(data){	
				$("#slist").empty();
				var k = Object.keys(data).length;	
				allitem.value="";
				for (var l = 0; l < k; l++) {
					var option = document.createElement("option");
						option.id = l+1;
						option.text = data[l].descrip;
						prolist.add(option);						
					if(l==0){x=data[l].descrip;}else{x=x + "," + data[l].descrip;}	
				}
				allitem.value=x;
			}
		});	
	}
	function Drawing(a) {	
		$("#idraw").val(a);	
		var table = $('#example').DataTable();
		var i=(table.page.info().page);	
		var info = a+ ":"+i;
		var prolist =document.getElementById("dlist");
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Item/find_drawing/"+info,
			dataType:"json",
			success:function(data){	
				$("#dlist").empty();
				for (var l = 0; l < 10; l++) {
					var option = document.createElement("option");
						option.id = l+1;
						option.text = data[l].descrip;
						prolist.add(option);
				}
			}
		});	
	}
	function remove_list(a) {	
		var sel ;
		var showlist;				
		if(a==1){	
		sel = document.getElementById("dlist");
			showlist = document.getElementById("seldraw");		
		}else{
		sel = document.getElementById("slist");
		showlist = document.getElementById("selitem");
		}
		var myselection="";	
		sel.remove(sel.selectedIndex);
		var tlist= sel.length;	
		for(var i=0;i<tlist;i++){	
			if (myselection=="") {
				myselection= sel.options[i].value;
			} else {
				myselection= myselection+ "," +sel.options[i].value;
			}
		}	
		showlist.value=myselection;
	}
	
	function add_itemsublist() {	
		var additem ;
		var sel ;
		var showlist;		
		additem = document.getElementById("sitemid").value;
		sel = document.getElementById("slist");
		showlist = document.getElementById("selitem");	
		if(additem.length>0){
		var listLength = showlist.value.length;	
		if (listLength>0){showlist.value =showlist.value + "," + additem;}else{showlist.value =additem;}
		var optmain = document.createElement("option");
		optmain.text = additem;
		sel.add(optmain);
		}else{alert("Please enter the sub item");}
	}
	function add_list() {	
		var allitem ;
		var sel ;
		var showlist;		
		allitem = document.getElementById("dtype");
		sel = document.getElementById("dlist");
		showlist = document.getElementById("seldraw");		
		var listLength = allitem.length;
		var myselection="";	
		for(var i=0;i<listLength;i++){
			if(allitem.options[i].selected){ 			
				var optmain = document.createElement("option");
				optmain.value=allitem.options[i].value;
				optmain.text = allitem.options[i].text;
				sel.add(optmain);
			}
		}
		var tlist= sel.length;	
		for(var i=0;i<tlist;i++){		
			if (myselection=="") {
				myselection= sel.options[i].value;
			} else {
				myselection= myselection+ "," +sel.options[i].value;
			}
		}	
		showlist.value=myselection;
	}
</script>

