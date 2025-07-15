<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Road Location base item</h2>	
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
				<?php if (strpos($mauth,'151')>-1)  { ?>	
				<a href="#add" onclick="add()" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add Schedule</a>
						
				<?php } ?>
				<form action="<?=base_url('index.php/schedule/save_roadno')?>" method="post">	
				<div class="form-group row">
					<div class="col-sm-2 "><label>Road Name</label></div>
					<div class="col-sm-6">
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
					<div class="col-sm-4">
						<input type="submit" name="show" value="show" class="btn btn-success">
					<?php	if (strpos($mauth,'155')>-1)  { ?>		
						<a href="<?=base_url('index.php/schedule/Approve')?>" onclick="return confirm('Are you sure to Approve it?')" class="btn btn-danger">APPROVE</a>
					<?php } ?>	
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-2"><label>Item Name</label></div>
					<div  class="col-sm-7">
					<select name="selitem" id="selitem" required="form-control" class="form-control" >
						<?php foreach ($get_itemlist as $item):?>
							<option <?php $a = $this->session->userdata('itemname');
								if($item->name==$a){?>selected<?php }
								?>> <?=$item->name ?>	</option> 
						<?php endforeach ?>
					</select>
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
							<td>Schedule Id</td>
							<td>Chainage</td>
							<td>Item</td>
							<td>Description</td>
							<td>Remarks</td>
							<td>Status</td>
							<td>progress (%)</td>
							<td>Action</td>
						</tr></thead>
					<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_schedule as $schedule) : $no++;?>

						<tr>
							<td><?=$schedule->itemcode?></td>
							<td><?=$schedule->chainage?></td>
							<td><?=$schedule->itemsize?></td>
							<td><?=$schedule->descrip?></td>	
							<td><?=$schedule->rem?></td>
							<td><?=$schedule->progress?></td>
							<td><?=$schedule->percent?></td>													
							<td>								
							<?php	if ($schedule->percent != '100' || $this->session->userdata('level') == 'Admin') { ?>	
								<?php	if (strpos($mauth,'154')>-1)  { ?>	
									<a href="#progress" onclick="progress('<?=$schedule->itemcode.':'.$schedule->itemsize ?>')" class="btn btn-success btn-sm" data-toggle="modal">Status</a>							
								<?php } ?>
								<?php	if ((strpos($mauth,'152')>-1 && $schedule->wdone <2)||(strpos($mauth,'155')>-1 ))  {  ?>	
									<a href="#edit" onclick="edit('<?=$schedule->itemcode?>')" class="btn btn-success btn-sm" data-toggle="modal">Edit</a>
								<?php	} if (strpos($mauth,'153')>-1 && $schedule->wdone <2)  {  ?>										
									<a href="<?=base_url('index.php/schedule/hapus/'.$schedule->itemcode)?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm">Delete</a>
								<?php } ?>	
								
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
						Add Road schedule
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/schedule/add')?>" method="post">
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>schedule ID</label></div>
								<div class="col-sm-5">
									<input type="text" id="sechid" name="sechid" Readonly required class="form-control">
								</div>
								<div class="col-sm-3">
								<select type="text" name="scn"  id="scn" class="form-control"; onchange="javascript:getnewid()";>
							
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
								<select name="item" id="item" required="form-control" class="form-control" >
									<?php foreach ($get_itemlist as $item):?>
										<option > <?=$item->name ?>	</option> 
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
								<div class="col-sm-3 offset-1"><label>Remarks</label></div>
								<div class="col-sm-6">
									<input type="text" name="rem"  class="form-control">
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
						Update schedule Detail
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/schedule/schedule_update')?>" method="post">
						<div class="modal-body">
							<input type="hidden" name="user_code_lama" id="user_code_lama">	
							<input type="hidden" name="aadetails" id="aadetails">	
									
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Chainage</label></div>
								<div class="col-sm-7">
									<input type="text" name="ch2" id="ch2" required class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Item</label></div>
								<div class="col-sm-7">
									<select name="item2" id="item2" required="form-control" class="form-control" >
										<?php foreach ($get_itemlist as $item):?>
											<option > <?=$item->name ?>	</option> 
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Description</label></div>
								<div class="col-sm-7">
								<input type="text" name="descrip2" id="descrip2" class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Remarks</label></div>
								<div class="col-sm-7">
								<input type="text" name="rem2" id="rem2" class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Lat & Long</label></div>
								<div class="col-sm-7">
								<input type="text" name="latlng" id="latlng" class="form-control">
								</div>
							</div>
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<?php if ($this->session->userdata('level') == 'Admin') { ?>	
									<a onclick="getgps()" class="btn btn-success">Set GPS</a>							
							<?php } ?>
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
					<form action="<?=base_url('index.php/schedule/schedule_update')?>" method="post">
						<div class="modal-body">
							<input type="hidden" name="progcode" id="progcode">	
							<input type="hidden" id="yrm" name="yrm" >					
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Progress</label></div>
								<div class="col-sm-7">									
									<select name="prog" id="prog" required="form-control" class="form-control" onclick="javascript:proval()";>
										<option>NOT STARTED</option>
										<option>IN PROGRESS</option>
										<option>COMPLETED</option>								
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Progress %</label></div>
								<div class="col-sm-7">
								<input type="text" name="pper" id="pper" class="form-control">
								</div>
							</div>
							<div class="form-group row" >
								<div class="col-sm-3 offset-1" id="surl"><label>Survival No</label></div>
								<div class="col-sm-7">
								<input type="text" name="sur" id="sur" class="form-control">
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
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Schedule/find_schedule/"+info,
			dataType:"json",
			success:function(data){				
				$("#ch2").val(data.chainage);
				$("#item2").val(data.itemsize);
				$("#descrip2").val(data.descrip);
				$("#rem2").val(data.rem);
				$("#user_code_lama").val(data.itemcode);
				$("#latlng").val(data.latlng);		
				$("#aadetails").val(data.aadetails);		
			}
		});
		
	}
	function getgps() {		
		var b=document.getElementById("ch2").value;
		var slocation = b*1000;
		var callocation=0;
		var mlatlong='';
		var lat1=0;
		var lat2=0;
		var lng1=0;
		var lng2=0;
		var z= localStorage.getItem("loadedkml");
		var y=z.split('::');		
			for (var j=0;j<y.length;j++) {  
			var x = y[j].split(' ');
			var p=x[0].split(','); 
			lat1=p[1];lng1=p[0];
				for (var i=1;i<x.length-1;i++) {           
					 p=x[i].split(','); 
					 lat2=p[1];lng2=p[0];
					 callocation =callocation+get_distance(lat1,lat2,lng1,lng2);
					 lat1=lat2;
					 lng1=lng2;
				 if(callocation>slocation){break;}else{mlatlong=lat2+','+lng2;}
				}   
			}
		$("#latlng").val(mlatlong);		
		//alert(info);
	}
	function progress(a) {
		var table = $('#example').DataTable();
		var i=(table.page.info().page);	
		var b=a.split(":")
		var info = b[0]+ ":"+i;
		var proitem;
		var prolist =document.getElementById("prog");
		const d = new Date();
		//alert(info);
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/schedule/find_schedule/"+info,
			dataType:"json",
			success:function(data){					
				$("#progcode").val(data.itemcode);
				var mn= d.getMonth()+1;
				if (mn<10){mn="0"+mn};							
				$("#pper").val(data.percent);
				$("#prog").val(data.progress);
				if (b[1]!=='Road side plantation'){ $("#surl").hide(); $("#sur").hide();$("#yrm").val(d.getFullYear().toString()+mn);}else{
					$("#yrm").val(d.getFullYear().toString()+mn+":"+data.descrip);
				}
			}
		});
		
	}
	
	function add() {	
	var list1 =document.getElementById("proid");	
	var a= list1.options[list1.selectedIndex].text.split(":");	
	document.getElementById("sechid").value=a[0]+'H11';
	var b=a[0]+'H1';
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/schedule/get_scheduleid/"+b,
			dataType:"json",
			success:function(data){		
				data=data+1;
				if (data <10){data="0"+data;}
				$("#sechid").val(b+data);	
				}
		});
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
	var otext =document.getElementById("sechid").value;
	var b=document.getElementById("scn").value;
	var a=otext.substring(0,4)+b;
	//alert(a);
	document.getElementById("sechid").value=a+'01';
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/schedule/get_scheduleid/"+a,
			dataType:"json",
			success:function(data){	
				data=data+1;
				if (data <10){data="0"+data;}
				$("#sechid").val(a+data);		
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

