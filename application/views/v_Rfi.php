<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">RFI List</h2>	
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
				<?php if (strpos($mauth,'271')>-1)  { ?>	
				<a href="#add" onclick="add(1)" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add Rfi</a>
				<?php } ?>
				<form action="<?=base_url('index.php/Rfi/save_roadno')?>" method="post">	
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
						<tr><td>RFI ID </td>							
							<td>Location</td>
							<td>Date</td>
							<td>Time</td>							
							<td>Remarks</td>
							<td>For</td>
							<td>Status</td>
							<td>Action</td>
						</tr></thead>
					<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_Rfi as $Rfi) : $no++;?>

						<tr>
							<td><?=$Rfi->rfiid?></td>
							<td><?=$Rfi->location?></td>
							<td><?=$Rfi->mdate?></td>
							<td><?=$Rfi->mtime?></td>	
							<td><?=$Rfi->rem?></td>	
							<td><?=$Rfi->muser?></td>
							<td><?php if (is_null($Rfi->myn)) {echo $Rfi->action;} else {echo $Rfi->myn;} ?></td>									
							<td>
								<?php	if (is_null($Rfi->myn)) {if (strpos($mauth,'272')>-1 && ($Rfi->mid ==$this->session->userdata('username')))  {  ?>	
									<a href="#edit" onclick="edit('<?=$Rfi->rfiid?>')" class="btn btn-success btn-sm" data-toggle="modal"><i class="fa fa-pencil"></i></a>
								<?php	} if (strpos($mauth,'273')>-1 && ($Rfi->mid ==$this->session->userdata('username')))  {  ?>										
									<a href="<?=base_url('index.php/Rfi/hapus/'.$Rfi->rfiid)?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
								<?php	} if (strpos($mauth,'274')>-1 && ($Rfi->muser ==$this->session->userdata('username')))  {  ?>										
									<a href="#Action" onclick="Action('<?=$Rfi->rfiid.':'.$Rfi->location?>')" class="btn btn-primary btn-sm" data-toggle="modal">Action</a>
								<?php	} }
								
								if (strpos($mauth,'275')>-1)  {  ?>										
									<a href="#View" onclick="View('<?=$Rfi->rfiid?>')" class="btn btn-primary btn-sm" data-toggle="modal">View</a>
						
								<?php } ?>	
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="modal" id="add">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						Add Request for Inspection
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
				
					<form action="<?=base_url('index.php/Rfi/add')?>" method="post" enctype="multipart/form-data">
			
						<div class="modal-body">
							<div class="form-group row">
								<input type="hidden" id="rfirow" name="rfirow"  class="form-control">
							</div>													
							<div class="form-group row">
								<div class="col-sm-3 "><label>Item Type</label></div>
								<div class="col-sm-2 "><label>Sub Item Type</label></div>
								<div class="col-sm-3 "><label>Location</label></div>
								<div class="col-sm-2 "><label>Request to</label></div>
							</div>	
							<div class="form-group row">
								<div  class="col-sm-3">
								<select name="item" id="item" required="form-control" class="form-control" onchange="javascript:Load_chainagelist()";>
									<?php foreach ($get_itemlist as $item):?>
										<option value="<?=$item->a?>"> <?=$item->b?></option> 
									<?php endforeach ?>
								</select>
								</div>					
								<div  class="col-sm-2">
								<select name="sitem" id="sitem" required="form-control" class="form-control";>
									
								</select>
								</div>								
								<div class="col-sm-3">
									<select name="chlst" id="chlst" required="form-control"  class="form-control";></select>	
								</div>	
								<div  class="col-sm-2">
								<select name="ulist" id="ulist" required="form-control" required class="form-control";>
									
								</select>
								</div>	
								<div class="col-sm-2">
								<button type="button" class="btn btn-default" id="brfi" onclick="javascript:prepare_fill_RFI()">Add RFI</button>
								</div>	
							</div>	
							<label>RFI Details</label>
							<div id="inRows" >
								<div class="form-group row">
									<div class="col-sm-1 "><label>ID</label></div>
									<div class="col-sm-3 "><label>Location</label></div>
									<div class="col-sm-3 "><label>Date of Inspection</label></div>
									<div class="col-sm-2 "><label>Time of Inspection</label></div>	
									<div class="col-sm-3 "><label>Remarks</label></div>								
								</div>	
							</div>
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<p style="font-size:20px;color:red;"  id="msg1"></p>
							<input type="submit" name="save" id="save" value="Generate RFI" class="btn btn-success">							
						</div>
					</form>
				</div>
			</div>
		</div>	
		<div class="modal" id="edit">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						Edit Request for Inspection
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>				
					<form action="<?=base_url('index.php/Rfi/Rfi_update')?>" method="post" enctype="multipart/form-data">
			
						<div class="modal-body">		
							<label>RFI Details</label>
							<div id="inRows2" >
								
							</div>
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<input type="submit" name="edit" value="Update RFI" class="btn btn-success">							
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="View">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 id="h02"> </h5>
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<div class=col-md-12 style="overflow-x: auto">
						<h5 id="h01"> </h5>
						<table class="table table-hover table-bordered" id="example2">
						
						</table>
					</div>				
				</div>
			</div>		
		</div>
		<div class="modal fade" id="Action">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Invoce processing
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Rfi/add')?>" method="post">
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>RFI ID</label></div>
								<div class="col-sm-7">
									<input type="text" name="rfiid2" id="rfiid2" Readonly class="form-control">
								</div>
							</div>	
							<input type="text" name="chd" id="chd" Readonly class="form-control">
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>User List</label></div>
								<div  class="col-sm-7">
									<select name="ulist2" id="ulist2" required="form-control" class="form-control";>
										
									</select>
								</div>			
							</div>	
							<?php if (strpos($mauth,'276')>-1)  {  ?>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Action</label></div>
								<div  class="col-sm-7">
									<select name="action2" id="action2" required="form-control" class="form-control";>
									<option value="Action Taken">Action Taken</option>	
									<option value="Approved">Approved</option>
									<option value="Rejected">Rejected</option>
									</select>
								</div>
							</div>
							<?php } ?>

							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Action Details</label></div>
								<div class="col-sm-7">
									<input type="text" name="descrip2" id="descrip2" class="form-control">
								</div>
							</div>								
						</div>						
						<div class="modal-footer justify-content-between">						
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<input type="submit" name="Action" value="Save" class="btn btn-success">							
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
			url:"<?=base_url()?>index.php/Rfi/find_Rfi/"+info,
			dataType:"json",
			success:function(data){							
			var container = document.getElementById("inRows2");	
			while (container.hasChildNodes()) { container.removeChild(container.lastChild); }						
			var newColumn = document.createElement('div');
				newColumn.innerHTML = '<div class="form-group row"><div class="col-sm-3 "><label>Location</label></div><div class="col-sm-3 "><label>Date of Inspection</label></div><div class="col-sm-3 "><label>Time of Inspection</label></div><div class="col-sm-3 "><label>Remarks</label></div></div>'	
				newColumn.innerHTML = newColumn.innerHTML + '<div class="form-group row"><div class="col-sm-3"><input type="text" name="ch0" id="ch0" Required class="form-control"></div><div class="col-sm-3"><input type="date" name="md0" id="md0" Required class="form-control"></div><div class="col-sm-3"><input type="time" name="mt0" id="mt0" Required class="form-control"></div><div class="col-sm-3"><input type="text" name="rm0" id="rm0" Required class="form-control"></div><div class="col-sm-1"><input type="hidden"  name="rfiid0" id="rfiid0" class="form-control"></div></div>'	
				container.appendChild(newColumn);
				document.getElementById('rfiid0').value=data.rfiid;
				document.getElementById('ch0').value=data.location;
				document.getElementById('md0').value=data.mdate;
				document.getElementById('mt0').value=data.mtime;
				document.getElementById('rm0').value=data.rem;				
			}
		});
		
	}	
	
	function add(a) {	
		load_users(a);
		Load_chainagelist();
	}
	function Action(a) {
		var b = a.split(':');
		document.getElementById('rfiid2').value=b[0];
		document.getElementById('chd').value=b[1];					
		load_users(2);
	}
	function load_users(a){
		var ulist ="";				
	if(a==1){$("#ulist").empty(); ulist = document.getElementById("ulist");	}else{ $("#ulist2").empty();ulist = document.getElementById("ulist2");}
	
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Rfi/get_userid",
			dataType:"json",
			success:function(data){	
				var k = Object.keys(data).length;
				for (var i = 0; i < k; i++) {
					var option = document.createElement("option");	
					option.text = data[i].username;
					ulist.add(option);				
				}	
			}
		});	
	}
	function Load_chainagelist() {	
	var list2=document.getElementById("item");
	var c= list2.options[list2.selectedIndex].value;
	var chlist = document.getElementById("chlst");
	$("#chlst").empty();
	//alert(c);	
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Rfi/get_chainagelist/"+c,
			dataType:"json",
			success:function(data){	
				var k = Object.keys(data).length;
				if (k>0){$('#brfi').removeAttr('disabled');}else{$('#brfi').attr('disabled','disabled');}
				for (var i = 0; i < k; i++) {
					var option = document.createElement("option");					
					option.value =i;
					option.text = data[i].ch;
					chlist.add(option);
				}	
			}
		});	
		Load_rfiitem();	
	}

	function Load_rfiitem() {		
		var list2=document.getElementById("item");
		var list1 =document.getElementById("sitem");
		$("#sitem").empty();	
		var c= list2.options[list2.selectedIndex].value;
		var iname= list2.options[list2.selectedIndex].text;	
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Item/find_rfiitem/"+c,
			dataType:"json",
			success:function(data){	
				var k = Object.keys(data).length;			
			if(k>0){
				for (var l = 0; l < k; l++) {
					var option = document.createElement("option");
					option.value =  data[l].id;
					option.text = data[l].descrip;
					list1.add(option);
				}
			}else{
				var option = document.createElement("option");
				option.value = 0;
				option.text =iname;
				list1.add(option);
			}
			}
		});	
		
	}
	function prepare_fill_RFI() {

	var list1 =document.getElementById("proid");	
	var a= list1.options[list1.selectedIndex].text.split(":");	
	var e = document.getElementById("item");
	var v1 = e.options[e.selectedIndex].value;	
	var s = document.getElementById("sitem");
	var v2 = s.options[s.selectedIndex].value;	
	var ch = $("#chlst option:selected").text();
	if (v2.length<2){v2='0'+v2;}
	var nrfiid = a[0]+ v1 + v2 ;
	var rfientry =checkalreadyenter(nrfiid,ch);
	if(rfientry ==1){alert('RFI already issued for this section.');return;}	
	var vd =verifydrawing(ch,v1);
	if(vd>0){alert('Drawing not verified for this location');return;}
	var rrow = document.getElementById("rfirow").value;	
	
	if (rrow.length==0){rrow='0';}
	var rfiid='rfiid'+rrow;
	var loca='ch'+rrow;
	var md='md'+rrow;	
	var mt='mt'+rrow;
	var rm='rm'+rrow;
	var mdate = getFormattedDateTime();
	var container = document.getElementById("inRows");
	if (rrow.length<2){rrow='0'+rrow;}
	var nrfiid = nrfiid +mdate+rrow;
	//alert(nrfiid);
		//while (container.hasChildNodes()) { container.removeChild(container.lastChild); }						
	var newColumn = document.createElement('div');	
		//newColumn.innerHTML = '<div class="form-group row"><div class="col-sm-1"><input type="text" name="'+ rfiid +'" id="'+ rfiid +'" Readonly class="form-control"></div><div class="col-sm-3"><input type="text" name="'+ loca +'" id="'+ loca +'" Required onchange="javascript:checkchainage(this.id)" class="form-control"></div><div class="col-sm-3"><input type="date" name="'+ md +'" id="'+ md +'" Required class="form-control"></div><div class="col-sm-2"><input type="time" name="'+ mt +'" id="'+ mt +'" Required class="form-control"></div><div class="col-sm-3"><input type="text" name="'+ rm +'" id="'+ rm +'" Required class="form-control"></div></div>'	
		newColumn.innerHTML = '<div class="form-group row">' +
		'<div class="col-sm-1">' +
			'<input type="text" name="'+ rfiid +'" id="'+ rfiid +'" Readonly class="form-control">' +
		'</div>' +
		'<div class="col-sm-3">' +
			'<input type="text" name="'+ loca +'" id="'+ loca +'" Required onchange="javascript:checkchainage(this.id)" class="form-control">' +
		'</div>' +
		'<div class="col-sm-3">' +
			'<input type="date" name="'+ md +'" id="'+ md +'" Required class="form-control" min="<?php echo date('Y-m-d'); ?>">' +
		'</div>' +
		'<div class="col-sm-2">' +
			'<input type="time" name="'+ mt +'" id="'+ mt +'" Required onchange="javascript:check_datetime(this.id)" class="form-control" min="<?php echo date('H:i'); ?>">' +
		'</div>' +
		'<div class="col-sm-3">' +
			'<input type="text" name="'+ rm +'" id="'+ rm +'"  Required onchange="javascript:checkchainage(this.id)" class="form-control">' +
		'</div>' +
		'</div>';
		$("#rfirow").val(Number(rrow) + 1);
		container.appendChild(newColumn);
		document.getElementById(rfiid).value=nrfiid;
		document.getElementById(loca).value=ch;
		$('#brfi').attr('disabled','disabled');
		//alert(loca);
	
	}
	function View(c) {
		var table_data = '';
      $('#example2').empty();
	  const tabcaption = document.getElementById("h01");	
	  const itemname = document.getElementById("h02");	  
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Rfi/list_Rfi/"+c,
			dataType:"json",
			success:function(data){					
				var toval="";
				tabcaption.innerHTML = "RFI ID Number :"+data[0].rfiid;	
				var itemid=data[0].rfiid.substring(3,6);
				var sitemid=Number(data[0].rfiid.substring(6,8));
				if (sitemid>0){sitemid='/Sub item ';}else{sitemid=''}
				<?php foreach ($get_itemlist as $item):?>
					if (itemid == '<?=$item->a?>'){itemname.innerHTML = "RFI approval status of :"+'<?=$item->b?>'+sitemid;}
				<?php endforeach ?>

				var k = Object.keys(data).length;	
				var table = document.getElementById("myTable"); 				
				table_data += '<thead style="background-color: #464b58; color:white;">';
				table_data += '<tr>';
				table_data += '<td>Loation</td>';
				table_data += '<td>Date</td>';	
				table_data += '<td>Time</td>';	
				table_data += '<td>Remarks</td>';
				table_data += '<td>Action</td>';
				table_data += '<td>From user</td>';
				table_data += '<td>To user</td>';
				table_data += '</tr>';
				table_data += '</thead>';		
				table_data += '<tbody style="background-color: white;">';				
				for (var i=0;i<k;i++){	
					//if(data[i].action !=='Approved'){toval=data[i].muser;}else{toval='Paid';}
					table_data += '<tr>';
					table_data += '<td>' + data[i].location + '</td>';
					table_data += '<td>' + data[i].mdate + '</td>';
					table_data += '<td>' + data[i].mtime + '</td>';
					table_data += '<td>' + data[i].rem + '</td>';
					table_data += '<td>' + data[i].action + '</td>';
					table_data += '<td>' + data[i].mid + '</td>';
					table_data += '<td>' + data[i].muser + '</td>';
					table_data += '</tr>';
				}			
				table_data += '</tbody>'; 

				$('#example2').append(table_data);
   			 }	

		});
	}
	function verifydrawing(a,b) {	
	var c=0;
	var d=0;
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Rfi/verify_drawing/"+a+"/"+b,
			dataType:"json",
			async: false,
			success:function(data){	
				c=data[0].t;	
				d=data[0].a;
				//alert(c+'-'+d);
				if (c>0 && d>0){c=c-d;}else{c=1;}
			}
		});	
		return c;
	}
	function checkalreadyenter(i,c) {	
		var d=0;
		//alert(i+'-'+c);
		<?php $no=0; foreach ($get_Rfi as $Rfi) : $no++;?>
			var a = '<?=substr($Rfi->rfiid,0,8)?>';
			var b='<?=$Rfi->location?>';
			var cho=b.split('-');//from database chainage
			var chn=c.split('-');//selected chainage
			//alert(b);
			if (a == i) {
				if (cho.length==chn.length){					
					if (b==c){d=1;}else{
						if (cho.length==2 && !isWithinRange (chn[0], chn[1], cho[0], cho[1])) {d=b;}//already exist within range
					}
				}
			}
		<?php endforeach ?>
		return d;
	}
	function isWithinRange(a1, a2, b1, b2) { // a1,a2 lies inbetween b1 and b2	
    return (Number(a1) < Number(b1) && Number(a2) <= Number(b1)) || (Number(a1) >= Number(b2) && Number(a2) > Number(b2));
	}
	function getFormattedDateTime() {
		let now = new Date();
		
		let year = now.getFullYear().toString().slice(-2); // Get last two digits of the year
		let month = (now.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based, so add 1
		let day = now.getDate().toString().padStart(2, '0');
		let hours = now.getHours().toString().padStart(2, '0');
		let minutes = now.getMinutes().toString().padStart(2, '0');

		return `${year}${month}${day}${hours}${minutes}`;
	}

	function checkchainage(a) {	
		var b = a.replace(a.substr(0,2),'rfiid');
		var c = a.replace(a.substr(0,2),'ch');
		var rfiid = document.getElementById(b).value.substring(0, 8);; //rfiid
		document.getElementById("msg1").innerHTML='';
		var e = document.getElementById(c).value;//entered chainage	
		var chn=e.split('-');
		var yn =checkalreadyenter(rfiid,e);
		if(yn==0){			
			$('#save').removeAttr('disabled');document.getElementById("msg1").innerHTML='';				
		}else{
			document.getElementById("msg1").innerHTML='RFI already issued for location '+yn;$('#save').attr('disabled','disabled');
		}

	}

	function check_datetime(a) {		
		document.getElementById("msg1").innerHTML = '';
		var v1 = document.getElementById(a).value;
		var v2 = document.getElementById(a.replace('mt', 'md')).value;
		var cd = '<?php echo date('Y-m-d') ?>';
		var ct = '<?php date_default_timezone_set('Asia/Kolkata'); echo date('H:i') ?>';
		var vt = v1.split(':');
		var nt = ct.split(':');
		if (v2 == cd) {
			var v1InMinutes = parseInt(vt[0]) * 60 + parseInt(vt[1]);
			var ctInMinutes = parseInt(nt[0]) * 60 + parseInt(nt[1]);
			var difference = v1InMinutes - ctInMinutes;
			if(difference <0){document.getElementById("msg1").innerHTML='Time selection can not be in previous time on same date';$('#save').attr('disabled','disabled');}else{$('#save').removeAttr('disabled');document.getElementById("msg1").innerHTML='';}
		}else{
			$('#save').removeAttr('disabled');document.getElementById("msg1").innerHTML='';
		}

	}
</script>