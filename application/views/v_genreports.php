<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Generate Physical and Financial Reports</h2>
	
  </div>
</header>
<body onload="Storefiltertext()">
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
			<form action="<?=base_url('index.php/Report/display')?>" method="post">
			<div class="card-header">				
				<div class="form-group row">					
					<div class="col-sm-1"><label>Year</label></div>
					<div class="col-sm-1.5">
						<select name="pyear"  id="pyear" class="form-control" onchange="javascript:Storefiltertext()";>
						<?php $a =$this->session->userdata('phyyear');?>
						<option value="1"<?php if($a==1){?>selected<?php }?>>2024</option>
						<option value="2"<?php if($a==2){?>selected<?php }?>>2025</option>
						<option value="3"<?php if($a==3){?>selected<?php }?>>2026</option>
						</select> 			
					</div>		
					<div class="col-sm-1"><label>Month</label></div>
					<div class="col-sm-2">
						<select  name="pmonth"  id="pmonth" class="form-control" onchange="javascript:Storefiltertext()";>
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
					<div class="col-sm-1.5 "><label>Package Name</label></div>
					<div class="col-sm-5">
						<select name="pkgid" id="pkgid" required="form-control" class="form-control" onchange="javascript:Getroad()";>
								<?php foreach ($get_pkglist as $road):?>
									<option value="<?=$road->pkgsn?>"
									<?php $a = $this->session->userdata('pkgid');
									if($road->pkgsn==$a){?>selected<?php }
									?>
									> <?=$road->pkgsn. ":".$road->pkg ?>									
									</option> 
								<?php endforeach ?>
						</select>
					</div>
					
					<input type="hidden" name="editproid" id="editproid">					
				</div>
				<div class="form-group row">
					<div class="col-sm-1.5 "><label>Road Name</label></div>
					<div class="col-sm-5" >
						<select name="proid" id="proid" required="form-control" class="form-control" onchange="javascript:Storefiltertext()";>
						<?php foreach ($get_roadlist as $road):?>
									<option value="<?=$road->rid?>"
									<?php $a = $this->session->userdata('phyroadid');
									if($road->rid==$a){?>selected<?php }
									?>
									> <?=$road->rid. ":".$road->rname ?>									
									</option> 
								<?php endforeach ?>
						</select>
					</div>				
					<div class="col-sm-1.5"><label>Item Name</label></div>
					<div  class="col-sm-3">
					<select name="item" id="item" required="form-control" class="form-control"  onchange="javascript:Storefiltertext()";>
						<?php foreach ($get_itemlist as $item):?>
							<option > <?=$item->name ?>	</option> 
						<?php endforeach ?>
					</select>
					</div>
				</div>	
			</div>	
				
			<div class="modal-footer justify-content-between">
						
				<input type="submit" name="viewstrip" value="Monthly Strip plan" class="btn btn-success">	
			
				<div class="col-sm-1.5">
					<select name="selrepo"  id="selrepo" class="form-control" onchange="javascript:Storefiltertext()";>
						<?php $a =$this->session->userdata('selrepo');?>
						<option value="1"<?php if($a==1){?>selected<?php }?>>Location Wise All Structure Status</option>
						<option value="2"<?php if($a==2){?>selected<?php }?>>Location Wise Selected Structure Status</option>
						<option value="3"<?php if($a==3){?>selected<?php }?>>Monthly Sectional Progress Report</option>					
						<option value="4"<?php if($a==4){?>selected<?php }?>>Monthly structure Progress Report</option>
						<option value="5"<?php if($a==5){?>selected<?php }?>>Monthly physical Progress TCS wise</option>
						<option value="6"<?php if($a==6){?>selected<?php }?>>Monthly physical Progress Summary</option>
						<option value="7"<?php if($a==7){?>selected<?php }?>>Monthly physical Progress Group wise</option>
						
						<option value="8"<?php if($a==8){?>selected<?php }?>>Financial Payment process details</option>
						<option value="9"<?php if($a==9){?>selected<?php }?>>Financial Package wise Summary report</option>	
						<option value="10"<?php if($a==10){?>selected<?php }?>>Physical Stage progress of Structures </option>	
						<?php	if (strpos($mauth,'201')>-1)  { ?>		
						<option value="11"<?php if($a==11){?>selected<?php }?>>Export Packagewise Monthly Format </option>	
						<?php }	 ?>	
						<?php	if (strpos($mauth,'202')>-1)  { ?>		
						<option value="12"<?php if($a==12){?>selected<?php }?>>Export Summary of Monthly Format </option>	
						<?php }	 ?>		
						
					</select> 			
				</div>		
				<input type="submit" name="viewrepo" value="View selected Report" class="btn btn-success">	
			
			</div>	
			<input type="hidden" name="filtertext" id="filtertext">
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
function Getroad() {
	var list3 =document.getElementById("pkgid");
	var x = document.getElementById("proid"); 
	var pkid = list3.options[list3.selectedIndex].text.split(":");; 
	var filtxt=pkid[0];
	$("#proid").empty();	
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Report/get_roadlist/"+filtxt,
			dataType:"json",
			success:function(data){				
			var k = Object.keys(data).length;		
			for (i=0;i<k;i++){					
				var option = document.createElement("option");				
				option.text = data[i].rid+":"+data[i].rname;
				option.value = data[i].rid;
				x.add(option);		
			}
			Storefiltertext();
			}
			
		});
		
		
	}
	
	function Storefiltertext()
	{   	
	var myear =document.getElementById("pyear");
	var mymonth=document.getElementById("pmonth");	
	var list1 =document.getElementById("proid");
	var list2 =document.getElementById("selrepo");	
	var list3 =document.getElementById("pkgid");	
	var list4 =document.getElementById("item");	
	var myselyr= myear.options[myear.selectedIndex].value;
	var myselmonth= mymonth.options[mymonth.selectedIndex].value;
	var selrepo = list2.options[list2.selectedIndex].value;	
	var pkid = list3.options[list3.selectedIndex].text;
	var item = list4.options[list4.selectedIndex].text;
	var rid= list1.options[list1.selectedIndex].text.split(":");
	if(selrepo==2){list4.disabled=false;} else{list4.disabled=true;}
	document.getElementById("filtertext").value=rid[0]+":"+myselyr+":"+myselmonth+":"+selrepo+":"+rid[1]+":"+pkid+":"+item;
	
}
</script>
