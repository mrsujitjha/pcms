<header class="page-header">
	<div class="container-fluid">
		<h2 class="no-margin-bottom">PAYMENT PROCESSING </h2>
		<h2 class="no-margin-bottom">Package: <?= $this->session->userdata('pkgid'); ?></h2>
	</div>
</header>

<div class="table-agile-info">
	<div class="container-fluid">
		<?php $mauth = $this->session->userdata('autho');
		if ($this->session->flashdata('message') != null) {
			echo "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>"
				. $this->session->flashdata('message') . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span>
			</button> </div>";
		} ?>
		<br>
		<div class="card rounded-0 shadow">
			<div class="card-header">
				<div class="d-flex h-100">
					<div>
						<form action="<?= base_url('index.php/Financial/save_pkg') ?>" method="post">
							<div class="form-group row">
								<div class="col-sm-3 "><label>Package Name</label></div>
								<div class="col-sm-5">
									<select name="proid" id="proid" required="form-control" class="form-control" ;>
										<?php $flowlis = '';
										foreach ($get_pkglist as $road) : ?>
											<option <?php $a = $this->session->userdata('pkgid');
													if ($road["pkgid"] == $a) { ?>selected<?php }
																		?>> <?= $road["flowid"] . ":" . $road["pkgid"] ?>
											</option>
										<?php
											if ($flowlis == '') {
												$flowlis = $road["flow"];
											} else {
												$flowlis = $flowlis . ":" . $road["flow"];
											}
										endforeach
										?>
									</select>
								</div>
								<div class="col-sm-2">
									<input type="submit" name="show" value="Show" class="btn btn-success">
								</div>
								<?php if ($this->session->userdata('level') == 'Admin') { ?>
									<div class="col-sm-2">
										<input type="submit" name="showall" value="Show All" class="btn btn-success">
									</div>
								<?php } ?>
							</div>
						</form>
					</div>
					<div class="align-self-end ml-auto">
						<?php if (strpos($mauth, '181') > -1) { ?>
							<div class="form-group row">
								<a href="#add" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Payment Within Contract Amount</a>
							</div>
						<?php }
						if (strpos($mauth, '184') > -1) { ?>
							<div class="form-group row">
								<a href="#addother" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Payment Except Contract Amount</a>
							</div>
						<?php } ?>
					</div>
				</div>
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
							<td>#</td>
							<td>SPS/IPC ID</td>
							<td>Date</td>
							<td>Description</td>
							<td>Amount (Cr.)</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody style="background-color: white;">
						<?php $no = 0;
						foreach ($get_ipc as $ipc) : $no++; ?>

							<tr>
								<td><?= $no ?></td>
								<td><?= $ipc->fincode ?></td>
								<td><?= $ipc->mdate ?></td>
								<td><?= $ipc->descrip ?></td>
								<td><?= $ipc->amount ?></td>
								<td>

									<?php if ($this->session->userdata('userid') == $ipc->toid) { ?>
										<a href="#Action" onclick="myaction('<?= $ipc->fincode . ':' . $ipc->descrip . ':' . $ipc->amount . ':' . $ipc->flow ?>')" class="btn btn-success btn-sm" data-toggle="modal">Action</a>
									<?php } ?>
									<a href="#display" onclick="mydisplay('<?= $ipc->fincode ?>')" class="btn btn-success btn-sm" data-toggle="modal">View</a>
									<?php if (strpos($mauth, '185') > -1) { ?>
										<a href="<?= base_url('index.php/Financial/hapus/' . $ipc->fincode) ?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm">Delete</a>
									<?php }
									if (strpos($ipc->fincode, 'SPS') !== false) { ?>
										<a href="#sps" onclick="mysps('<?= $ipc->fincode ?>')" class="btn btn-success btn-sm" data-toggle="modal"> Bill</a>

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
						Generate Stage Payment Statement(SPS)
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?= base_url('index.php/Financial/add') ?>" method="post">
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>SPS ID</label></div>
								<div class="col-sm-7">
									<input type="text" id="spsid" name="spsid" Readonly required class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Amount</label></div>
								<div class="col-sm-7">
									<input type="amt" name="amt" id="amt" required class="form-control">
								</div>

							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Description</label></div>
								<div class="col-sm-7">
									<input type="text" name="descrip" id="descrip" required class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Payment</label></div>
								<div class="col-sm-7">
									<select type="text" name="proad" id="proad" required class="form-control" onchange="javascript:load_id()" ;>
										<option value='PKG' selected>Package related</option>
										<?php $b = $this->session->userdata('pkgid');
										foreach ($get_roadlist as $road) :
											if ($road["pkg"] == $b) {
										?>
												<option value="<?= $road["rid"] ?>" <?php $a = $this->session->userdata('roadid');
																					if ($road["rid"] == $a) { ?>selected<?php } ?>><?= $road["rid"] . ":" . $road["rname"] ?>
												</option>
										<?php }
										endforeach ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Payment Heading</label></div>
								<div class="col-sm-7">
									<select type="text" name="ptype" id="ptype" required class="form-control" onchange="javascript:load_id()" ;>
										<option value='SPS' selected>Stage Payment Statement</option>
										<option value='ADV'> Advance Payment</option>
										<option value='INT'> Interest Payment</option>
										<option value='RET'> Retention money Payment</option>
										<option value='OTH'> Other type of Payment</option>
									</select>
								</div>
							</div>

							<input type="hidden" id="pdetail" name="pdetail" class="form-control">
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<?php if (strpos($mauth, '182') > -1) { ?>
								<input type="submit" id="gen" name="gen" value="Generate" class="btn btn-success">
							<?php }
							if (strpos($mauth, '183') > -1) { ?>
								<input type="submit" name="save" value="Save" class="btn btn-success">
							<?php } ?>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal" id="addother">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Enter Payment made in Project (Not included in Contract amount)
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?= base_url('index.php/Financial/add') ?>" method="post">
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Bill ID</label></div>
								<div class="col-sm-7">
									<input type="text" id="bid" name="bid" Readonly required class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Payment</label></div>
								<div class="col-sm-7">
									<select type="text" name="oproad" id="oproad" required class="form-control" onchange="javascript:load_billid()" ;>
										<option value='PKG' selected>Package related</option>
										<?php $b = $this->session->userdata('pkgid');
										foreach ($get_roadlist as $road) :
											if ($road["pkg"] == $b) {
										?>
												<option value="<?= $road["rid"] ?>" <?php $a = $this->session->userdata('roadid');
																					if ($road["rid"] == $a) { ?>selected<?php } ?>><?= $road["rid"] . ":" . $road["rname"] ?>
												</option>
										<?php }
										endforeach ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Amount</label></div>
								<div class="col-sm-7">
									<input type="oamt" name="oamt" id="oamt" required class="form-control">
								</div>

							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Description</label></div>
								<div class="col-sm-7">
									<input type="text" name="odescrip" id="odescrip" required class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Payment Heading</label></div>
								<div class="col-sm-7">
									<select type="text" name="optype" id="optype" required class="form-control" onchange="javascript:load_billid()" ;>
										<option value='WSC' selected>Within Project Sanction cost</option>
										<option value='OHD'> Other Sanction Heading</option>
									</select>
								</div>
							</div>

							<input type="hidden" id="opdetail" name="opdetail" class="form-control">
						</div>
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<input type="submit" name="osave" value="Save" class="btn btn-success">
						</div>
					</form>
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
					<form action="<?= base_url('index.php/Financial/add') ?>" method="post">
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>SPS/IPC ID</label></div>
								<div class="col-sm-7">
									<input type="text" id="spsid2" name="spsid2" Readonly required class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Amount</label></div>
								<div class="col-sm-7">
									<input type="text" name="amt2" id="amt2" required class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Description</label></div>
								<div class="col-sm-7">
									<input type="text" name="descrip2" id="descrip2" class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Action</label></div>
								<div class="col-sm-7">
									<select name="item2" id="item2" required="form-control" class="form-control" onchange="javascript:actionvalue()" ;>
										<option value='rev'> Revert with comments</option>
										<option value='for'> Forward for Payment</option>
									</select>
								</div>
							</div>

						</div>
						<input type="text" id="flowcode" name="flowcode" class="form-control">
						<input type="text" id="pdetail2" name="pdetail2" class="form-control">
						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<input type="submit" name="action" value="Save" class="btn btn-success">
						</div>
					</form>
				</div>

			</div>
		</div>
		<div class="modal fade" id="sps">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						View Detail invoice Items
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
					</div>
					<div class="col-md-12" style="overflow-x: auto">
						<table class="table table-hover table-bordered" id="example3">

						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="display">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						Invoce processing View
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
					</div>
					<div class="col-md-12" style="overflow-x: auto">
						<table class="table table-hover table-bordered" id="example2">

						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var a = <?php if ($this->session->has_userdata('mypage')) {
				echo ($this->session->userdata('mypage'));
			} else {
				echo ('0');
			} ?>;
	var i = a * 10;
	$(document).ready(function() {
		$('#example').DataTable({
			'displayStart': i
		});

	});

	function myaction(a) {
		var data = a.split(":");
		$("#spsid2").val(data[0]);
		$("#descrip2").val(data[1]);
		$("#amt2").val(data[2]);
		$("#flowcode").val(data[3]);
	}

	function actionvalue() {

		var list1 = document.getElementById("item2");
		var maction = list1.options[list1.selectedIndex].text;
		var c = document.getElementById("spsid2").value;
		var a = document.getElementById("flowcode").value;
		var b = a.split(",");
		var frmid = '<?= $this->session->userdata('userid'); ?>';
		var newid = 0;
		var k = 0;
		for (k = 0; k < b.length; k++) {
			if (b[k] == frmid) {
				break;
			}
		}
		if (list1.selectedIndex == 0) {
			toid = b[k - 1];
		} else {
			if (b.length == k + 1) {
				toid = "Paid"
			} else {
				toid = b[k + 1]
			};
		}

		//alert(k+ ":"+b.length);
		$.ajax({
			type: "post",
			url: "<?= base_url() ?>index.php/Financial/maxprogressid/" + c,
			dataType: "json",
			success: function(data) {
				newid = parseInt(data.sn) + 1;
				$("#pdetail2").val(newid + ":" + frmid + ":" + toid + ":" + maction + ":" + data.pkgid);
			}
		});
	}

	function load_id() {
		var list0 = document.getElementById("proad"); //road code
		var list1 = document.getElementById("proid"); //billcode 
		var list2 = document.getElementById("ptype");

		var n = list0.options[list0.selectedIndex].value;
		var a = list1.options[list1.selectedIndex].text.split(":");
		var b = list2.options[list2.selectedIndex].value;

		var d = new Date().getFullYear().toString().substring(2, 4);

		//alert(n);
		var c = a[0] + "-" + n + "-" + b + "-" + d;
		var newid = c + "01";
		var flowlist = '<?= $flowlis; ?>';
		var fl = flowlist.split(":");
		var frtn = fl[list1.selectedIndex].split(",");
		if (b == 'SPS') {
			document.getElementById("gen").disabled = false;
			document.getElementById("amt").value = 0;
			document.getElementById("descrip").value = 'Auto generated SPS';
		} else {
			document.getElementById("gen").disabled = true;
		}
		//alert(b);
		$("#spsid").val(newid);
		$("#pdetail").val("1:" + frtn[0] + ":" + frtn[1] + ":SPS raised:" + a[1]);
		$.ajax({
			type: "post",
			url: "<?= base_url() ?>index.php/Financial/maxspsid/" + c,
			dataType: "json",
			success: function(data) {
				newid = parseInt(data) + 1;
				if (newid < 10) {
					newid = "0" + newid;
				}
				$("#spsid").val(c + newid);
			}
		});
	}

	function load_billid() {

		var list0 = document.getElementById("oproad"); //road code
		var list1 = document.getElementById("proid"); //pkgcode
		var list2 = document.getElementById("optype"); //billcode 

		var n = list0.options[list0.selectedIndex].value;
		var a = list1.options[list1.selectedIndex].text.split(":");
		var b = list2.options[list2.selectedIndex].value;
		var d = new Date().getFullYear().toString().substring(2, 4);
		var c = a[0] + "-" + n + "-" + b + "-" + d;
		var newid = c + "01";
		$("#bid").val(newid);
		$("#opdetail").val("1:0" + ":Paid" + ":Payment:" + a[1]);
		$.ajax({
			type: "post",
			url: "<?= base_url() ?>index.php/Financial/maxspsid/" + c,
			dataType: "json",
			success: function(data) {
				newid = parseInt(data) + 1;
				if (newid < 10) {
					newid = "0" + newid;
				}
				$("#bid").val(c + newid);
			}
		});
	}

	function mydisplay(c) {
		var table_data = '';
		$('#example2').empty();

		$.ajax({
			type: "post",
			url: "<?= base_url() ?>index.php/Financial/savesessionspcid/" + c,
			dataType: "json",
			success: function(data) {
				var k = Object.keys(data).length;
				var toval = "";
				//alert(data[i].fincode);				
				table_data += '<thead style="background-color: #464b58; color:white;">';
				table_data += '<tr>';
				table_data += '<td>SPS/IPC ID</td>';
				table_data += '<td>Date</td>';
				table_data += '<td>Description</td>';
				table_data += '<td>Amount (Cr.)</td>';
				table_data += '<td>Action</td>';
				table_data += '<td>From</td>';
				table_data += '<td>To</td>';
				table_data += '</tr></thead>';
				table_data += '<tbody style="background-color: white;">';
				for (var i = 0; i < k; i++) {
					if (data[i].toid !== 'Paid') {
						toval = data[i].tuser;
					} else {
						toval = 'Paid';
					}
					table_data += '<tr>';
					table_data += '<td>' + data[i].fincode + '</td>';
					table_data += '<td>' + data[i].mdate + '</td>';
					table_data += '<td>' + data[i].descrip + '</td>';
					table_data += '<td>' + data[i].amount + '</td>';
					table_data += '<td>' + data[i].status + '</td>';
					table_data += '<td>' + data[i].fuser + '</td>';
					table_data += '<td>' + toval + '</td>';
					table_data += '</tr>';
				}
				table_data += '</tbody>';

				$('#example2').append(table_data);

			}

		});
	}

	function mysps(c) {
		var table_data = '';
		$('#example3').empty();

		$.ajax({
			type: "post",
			url: "<?= base_url() ?>index.php/Financial/showsps/" + c,
			dataType: "json",
			success: function(data) {
				var k = Object.keys(data).length;
				var toval = 0;
				//alert(data[i].fincode);				
				table_data += '<thead style="background-color: #464b58; color:white;">';
				table_data += '<tr>';
				table_data += '<td>SPS/Item Name</td>';
				table_data += '<td>Scope</td>';
				table_data += '<td>Quantity</td>';
				table_data += '<td>Amount (Cr.)</td>';
				table_data += '</tr></thead>';
				table_data += '<tbody style="background-color: white;">';
				for (var i = 0; i < k; i++) {
					toval += Number(data[i].A);
					table_data += '<tr>';
					table_data += '<td>' + data[i].name + '</td>';
					table_data += '<td>' + data[i].T + '</td>';
					table_data += '<td>' + data[i].Q + '</td>';
					table_data += '<td>' + data[i].A + '</td>';
					table_data += '</tr>';
				}
				table_data += '<tr>';
				table_data += '<td>Total</td>';
				table_data += '<td></td>';
				table_data += '<td></td>';
				table_data += '<td>' + toval.toFixed(3) + '</td>';
				table_data += '</tr>';
				table_data += '</tbody>';

				$('#example3').append(table_data);

			}

		});
	}
</script>