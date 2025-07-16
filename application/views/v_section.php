<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Road Section</h2>
  </div>
</header>
<body onload="proval()">
<div class="table-agile-info">	
	<div class="container-fluid">
		<?php $mauth=$this->session->userdata('autho') ; if ($this->session->flashdata('message')!=null) {
		echo "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>"
			.$this->session->flashdata('message')."<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span>
			</button> </div>";
		} ?>
		<br>
		<div class="card rounded-0 shadow">
			<div class="card-header">
				<?php if (strpos($mauth,'131')>-1)  { ?>	
				<a href="#add" onclick="add()" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add Section Detail</a>
			    <?php } ?>
				<form action="<?=base_url('index.php/Section/save_roadno')?>" method="post">	
				<div class="form-group row">
					<div class="col-sm-2 "><label>Road Name</label></div>
					<div class="col-sm-6">
						<select name="proid" id="proid" required="form-control" class="form-control" onclick="javascript:proval()"; >
				
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
					<?php	if (strpos($mauth,'135')>-1)  { ?>		
						<a href="<?=base_url('index.php/Section/Approve')?>" onclick="return confirm('Are you sure to Approve it?')" class="btn btn-danger">APPROVE</a>
					<?php } ?>	
					</div>										
				</div>

				<div class="row justify-content-md-left">	
				<?php $mauth=$this->session->userdata('autho') ;
					 if (strpos($mauth,'140')>-1) {?>	
							<div class="col-sm-2">
							<li><a href="<?php echo base_url('index.php/Tcsmgm');?>"><span>TCS Code</span></a></li>
							</div>
					<div class="col-sm-3">
						<select type="text" name="tcsselcode"  id="tcsselcode"  class="form-control" onclick="javascript:proval()";>
							<?php foreach ($get_tcslist as $road):?>
									<option value="<?=$road->itemid?>">
										<?=$road->name ?>
									</option> 
							<?php endforeach ?>
						</select> 
					</div>
					<?php } ?>
					
					<?php	if (strpos($mauth,'134')>-1)  { ?>
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
					<?php } ?>
					</div>	
				</div>	
				</form>
			
				<input type="hidden" name="tcsidgen" id="tcsidgen">			
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
							<td>Section Id</td>
							<td>From Chainage</td>
							<td>To chainage</td>
							
							<td>Action</td>
						</tr></thead>
					<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_section as $section) : $no++;?>

						<tr>
							<td><?=$section->roadid?></td>
							<td><?=$section->fromch?></td>
							<td><?=$section->toch?></td>							
							<td>								
								<?php if (strpos($mauth,'134')>-1)  { ?>	
								<a href="#progress" onclick="progress('<?=$section->roadid.':'.$section->fromch.':'.$section->toch.':'.$section->tcsid?>')" class="btn btn-success btn-sm" data-toggle="modal">Progress</a>
								<?php } ?>								
								<?php	if ((strpos($mauth,'132')>-1 && $section->wdone <2)||(strpos($mauth,'135')>-1 ))  {  ?>	
								<a href="#edit" onclick="edit('<?=$section->roadid?>')" class="btn btn-success btn-sm" data-toggle="modal">Edit</a>
								<?php } if (strpos($mauth,'133')>-1  && $section->wdone <2)  { ?>		
									<a href="<?=base_url('index.php/Section/hapus/'.$section->roadid)?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm">Delete</a>
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
						Add Road Section
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Section/add')?>" method="post">
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-3 "><label>Section ID</label></div>
								<div class="col-sm-6">
									<input type="text" id="secid" name="secid" Readonly required class="form-control">
								</div>
								<div class="col-sm-3">
								<select type="text" name="scn"  id="scn"  class="form-control"; onchange="javascript:getnewid()";>
							
								</select> 
								</div>	
							</div>
							<div class="form-group row">
								<div class="col-sm-3 "><label>From chainage</label></div>
								<div class="col-sm-6">
									<input type="text" name="fromch2" id="fromch2" required class="form-control" onchange="javascript:checktcschainage(2)";>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 "><label>To chainage</label></div>
								<div class="col-sm-6">
									<input type="text" name="toch2" id="toch2" required class="form-control" onchange="javascript:checktcschainage(2)";>
								</div>
							</div>
							
							<input type="hidden" name="selitem2" id="selitem2" required class="form-control">
							<div class="form-group row">	
								<div class="col-sm-6 "> <p>Selected section Lane Type:</p></div>
									<input type="radio" id="2lane" name="lane" value="C" checked="checked">
									<label for="2lane">2-Lane</label>
									<input type="radio" id="4lane" name="lane" value="LR">
									<label for="4lane">4-Lane</label>
								</div>
								<div class="modal-footer justify-content-between">							
									<input type="submit" name="save" id="save" value="Save" class="btn btn-success">
									<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>								
									<p style="font-size:20px;color:red;"  id="msg2"></p>
								</div>

								<div class="clist-group">
									<select name = 'itemlist2' id="itemlist2" size=10 multiple onclick="javascript:add_list(1)";>
										<?php foreach ($get_item as $item): ?>
											<option value="<?=$item->itemid?>"><?php echo $item->name ?></option>
										<?php endforeach ?>									
									</select>
									<select name = 'itemlistsel2' id="itemlistsel2" size=10 multiple ondblclick="javascript:remove_list(1)";>
																
									</select>	
								</div>
							</div>			
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal" id="progress">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						Update Section wise physical progress &nbsp &nbsp <input type="trext" name="sectionch" id="sectionch" readonly>
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
							
					</div>				
					
					<form action="<?=base_url('index.php/Section/delphy')?>" method="post">
						<input type="hidden" name="selyrmonth" id="selyrmonth">	
						<input type="hidden" name="filtertext" id="filtertext">	
						<input type="hidden" name="oldrecord" id="oldrecord">	
						<input type="hidden" name="checkentrydata" id="checkentrydata">	
						
						<div class="modal-body">
							<div id="inRows" class="form-group row"></div>	

							<div class="modal-footer justify-content-between">
								<input type="submit" name="prog" value="Save" class="btn btn-success">
								<div class="clist-group">
									<select name = 'recordlist' id="recordlist"  class="form-control"  onchange="javascript:loadrecord()";>
																		
									</select>
								</div>
								
								<p style="font-size:20px;color:red;"  id="msg1"></p>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>								
							</div>							
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="edit">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Update Section Detail
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Section/Section_update')?>" method="post">
						<div class="modal-body">
							<input type="hidden" name="user_code_lama" id="user_code_lama">
							<input type="hidden" name="aadetails" id="aadetails">						
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>From Chainage</label></div>
								<div class="col-sm-7">
									<input type="text" name="fromch" id="fromch" required class="form-control" onchange="javascript:checktcschainage(1)";>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>TO Chainage</label></div>
								<div class="col-sm-7">
									<input type="text" name="toch" id="toch" required class="form-control" onchange="javascript:checktcschainage(1)";>
								</div>
							</div>
							<input type="hidden" name="selitem" id="selitem"  required class="form-control">
						
							<div class="modal-footer justify-content-between">
							<input type="submit" name="edit" id="editbutton" value="Save" class="btn btn-success">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<p style="font-size:20px;color:red;"  id="msg3"></p>							
							</div>	
							<div class="form-group row">			
								<div class="clist-group">
									<select name = 'itemlist' id="itemlist" size=10  multiple onclick="javascript:add_list(2)";>
										<?php foreach ($get_item as $item): ?>
											<option value="<?=$item->itemid?>"><?php echo $item->name ?></option>
										<?php endforeach ?>									
									</select>
									<select name = 'itemlistsel' id="itemlistsel" size=10 multiple ondblclick="javascript:remove_list(2)";>
																	
									</select>
								</div>
							</div>
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
		var proitem;
		var prolist =document.getElementById("itemlistsel");
		var sel = document.getElementById("itemlist");
		var listLength;
		
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Section/find_section/"+info,
			dataType:"json",
			success:function(data){				
				$("#fromch").val(data.fromch);
				$("#toch").val(data.toch);
				$("#selitem").val(data.tcsid);
				$("#user_code_lama").val(data.roadid);	
				$("#aadetails").val(data.aadetails);	
				var x=data.tcsid;		
				proitem=x.split(",");
				$("#itemlistsel").empty();				
				for (var l = 0; l < proitem.length; l++) {
					var option = document.createElement("option");
					for(var i=0;i<sel.length;i++){if(proitem[l]==sel[i].value){
						option.value = sel[i].value;	
						option.text = sel[i].text;						
						prolist.add(option);break;}}
				}
			}
		});
	}
	function add() {
	var a=document.getElementById("tcsidgen").value;	
	var alltcs='';
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Section/get_sectionid/"+a,
			dataType:"json",
			success:function(data){		
				data=data+1;
				if (data <10){data="0"+data;}
				$("#secid").val(a+"-LR-"+data);		
			}
		});	
		var num = $("#scn").length;
		$("#scn").val(num+1);
	}
	function getnewid() {
	var otext=document.getElementById("tcsidgen").value;	
	var b=document.getElementById("scn").value;	
	var a=otext.substring(0,4)+b+otext.substring(5);
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Section/get_sectionid/"+a,
			dataType:"json",
			success:function(data){		
				data=data+1;
				if (data <10){data="0"+data;}
				$("#secid").val(a+"-LR-"+data);		
			}
		});	
		
	}
	function add_list(a) {	
		var allitem ;
		var sel ;
		var showlist;
		if (a==1){
			allitem = document.getElementById("itemlist2");
			sel = document.getElementById("itemlistsel2");
			showlist = document.getElementById("selitem2");
		}else{
			allitem = document.getElementById("itemlist");
			sel = document.getElementById("itemlistsel");
			showlist = document.getElementById("selitem");
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
	function remove_list(a) {	
			var sel ;
			var showlist;
			if (a==1){			
				sel = document.getElementById("itemlistsel2");
				showlist = document.getElementById("selitem2");
			}else{			
				sel = document.getElementById("itemlistsel");
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
	function proval(){  
		var myselection;
		var tcsid;
		var list1 =document.getElementById("proid");
		var list2=document.getElementById("tcsselcode");
		var sc=1;
		myselection= list1.options[list1.selectedIndex].text.split(":");
		tcsid= list2.options[list2.selectedIndex].text;
		<?php $no=0; foreach ($get_roadlist as $road) : $no++;?>	
			var rno ='<?=$road["rid"]?>';
			if (rno==myselection[0]){var seslength ='<?=$road["sc"];?>';}		
		<?php endforeach ?>	
		//alert(seslength);
		localStorage.setItem("seslength", seslength);
		var l=seslength.split('-');
		sc=l.length;
		document.getElementById("tcsidgen").value=myselection[0]+'H'+sc+tcsid;  
		var x = document.getElementById("scn");
		if (sc >1 ) {
			for (var i = 1; i <= sc; i++) {
			var option = document.createElement("option");
			option.text =i;
			x.add(option);
			}
		}
	}
	function loadrecord(){  
	var list2=document.getElementById("recordlist");
	var myselection= list2.options[list2.selectedIndex].text.split(":");
	
	var myitem = document.getElementById("selyrmonth").value.split("::");
	var data=myitem[2].split(",");
	var k=data.length;
	var i=0;
		for (i=0;i<k;i++){
			document.getElementById(data[i]).value="";	
			document.getElementById('fch'+data[i]).value="";	
			document.getElementById('tch'+data[i]).value="";
		}
	var myrecord = document.getElementById("oldrecord").value.split("::");	
	var selrecord=myrecord[myselection[1]].split(":");	
    k=selrecord.length;
	//alert(selrecord[0]);
		for (i=0;i<k;i++){
			var ndata=selrecord[i].split(",");			
			document.getElementById('fch'+ndata[0]).value=ndata[1];	
			document.getElementById('tch'+ndata[0]).value=ndata[2];
			document.getElementById(ndata[0]).value=ndata[2]*1-ndata[1]*1;	
		}
	}
	function progress(a){	
		var rid;
		var myselyr;
		var myselmonth;		
		var newcode;
		var codename;
		var mylist="";
		var b=a.split(":");
		newcode=b[3].split(",");
		var j=newcode.length;
		
		var myear =document.getElementById("pyear");
		var mymonth=document.getElementById("pmonth");
		var list1 =document.getElementById("proid");	

		rid= list1.options[list1.selectedIndex].text.split(":");
		myselyr= myear.options[myear.selectedIndex].text;
		myselmonth= mymonth.options[mymonth.selectedIndex].value;		
		if (myselmonth<10){myselmonth="0"+myselmonth};
		var ftext=b[0] + ":"+ myselyr+myselmonth;
		document.getElementById("selyrmonth").value=ftext+"::"+b[1]+"-"+b[2]+"::"+b[3];
		document.getElementById("filtertext").value=rid[0]+":"+myselyr+":"+myselmonth;
		document.getElementById("sectionch").value="Chainage: "+b[1]+"-"+b[2];
		$.ajax({			
			type:"post",
			url:"<?=base_url()?>index.php/Section/get_itemname",
			dataType:"json",
			success:function(data){	
				var k = Object.keys(data).length;
				for (var i = 0; i < j; i++) {				
					for (var l = 0; l < k; l++) {
						if (newcode[i]===(data[l].itemid)){mylist=mylist+","+data[l].name;break;};
					}
				}
			codename=mylist.split(",");	
			var container = document.getElementById("inRows");
			while (container.hasChildNodes()) { container.removeChild(container.lastChild); }
			for (i=0;i<j;i++){	
			k=i+1;		
			var newColumn = document.createElement('div');	
			newColumn.innerHTML = '<div class="form-group row"><div class="col-sm-4 offset-1"><label>'+ codename[k] +'</label></div><div class="col-sm-2"><input type="text" name="'+ newcode[i] +'" id="'+ newcode[i] +'"class="form-control" readonly></div><div class="col-sm-2"><input type="text" name="fch'+ newcode[i] +'" id="fch'+ newcode[i] +'" placeholder="FROM CH" class="form-control" oninput="javascript:fillch('+ newcode[i] +')";></div><div class="col-sm-2"><input type="text" name="tch'+ newcode[i] +'" id="tch'+ newcode[i] +'" placeholder="TO CH" class="form-control"  oninput="javascript:fillch('+ newcode[i] +')";></div></div>';
			container.appendChild(newColumn);}
			fill_old_entry(ftext);
			}
		});
	}
	function fill_old_entry(a){
		var x = document.getElementById("recordlist");  
		var storerec = document.getElementById("oldrecord");
		var checkentrydata = document.getElementById("checkentrydata"); 

		var mystring=""; 	
		$("#recordlist").empty();	
		var table = $('#example').DataTable();
		var i=(table.page.info().page);	
		var info = a+ ":"+i;
  		var rrno=-1;
		$.ajax({			
			type:"post",
			url:"<?=base_url()?>index.php/Section/get_monthlyentry/"+info,
			dataType:"json",
			success:function(mdata){	
			//var k = Object.keys(mdata).length;
			var data=mdata[0];
			var data1=mdata[1];			
			var k = Object.keys(data).length;
			var y= Object.keys(data1).length;
		//	alert(y);
			for (i=0;i<k;i++){	
				//alert (data[i].item + " "+data[i].qyt + " "+data[i].fromch+ " "+data[i].toch);
				document.getElementById(data[i].item ).value=data[i].qyt;	
				document.getElementById("fch"+data[i].item ).value=data[i].fromch;	
				document.getElementById("tch"+data[i].item ).value=data[i].toch;
				var rrow=data[i].item + ","+data[i].fromch+","+data[i].toch ;
				
				if (data[i].recno!==rrno){
				var option = document.createElement("option");
				option.text ="Update old Record:"+data[i].recno;
				x.add(option);
				if (mystring.length>0) {mystring=mystring+":"};
				}
				rrno=data[i].recno; 
				if (mystring.length>0) {mystring= mystring+":"+rrow;}else{mystring=rrow;}
			}
			var option = document.createElement("option");			
			var nrec=rrno*1+1;
			option.text ="Enter New Record:"+ nrec;
			x.add(option);
			storerec.value=mystring;
			rrno=-1;
			mystring="";
			for (i=0;i<y;i++){	
				var trow=data1[i].item + ","+data1[i].fromch+","+data1[i].toch ;
				if (mystring.length>0) {mystring=mystring+":"};				
				rrno=data1[i].recno; 
				if (mystring.length>0) {mystring= mystring+":"+trow;}else{mystring=trow;}
			}
			checkentrydata.value=mystring;
			}
		});
	}
	function fillch(a){		
		var dtl =document.getElementById("selyrmonth").value.split("::");
		var storerec = document.getElementById("checkentrydata").value; 
		var recarray=storerec.split("::");//already entered record details
		var messagetouser='';
		document.getElementById("msg1").innerHTML='';
		var ch =dtl[1].split("-");//min max chainage
		var chok =true;	
		var stch =parseFloat(ch[0]).toFixed(3)*1;
		var ench =parseFloat(ch[1]).toFixed(3)*1;
		var ech=document.getElementById("tch"+a).value;
		var sch=document.getElementById("fch"+a).value;
		
		if (isNaN(sch) ||isNaN(ech)){document.getElementById(a).value="";}else
		{	
			ech=parseFloat (ech).toFixed(3)*1;
			sch=parseFloat (sch).toFixed(3)*1;
			messagetouser="";			
			if((stch-sch)>0 || (ech-ench)>0 ){messagetouser="Outside section not allowed";chok=false;}
			if((stch-ech)>0 || (sch-ench)>0 ){messagetouser="Chainage must be with in range";chok=false;}
			if(ech==0){chok=false;}	
			//alert (stch + "-"+ench+"-"+sch+"-"+ech);
			if (chok){
			
				for (i=0;i<recarray.length;i++){ //number of record 
					var mrow = recarray[i].split(":");
					for (j=0;j<mrow.length;j++){ // number of item
						var chh=mrow[j].split(",");
						if (chh[0]==a){ //selected item entry
							var stch1 =parseFloat(chh[1]).toFixed(3)*1;
							var ench1 =parseFloat(chh[2]).toFixed(3)*1;
							break;
						}			
					}	
					messagetouser="";			
					if(Math.abs(stch1 - sch) < 1e-9 && Math.abs(ench1 - ech) < 1e-9){messagetouser="Section already exist";chok=false;break;}
					if((sch-stch1)>0 && (ench1-sch)>0 ){messagetouser="within section not allowed";chok=false;break;}
					if((ech-stch1)>0 && (ench1-ech)>0 ){messagetouser="within section not allowed";chok=false;break;}	
					if((stch1-sch)>=0 && (ech-ench1)>0 ){messagetouser="Part of section exist";chok=false;break;}
											
					//alert (chh[0] + "-" + stch1 + "-"+ench1+"-"+sch+"-"+ech);
				}
			}
			document.getElementById("msg1").innerHTML=messagetouser;
			var length=ech-sch;	
			if (chok){document.getElementById(a).value=length.toFixed(3);}else{document.getElementById(a).value="";}
		}
	}
	function checktcschainage(addedit){		
		var ech='';
		var sch='';
		var chok =false;	
		var messagetouser="";
		var maxlength ='<?=$this->session->userdata('roadlength');?>'
		var seslength = localStorage.getItem("seslength");
		var l=seslength.split('-');
		var x = document.getElementById("scn").value;	
		if(l.length>1){maxlength =l[x-1];}
		//alert(maxlength);
		if(addedit==2){ 	
		document.getElementById("msg2").innerHTML=messagetouser;}else{document.getElementById("msg3").innerHTML=messagetouser;}
	
		if(addedit==2){ 
		ech=document.getElementById("toch2").value;
		sch=document.getElementById("fromch2").value;}else{
		ech=document.getElementById("toch").value;
		sch=document.getElementById("fromch").value;}
		
		if (isNaN(sch) ||isNaN(ech)){chok =true;messagetouser="Enter From and To chainages";}else{
			messagetouser="Save the entered Tcs details.";	
			ech=parseFloat (ech).toFixed(2)*1;
			sch=parseFloat (sch).toFixed(2)*1;	
			if (ech>maxlength || sch>maxlength ){messagetouser="Section length can't be more than road length.";chok=true;}			
			if (chok==false){		
				<?php $no=0; foreach ($get_section as $section) : $no++;?>			
				var stch1 ='<?=$section->fromch?>';
				var ench1 ='<?=$section->toch?>';
				if(Math.abs(stch1 - sch) < 1e-9 && Math.abs(ench1 - ech) < 1e-9){messagetouser="Section already exist";chok=true;}
				if((sch-stch1)>0 && (ench1-sch)>0 ){messagetouser="within Chainage New TCS not allowed";chok=true;}
				if((ech-stch1)>0 && (ench1-ech)>0 ){messagetouser="within Chainage New TCS not allowed";chok=true;}	
				if((stch1-sch)>=0 && (ech-ench1)>0 ){messagetouser="Inbetween TCS Exist";chok=true;}
			<?php endforeach ?>	
			}
		}	
		
		//if(addedit==2){ 
			//document.getElementById("save").disabled = chok;}else{document.getElementById("editbutton").disabled = chok;}
		//if(addedit==2){ 	
		//document.getElementById("msg2").innerHTML=messagetouser;}else{document.getElementById("msg3").innerHTML=messagetouser;}
	
	
	}
</script>
</body>
