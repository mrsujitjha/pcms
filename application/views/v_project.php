<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Package Details</h2>
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
			<?php if (strpos($mauth,'111')>-1)  { ?>
				<a href="#add"  onclick="add()" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add New Package</a>
			<?php } ?>
			</div>
		
			<div class=col-md-12 style="overflow-x: auto">
				<table class="table table-hover w-auto small table-bordered " id="example" ui-options=ui-options="{
					
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
							<td>SN</td>							
							<td>Tranche</td>
							<td>Mode</td>
							<td>Package Name</td>
							<td>Contract Amount</td>							
							<td>Appointed date</td>							
							<td>Contract Amount(COS)</td>
							<td>Date of Complition</td>
							<td>Extended date of Complition</td>
							<td>Awarded Length</td>
							<td>Awarded Length(COS)</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_project as $project) : $no++;?>
						<tr>							
							<td><?=$project->pkgsn?></td>
							<td><?=$project->tranche?></td>
							<td><?=$project->mode?></td>
							<td><?=$project->pkg?></td>
							<td><?=$project->camt?></td>							
							<td><?=$project->aptdate?></td>
							<td><?=$project->cosamt?></td>
							<td><?=$project->comdate?></td>
							<td><?=$project->excomdate?></td>
							<td><?=$project->awlength?></td>
							<td><?=$project->coslength?></td>
							<td class="text-center">
							<?php if (strpos($mauth,'112')>-1)  { ?>
								<a href="#edit" onclick="edit('<?=$project->pkgsn?>')" class="btn btn-primary btn-sm rounded-0" data-toggle="modal"><i class="fa fa-pencil"></i></a>
							<?php } if (strpos($mauth,'113')>-1)  {?>	
								<a href="<?=base_url('index.php/project/hapus/'.$project->pkgsn)?>" onclick="return confirm('Are you sure to delete this project?')" class="btn btn-danger btn-sm rounded-0"><i class="fa fa-trash"></i></a>
							<?php } if (strpos($mauth,'114')>-1)  {?>	
								<a href="#milestone" onclick="milestone('<?=$project->pkgsn.':'.$project->comdate.':'.$project->excomdate.':'.$project->aptdate?>')" class="btn btn-primary btn-sm rounded-0" data-toggle="modal"><i class="fa fa-calendar"></i></a>
							<?php } if (strpos($mauth,'115')>-1)  {?>	
							<a href="#award" onclick="award('<?=$project->pkgsn?>')" class="btn btn-primary btn-sm rounded-0" data-toggle="modal"><i class="fa fa-calendar-check-o"></i></a>
												
							<?php } ?>
							</td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="modal" id="add">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					Add New project
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/project/add')?>" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Package SN</label></div>
							<div class="col-sm-7">
								<input type="text" id="pkgsn" name="pkgsn" readonly required="form-control" class="form-control">
							</div>
						</div>						
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Tranche</label></div>
							<div class="col-sm-7">
								<input type="text" name="tranche" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Mode</label></div>
							<div class="col-sm-7">
								<input type="text" name="mode" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Package name</label></div>
							<div class="col-sm-7">
								<input type="text" name="pkg" required="form-control" class="form-control">
							</div>
						</div>						
						<div class="modal-footer justify-content-between">							
							<input type="submit" name="save" value="Save"  class="btn btn-success">
							<button type="button"  class="btn btn-danger" data-dismiss="modal">Close</button>
						</div>				
						
					</div>			
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="edit">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					Update project
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/project/project_update')?>" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<input type="hidden" name="editproid" id="editproid">
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Tranche</label></div>
							<div class="col-sm-7">
								<input type="text" name="tranche" id="tranche" required="form-control" class="form-control">
							</div>
						</div>

						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Mode</label></div>
							<div class="col-sm-7">
								<input type="text" name="mode" id="mode" required="form-control" class="form-control">
							</div>
						</div>

						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Package name</label></div>
							<div class="col-sm-7">
								<input type="text" name="pkg" id="pkg" required="form-control" class="form-control">
							</div>
						</div>
						
					</div>	
					<div class="modal-footer justify-content-between">
						<input type="submit" name="save" value="Save" class="btn btn-success">							
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>												
				</form>
			</div>			
		</div>
	</div>	
	<div class="modal fade" id="award">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					Project Awarded Details
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/project/project_update')?>" method="post" enctype="multipart/form-data">
					<div class="modal-body">
						<input type="hidden" name="awardid" id="awardid">
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Contractor Name</label></div>
							<div class="col-sm-7">
								<select name="conid" id="conid" required="form-control" class="form-control" >							
								
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Contract Amount</label></div>
							<div class="col-sm-7">
								<input type="text" id="e1" name="e1"  required="form-control" class="form-control">
							</div>
						</div>
						
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Appointed date</label></div>
							<div class="col-sm-7">
								<input type="date" id="e2" name="e2"   required="form-control" class="form-control">
							</div>
						</div>		
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Contract Amount(COS)</label></div>
							<div class="col-sm-7">
								<input type="text" id="e3" name="e3"   class="form-control">
							</div>
						</div>		
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Date of Complition</label></div>
							<div class="col-sm-7">
								<input type="date" id="e4" name="e4"   required="form-control" class="form-control">
							</div>
						</div>		
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Extended date of Complition</label></div>
							<div class="col-sm-7">
								<input type="text" id="e5" name="e5"  readonly class="form-control">
							</div>
						</div>		
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Awarded Length</label></div>
							<div class="col-sm-7">
								<input type="text" id="e6" name="e6"  required="form-control"  class="form-control">
							</div>
						</div>		
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Awarded Length(COS)</label></div>
							<div class="col-sm-7">
								<input type="text" id="e7" name="e7"  class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Performance Guarentee</label></div>
							<div class="col-sm-7">
								<input type="date" id="e8" name="e8"  required="form-control"  class="form-control">
							</div>
						</div>		
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Insurance Date</label></div>
							<div class="col-sm-7">
								<input type="date" id="e9" name="e9"  class="form-control">
							</div>
						</div>
					</div>		
					<div class="modal-footer justify-content-between">
						<input type="submit" name="awarded" value="Save" class="btn btn-success">							
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>
										
				</form>
			</div>			
		</div>
	</div>	
	<div class="modal fade" id="milestone">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					Update project Milestone and EOT
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/project/project_update')?>" method="post" enctype="multipart/form-data">
					<div class="modal-body">							
						<div class="form-group row">
							<div class="col-sm-3 "><label>Date of commencement</label></div>
							<div class="col-sm-3">
								<input type="date" id="m0" name="m0"  readonly class="form-control">
							</div>	
							<div class="col-sm-3"><label>Date of Complition</label></div>
							<div class="col-sm-3">
								<input type="text" id="m1" name="m1"  readonly class="form-control">
							</div>							
						</div>	
						<input type="hidden" id="pkgid" name="pkgid"  class="form-control">	
						
						
						<div class="form-group row">
							<div class="col-sm-3 "><label>Milestones</label></div>
							<div class="col-sm-2 "><label>TARGET PROGRESS</label></div>
							<div class="col-sm-2 "><label>DAYS</div>
							<div class="col-sm-2 "><label>PLANNED DATE</label></div>
							<div class="col-sm-3 "><label>ACHEIVED DATE</label></div>
						</div>	
						<div class="form-group row">
							<div class="col-sm-3"><label>Milestone-1</label></div>
							<div class="col-sm-2">
								<input type="text" id="pd1" name="pd1"   required="form-control" class="form-control">
							</div>		
							<div class="col-sm-2">
								<input type="text" id="md1" name="md1"   required="form-control" class="form-control" onchange="javascript:getmilestonedate(1)";>
							</div>												
							<div class="col-sm-2">
								<input type="text" id="dd1" name="dd1"  readonly required="form-control" class="form-control">
							</div>
							<div class="col-sm-3">
								<input type="date" id="ed1" name="ed1" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3"><label>Milestone-2</label></div>
							<div class="col-sm-2">
								<input type="text" id="pd2" name="pd2"   required="form-control" class="form-control">
							</div>		
							<div class="col-sm-2">
								<input type="text" id="md2" name="md2"   required="form-control" class="form-control" onchange="javascript:getmilestonedate(2)";>
							</div>												
							<div class="col-sm-2">
								<input type="text" id="dd2" name="dd2"  readonly required="form-control" class="form-control">
							</div>
							<div class="col-sm-3">
								<input type="date" id="ed2" name="ed2"    class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3"><label>Milestone-3</label></div>
							<div class="col-sm-2">
								<input type="text" id="pd3" name="pd3"   required="form-control" class="form-control">
							</div>		
							<div class="col-sm-2">
								<input type="text" id="md3" name="md3"   required="form-control" class="form-control" onchange="javascript:getmilestonedate(3)";>
							</div>												
							<div class="col-sm-2">
								<input type="text" id="dd3" name="dd3"  readonly required="form-control" class="form-control">
							</div>
							<div class="col-sm-3">
								<input type="date" id="ed3" name="ed3"  class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 "><label>Milestone-4</label></div>
							<div class="col-sm-2">
								<input type="text" id="pd4" name="pd4"   required="form-control" class="form-control">
							</div>		
							<div class="col-sm-2">
								<input type="text" id="md4" name="md4"   required="form-control" class="form-control" onchange="javascript:getmilestonedate(4)";>
							</div>												
							<div class="col-sm-2">
								<input type="text" id="dd4" name="dd4"  readonly required="form-control" class="form-control">
							</div>
							<div class="col-sm-3">
								<input type="date" id="ed4" name="ed4"    class="form-control">
							</div>
						</div>
						<div class="modal-footer justify-content-between">
							<input type="submit" name="update" value="UPDATE" class="btn btn-success">
							<div class="clist-group">
								<select name = 'mlist' id="mlist"  class="form-control"  onchange="javascript:loadrecord()";>
																	
								</select>								
							</div>
							<div  class="col-sm-4">
								<input type="text" hidden id="m2" name="m2"  class="form-control" onchange="javascript:calculateEOT()";>
							</div>
							<div hidden class="clist-group">
								<select  name = 'mlistall' id="mlistall"  class="form-control";>
																	
								</select>
							</div>							
							<input type="hidden" id="aggd" name="aggd" class="form-control">						
							<button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
						</div>
					</div>							
				</form>
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
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Project/edit_project/"+a,
			dataType:"json",
			success:function(data){				
				$("#editproid").val(data.pkgsn);
				$("#tranche").val(data.tranche);
				$("#mode").val(data.mode);
				$("#pkg").val(data.pkg);				
			}
				
		});		
	}	
	function award(a) {	
		const dropdown = document.getElementById("conid");	
		<?php foreach ($conlist as $con) :?>
			const option = document.createElement("option");
			var n='<?=$con->cname?>';
			var i='<?=$con->cid?>';
			option.value = i;
			option.text = n;
			dropdown.appendChild(option);
		<?php endforeach ?>
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Project/edit_project/"+a,
			dataType:"json",
			success:function(data){				
				$("#awardid").val(data.pkgsn);				
				$("#e1").val(data.camt);
				$("#e2").val(data.aptdate);	
				$("#e3").val(data.cosamt);
				$("#e4").val(data.comdate);
				$("#e5").val(data.excomdate);
				$("#e6").val(data.awlength);
				$("#e7").val(data.coslength);
				$("#e8").val(data.pguar);
				$("#e9").val(data.insu);
				$("#conid").val(data.cname);
			}
		});		
	}	
	function milestone(a) {		
		var b =a.split(":");
		var eotd=b[2];
		
		if (eotd.length <5){eotd=b[1];}
		$("#m0").val(b[3]);	
		$("#m1").val(eotd);	
		$("#pkgid").val(b[0]+":0");
		$("#mlist").empty();
		$("#mlistall").empty();
		cleanmilestone();
		var x = document.getElementById("mlist"); 
		var mlistall = document.getElementById("mlistall");  
		var option = document.createElement("option");
			option.value=0;	
			option.text ="Contract Milestone";
			x.add(option);
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Project/load_milestone/"+b[0],// all milestone
			dataType:"json",
			success:function(data){		
				var k = (Object.keys(data).length)/4;
				for (var i=1;i<=k;i++){	
					var option = document.createElement("option");
					option.value=i;
					if(i==k){option.text ="ISSUE EOT NO-" + i;x.add(option);}else{option.text ="VIEW EOT NO-" + i;x.add(option);	}
				}	
				for (var j=0;j<k;j++){	//store record for further use
					var option = document.createElement("option");
					option.value=j;
					var r=j*4;
					option.text = data[r].days + ":"+ data[r].per + ":"+ data[r].adate+ ":" + data[r+1].days + ":" + data[r+1].per+ ":"+ data[r+1].adate + ":" + data[r+2].days + ":" + data[r+2].per+ ":"+ data[r+2].adate + ":" + data[r+3].days + ":" + data[r+3].per+ ":"+ data[r+3].adate;
					mlistall.add(option);
				}
				x.selectedIndex=k-1;
				loadrecord();			
				EOT_enable();	
			}
				
		});		
	}	
	function loadrecord(){ 		
		var list2=document.getElementById("mlist");
		var sn= list2.options[list2.selectedIndex].value;
		var recno =document.getElementById("pkgid").value;
		var ndate =document.getElementById("m2");
		var aggdate =document.getElementById("m0").value;
		var b =recno.split(":");
		$("#pkgid").val(b[0]+":" + sn);
		var mlistall = document.getElementById("mlistall");  		
		if(mlistall.length-1< sn){	
			ndate.hidden=false;
		}else{
			ndate.hidden=true;
			var allval= mlistall.options[sn].text;
			var data=allval.split(":");		
			$("#md1").val(data[0]);	
			$("#pd1").val(data[1]);
			$("#ed1").val(data[2]);
			$("#dd1").val(getnewdate(aggdate,data[0]));
			$("#md2").val(data[3]);	
			$("#pd2").val(data[4]);
			$("#ed2").val(data[5]);
			$("#dd2").val(getnewdate(aggdate,data[3]));
			$("#md3").val(data[6]);	
			$("#pd3").val(data[7]);
			$("#ed3").val(data[8]);
			$("#dd3").val(getnewdate(aggdate,data[6]));
			$("#md4").val(data[9]);	
			$("#pd4").val(data[10]);
			$("#ed4").val(data[11]);
			$("#dd4").val(getnewdate(aggdate,data[9]));
			$("#aggd").val(data[0]+":"+data[3]+":"+data[6]+":"+data[9]);
		}
		EOT_enable();	
	}
	function cleanmilestone(){
		$("#md1").val("");	
		$("#pd1").val("");
		$("#dd1").val("");
		$("#md2").val("");	
		$("#pd2").val("");
		$("#dd2").val("");
		$("#md3").val("");	
		$("#pd3").val("");
		$("#dd3").val("");
		$("#md4").val("");	
		$("#pd4").val("");
		$("#dd4").val("");
	}
	function EOT_enable(){
		var m1ach =document.getElementById("ed1").value;
		var m2ach =document.getElementById("ed2").value;
		var m3ach =document.getElementById("ed3").value;
		var m4ach =document.getElementById("ed4").value;
		if(m1ach.length>0){  $("#md1").prop("readonly", true); $("#pd1").prop("readonly", true);  $("#ed1").prop("readonly", true);  };
		if(m2ach.length>0){  $("#md2").prop("readonly", true); $("#pd2").prop("readonly", true);  $("#ed2").prop("readonly", true);  };
		if(m3ach.length>0){  $("#md3").prop("readonly", true); $("#pd3").prop("readonly", true);  $("#ed3").prop("readonly", true);  };
		if(m4ach.length>0){  $("#md4").prop("readonly", true); $("#pd4").prop("readonly", true);  $("#ed4").prop("readonly", true);  };

	}
	function add() {	
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Project/get_projectid",
			dataType:"json",
			success:function(data){				
				$("#pkgsn").val(parseInt(data.pkgsn)+1);
			}
		});
	}
	function getdays(d){	
		var yrm =d.split("-");	
		var td="";
		if(yrm[0] % 4 == 0){td="0,31,60,91,121,152,182,213,244,274,305,335,366"; }
		else{td="0,31,59,90,120,151,181,212,243,273,304,334,365";}
		var mdays =td.split(",");
		let md=Number(mdays[yrm[1]-1])+Number(yrm[2]);
		return md;
	}
	function getmilestonedate(a){
		var mdtext;
		var ddtext;
		var cdate =document.getElementById("m0").value;
		switch (a) {
		case 1:
			mdtext=document.getElementById("md1");
			ddtext=document.getElementById("dd1");
			break;
		case 2:
			mdtext=document.getElementById("md2");
			ddtext=document.getElementById("dd2");
			break;
		case 3:
			mdtext=document.getElementById("md3");
			ddtext=document.getElementById("dd3");
			break;
		case 4:
			mdtext=document.getElementById("md4");
			ddtext=document.getElementById("dd4");
			break;
		}
		ddtext.value= getnewdate(cdate,mdtext.value);

	}
	function calculateEOT(a){
		var eotd =document.getElementById("m2").value;
		var m1ach =document.getElementById("ed1").value;
		var m2ach =document.getElementById("ed2").value;
		var m3ach =document.getElementById("ed3").value;
		var m4ach =document.getElementById("ed4").value;
		var md1 =document.getElementById("md1");
		var md2 =document.getElementById("md2");
		var md3 =document.getElementById("md3");
		var md4 =document.getElementById("md4");
		var md5 =document.getElementById("aggd").value;
		var olddays=md5.split(":");	
		if(m1ach.length==0){md1.value=Number(olddays[0])+Number(eotd);getmilestonedate(1);}
		if(m2ach.length==0){md2.value=Number(olddays[1])+Number(eotd);getmilestonedate(2);}
		if(m3ach.length==0){md3.value=Number(olddays[2])+Number(eotd);getmilestonedate(3);}
		if(m4ach.length==0){md4.value=Number(olddays[3])+Number(eotd);getmilestonedate(4);}
	}	
	function getnewdate(mdate,d){			
		var yrm =mdate.split("-");	
		var ny=yrm[0];
		var maxd=0;
		var md=get_totaldays(ny,yrm[1],Number(yrm[2]) + Number(d));		
		var j=Math.round(md/365,0);
		for(var i=0;i<j;i++){
			if(ny % 4 == 0){maxd=366;}else{maxd=365;}
			if(md > maxd){md= md-maxd;ny=Number(ny)+1;}
		}	
		var nmd =get_monthdays(ny,md);
		var newdate = nmd + "-" + ny;
		return newdate;
	}
	function get_totaldays(y,m,d){		
		var td="";
		var maxd=0;
		if(y % 4 == 0){td="0,31,60,91,121,152,182,213,244,274,305,335,366"; maxd=366;}
		else{td="0,31,59,90,120,151,181,212,243,273,304,334,365";maxd=365;}
		var mdays =td.split(",");
		let md=Number(mdays[m-1]) + Number(d);
		return md;
	}
	function get_monthdays(y,md){		
		var td="";
		var nm=0;
		var nd=0;
		if(y % 4 == 0){td="0,31,60,91,121,152,182,213,244,274,305,335,366";}
		else{td="0,31,59,90,120,151,181,212,243,273,304,334,365";}
		var mdays =td.split(",");
		for(var i=0;i<13;i++){if(Number(md) < Number(mdays[i])){nm=i;nd=Number(md)-Number(mdays[i-1]);break;}}		
		if (nd <1){nd =Number(mdays[i])-Number(mdays[i-1]);}
		if (nd < 10){nd ="0"+nd;}
		if (nm < 10){nm ="0"+nm;}
		return nd+"-"+nm;
	}
</script>