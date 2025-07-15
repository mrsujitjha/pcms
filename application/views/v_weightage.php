<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Weightage management</h2>
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
				<?php if (strpos($mauth,'171')>-1)  { ?>
				<a href="#add" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add Weightage</a>
				<?php } ?>	
				<form action="<?=base_url('index.php/Weightage/save_roadno')?>" method="post">	
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
							<?php	if (strpos($mauth,'175')>-1)  { ?>		
						<a href="<?=base_url('index.php/Weightage/Approve')?>" onclick="return confirm('Are you sure to Approve it?')" class="btn btn-danger">APPROVE</a>
					<?php } ?>	
						</div>
						
					</div>
				</form>
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
							<td>SN</td>					
							<td>Item</td>
							<td>Description</td>	
							<td>Weightage</td>									
							<td>Action</td>
						</tr></thead>
					<tbody style="background-color: white;">
						<?php $no=0; foreach ($get_weightlist as $flow) : $no++;?>
						<tr>
							<td><?=$flow->id?></td>							
							<td><?=$flow->item?></td>
							<td><?=$flow->descrip?></td>
							<td><?=$flow->mw?></td>							
							<td>
							<?php	if ((strpos($mauth,'172')>-1 && $flow->wdone <2)||(strpos($mauth,'175')>-1 ))  {  ?>	
								<a href="#edit" onclick="edit('<?= $flow->id ?>')" class="btn btn-success btn-sm" data-toggle="modal">Edit</a>
							<?php } if ((strpos($mauth,'174')>-1  && $flow->wdone <2) ||(strpos($mauth,'175')>-1 ))  { ?>		
								<a href="#weight" onclick="weight('<?= $flow->id.'::'. $flow->subitem.'::'. $flow->sw .'::'. $flow->pcon ?>')" class="btn btn-success btn-sm" data-toggle="modal">Weightage</a>
							<?php } if (strpos($mauth,'173')>-1  && $flow->wdone <2)  { ?>		
								<a href="<?=base_url('index.php/weightage/hapus/'.$flow->id)?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm">Delete</a>
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
						Add New item and sub item with Weightage
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Weightage/add')?>" method="post">
						<div class="modal-body">							
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Item</label></div>
								<div class="col-sm-7">									
									<textarea name="item"  id="item" style="width:250px;height:75px;"></textarea>
								</div>								
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Sub Item Details</label></div>
								<div class="col-sm-7">
								<textarea name="sitem"  id="sitem" style="width:250px;height:75px;"></textarea>
								</div>	
							</div>	
							<div class="form-group row">
								<div class="col-sm-7 offset-1"><label>Item weightage</label></div>
								<div class="col-sm-3">
									<input type="text" name="mw" id="mw" required class="form-control">
								</div>	
							</div>	
								<input type="hidden"  name="subi" id="subi"  class="form-control">		
							
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Item Type</label></div>
								<div class="col-sm-7">
									<select name = 'tcslist' id="tcslist" class="form-control" onclick="javascript:loaditemlist(1)";>	
									<option value ='0'>List Point Item</option>
									<option value ='1'>List Stage Item</option>
									<?php foreach ($get_Tcslist as $item): ?>
										<option value='2'><?= $item->name?></option>
									<?php endforeach ?>						
									</select>
								</div>	
							</div>
							<div class="form-group row">
								<div class="col-sm-12 offset-1"><label>Road Sub-Item List and Progress parameter</label></div>
							</div>
						</div>	
						
						<div class="clist-group  offset-1">								
							<select name = 'ilist' id="ilist"  size=10 multiple class="form-control" ondblclick="javascript:deleteitem(1)";>
															
							</select>		
						</div>		
						<div class="modal-footer justify-content-between">
							<input type="submit" name="save" value="Save" class="btn btn-success">							
							<select name = 'ialist' id="ialist" class="form-control">
															
							</select>
							<select hidden name = 'stlist' id="stlist" class="form-control">
								<?php foreach ($get_stage_list as $item): ?>
									<option value="<?=$item->itemid?>"><?= $item->stages?></option>
								<?php endforeach ?>									
							</select>

							<input type="button" name="Add" value="Add" class="btn btn-success"  onclick="javascript:additem(1)";>
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
						Update weightage Detail
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Weightage/edit_weightage')?>" method="post">
						<div class="modal-body">
							<input type="hidden" name="user_code_lama" id="user_code_lama">		
								<input type="hidden" name="aadetails" id="aadetails">			
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Item</label></div>
								<div class="col-sm-7">									
									<textarea name="item2"  id="item2" style="width:250px;height:75px;"></textarea>
								</div>								
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Sub Item Details</label></div>
								<div class="col-sm-7">
								<textarea name="sitem2"  id="sitem2" style="width:250px;height:75px;"></textarea>
								</div>	
							</div>	
							<div class="form-group row">
								<div class="col-sm-7 offset-1"><label>Item weightage</label></div>
								<div class="col-sm-3">
									<input type="text" name="mw2" id="mw2" required class="form-control">
								</div>							
							</div>	
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Item Type</label></div>
								<div class="col-sm-7">
									<select name = 'tcslist2' id="tcslist2" class="form-control" onclick="javascript:loaditemlist(2)";>	
									<option value ='0'>List Point Item</option>
									<option value ='1'>List Stage Item</option>
									<?php foreach ($get_Tcslist as $item): ?>
										<option value='2'><?= $item->name?></option>
									<?php endforeach ?>						
									</select>
								</div>	
							</div>					
							<input type="text" name="subi2" id="subi2"  class="form-control">		
							<div class="form-group row">
								<div class="col-sm-12 offset-1"><label>Road Item List and Progress parameter</label></div>
								
							</div>
							
						</div>		
						<div class="clist-group  offset-1">								
							<select name = 'ilist2' id="ilist2"  size=10 multiple class="form-control" ondblclick="javascript:deleteitem(2)";>
															
							</select>		
						</div>		
						<div class="modal-footer justify-content-between">
							<input type="submit" name="edit" value="Save" class="btn btn-success">
							<select name = 'ialist2' id="ialist2" class="form-control">
												
							</select>
							<select hidden name = 'stlist2' id="stlist2" class="form-control">
								<?php foreach ($get_stage_list as $item): ?>
									<option value="<?=$item->itemid?>"><?= $item->stages?></option>
								<?php endforeach ?>									
							</select>
							<select hidden name = 'ialist4' id="ialist4" class="form-control">
								<?php foreach ($get_item as $item): ?>
									<option value="<?=$item->itemid?>"><?= $item->name.'('.$item->unit.')' ?></option>
								<?php endforeach ?>								
							</select>
							<input type="button" name="Add" value="Add" class="btn btn-success"  onclick="javascript:additem(2)";>
						</div>
					</form>
				</div>				
			</div>
		</div>
		<div class="modal fade" id="weight">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						Update weightage Detail
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?=base_url('index.php/Weightage/edit_weightage')?>" method="post">
						<div id="inRows" class="form-group row"></div>						
						<div class="modal-footer justify-content-between">
							<input type="submit" name="weight" value="Save" class="btn btn-success">
						</div>	
						<select hidden name = 'lst' id="lst" class="form-control">
								<?php foreach ($get_item as $item): ?>
									<option value="<?=$item->itemid?>"><?= $item->name.'('.$item->unit.')' ?></option>
								<?php endforeach ?>									
						</select>	
						<input type=hidden name="tn" id="tn"  class="form-control">
						<input type=hidden name="un" id="un"  class="form-control">
						<select hidden  name = 'stlist3' id="stlist3" class="form-control">
								<?php foreach ($get_stage_list as $item): ?>
									<option value="<?=$item->itemid?>"><?=$item->stage?></option>
								<?php endforeach ?>									
						</select>
					</form>
				</div>				
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
		var table = $('#example').DataTable();
		var i=(table.page.info().page);	
		var info = a+ ":"+i;
		var list1 = document.getElementById("ilist2");
		var sel = document.getElementById("ialist4");
		var aitem=0;
	//	alert(info);		
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Weightage/get_detail/"+info,
			dataType:"json",
			success:function(data){						
				$("#item2").val(data.item);
				$("#sitem2").val(data.descrip);	
				$("#mw2").val(data.mw);
				$("#subi2").val(data.subitem);
				$("#user_code_lama").val(data.id);				
				$("#aadetails").val(data.aadetails);	
				var x=data.subitem;		
				var proitem=x.split(",");				
				$("#ilist2").empty();	
				//alert();	
				for (var l = 0; l < proitem.length; l++) {
					var option = document.createElement("option");
					var tcs=proitem[l].substr(3,proitem[l].length);
						for(var i=0;i<sel.length;i++){
						if(proitem[l]==sel[i].value || (proitem[l].substr(0,3)==sel[i].value && aitem !=proitem[l].substr(0,3))) {
						aitem= proitem[l].substr(0,3);
						option.value = sel[i].value;
						if(tcs.length>3){option.text = sel[i].text+':'+tcs;
						}else{option.text = sel[i].text;
						}
						
						list1.add(option);break;}}
				}
			
			}				
		});		
	}
function additem(a) {	
	var sel;	
	var list1 ;
	var tcs;
	if(a==2){ list1 = document.getElementById("ilist2");sel = document.getElementById("ialist2");tcs=document.getElementById("tcslist2");}else{ list1 = document.getElementById("ilist");sel = document.getElementById("ialist");tcs=document.getElementById("tcslist");}
	var option = document.createElement("option");
	var n =sel.selectedIndex;
	var rid= tcs.options[tcs.selectedIndex].text;	
	var km= sel.options[n].text .includes("Km");	
	var codename="";
	option.value=sel.options[n].value;
	if (km){
		option.text = sel.options[n].text + ':'+rid;	
	}else{
		option.text = sel.options[n].text;	
	}
	list1.add(option);
	load_list(a);
}	
function load_list(a){
	var showlist;	
	var list1 ;
	var stagelist;
	if(a==2){list1 = document.getElementById("ilist2");showlist = document.getElementById("subi2");stagelist = document.getElementById("stlist2");}else{list1 = document.getElementById("ilist");showlist = document.getElementById("subi");stagelist = document.getElementById("stlist");}

	var tlist= list1.length;
	var slist=stagelist.length;
	var t1="";
	showlist.value= "";	
	//alert(tcs);
	for(var i=0;i<tlist;i++){	
		var stage= list1.options[i].text.includes("Stage");
		if (stage){			
			var info=list1.options[i].value;		
			for (var n =0;n<slist;n++){					
				if (stagelist.options[n].value==info){					
				 var codename=stagelist.options[n].text.split(",");							
					for(var j=0;j<codename.length;j++){						
						if (t1=="") {
							t1=info+"-"+codename[j];
						} else {
							t1= t1+ "," +info+"-"+codename[j];
						}
					}
					break;// all same item has same stage if not remove break
				}				
			}
		}else{			
			var km= list1.options[i].text.includes("Km");				
			if (km){	
				var rid=list1.options[i].text.split(":");		
				if (t1=="") { t1= list1.options[i].value+rid[1];} else {t1= t1+ "," +list1.options[i].value+rid[1];}
			}else{
				if (t1=="") { t1= list1.options[i].value;} else {t1= t1+ "," +list1.options[i].value;}			
			}
		
		}
	}
	showlist.value =t1;

}
function deleteitem(a) {	
	var list1 ;
	if(a==2){ list1 = document.getElementById("ilist2");}else{ list1 = document.getElementById("ilist");}
	var n =list1.selectedIndex;
	list1.remove(n);
	load_list(a);
}
function loaditemlist(a){
	if(a==1){
	var list1 =document.getElementById("tcslist");
	var list2 =document.getElementById("ialist");
	}else{
		var list1 =document.getElementById("tcslist2");
	var list2 =document.getElementById("ialist2");
	}

	var rid= list1.options[list1.selectedIndex].value;
	var rtext= list1.options[list1.selectedIndex].text;
	if(rid<2){rtext="0"};//no search text require
	var stext=rid+':'+rtext;
	var laodeditem="";
	//alert(stext);
	$.ajax({
		type:"post",
		url:"<?=base_url()?>index.php/Weightage/get_itemdetails/"+stext,
		dataType:"json",
			success:function(data){	
				var k = Object.keys(data).length;
				if(a==1){$("#ialist").empty();}else{$("#ialist2").empty();}	
				if(rid<2){	// point and stage item				
				for (var l = 0; l < k; l++) {
					var option = document.createElement("option");		
						option.value = data[l].itemid;
						option.text = data[l].name+'('+data[l].unit+')';						
				list2.add(option);}
				}else{
					var item= data[0].itemid.split(",");					
					for (var n=0;n<item.length;n++){
						if (laodeditem.includes(item[n])==false){
							laodeditem= laodeditem+','+item[n];
							<?php foreach ($get_item as $item): ?>
								var ino='<?=$item->itemid?>';
								var inm='<?=$item->name?>';
								var inu='<?=$item->unit?>';	
								if(item[n]==ino){
									var option = document.createElement("option");		
										option.value = item[n];
										option.text = inm +'('+inu+')';						
										list2.add(option);								
								}	

							<?php endforeach ?>	
						}
					}
				}
			}			
		});	
}
function weight(a) {
	var data=a.split("::");	
		var container = document.getElementById("inRows");
		var list1 = document.getElementById("lst");
		var list3 = document.getElementById("stlist3");
		var unv = document.getElementById("un");
		unv.value=data[0];
		//alert(data[1].substring(0,3));
		var item=data[1];
		while (container.hasChildNodes()) { container.removeChild(container.lastChild); }		
		var stage=item.split(",");
		document.getElementById("tn").value=stage.length;
		var tlist= list1.length;
	
		for (var i=0;i<stage.length;i++){
			var sname;
		  // alert(stage[i]);		 
		   if (stage[i].length==3 || stage[i].length>5){ //point or line item
			for (var j=0;j<tlist;j++){
				if(lst.options[j].value==stage[i].substring(0,3)){sname=lst.options[j].text;}
			}
			}else{ //stage item					
				for (var n=0;n<list3.length;n++){
					if(list3.options[n].value==stage[i].substring(0,3)){
						var stname=list3.options[n].text.split(",");
						var no =stage[i].substring(4,5)-1;
						sname=stname[no];
						//alert(no);
					}
				}
			}
		
			// Create the dynamic elements
			var r1 = document.createElement('div');
			var tcode = 'P' + i; // Ensure 'i' is defined
			r1.className = "form-group row";

			// Start the div and label
			r1.innerHTML = '<div class="col-sm-12 offset-1" style="display: flex; align-items: center;">' +
				'<label style="width: 350px; margin-right: 10px;">' + sname + '</label>' +
				'<input type="text" id="' + tcode + '" name="' + tcode + '" class="form-control" style="width: 80px; margin-right: 10px;">' +
				'<select id="C' + i + '" name="C' + i + '" class="form-control" style="flex-grow: 1;"></select>' +
				'</div>';
				container.appendChild(r1);
				var get_paycon = <?= json_encode($get_paycon); ?>;
				var selectElement = document.getElementById('C' + i);
				var pcon=data[3].split(",");
				if (selectElement && Array.isArray(get_paycon)) {
					get_paycon.forEach(function(flow) {
						var option = document.createElement('option');
						option.value = flow.cid; 
						option.textContent = flow.pname; 
						if( flow.cid==pcon[i]){	option.selected = true;}
						selectElement.appendChild(option);
					});
				}

		}	
		var stage=data[2].split(",");
		//alert(data[2]);
		for (var i=0;i<stage.length;i++){
			var tcode='P'+i;
			var wbox = document.getElementById(tcode);
			wbox.value=stage[i];
		}
		
}
</script>

