<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Road Details</h2>
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
				<?php if (strpos($mauth,'101')>-1)  { ?>
				<a href="#add"  onclick="add()" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add New Road</a>
				<?php } ?>
			</div>
			

			<div class=col-md-12 style="overflow-x: auto">
				<table class="table table-hover w-auto small table-bordered" id="example" ui-options=ui-options="{
					
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
						<tr><td>#</td>
							<td>Road Name</td>
							<td>Length</td>
							<td>Amount</td>
							<td>Section length</td>
							<td>Provisional certificate</td>
							<td>Complition certificate</td>
							<td>Action</td>							
						</tr></thead>
						<tbody style="background-color: white;">
						<?php $rlist=$this->session->userdata('rlist'); foreach ($get_Road as $Road) : ?>
						<tr>	
						<?php if (strlen($rlist) ==0){ ?>
							<td><?=$Road->rid?></td>
							<td><?=$Road->rname?></td>
							<td><?=$Road->rlength?></td>
							<td><?=$Road->rcost?></td>	
							<td><?=$Road->sc?></td>	
							<td><?=$Road->pcerti?></td>	
							<td><?=$Road->fcerti?></td>	
							<td class="text-center">
							<?php if (strpos($mauth,'102')>-1)  { ?>
								<a href="#edit" onclick="edit('<?=$Road->rid?>')" class="btn btn-primary btn-sm rounded-2" data-toggle="modal"><i class="fa fa-pencil"></i></a>
								<?php } if (strpos($mauth,'104')>-1)  { ?>	
								<a href="#kml" onclick="kml('<?=$Road->rid?>')" class="btn btn-success btn-sm rounded-2" data-toggle="modal">KML</a>
								<?php } if (strpos($mauth,'103')>-1)  {?>
								<a href="<?=base_url('index.php/Road/hapus/'.$Road->rid)?>" onclick="return confirm('Are you sure to delete this project?')" class="btn btn-danger btn-sm rounded-0"><i class="fa fa-trash"></i></a>
								<?php } ?>
							</td>
						<?php } else { if (strpos($rlist, $Road->rid) !== false) {  ?>
							<td><?=$Road->rid?></td>
							<td><?=$Road->rname?></td>
							<td><?=$Road->rlength?></td>
							<td><?=$Road->rcost?></td>	
							<td><?=$Road->sc?></td>	
							<td><?=$Road->pcerti?></td>	
							<td><?=$Road->fcerti?></td>	
							<td class="text-center">
							<?php if (strpos($mauth,'102')>-1)  { ?>
								<a href="#edit" onclick="edit('<?=$Road->rid?>')" class="btn btn-primary btn-sm rounded-0" data-toggle="modal"><i class="fa fa-pencil"></i></a>
								<?php } if (strpos($mauth,'104')>-1)  { ?>	
								<a href="#kml" onclick="kml('<?=$Road->rid?>')" class="btn btn-primary btn-sm rounded-0" data-toggle="modal">KML</a>
								<?php } if (strpos($mauth,'103')>-1)  {?>
								<a href="<?=base_url('index.php/Road/hapus/'.$Road->rid)?>" onclick="return confirm('Are you sure to delete this project?')" class="btn btn-danger btn-sm rounded-0"><i class="fa fa-trash"></i></a>
								<?php } ?>	</td>
						<?php }} ?>	
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<!--	<p><?php //echo $links; ?></p> -->
			</div>
		</div>
	</div>
	<div class="modal" id="add">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Add New Rew
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/Road/add')?>" method="post" enctype="multipart/form-data">
					<div class="modal-body">						
						
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Road no</label></div>
							<div class="col-sm-7">
								<input type="text" id="rid" name="rid" readonly required="form-control" class="form-control">
							</div>
						</div>

						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Road name</label></div>
							<div class="col-sm-7">
								<input type="text" name="rname" required="form-control" class="form-control">
							</div>
						</div>						
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Sanction length</label></div>
							<div class="col-sm-7">
								<input type="text" name="slength" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Awarded length</label></div>
							<div class="col-sm-7">
								<input type="text" name="alength" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>revised length</label></div>
							<div class="col-sm-7">
								<input type="text" name="rlength" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Sanction Amount</label></div>
							<div class="col-sm-7">
								<input type="text" name="scost" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Awarded Amount</label></div>
							<div class="col-sm-7">
								<input type="text" name="acost" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Revised Amount</label></div>
							<div class="col-sm-7">
								<input type="text" name="rcost" required="form-control" class="form-control">
							</div>
						</div>	
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Section Length</label></div>
							<div class="col-sm-7">
								<input type="text" name="rsec" required="form-control" class="form-control">
							</div>
						</div>	
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Section Starting Chainage</label></div>
							<div class="col-sm-7">
								<input type="text" name="rsecsc" id="rsecsc" required="form-control" class="form-control">
							</div>
						</div>						
					</div>

					<div class="modal-footer justify-content-end">
						<input type="submit" name="save" value="Save" class="btn btn-primary btn-sm rounded-0">
						
						<button type="button" class="btn btn-default btn-sm border rounded-0" data-dismiss="modal">Close</button>
					</div>
					
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="kml">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Upload KML file for road alignment
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/Road/Road_update')?>" method="post" enctype="multipart/form-data">
					<div class="form-group row">
						<div class="col-sm-3 offset-1">
							<input type="hidden" name="krid" id="krid">
							<input type="file" onchange="readText(event)" />
						</div>
					</div>
					<div class="form-group row">						
						<textarea  id="output" name="output" rows="4" cols="50"></textarea>
					</div>
					<div class="modal-footer justify-content-end">
						<input type="submit" name="savekml" value="Upload" class="btn btn-primary btn-sm rounded-0">
						<input type="submit" name="clearkml" value="Clear kml" onclick="return confirm('Are you sure to Clear uploaded Road alignment?')" class="btn btn-primary btn-sm rounded-0">
						<input hidden type="submit" name="exportkml" value="Export kml" onclick="return confirm('Are you sure to download Road alignment as Kml file?')" class="btn btn-primary btn-sm rounded-0">
						<button type="button" class="btn btn-default btn-sm border rounded-0" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>		
		</div>		
	</div>		
	
	<div class="modal fade" id="edit">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Update Road
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/Road/Road_update')?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="editroadid" id="editroadid">
						
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Road name</label></div>
							<div class="col-sm-7">
								<input type="text" name="rname2" id="rname2" required="form-control" class="form-control">
							</div>
						</div>						
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Sanction length</label></div>
							<div class="col-sm-7">
								<input type="text" name="slength2" id="slength2" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Awarded length</label></div>
							<div class="col-sm-7">
								<input type="text" name="alength2" id="alength2" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>revised length</label></div>
							<div class="col-sm-7">
								<input type="text" name="rlength2" id="rlength2" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Sanction Amount</label></div>
							<div class="col-sm-7">
								<input type="text" name="scost2" id="scost2" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Awarded Amount</label></div>
							<div class="col-sm-7">
								<input type="text" name="acost2" id="acost2" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Revised Amount</label></div>
							<div class="col-sm-7">
								<input type="text" name="rcost2" id="rcost2" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Section Length</label></div>
							<div class="col-sm-7">
								<input type="text" name="rsec2" id="rsec2" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Section Starting Chainage</label></div>
							<div class="col-sm-7">
								<input type="text" name="rsecsc2" id="rsecsc2" required="form-control" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Package name</label></div>
							<div class="col-sm-7">
							<select name="pkgid2" id="pkgid2" required="form-control" class="form-control" onclick="javascript:proval()";>
								<?php foreach ($get_pkg as $pkg):?>
									<option> <?=$pkg->pkg ?></option> 
								<?php endforeach ?>
							</select>
							</div>		
						</div>		
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Provisional Certificate</label></div>
							<div class="col-sm-7">
								<input type="date" name="pcerti" id="pcerti"  class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Complition Certificate</label></div>
							<div class="col-sm-7">
								<input type="date" name="fcerti" id="fcerti"  class="form-control">
							</div>
						</div>						
					<div class="modal-footer justify-content-end">
						<input type="submit" name="save" value="Save" class="btn btn-primary btn-sm rounded-0">
						<button type="button" class="btn btn-default btn-sm border rounded-0" data-dismiss="modal">Close</button>
					</div>
				</form>
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
		//alert(info);
		
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Road/edit_Road/"+info,
			dataType:"json",
			success:function(data){				
				$("#editroadid").val(data.rid);				
				$("#rname2").val(data.rname);
				$("#slength2").val(data.slength);
				$("#alength2").val(data.alength);
				$("#rlength2").val(data.rlength);
				$("#scost2").val(data.scost);
				$("#acost2").val(data.acost);
				$("#rcost2").val(data.rcost);
				$("#rsec2").val(data.sc);
				$("#rsecsc2").val(data.ssch);
				$("#pkgid2").val(data.pkg);
				$("#pcerti").val(data.pcerti);
				$("#fcerti").val(data.fcerti);
				//alert(data.pkg);		
			}
				
		});
		
	}
	function add() {
	var newrid;
		$.ajax({
			type:"post",
			url:"<?=base_url()?>index.php/Road/get_roadcode",
			dataType:"json",
			success:function(data){
				data=data+1;				
			 if (data <10){newrid="R0"+data;} else {newrid="R"+data;}
				$("#rid").val(newrid);				
			}
		});
	}
	function kml(a) {	
	$("#krid").val(a);		
		
	}
	async function readText(event) {
 	const file = event.target.files.item(0)
  	const text = await file.text(); 
	const n =(text.split("<LineString>").length - 1);
	
	if (n > 20){alert("There are " + n + " Line String");}
	var n1=0;
	var n2=0;
	var nindex=0;
	var a='';
	if (n > 1){	
		for (var i=0;i<n;i++){			
			 n1 = text.indexOf("<LineString>",nindex);
			 n2 = text.indexOf("</LineString>",n1);
			var mtext=text.substring(n1,n2);			
			if (a.length>0) {a=a+"::"};		
			 a = a + parseXmlToJson(mtext,'coordinates');
			 nindex=n2;
		}

	}else{
		a = parseXmlToJson(text,'coordinates');
	};

	document.getElementById("output").innerText=a;
	
}
function parseXmlToJson(text,key) {	
  return text.substring(
    text.lastIndexOf('<' + key + '>') + ('<' + key + '>').length,
    text.lastIndexOf('</' + key + '>')
  );
}





</script>