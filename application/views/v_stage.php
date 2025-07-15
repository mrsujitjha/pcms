<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom"> Stagewise progress of Road Item</h2>	
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
				<?php if (strpos($mauth,'161')>-1)  { ?>
				<a href="#add" onclick="add()" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add Stage Item</a>
				<?php } ?>
				<form action="<?=base_url('index.php/Stage/save_roadno')?>" method="post">	
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
						<?php	if (strpos($mauth,'165')>-1)  { ?>		
						<a href="<?=base_url('index.php/Stage/Approve')?>" onclick="return confirm('Are you sure to Approve it?')" class="btn btn-danger">APPROVE</a>
					<?php } ?>	
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-2"><label>Item Name</label></div>
					<div  class="col-sm-7">
					<select name="selitem" id="selitem" required="form-control" class="form-control" >
						<?php foreach ($get_stageitem as $item):?>
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
							<td>Id</td>
							<td>Chainage</td>
							<td>Length</td>
							<td>Span</td>
							<td>Description</td>
							<td>Action</td>
						</tr></thead>
					<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_stagedetail as $schedule) : $no++;?>

						<tr>
							<td><?=$schedule->id?></td>
							<td><?=$schedule->chainage?></td>
							<td><?=$schedule->length?></td>	
							<td><?=$schedule->span?></td>
							<td><?=$schedule->descrip?></td>											
							<td>	
								<?php if (strpos($mauth,'164')>-1)  { ?>
									<a href="#progress" onclick="progress('<?=$schedule->id?>')" class="btn btn-success btn-sm" data-toggle="modal">Progress</a>							
								<?php } ?>								
								<?php	if ((strpos($mauth,'162')>-1 && $schedule->wdone <2)||(strpos($mauth,'165')>-1 ))  {  ?>	
									<a href="#edit" onclick="edit('<?=$schedule->id?>')" class="btn btn-success btn-sm" data-toggle="modal">Edit</a>
								<?php } if (strpos($mauth,'163')>-1 && $schedule->wdone <2)  { ?>		
									<a href="<?=base_url('index.php/Stage/hapus/'.$schedule->id)?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm">Delete</a>
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
						Add Road Stage
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Stage/add')?>" method="post">
						<div class="modal-body">											
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Item Name</label></div>
								<div  class="col-sm-5">
								<select name="item" id="item" required="form-control" class="form-control"  onclick="javascript:loadstage()"; >
									<?php foreach ($get_stageitem as $item):?>
										<option > <?=$item->itemid.":".$item->name ?>	</option> 
									<?php endforeach ?>
								</select>
								</div>	
								<div class="col-sm-3">
								<select type="text" name="scn"  id="scn" class="form-control"; onchange="javascript:getnewid()";>
							
								</select> 
								</div>	
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Chainage</label></div>
								<div class="col-sm-7">
									<input type="text" name="ch" required class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Length</label></div>
								<div class="col-sm-7">
									<input type="text" name="length"  class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Span</label></div>
								<div class="col-sm-7">
									<input type="text" name="span"  class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Description</label></div>
								<div class="col-sm-7">
									<input type="text" name="descrip"  class="form-control">
								</div>
							</div>
							<div class="form-group row">
								
								<div class="col-sm-7">
									<input type="hidden" name="stages"  id="stages"  readonly class="form-control">
								</div>
							</div>
							<div class="form-group row">								
								<div class="col-sm-6">
									<select type="text" name="mstages" id="mstages" size=5 multiple  class="form-control" onclick="javascript:add_list(1)";>
																		
									</select> 
								</div>
								<div class="col-sm-6">
									<select type="text" name="sstages" id="sstages" size=5 multiple  class="form-control" onclick="javascript:remove_list(1)";>
																		
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
						Update Stage Detail
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Stage/Stage_update')?>" method="post">
						<div class="modal-body">
							<input type="hidden" name="user_code_lama" id="user_code_lama">	
							<input type="hidden" name="aadetails" id="aadetails">						
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Item Name</label></div>
								<div  class="col-sm-7">
								<input type="text" name="item2" id="item2" readonly class="form-control">
								</div>	
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Chainage</label></div>
								<div class="col-sm-7">
									<input type="text" name="ch2" id="ch2" required class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Length</label></div>
								<div class="col-sm-7">
									<input type="text" name="length2" id="length2"  class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Span</label></div>
								<div class="col-sm-7">
									<input type="text" name="span2" id="span2"  class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Description</label></div>
								<div class="col-sm-7">
									<input type="text" name="descrip2" id="descrip2" class="form-control">
								</div>
							</div>	
							<input type="hidden" name="stages2" id="stages2"  class="form-control">
								
							<div class="form-group row">								
								<div class="col-sm-6">
									<select type="text" name="mstages2" id="mstages2" size=5 multiple  class="form-control" onclick="javascript:add_list(2)";>
																		
									</select> 
								</div>
								<div class="col-sm-6">
									<select type="text" name="sstages2" id="sstages2" size=5 multiple  class="form-control" onclick="javascript:remove_list(2)";>
																		
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
		<div class="modal fade" id="progress">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Update Progress
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Stage/Stage_update')?>" method="post">
						<div class="modal-body">
							<input type="hidden" name="progcode" id="progcode">	
							<input type="hidden" name="tn" id="tn">				
							<div id="inRows" class="form-group row"></div>
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
		var Allstagelist =document.getElementById("mstages2");
		var stagelist =document.getElementById("sstages2");
		var allid;
		var selid;
		var alllist;
		$("#mstages2").empty();
		$("#sstages2").empty();	
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Stage/find_Stage/"+info,
			dataType:"json",
			success:function(data){		
				//alert(data[0].chainage);		
				$("#ch2").val(data[0].chainage);
				$("#item2").val(data[0].itemname);
				$("#length2").val(data[0].length);
				$("#span2").val(data[0].span);
				$("#descrip2").val(data[0].descrip);
				$("#stages2").val(data[0].stages);
				$("#user_code_lama").val(data[0].id);
				$("#aadetails").val(data.aadetails);		
			//	alert(data[0].id)	;	
				selid=data[0].stages.split(",");
				allid=data[0].idstg.split(",");
				alllist=data[0].allstg.split(",");							
				for (var l = 0; l < allid.length; l++) {
					var optmain = document.createElement("option");
					optmain.text = alllist[l];
					Allstagelist.add(optmain);
				}						
				for (var l = 0; l < selid.length; l++) {				
					var optsopt = document.createElement("option");
					optsopt.value=selid[l];
					optsopt.text = alllist[selid[l]-1];
					stagelist.add(optsopt);
				}
			}
		});
		
	}
	function add() {	
	var list1 =document.getElementById("proid");	
	var a= list1.options[list1.selectedIndex].text.split(":");	
		var sc=1;		
		<?php $no=0; foreach ($get_roadlist as $road) : $no++;?>	
			var rno ='<?=$road["rid"]?>';
			if (rno==a[0]){var seslength ='<?=$road["sc"];?>';}		
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
	function loadstage() {	
		var list1 =document.getElementById("item");	
		var a= list1.options[list1.selectedIndex].text;	
		var Allstagelist =document.getElementById("mstages");
		var alllist;
		var b=a.split(":")	
		$("#mstages").empty();				
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Stage/find_allStages/"+b[0],
			dataType:"json",
			success:function(data){	
				//alert(data[0].allstg);
				alllist=data[0].allstg.split(",");	
				for (var l = 0; l < alllist.length; l++) {
					var optmain = document.createElement("option");					
					optmain.text = alllist[l];
					Allstagelist.add(optmain);
				}
				}
		});
	}
	function progress(a) {
		var table = $('#example').DataTable();
		var i=(table.page.info().page);	
		var info = a+ ":"+i;
		var nstages='';
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Stage/find_Stage/"+info,
			dataType:"json",
			success:function(data){	
			//document.getElementById("progcode").value=a+":"+data[0].stages;			
			var span=data[0].span;
			var codename=data[0].stages.split(",");
			var alllist=data[0].allstg.split(",");	
			var container = document.getElementById("inRows");
			while (container.hasChildNodes()) { container.removeChild(container.lastChild); }
			var iname=0;	
			for (var i=0;i<codename.length;i++){
				var nn=alllist[codename[i]-1];
				var rn;							
			if (nn=='Span' || nn=='Foundation') {
				if (nn=='Foundation') {rn=Number(span)+1;}else{rn=span;}
				for (var j=1;j<=rn;j++){
					var r = document.createElement('div');
					r.class=="form-group row";	
					iname=iname+1
					var icode ='P'+iname;
					r.innerHTML = '<div class="col-sm-12"><label>'+ nn+'-'+j +'</label></div><div class="col-sm-12"><select type="text" name='+icode+' id='+icode+' class="form-control"><option>NOT STARTED</option><option>IN PROGRESS</option><option>COMPLETED</option></select></div>';	
					container.appendChild(r);
				  if(nstages==''){nstages=codename[i];}else{nstages=nstages+','+codename[i];}
				}
			}else{
				iname=iname+1;
				var r1 = document.createElement('div');
				r1.class=="form-group row";
				var icode ='P'+iname;
				r1.innerHTML = '<div class="col-sm-12"><label>'+ alllist[codename[i]-1] +'</label></div><div class="col-sm-12"><select type="text" name='+icode+' id='+icode+' class="form-control"><option>NOT STARTED</option><option>IN PROGRESS</option><option>COMPLETED</option></select></div>';	
				container.appendChild(r1);
				if(nstages==''){nstages=codename[i];}else{nstages=nstages+','+codename[i];}
			}
						
			}
			document.getElementById("progcode").value=a+":"+nstages;	
			document.getElementById("tn").value=iname;
			//alert(data[0].status)	;
			var progress=data[0].status.split(",");
				for (var i=1;i<=progress.length;i++){
					var tcode='P'+i;
					var wbox = document.getElementById(tcode);
					wbox.value=progress[i-1];
				}	
				
			}
		});
		
	}
	function add_list(a) {	
		var allitem ;
		var sel ;
		var showlist;
		if (a==1){
			allitem = document.getElementById("mstages");
			sel = document.getElementById("sstages");
			showlist = document.getElementById("stages");
		}else{
			allitem = document.getElementById("mstages2");
			sel = document.getElementById("sstages2");
			showlist = document.getElementById("stages2");
		}
	var listLength = allitem.length;
	var myselection="";	
	for(var i=0;i<listLength;i++){
		if(allitem.options[i].selected){ 			
			var optmain = document.createElement("option");
			optmain.value=i+1;
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
function remove_list(a) {	
		var sel ;
		var showlist;
		if (a==1){			
			sel = document.getElementById("sstages");
			showlist = document.getElementById("stages");
		}else{			
			sel = document.getElementById("sstages2");
			showlist = document.getElementById("stages2");
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

