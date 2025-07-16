<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Drawing List</h2>	
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
				<?php if (strpos($mauth,'261')>-1)  { ?>	
				<a href="#add" onclick="add()" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add Drawings</a>
				<?php } ?>
				<form action="<?=base_url('index.php/Drawings/save_roadno')?>" method="post">	
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
						<tr><td>Drawing type </td>							
							<td>Location</td>
							<td>status</td>
							<td>User</td>							
							<td>Remarks</td>
							<td>Action</td>
						</tr></thead>
					<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_Drawings as $Drawings) : $no++;?>

						<tr>
							<td><?=$Drawings->dtype?></td>
							<td><?=$Drawings->TCS?></td>
							<td><?=$Drawings->status?></td>
							<td><?=$Drawings->userid?></td>	
							<td><?=$Drawings->rem?></td>										
							<td>
								<?php	if (strpos($mauth,'262')>-1 && ($Drawings->status =='Submited for review.') && ($Drawings->userid ==$this->session->userdata('username')))  {  ?>	
									<a href="#edit" onclick="edit('<?=$Drawings->didn?>')" class="btn btn-success btn-sm" data-toggle="modal"><i class="fa fa-pencil"></i></a>
								<?php	} if (strpos($mauth,'263')>-1 && ($Drawings->status =='Submited for review.') && ($Drawings->userid ==$this->session->userdata('username')))  {  ?>										
									<a href="<?=base_url('index.php/Drawings/hapus/'.$Drawings->didn)?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
								<?php	} if (strpos($mauth,'264')>-1 && $Drawings->status <>'Approved') {  ?>										
									<a href="#Action" onclick="Action('<?=$Drawings->didn.':'.$Drawings->fname?>')" class="btn btn-primary btn-sm" data-toggle="modal">Action</a>
								<?php	} if (strpos($mauth,'265')>-1)  {  ?>										
									<a href="#progress" onclick="progress('<?=$Drawings->didn?>')" class="btn btn-primary btn-sm" data-toggle="modal">View</a>
						
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
						Add Road Drawings
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
				
					<form action="<?=base_url('index.php/Drawings/add')?>" method="post" enctype="multipart/form-data">
			
						<div class="modal-body">
							<div class="form-group row">
								<input type="hidden" id="sechid" name="sechid" Readonly required class="form-control">
							</div>		
							<input type="hidden" id="itype" name="itype" />
							<input type="hidden" id="tcstext" name="tcstext" />						
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Drawing Type</label></div>
								<div  class="col-sm-7">
								<select name="item" id="item" required="form-control" class="form-control" onchange="javascript:getnewid()";>
								<option value=1>Plan and Profile - Linear</option>
									<option value=2>Culverts - Point</option>
									<option value=3>Major Bridges- Point</option>
									<option value=4>Minor Bridges- Point</option>
									<option value=5>VUP/CUP/PUP/VOP- Point</option>
									<option value=6>ROB - Point</option>
									<option value=7>Typical Cross-sections - Typical</option>
									<option value=8>Toll Plaza- Point</option>
									<option value=9>ATMS - Typical</option>
									<option value=10>Drainage Plan- Linear</option>
									<option value=11>Drain design- Linear</option>
									<option value=12>Major Junction – Point</option>
									<option value=13>Minor Junction – Point</option>
									<option value=14>Grade separated Junctions - Point</option>
									<option value=15>Street Lighting - Linear</option>
									<option value=16>Project facilities provided</option>
									<option value=17>Pedestrian Crossing - Typical</option>
									<option value=18>Landscaping and horticulture - Linear</option>
									<option value=19>Drawing of typical details slope protection wall measures - Typical</option>
									<option value=20>traffic diversion plans - Point</option>
									<option value=21>road furniture items - Typical</option>
									<option value=22>Others </option>
								</select>
								</div>	
							</div>						
							<div class="form-group row">
								<div class="col-sm-10 offset-1">							
									<input type="file" id="mydoc" name="mydoc" required class="form-control"/>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Chainage</label></div>
								<div class="col-sm-7">
									<input type="text" name="tcslist" id="tcslist" class="form-control">	
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
						Update Drawings Detail
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Drawings/Drawings_update')?>" method="post">
						<div class="modal-body">
							<input type="hidden" name="user_code_lama" id="user_code_lama">						
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Chainage</label></div>
								<div class="col-sm-6">
								<input type="text" name="tcslist2" id="tcslist2" class="form-control">
								
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
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						Drawings approval status
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
		<div class="modal" id="Action">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Revised and Approval of Drawings
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>				
					<form action="<?=base_url('index.php/Drawings/Drawings_update')?>" method="post" enctype="multipart/form-data">
						<div class="modal-body">	
						<input type="hidden" name="dcode" id="dcode" class="form-control">			
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Existing Attachment</label></div>
								<div class="col-sm-6">
								<input type="text" name="attach" id="attach" class="form-control">
								</div>
								<div class="col-sm-1">
								<button type="button" class="btn btn-primary btn-sm" onclick="javascript:Downloaddoc()"; ><i class="fa fa-download"></i>	
								</div>
								
							</div>		
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Action Type</label></div>
								<div  class="col-sm-8">
								<select name="mstatus" id="mstatus" required="form-control" class="form-control" onchange="javascript:getaction()";>
									<option >Comments For Revision </option>
									<option >Submission For Approval</option>
									<option >Approved</option>
								</select>
								</div>	
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1">							
									<input type="file" id="myattach" name="myattach" />
								</div>
							</div>												
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Remarks</label></div>
								<div class="col-sm-8">
								<input type="text" name="remany" id="remany" class="form-control">
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
			url:"<?=base_url()?>index.php/Drawings/find_Drawings/"+info,
			dataType:"json",
			success:function(data){				
				$("#tcslist2").val(data.TCS);
				$("#rem2").val(data.rem);
				$("#user_code_lama").val(data.didn);	
			}
		});
		
	}
	function Action(a) {	
		var dcode=a.split(":");	
		$("#attach").val(dcode[1]);
		$("#dcode").val(dcode[0]);	
	}
	function Downloaddoc() {	
		var mpath =document.getElementById("attach").value;	
		  window.open('<?=base_url()?>assets/drawings/'+mpath);
	}
	function progress(c) {
		var table_data = '';
      $('#example2').empty();
	  const tabcaption = document.getElementById("h01");	 
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Drawings/list_Drawings/"+c,
			dataType:"json",
			success:function(data){	
				var k = Object.keys(data).length;	
				var toval="";			
				//alert(data[i].fincode);
				tabcaption.innerHTML = data[0].dtype + " for selected Tcs : " + data[0].TCS ;	
				var table = document.getElementById("myTable"); 				
				table_data += '<thead style="background-color: #464b58; color:white;">';
				table_data += '<tr>';
				table_data += '<td>Status</td>';
				table_data += '<td>User ID </td>';	
				table_data += '<td>Remarks</td>';	
				table_data += '<td>Attachment</td>';
				table_data += '<td>Download</td>';
				table_data += '</tr>';
				table_data += '</thead>';		
				table_data += '<tbody style="background-color: white;">';				
				for (var i=0;i<k;i++){	
					if(data[i].toid !=='Paid'){toval=data[i].tuser;}else{toval='Paid';}
					table_data += '<tr>';
					table_data += '<td>' + data[i].status + '</td>';
					table_data += '<td>' + data[i].userid + '</td>';
					table_data += '<td>' + data[i].rem + '</td>';
					table_data += '<td>' + data[i].fname + '</td>';
					table_data += '<td><a href="<?=base_url()?>assets/drawings/'+data[i].fname+'" class="btn btn-primary btn-sm"><i class="fa fa-download"></i></a></td>';																								 
					table_data += '</tr>';
				}			
				table_data += '</tbody>'; 

				$('#example2').append(table_data);
   			 }	

		});
	}
	function getaction() {	
		var list1 =document.getElementById("mstatus");	
		var a= list1.options[list1.selectedIndex].text;
		if(a=='Approved'){document.getElementById("myattach").disabled = true;}else{document.getElementById("myattach").disabled = false;}
	}
	function add() {			
		getnewid();
	}
	function getnewid() {	
	var list1 =document.getElementById("proid");	
	var a= list1.options[list1.selectedIndex].text.split(":");	
	var list2=document.getElementById("item");
	var b= list2.options[list2.selectedIndex].value;	
	var list3=document.getElementById("tcslist");	
	var c=a[0]+b;
	//alert(c);	
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Drawings/get_Drawingsid/"+c,
			dataType:"json",
			success:function(data){	
				if(data.ricode==null){c=c+'01';}else{
					var nv=Number(data.ricode.substring(6,8))+1;
					if (nv < 10){c=c+"0"+nv;}else{c=c+nv;}
				}
				$("#sechid").val(c);
				$("#itype").val(list2.options[list2.selectedIndex].text);
				$("#tcstext").val(list3.options[list3.selectedIndex].text);
			}
		});	
		
	}
</script>

