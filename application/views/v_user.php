<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">System Users</h2>
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
		<div class="card rounded-0 shadow">
			<div class="card-header">
			<?php if (strpos($mauth,'211')>-1)  { ?>
			<br><a href="#add" data-toggle="modal" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New System User</a><br>
			<?php } ?>
			</div>
			<div class="card-body">
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
						<td>Full Name</td>
						<td>Username</td>
						<td>Email</td>
						<td>Level</td>
						<td>Action</td>
					</tr></thead>
				<tbody style="background-color: white;">
					<?php $no=0; foreach ($get_user as $user) : $no++;?>

					<tr>
						<td><?=$no?></td>
						<td><?=$user->fullname?></td>
						<td><?=$user->username?></td>
						<td><?=$user->email?></td>
						<td><?=$user->level?></td>				
						<td>
						<?php if (strpos($mauth,'212')>-1)  { ?>
							<a href="#edit" onclick="edit('<?=$user->user_code?>')" class="btn btn-success btn-sm" data-toggle="modal">Edit</a>
						<?php } if (strpos($mauth,'213')>-1)  { ?>	
							<a href="<?=base_url('index.php/user/hapus/'.$user->user_code)?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm">Delete</a>
						<?php } if (strpos($mauth,'214')>-1)  { ?>		
							<a href="#asign" onclick="asign('<?=$user->user_code?>')" class="btn btn-success btn-sm" data-toggle="modal">Assign</a>
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
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Add System User
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/user/add')?>" method="post">
					<div class="modal-body">
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Name</label></div>
							<div class="col-sm-7">
								<input type="text" name="fullname" required class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Username</label></div>
							<div class="col-sm-7">
								<input type="text" name="username" id="username2" required class="form-control" onchange="javascript:verifyusername(1)";>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Password</label></div>
							<div class="col-sm-7">
								<input type="password" name="password" required class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Email</label></div>
							<div class="col-sm-7">
								<input type="email" name="email" required class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Level</label></div>
							<div class="col-sm-7">
								<select type="text" name="level" id="level" required class="form-control" onclick="javascript:addautolist(1)";>
									<option>Admin</option>
									<option>Head Office</option>
								 	<option>Project Director</option>
									<option>Authority Engineers</option>
									<option>Contractor</option>
									<option>Other User</option>		
								</select> 
							</div>
						</div>
						<input type="text" name="selectedmenu" id="selectedmenu" required class="form-control">
						<div class="form-group row">			
							<div class="clist-group">
								<select name = 'menulist' id="menulist" size=10  multiple onclick="javascript:add_list(1)";>
								<option value='100'>ROAD MANAGEMENT</option>
								<option value='101'>Add</option>
								<option value='102'>Edit</option>
								<option value='103'>Delete</option>
								<option value='104'>Update KML</option>
								<option value='110'>PACKAGE MANAGEMENT</option>
								<option value='111'>Add</option>
								<option value='112'>Edit</option>
								<option value='113'>Delete</option>
								<option value='114'>Mile stone</option>
								<option value='115'>Award</option>
								<option value='120'>ITEM MANAGEMENT</option>
								<option value='121'>Add</option>
								<option value='122'>Edit</option>
								<option value='123'>Delete</option>
								<option value='130'>SECTION MANAGEMENT</option>
								<option value='131'>Add</option>
								<option value='132'>Edit</option>
								<option value='133'>Delete</option>
								<option value='134'>Progress Entry</option>
								<option value='135'>Scope Approval</option>	
								<option value='140'>TCS MANAGEMENT</option>
								<option value='141'>Add</option>
								<option value='142'>Edit</option>
								<option value='143'>Delete</option>
								<option value='150'>LOCATION ITEM MANAGEMENT</option>
								<option value='151'>Add</option>
								<option value='152'>Edit</option>
								<option value='153'>Delete</option>
								<option value='154'>Progress Entry</option>
								<option value='155'>Scope Approval</option>	
								<option value='160'>STAGE ITEM MANAGEMENTt</option>
								<option value='161'>Add</option>
								<option value='162'>Edit</option>
								<option value='163'>Delete</option>
								<option value='164'>Progress Entry</option>
								<option value='165'>Scope Approval</option>	
								<option value='170'>WEIGHTAGE MANAGEMENT</option>
								<option value='171'>Add</option>
								<option value='172'>Edit</option>
								<option value='173'>Delete</option>
								<option value='174'>Sub-Weightage Entry</option>
								<option value='175'>Weightage Approval</option>	
								<option value='180'>FINANCIAL PROGRESS</option>
								<option value='181'>Payment within Contract amount</option>
								<option value='182'>Auto Generate SPS</option>
								<option value='183'>Direcr Entry </option>
								<option value='184'>Payment not in Contract amount</option>
								<option value='185'>Delete Entry</option>
								<option value='190'>MAINTAINANCE ACTIVITY</option>
								<option value='191'>Add</option>
								<option value='192'>Edit</option>
								<option value='193'>Delete</option>
								<option value='194'>Progress Entry</option>
								<option value='200'>GENERAL REPORTS</option>
								<option value='201'>Indivisual Monthly progress Report </option>
								<option value='202'>Summary Of Monthly progress Report </option>
								<option value='210'>USER MANAGEMENT</option>
								<option value='211'>Add</option>
								<option value='212'>Edit</option>
								<option value='213'>Delete</option>
								<option value='214'>Assign Road</option>
								<option value='220'>PAYMENT FLOW MANAGEMENT</option>
								<option value='221'>Add</option>
								<option value='222'>Edit</option>
								<option value='223'>Delete</option>
								<option value='230'>HINDRANCE MANAGEMENT</option>
								<option value='231'>Add</option>
								<option value='232'>Edit</option>
								<option value='233'>Delete</option>
								<option value='240'>PHOTO MANAGEMENT</option>
								<option value='241'>Add</option>
								<option value='242'>Edit</option>
								<option value='243'>Delete</option>
								<option value='250'>PUNCH LIST MANAGEMENT</option>
								<option value='251'>Add</option>
								<option value='252'>Edit</option>
								<option value='253'>Delete</option>
								<option value='254'>Progress</option>
								<option value='260'>DOCUMENTS MANAGEMENT</option>
								<option value='261'>Add</option>
								<option value='262'>Edit</option>
								<option value='263'>Delete</option>
								<option value='264'>Action</option>	
								<option value='265'>View</option>									
								<option value='270'>RFI MANAGEMENT</option>
								<option value='271'>Add</option>
								<option value='272'>Edit</option>
								<option value='273'>Delete</option>
								<option value='274'>Action</option>	
								<option value='275'>View</option>	
								<option value='276'>Verifier</option>	
								<option value='280'>View Popup Message</option>
								<option value='290'>Contractor</option>	
								<option value='291'>Add</option>
								<option value='292'>Edit</option>
								<option value='293'>Delete</option>	
								</select>
								<select name = 'selmenu' id="selmenu" size=10 multiple ondblclick="javascript:remove_list(1)";>
																
								</select>
							</div>
						</div>
					</div>
					<p style="font-size:20px;color:red;"  id="msg1"></p>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<input type="submit" name="save" id="save" value="Save" class="btn btn-success">
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="edit">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Update User Info
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/user/user_update')?>" method="post">
					<div class="modal-body">
						<input type="hidden" name="user_code_lama" id="user_code_lama">
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Name</label></div>
							<div class="col-sm-7">
								<input type="text" name="fullname2" id="fullname2" required class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Username</label></div>
							<div class="col-sm-7">
								<input type="text" name="uname" id="uname" required class="form-control" onchange="javascript:verifyusername(2)";>
							</div>
						</div>
						
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Email</label></div>
							<div class="col-sm-7">
								<input type="email" name="email2" id="email2" required class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Status</label></div>
							<div class="col-sm-7">
								<select type="text" name="level2" id="level2" required class="form-control" onclick="javascript:addautolist(2)";>
									<option>Admin</option>
									<option>Head Office</option>
								 	<option>Project Director</option>
									<option>Authority Engineers</option>
									<option>Contractor</option>
									<option>Other User</option>	
								</select>
							</div>
						</div>
						<input type="text" name="selectedmenu2" id="selectedmenu2" required class="form-control">
						<div class="form-group row">			
							<div class="clist-group">
								<select name = 'menulist2' id="menulist2" size=10  multiple onclick="javascript:add_list(2)";>
								<option value='100'>ROAD MANAGEMENT</option>
										<option value='101'>Add</option>
										<option value='102'>Edit</option>
										<option value='103'>Delete</option>
										<option value='104'>Update KML</option>
										<option value='110'>PACKAGE MANAGEMENT</option>
										<option value='111'>Add</option>
										<option value='112'>Edit</option>
										<option value='113'>Delete</option>
										<option value='114'>Mile stone</option>
										<option value='115'>Award</option>
										<option value='120'>ITEM MANAGEMENT</option>
										<option value='121'>Add</option>
										<option value='122'>Edit</option>
										<option value='123'>Delete</option>
										<option value='130'>SECTION MANAGEMENT</option>
										<option value='131'>Add</option>
										<option value='132'>Edit</option>
										<option value='133'>Delete</option>
										<option value='134'>Progress Entry</option>
										<option value='135'>Scope Approval</option>	
										<option value='140'>TCS MANAGEMENT</option>
										<option value='141'>Add</option>
										<option value='142'>Edit</option>
										<option value='143'>Delete</option>
										<option value='150'>LOCATION ITEM MANAGEMENT</option>
										<option value='151'>Add</option>
										<option value='152'>Edit</option>
										<option value='153'>Delete</option>
										<option value='154'>Progress Entry</option>
										<option value='155'>Scope Approval</option>	
										<option value='160'>STAGE ITEM MANAGEMENTt</option>
										<option value='161'>Add</option>
										<option value='162'>Edit</option>
										<option value='163'>Delete</option>
										<option value='164'>Progress Entry</option>
										<option value='165'>Scope Approval</option>	
										<option value='170'>WEIGHTAGE MANAGEMENT</option>
										<option value='171'>Add</option>
										<option value='172'>Edit</option>
										<option value='173'>Delete</option>
										<option value='174'>Sub-Weightage Entry</option>
										<option value='175'>Weightage Approval</option>	
										<option value='180'>FINANCIAL PROGRESS</option>
										<option value='181'>Payment within Contract amount</option>
										<option value='182'>Auto Generate SPS</option>
										<option value='183'>Direcr Entry </option>
										<option value='184'>Payment not in Contract amount</option>
										<option value='185'>Delete Entry</option>
										<option value='190'>MAINTAINANCE ACTIVITY</option>
										<option value='191'>Add</option>
										<option value='192'>Edit</option>
										<option value='193'>Delete</option>
										<option value='194'>Progress Entry</option>
										<option value='200'>GENERAL REPORTS</option>
										<option value='201'>Indivisual Monthly progress Report </option>
										<option value='202'>Summary Of Monthly progress Report </option>
										<option value='210'>USER MANAGEMENT</option>
										<option value='211'>Add</option>
										<option value='212'>Edit</option>
										<option value='213'>Delete</option>
										<option value='214'>Assign Road</option>
										<option value='220'>PAYMENT FLOW MANAGEMENT</option>
										<option value='221'>Add</option>
										<option value='222'>Edit</option>
										<option value='223'>Delete</option>
										<option value='230'>HINDRANCE MANAGEMENT</option>
										<option value='231'>Add</option>
										<option value='232'>Edit</option>
										<option value='233'>Delete</option>
										<option value='240'>PHOTO MANAGEMENT</option>
										<option value='241'>Add</option>
										<option value='242'>Edit</option>
										<option value='243'>Delete</option>
										<option value='250'>PUNCH LIST MANAGEMENT</option>
										<option value='251'>Add</option>
										<option value='252'>Edit</option>
										<option value='253'>Delete</option>
										<option value='254'>Progress</option>
										<option value='260'>DOCUMENTS MANAGEMENT</option>
										<option value='261'>Add</option>
										<option value='262'>Edit</option>
										<option value='263'>Delete</option>
										<option value='264'>Action</option>	
										<option value='265'>View</option>									
										<option value='270'>RFI MANAGEMENT</option>
										<option value='271'>Add</option>
										<option value='272'>Edit</option>
										<option value='273'>Delete</option>
										<option value='274'>Action</option>	
										<option value='275'>View</option>	
										<option value='276'>Verifier</option>	
										<option value='280'>View Popup Message</option>
										<option value='290'>Contractor</option>	
										<option value='291'>Add</option>
										<option value='292'>Edit</option>
										<option value='293'>Delete</option>	
								</select>
								<select name = 'selmenu2' id="selmenu2" size=10 multiple ondblclick="javascript:remove_list(2)";>
																
								</select>
							</div>
						</div>
						<div id="inRows" class="form-group row"></div>	
					</div>
					<p style="font-size:20px;color:red;"  id="msg2"></p>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<input type="submit" name="edit" id="btnedit" value="Save" class="btn btn-success">
					</div>
				</form>
			</div>			
		</div>
	</div>
	<div class="modal fade" id="asign">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Update User Package access
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/user/user_update')?>" method="post">
					<div class="modal-body">
						<input type="hidden" name="user_code_lama2" id="user_code_lama2">
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Package List</label></div>
							<div class="col-sm-7">
								<input type="text" name="pkglist" id="pkglist"  class="form-control">
							</div>
						</div>						
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Select  Road</label></div>
							<div class="col-sm-7">
								<select type="text" name="pkgname"  id="pkgname" required class="form-control" onchange="javascript:proval()";>
									<?php foreach ($get_roadlist as $road):?>
											<option value="<?=$road->rid?>">
												<?=$road->rid.":".$road->rname ?>
											</option> 
									<?php endforeach ?>
								</select> 
							</div>
						</div>
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<input type="submit" name="asign" value="Save" class="btn btn-success">
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
			url:"<?=base_url()?>index.php/user/edit_user/"+a,
			dataType:"json",
			success:function(data){
				$("#user_code").val(data.user_code);
				$("#fullname2").val(data.fullname);
				$("#uname").val(data.username);
				$("#email2").val(data.email);	
				$("#selectedmenu2").val(data.autho);
				$("#user_code_lama").val(data.user_code);
				$("#selmenu2").empty();				
				$("#level2").val(data.level);
				
				var allitem = document.getElementById("menulist2");
				var sel = document.getElementById("selmenu2");		
				var b=data.autho;	
					for (var i = 0; i < allitem.length; i++) {					
						var rid= allitem.options[i].value;						
						if(b.includes(rid)){						
						var option = document.createElement("option");
						option.value = allitem.options[i].value;
						option.text = allitem.options[i].text;
						sel.add(option);}
					}
			}
		});
		
	}
	function asign(a) {
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/user/edit_user/"+a,
			dataType:"json",
			success:function(data){
				$("#pkglist").val(data.rlist);
				$("#user_code_lama2").val(data.user_code);
			}
		});
		}
	function proval() {
	//	alert("");
		var list1 =document.getElementById("pkgname");		
		var rid= list1.options[list1.selectedIndex].text.split(":");	
		var rlist =document.getElementById("pkglist").value;
		if (rlist.length >0){
		document.getElementById("pkglist").value=rlist+","+rid[0];}else{
			document.getElementById("pkglist").value=rid[0];	
		}
	}
	function verifyusername(a) {
		var uname ="";
		var mbutton ="";
		var msgbox ="";
	if (a==1){ 
		 uname =document.getElementById("username2").value;
		mbutton =document.getElementById('save');	
		 msgbox=	document.getElementById("msg1");
	}else{
		uname =document.getElementById("username").value;
		mbutton =document.getElementById('btnedit');	
		 msgbox=document.getElementById("msg2");
	}
		msgbox.innerHTML="";		
		mbutton.disabled = false;
		<?php foreach ($get_user as $user) :?>
		var u='<?=$user->username?>';
       	 if(uname==u){msgbox.innerHTML="User already exist.";mbutton.disabled ='disabled';}
		<?php endforeach ?>
	//alert(uname);

	}
	function add_list(a) {	
		var allitem ;
		var sel ;
		var showlist;
		if (a==1){
			allitem = document.getElementById("menulist");
			sel = document.getElementById("selmenu");
			showlist = document.getElementById("selectedmenu");
		}else{
			allitem = document.getElementById("menulist2");
			sel = document.getElementById("selmenu2");
			showlist = document.getElementById("selectedmenu2");
		}
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
	function addautolist(a) {	
		var allitem ;
		var sel ;
		var showlist;
		var mlevel;
		
		if (a==1){
			allitem = document.getElementById("menulist");
			sel = document.getElementById("selmenu");
			showlist = document.getElementById("selectedmenu");
			mlevel = document.getElementById("level");	
			$("#selmenu").empty();
		}else{
			allitem = document.getElementById("menulist2");
			sel = document.getElementById("selmenu2");
			showlist = document.getElementById("selectedmenu2");
			mlevel = document.getElementById("level2");
			$("#selmenu2").empty();
		}
		
		var rid= mlevel.selectedIndex;	
		var b="";
		
		if(rid==0){b="100,101,102,103,104,110,111,112,113,114,115,120,121,122,123,130,131,132,133,135,140,141,142,143,150,151,152,153,155,160,161,162,163,165,170,171,172,173,174,175,180,181,182,183,184,185,190,191,192,193,194,200,201,202,210,211,212,213,214,220,221,222,223,230,231,232,233,240,241,242,243,250,251,252,253,254,260,261,262,263,264,265,270,271,272,273,274,275,276,280,290,291,292,293";}
		if(rid==1){b="270,274,275,276,280,290,200,201,202";}
		if(rid==2){b="100,101,102,103,104,110,111,112,113,114,115,120,121,122,123,130,131,132,133,135,140,141,142,143,150,151,152,153,155,160,161,162,163,165,170,171,172,173,174,175,180,181,182,183,184,185,190,191,192,193,200,201,202,220,221,222,223,230,231,232,233,260,261,262,263,264,265,270,276,280,290,291,292,293";}
		if(rid==3){b="100,101,102,103,104,110,111,112,113,114,115,120,121,122,123,130,131,132,133,140,141,143,142,150,151,152,153,160,161,162,163,170,171,172,173,174,175,190,191,192,193,200,201,202,230,231,231,232,233,240,241,242,243,250,252,251,253,260,261,262,263,264,265,270,274,275,276,280,290,291,292,293";}//AE
		if(rid==4){b="270,271,272,273,274,275,260,261,262,263,264,265,250,254,240,241,242,243,220,221,222,223,200,201,202,190,190,191,192,193,194,180,181,182,183,184,185";}//contractor
		if(rid==5){b="";}//Other User

		showlist.value=b;
		for (var i = 0; i < allitem.length; i++) {					
			var rid= allitem.options[i].value;						
			if(b.includes(rid)){						
			var option = document.createElement("option");
			option.value = allitem.options[i].value;
			option.text = allitem.options[i].text;
			sel.add(option);}
		}
		
	}
	function remove_list(a) {	
			var sel ;
			var showlist;
			if (a==1){			
				sel = document.getElementById("selmenu");
			showlist = document.getElementById("selectedmenu");
			}else{			
				sel = document.getElementById("selmenu2");
			showlist = document.getElementById("selectedmenu2");
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
</script>

