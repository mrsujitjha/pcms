<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Road Location base Maintenance Activity</h2>	
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
				<?php if (strpos($mauth,'191')>-1)  { ?>
				<a href="#add" onclick="add()" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add Maintenance</a>
				<?php } ?>
				<form action="<?=base_url('index.php/Maintenance/save_roadno')?>" method="post">	
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
				<div class="form-group row">
					<div class="col-sm-2"><label>Item Name</label></div>
					<div class="col-sm-4">
					<select name="selitem" id="selitem" required="form-control" class="form-control" >
						<?php foreach ($get_itemlist as $item):?>
							<option <?php $a = $this->session->userdata('itemname');
								if($item->name==$a){?>selected<?php }
								?>> <?=$item->name ?>	</option> 
						<?php endforeach ?>
					</select>
					</div>	
					<div class="form-group row">	
						<div class="col-sm-2"><label>Year</label></div>
						<div class="col-sm-4">
							<select type="text" name="pyear"  id="pyear" required class="form-control";>
							<?php $a =$this->session->userdata('phyyear');?>
							<option value="1"<?php if($a==1){?>selected<?php }?>>2024</option>
							<option value="2"<?php if($a==2){?>selected<?php }?>>2025</option>
							<option value="3"<?php if($a==3){?>selected<?php }?>>2026</option>
							</select> 			
						</div>									
						<div class="col-sm-2"><label>Month</label></div>
						<div class="col-sm-4">
							<select type="text" name="pmonth"  id="pmonth" required class="form-control";>
							<?php $a =$this->session->userdata('phymonth');?>
							<option value="1"<?php if($a==1){?>selected<?php }?>>January</option>
							<option value="2"<?php if($a==2){?>selected<?php }?>>February</option>
							<option value="3"<?php if($a==3){?>selected<?php }?>>March</option>
							<option value="4"<?php if($a==4){?>selected<?php }?>>April</option>
							<option value="5"<?php if($a==5){?>selected<?php }?>>May</option>
							<option value="6"<?php if($a==6){?>selected<?php }?>>June</option>
							<option value="7"<?php if($a==7){?>selected<?php }?>>July</option>
							<option value="8"<?php if($a==8){?>selected<?php }?>>August</option>
							<option value="9"<?php if($a==9){?>selected<?php }?>>September</option>
							<option value="10"<?php if($a==10){?>selected<?php }?>>October</option>
							<option value="11"<?php if($a==11){?>selected<?php }?>>November</option>
							<option value="12"<?php if($a==12){?>selected<?php }?>>December</option>
							</select> 		
						</div>	
						
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
							<td>Maintenance Id</td>
							<td>Item</td>
							<td>Chainage</td>
							<td>Date of Report</td>
							<td>Description</td>
							<td>Status</td>
							<td>Date of Action</td>
							<td>Remarks</td>
							<td>Action</td>
						</tr></thead>
					<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_Maintenance as $Maintenance) : $no++;?>

						<tr>
							<td><?=$Maintenance->rid?></td>
							<td><?=$Maintenance->item?></td>
							<td><?=$Maintenance->chainage?></td>
							<td><?=get_dateformat($Maintenance->rdate)?></td>
							<td><?=$Maintenance->descrip?></td>	
							<td><?=$Maintenance->status?></td>
							<td><?=get_dateformat($Maintenance->cdate)?></td>
							<td><?=$Maintenance->rem?></td>											
							<td>								
								<?php if (strpos($mauth,'194')>-1)  { ?>	
									<a href="#progress" onclick="progress('<?=$Maintenance->rid?>')" class="btn btn-success btn-sm" data-toggle="modal">Status</a>							
								<?php } if (strpos($mauth,'192')>-1)  { ?>	
									<a href="#edit" onclick="edit('<?=$Maintenance->rid?>')" class="btn btn-success btn-sm" data-toggle="modal">Edit</a>
								<?php } if (strpos($mauth,'193')>-1)  { ?>		
									<a href="<?=base_url('index.php/Maintenance/hapus/'.$Maintenance->rid)?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm">Delete</a>
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
						Add Road Maintenance
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Maintenance/add')?>" method="post">
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Maintenance ID</label></div>
								<div class="col-sm-5">
									<input type="text" id="icode" name="icode" Readonly required class="form-control">
								</div>
								<div class="col-sm-3">
								<select type="text" name="scn"  id="scn" class="form-control" onclick="javascript:getnewid()";>
							
								</select> 
								</div>	
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Chainage</label></div>
								<div class="col-sm-6">
									<input type="text" name="ch" required class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Item Name</label></div>
								<div  class="col-sm-6">
								<select name="item" id="item" required="form-control" class="form-control" onclick="javascript:getnewid()"; >
									<?php foreach ($get_itemlist as $item):?>
										<option value=<?=$item->itemid ?>> <?=$item->name ?>	</option> 
									<?php endforeach ?>
								</select>
								</div>	
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Description</label></div>
								<div class="col-sm-6">
									<input type="text" name="descrip"  class="form-control">
								</div>
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Reporting date</label></div>
								<div class="col-sm-7">
								<input type="text" name="rdate" id="rdate" class="form-control">
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
						Update Maintenance Detail
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Maintenance/Maintenance_update')?>" method="post">
						<div class="modal-body">
							<input type="hidden" name="user_code_lama" id="user_code_lama">			
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Chainage</label></div>
								<div class="col-sm-7">
									<input type="text" name="ch2" id="ch2" required class="form-control">
								</div>
							</div>							
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Description</label></div>
								<div class="col-sm-7">
								<input type="text" name="descrip2" id="descrip2" class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Reporting date</label></div>
								<div class="col-sm-7">
								<input type="text" name="rdate2" id="rdate2" class="form-control">
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
						Update Progress
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Maintenance/Maintenance_update')?>" method="post">
						<div class="modal-body">
							<input type="hidden" name="progcode" id="progcode">		
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Status</label></div>
								<div class="col-sm-7">									
									<select name="prog" id="prog" required="form-control" class="form-control" onclick="javascript:proval()";>
										<option>NOT STARTED</option>
										<option>IN PROGRESS</option>
										<option>COMPLETED</option>								
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Complition Date</label></div>
								<div class="col-sm-7">
								<input type="text" name="cdate" id="cdate" class="form-control">
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
							<input type="submit" name="btprog" value="Save" class="btn btn-success">							
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
		//alert(info);
		$("#user_code_lama").val(a);	
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Maintenance/find_Maintenance/"+info,
			dataType:"json",
			success:function(data){	
				var d=data.rdate;	
				d= d.substring(0,4)	+'-'+d.substring(4,6)+'-'+d.substring(6)	
				$("#ch2").val(data.chainage);
				$("#item2").val(data.item);
				$("#rdate2").val(d);
				$("#descrip2").val(data.descrip);
			}
		});
		
	}
	
	function progress(a) {
		var table = $('#example').DataTable();
		var i=(table.page.info().page);	
		var info = a+ ":"+i;
		var proitem;
		var prolist =document.getElementById("prog");
		const d = new Date();
		$("#progcode").val(a);
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Maintenance/find_Maintenance/"+info,
			dataType:"json",
			success:function(data){	
				var mn= d.getMonth()+1;
				var dn= d.getDate();
				//alert(dn);
				if (mn<10){mn="0"+mn};
				if (dn<10){dn="0"+dn};
				$("#cdate").val(d.getFullYear()+"-"+mn+"-"+dn);	
				$("#prog").val(data.status);
				$("#rem").val(data.rem);
				//alert(data.itemcode);
			}
		});
		
	}
	
	function add() {	
	var list1 =document.getElementById("proid");	
	var a= list1.options[list1.selectedIndex].text.split(":");		
	const d = new Date();
	var mn= d.getMonth()+1;
	var dn= d.getDate();
	if (mn<10){mn="0"+mn};
	if (dn<10){dn="0"+dn};
	$("#rdate").val(d.getFullYear()+"-"+mn+"-"+dn);
		var sc=1;		
		<?php $no=0; foreach ($get_roadlist as $road) : $no++;?>	
			var rno ='<?=$road["rid"]?>';
			if (rno==a[0]){var seslength  ='<?=$road["sc"];?>';}		
		<?php endforeach ?>	
		var l=seslength.split('-');
		sc=l.length;
		$("#scn").empty();
		var x = document.getElementById("scn");
		if (sc >1 ) {
			for (var i = 1; i <= sc; i++) {
			var option = document.createElement("option");
			option.text =i;
			x.add(option);
			}
		}
	}
	function getnewid() {	
	var list1 =document.getElementById("proid");
	var list2 =document.getElementById("item");	
	var rid= list1.options[list1.selectedIndex].text.split(":");
	var itemid= list2.options[list2.selectedIndex].value;	
	var b=document.getElementById("scn").value;
	if(b.length==0){b=1;}
	var c=rid[0]+'H'+b+itemid;
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Maintenance/get_Maintenanceid/"+c,
			dataType:"json",
			success:function(data){					
				if(data.rid==null){c=c+'01';}else{
					var nv=Number(data.rid.substring(8,10))+1;
					if (nv < 10){c=c+"0"+nv;}else{c=c+nv;}
				}
				$("#icode").val(c);	
			}
		});	
		
	}
	
	function proval() {
	
	var list1 =document.getElementById("prog");	
	var a= list1.options[list1.selectedIndex].text;	
	var p =document.getElementById("pper");
	if(a=='COMPLETED'){p.value=100;}else{p.value="";}	
		
	}
function get_distance(lat1,lat2,lon1,lon2){
const R = 6371e3; // metres
const φ1 = lat1 * Math.PI/180; // φ, λ in radians
const φ2 = lat2 * Math.PI/180;
const Δφ = (lat2-lat1) * Math.PI/180;
const Δλ = (lon2-lon1) * Math.PI/180;
const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
          Math.cos(φ1) * Math.cos(φ2) *
          Math.sin(Δλ/2) * Math.sin(Δλ/2);
const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
const d = R * c; 
//alert(d);
return d;
}
</script>

<?php
function get_dateformat($a)
{	$b=substr($a,0,4);
	$c=substr($a,4,2);
	$d=substr($a,6);
	$e=$b."-".$c."-".$d;
	return$e;
}

?>