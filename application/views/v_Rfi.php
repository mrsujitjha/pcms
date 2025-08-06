<header class="page-header">
	<div class="container-fluid">
		<h2 class="no-margin-bottom">RFI List</h2>
	</div>
</header>
<style>
	@media (min-width: 900%) {
		.modal-dialog {
			width: 900%;
			margin: 30px auto;
		}
	}
</style>

<div class="table-agile-info">
	<div class="container-fluid">
		<?php $mauth = $this->session->userdata('autho');
		// echo "<pre> \n";print_r($mauth);die;
		if ($this->session->flashdata('message') != null) {
			echo "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>"
				. $this->session->flashdata('message') . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span>
			</button> </div>";
		} ?>
		<br>
		<div class="card rounded-0 shadow">
			<div class="card-header">
				<?php if (strpos($mauth, '271') > -1) { ?>
					<a href="#add" onclick="add(1)" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add Rfi</a>
				<?php } ?>
				<form action="<?= base_url('index.php/Rfi/save_roadno') ?>" method="post">
					<div class="form-group row">
						<div class="col-sm-2 "><label>Road Name</label></div>
						<div class="col-sm-7">
							<select name="proid" id="proid" required="form-control" class="form-control">
								<?php foreach ($get_roadlist as $road) : ?>
									<option value="<?= $road["rid"] ?>" <?php $a = $this->session->userdata('roadid');
																		if ($road["rid"] == $a) { ?>selected<?php }
																											?>> <?= $road["rid"] . ":" . $road["rname"] ?>
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
						<tr>
							<td>RFI ID </td>
							<td>Location</td>
							<td>Date</td>
							<td>Time</td>
							<td>Remarks</td>
							<td>For</td>
							<td>Status</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody style="background-color: white;">
						<?php
						$no = 0;
						$userid = $this->session->userdata('userid');
						$username = $this->session->userdata('username');

						$this->db->select('fullname');
						$this->db->where('user_code', $userid);
						$userRow = $this->db->get('user')->row();
						$login_fullname = $userRow ? trim($userRow->fullname) : null;

						foreach ($get_Rfi as $Rfi) : $no++;

							$current_assignee = trim($Rfi->muser);

							$this->db->select('muser, action');
							$this->db->where('rfiid', $Rfi->rfiid);
							$this->db->order_by('mdate DESC, mtime DESC');
							$this->db->limit(1);
							$lastAction = $this->db->get('tabrfiaction')->row();

							if ($lastAction) {
								$current_assignee = trim($lastAction->muser);
							}
						?>
							<tr>
								<td><?= $Rfi->rfiid ?></td>
								<td><?= $Rfi->location ?></td>
								<td><?= $Rfi->mdate ?></td>
								<td><?= $Rfi->mtime ?></td>
								<td><?= $Rfi->rem ?></td>
								<td><?= $Rfi->muser ?></td>
								<td>
									<?php if (is_null($Rfi->myn)) {
										echo $Rfi->action;
									} else {
										echo $Rfi->myn;
									} ?>
								</td>
								<td>
									<?php
									if (is_null($Rfi->myn)) {
										// Edit button
										if (strpos($mauth, '272') > -1 && ($Rfi->mid == $username)) { ?>
											<a href="#edit" onclick="edit('<?= $Rfi->rfiid ?>')" class="btn btn-success btn-sm" data-toggle="modal"><i class="fa fa-pencil"></i></a>
										<?php }

										// Delete button
										if (strpos($mauth, '273') > -1 && ($Rfi->mid == $username)) { ?>
											<a href="<?= base_url('index.php/Rfi/hapus/' . $Rfi->rfiid) ?>" onclick="return confirm('Are you sure to delete it?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
											<?php }
										if (strpos($mauth, '274') > -1) {
											if ($lastAction) {
												if (strtolower(trim($login_fullname)) == strtolower(trim($lastAction->muser))) { ?>
													<a href="#Action" onclick="Action('<?= $Rfi->rfiid . ':' . $Rfi->location . ':' . $Rfi->rfiflow ?>')" class="btn btn-primary btn-sm" data-toggle="modal">Action</a>
												<?php }
											} else {
												if ($Rfi->muser == $username) { ?>
													<a href="#Action" onclick="Action('<?= $Rfi->rfiid . ':' . $Rfi->location . ':' . $Rfi->rfiflow ?>')" class="btn btn-primary btn-sm" data-toggle="modal">Action</a>
									<?php }
											}
										}
									}
									?>

									<?php if (strpos($mauth, '275') > -1) { ?>
										<a href="#View" onclick="View('<?= $Rfi->rfiid ?>')" class="btn btn-primary btn-sm" data-toggle="modal">View</a>
									<?php }

									// Check if lastAction exists and its action is 'Approved' or 'Rejected' before showing the Flow List button
									if (strpos($mauth, '276') > -1 && (!isset($lastAction) || !in_array($lastAction->action, ['Approved', 'Rejected']))) { ?>
										<a href="javascript:void(0);" onclick="Flow('<?= $Rfi->rfiid ?>', '<?= $Rfi->rfiflow ?>','<?= $Rfi->muser ?>')" class="btn btn-dark btn-sm">Flow List</a>
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

					<form action="<?= base_url('index.php/Rfi/add') ?>" method="post" enctype="multipart/form-data">

						<div class="modal-body">
							<div class="form-group row">
								<input type="hidden" id="rfirow" name="rfirow" class="form-control">
							</div>
							<div class="form-group row">
								<div class="col-sm-3 "><label>Item Type</label></div>
								<div class="col-sm-2 "><label>Sub Item Type</label></div>
								<div class="col-sm-3 "><label>Location</label></div>
								<div class="col-sm-2 "><label>Request to</label></div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3">
									<select name="item" id="item" required="form-control" class="form-control" onchange="javascript:Load_chainagelist()" ;>
										<?php foreach ($get_itemlist as $item) : ?>
											<option value="<?= $item->a ?>"> <?= $item->b ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="col-sm-2">
									<select name="sitem" id="sitem" required="form-control" class="form-control" ;>

									</select>
								</div>
								<div class="col-sm-3">
									<select name="chlst" id="chlst" required="form-control" class="form-control" ;></select>
								</div>
								<div class="col-sm-2">
									<select name="ulist" id="ulist" required="form-control" required class="form-control" ;>

									</select>
								</div>
								<div class="col-sm-2">
									<button type="button" class="btn btn-default" id="brfi" onclick="javascript:prepare_fill_RFI()">Add RFI</button>
								</div>
							</div>
							<label>RFI Details</label>
							<div id="inRows">
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
							<p style="font-size:20px;color:red;" id="msg1"></p>
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
					<form action="<?= base_url('index.php/Rfi/Rfi_update') ?>" method="post" enctype="multipart/form-data">

						<div class="modal-body">
							<label>RFI Details</label>
							<div id="inRows2">

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
					<form action="<?= base_url('index.php/Rfi/add') ?>" method="post">
						<input type="hidden" id="loggedin_user" value="<?= $this->session->userdata('userid') ?>">
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>RFI ID</label></div>
								<div class="col-sm-7">
									<input type="text" name="rfiid2" id="rfiid2" readonly class="form-control">
								</div>
							</div>

							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>Location</label></div>
								<div class="col-sm-7">
									<input type="text" name="chd" id="chd" readonly class="form-control">
								</div>
							</div>

							<div class="form-group row" id="userListSection">
								<div class="col-sm-3 offset-1"><label>User List</label></div>
								<div class="col-sm-7">
									<select name="ulist2" id="ulist2" class="form-control">
										<option value="">-- Select User --</option>
									</select>
								</div>
							</div>

							<?php if (strpos($mauth, '274') > -1) { ?>
								<div class="form-group row">
									<div class="col-sm-3 offset-1"><label>Action</label></div>
									<div class="col-sm-7">
										<select name="action2" id="action2" class="form-control">
											<!-- Filled dynamically -->
										</select>
									</div>
								</div>
							<?php } ?>
							<div class="form-group row" id="finalApprovedDiv" style="display: none;">
								<div class="col-sm-3 offset-1"></div>
								<div class="col-sm-7">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="final_approved" id="final_approved" value="yes">
										<label class="form-check-label" for="final_approved">
											Is this final approved?
										</label>
									</div>
								</div>
							</div>

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

		<div class="modal fade" id="Flow">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						Flow List
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
					</div>
					<form action="<?= base_url('index.php/Rfi/flowlist') ?>" method="post">
						<input type="hidden" value="" id="main_id" name="main_id">
						<input type="hidden" value="" id="muser" name="muser">
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-3 offset-1"><label>User List</label></div>
								<div class="col-sm-6">
									<select name='userlist' id="userlist" size="10" multiple onclick="add_list_user();" class="form-control">
										<?php
										if (strpos($mauth, '274') !== false) {
											if (!empty($get_userlist)) {
												foreach ($get_userlist as $ob) { ?>
													<option value="<?= $ob->user_code ?>"><?= $ob->fullname ?></option>
										<?php   }
											}
										} ?>
									</select>
								</div>
								<div class="col-sm-8">
									<select name='userlistsel' id="userlistsel" size="10" multiple ondblclick="remove_list_user();" class="form-control">
									</select>
								</div>
								<input type="text" name="seluser" id="seluser" class="form-control" readonly placeholder="Selected IDs">
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

	function edit(a) {
		var table = $('#example').DataTable();
		var i = (table.page.info().page);
		var info = a + ":" + i;
		$.ajax({
			type: "post",
			url: "<?= base_url() ?>index.php/Rfi/find_Rfi/" + info,
			dataType: "json",
			success: function(data) {
				var container = document.getElementById("inRows2");
				while (container.hasChildNodes()) {
					container.removeChild(container.lastChild);
				}
				var newColumn = document.createElement('div');
				newColumn.innerHTML = '<div class="form-group row"><div class="col-sm-3 "><label>Location</label></div><div class="col-sm-3 "><label>Date of Inspection</label></div><div class="col-sm-3 "><label>Time of Inspection</label></div><div class="col-sm-3 "><label>Remarks</label></div></div>'
				newColumn.innerHTML = newColumn.innerHTML + '<div class="form-group row"><div class="col-sm-3"><input type="text" name="ch0" id="ch0" Required class="form-control"></div><div class="col-sm-3"><input type="date" name="md0" id="md0" Required class="form-control"></div><div class="col-sm-3"><input type="time" name="mt0" id="mt0" Required class="form-control"></div><div class="col-sm-3"><input type="text" name="rm0" id="rm0" Required class="form-control"></div><div class="col-sm-1"><input type="hidden"  name="rfiid0" id="rfiid0" class="form-control"></div></div>'
				container.appendChild(newColumn);
				document.getElementById('rfiid0').value = data.rfiid;
				document.getElementById('ch0').value = data.location;
				document.getElementById('md0').value = data.mdate;
				document.getElementById('mt0').value = data.mtime;
				document.getElementById('rm0').value = data.rem;
			}
		});

	}

	function add(a) {
		load_users(a);
		Load_chainagelist();
	}

	function Action(data) {
		const parts = data.split(':');
		const rfiid = parts[0];
		const location = parts[1];
		const rfiflow = parts.slice(2).join(':');
		const loggedin = document.getElementById("loggedin_user").value;

		document.getElementById('rfiid2').value = rfiid;
		document.getElementById('chd').value = location;

		const ulist = document.getElementById("ulist2");
		const actionDropdown = document.getElementById("action2");
		const userListSection = document.getElementById("userListSection");
		const finalApprovedDiv = document.getElementById("finalApprovedDiv");
		const finalApprovedCheckbox = document.getElementById("final_approved");

		// Clear contents
		ulist.innerHTML = `<option value="">-- Select User --</option>`;
		actionDropdown.innerHTML = "";

		// Default dropdown options
		const defaultOption = new Option("-- Select Action --", "");
		const forwardOption = new Option("Forward", "Forward");
		const approvedOption = new Option("Approved", "Approved");
		const rejectedOption = new Option("Rejected", "Rejected");

		actionDropdown.appendChild(defaultOption);
		actionDropdown.appendChild(approvedOption);
		actionDropdown.appendChild(rejectedOption);

		// Hide by default
		userListSection.style.display = "none";
		ulist.removeAttribute("required");
		finalApprovedDiv.style.display = "none";

		if (rfiflow.trim() !== "") {
			$.ajax({
				type: "POST",
				url: "<?= base_url('index.php/Rfi/get_users_from_rfiflow') ?>",
				data: {
					rfiflow: rfiflow,
					loggedin: loggedin
				},
				dataType: "json",
				success: function(response) {
					if (response.length > 0) {
						userListSection.style.display = "flex";

						// Add Forward at top (before approved/rejected)
						actionDropdown.insertBefore(forwardOption, actionDropdown.children[1]);

						// Add users to dropdown
						response.forEach(user => {
							const opt = new Option(user.fullname, user.fullname);
							ulist.appendChild(opt);
						});
					}
				},
				error: function(xhr, status, error) {
					console.error("AJAX Error:", error);
				}
			});
		}

		// 🧠 Action change listener
		actionDropdown.onchange = function() {
			const selectedAction = this.value;

			if (selectedAction === "Forward") {
				if (userListSection.style.display === "flex") {
					ulist.setAttribute("required", "required");
				}
				finalApprovedDiv.style.display = "none";
				finalApprovedCheckbox.checked = false;
			} else if (selectedAction === "Approved") {
				ulist.removeAttribute("required");
				finalApprovedDiv.style.display = "flex";
			} else {
				ulist.removeAttribute("required");
				finalApprovedDiv.style.display = "none";
				finalApprovedCheckbox.checked = false;
			}
		};

		$('#Action').modal('show');
	}


	function load_users(a) {
		var ulist = "";
		if (a == 1) {
			$("#ulist").empty();
			ulist = document.getElementById("ulist");
		} else {
			$("#ulist2").empty();
			ulist = document.getElementById("ulist2");
		}

		$.ajax({
			type: "post",
			url: "<?= base_url() ?>index.php/Rfi/get_userid",
			dataType: "json",
			success: function(data) {
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
		var list2 = document.getElementById("item");
		var c = list2.options[list2.selectedIndex].value;
		var chlist = document.getElementById("chlst");
		$("#chlst").empty();
		//alert(c);	
		$.ajax({
			type: "post",
			url: "<?= base_url() ?>index.php/Rfi/get_chainagelist/" + c,
			dataType: "json",
			success: function(data) {
				var k = Object.keys(data).length;
				if (k > 0) {
					$('#brfi').removeAttr('disabled');
				} else {
					$('#brfi').attr('disabled', 'disabled');
				}
				for (var i = 0; i < k; i++) {
					var option = document.createElement("option");
					option.value = i;
					option.text = data[i].ch;
					chlist.add(option);
				}
			}
		});
		Load_rfiitem();
	}

	function Load_rfiitem() {
		var list2 = document.getElementById("item");
		var list1 = document.getElementById("sitem");
		$("#sitem").empty();
		var c = list2.options[list2.selectedIndex].value;
		var iname = list2.options[list2.selectedIndex].text;
		$.ajax({
			type: "post",
			url: "<?= base_url() ?>index.php/Item/find_rfiitem/" + c,
			dataType: "json",
			success: function(data) {
				var k = Object.keys(data).length;
				if (k > 0) {
					for (var l = 0; l < k; l++) {
						var option = document.createElement("option");
						option.value = data[l].id;
						option.text = data[l].descrip;
						list1.add(option);
					}
				} else {
					var option = document.createElement("option");
					option.value = 0;
					option.text = iname;
					list1.add(option);
				}
			}
		});

	}

	function prepare_fill_RFI() {
		var list1 = document.getElementById("proid");
		var a = list1.options[list1.selectedIndex].text.split(":");
		var e = document.getElementById("item");
		var v1 = e.options[e.selectedIndex].value;
		var s = document.getElementById("sitem");
		var v2 = s.options[s.selectedIndex].value;
		var ch = $("#chlst option:selected").text().trim();

		if (v2.length < 2) {
			v2 = '0' + v2;
		}

		var isBlocked = false;
		$.ajax({
			type: "POST",
			url: "<?= base_url('index.php/Rfi/check_rfi_duplicate') ?>",
			data: {
				location: ch
			},
			dataType: "json",
			async: false,
			success: function(response) {
				if (response.status === "exists") {
					alert("RFI already approved for this section.");
					isBlocked = true;
				}
			}
		});
		if (isBlocked) return;

		var nrfiid = a[0] + v1 + v2;
		var rfientry = checkalreadyenter(nrfiid, ch);
		if (rfientry == 1) {
			alert('RFI already issued for this section.');
			return;
		}

		var vd = verifydrawing(ch, v1);
		if (vd > 0) {
			alert('Drawing not verified for this location');
			return;
		}

		var selectedItemText = $("#item option:selected").text().trim();
		var selectedLocation = ch.trim();
		var rrow = document.getElementById("rfirow").value;
		if (rrow.length == 0) {
			rrow = '0';
		}
		var rfiid = 'rfiid' + rrow;
		var loca = 'ch' + rrow;
		var md = 'md' + rrow;
		var mt = 'mt' + rrow;
		var rm = 'rm' + rrow;
		var mdate = getFormattedDateTime();
		var container = document.getElementById("inRows");
		if (rrow.length < 2) {
			rrow = '0' + rrow;
		}
		nrfiid = nrfiid + mdate + rrow;
		var newColumn = document.createElement('div');
		newColumn.setAttribute('class', 'form-group row rfi-entry');
		newColumn.setAttribute('id', 'rfirow' + rrow);

		newColumn.innerHTML =
			'<div class="col-sm-1">' +
			'<input type="text" name="' + rfiid + '" id="' + rfiid + '" Readonly class="form-control">' +
			'</div>' +
			'<div class="col-sm-3">' +
			'<input type="text" name="' + loca + '" id="' + loca + '" Required onchange="javascript:checkchainage(this.id)" class="form-control">' +
			'</div>' +
			'<div class="col-sm-3">' +
			'<input type="date" name="' + md + '" id="' + md + '" Required class="form-control" min="<?php echo date('Y-m-d'); ?>">' +
			'</div>' +
			'<div class="col-sm-2">' +
			'<input type="time" name="' + mt + '" id="' + mt + '" Required onchange="javascript:check_datetime(this.id)" class="form-control" min="<?php echo date('H:i'); ?>">' +
			'</div>' +
			'<div class="col-sm-2">' +
			'<input type="text" name="' + rm + '" id="' + rm + '" Required class="form-control">' +
			'</div>' +
			'<div class="col-sm-1 text-center">' +
			'<button type="button" class="btn btn-sm btn-danger" onclick="removeRfiRow(\'rfirow' + rrow + '\')">✖</button>' +
			'</div>';

		$("#rfirow").val(Number(rrow) + 1);
		container.appendChild(newColumn);
		document.getElementById(rfiid).value = nrfiid;
		document.getElementById(loca).value = ch;
		$('#brfi').attr('disabled', 'disabled');
	}

	// ALTER TABLE `tabitemcode` ADD `completed` INT NULL DEFAULT NULL AFTER `sitem`;
	// ALTER TABLE `tabrfiitem` ADD `completed` INT NULL DEFAULT NULL AFTER `descrip`;

	function removeRfiRow(rowId) {
		var row = document.getElementById(rowId);
		if (row) {
			row.remove();
			document.getElementById("msg1").innerHTML = '';
			var remaining = document.querySelectorAll('.rfi-entry').length;
			if (remaining === 0) {
				$('#brfi').removeAttr('disabled');
			}
			$('#save').removeAttr('disabled');
		}
	}


	function View(c) {
		var table_data = '';
		$('#example2').empty();
		const tabcaption = document.getElementById("h01");
		const itemname = document.getElementById("h02");
		$.ajax({
			type: "post",
			url: "<?= base_url() ?>index.php/Rfi/list_Rfi/" + c,
			dataType: "json",
			success: function(data) {
				var toval = "";
				tabcaption.innerHTML = "RFI ID Number :" + data[0].rfiid;
				var itemid = data[0].rfiid.substring(3, 6);
				var sitemid = Number(data[0].rfiid.substring(6, 8));
				if (sitemid > 0) {
					sitemid = '/Sub item ';
				} else {
					sitemid = ''
				}
				<?php foreach ($get_itemlist as $item) : ?>
					if (itemid == '<?= $item->a ?>') {
						itemname.innerHTML = "RFI approval status of :" + '<?= $item->b ?>' + sitemid;
					}
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
				for (var i = 0; i < k; i++) {
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

	function verifydrawing(a, b) {
		var c = 0;
		var d = 0;
		$.ajax({
			type: "post",
			url: "<?= base_url() ?>index.php/Rfi/verify_drawing/" + a + "/" + b,
			dataType: "json",
			async: false,
			success: function(data) {
				c = data[0].t;
				d = data[0].a;
				//alert(c+'-'+d);
				if (c > 0 && d > 0) {
					c = c - d;
				} else {
					c = 1;
				}
			}
		});
		return c;
	}

	function checkalreadyenter(i, c) {
		var d = 0;
		<?php $no = 0;
		foreach ($get_Rfi as $Rfi) : $no++; ?>
			var a = '<?= substr($Rfi->rfiid, 0, 8) ?>';
			var b = '<?= $Rfi->location ?>';
			var cho = b.split('-');
			var chn = c.split('-');
			if (a == i) {
				if (cho.length == chn.length) {
					if (b == c) {
						d = 1;
					} else {
						if (cho.length == 2 && !isWithinRange(chn[0], chn[1], cho[0], cho[1])) {
							d = b;
						}
					}
				}
			}
		<?php endforeach ?>
		return d;
	}

	function isWithinRange(a1, a2, b1, b2) {
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

	function checkchainage(fieldId) {
		var rfiIndex = fieldId.replace(/\D/g, '');
		var rfiidField = 'rfiid' + rfiIndex;
		var chField = 'ch' + rfiIndex;

		var rfiid = document.getElementById(rfiidField).value.substring(0, 8);
		var enteredLoc = document.getElementById(chField).value.trim();

		var dropdownLoc = $("#chlst option:selected").text().trim();

		document.getElementById("msg1").innerHTML = '';

		if (enteredLoc === '') {
			$('#save').attr('disabled', 'disabled');
			document.getElementById("msg1").innerHTML = 'Location cannot be empty.';
			return;
		}

		// Split and parse both ranges
		var [selStart, selEnd] = dropdownLoc.split('-').map(parseFloat);
		var [entStart, entEnd] = enteredLoc.split('-').map(parseFloat);

		if (isNaN(entStart) || isNaN(entEnd)) {
			$('#save').attr('disabled', 'disabled');
			document.getElementById("msg1").innerHTML = 'Invalid location format.';
			return;
		}

		// Check if entered range is inside selected range
		if (entStart < selStart || entEnd > selEnd || entStart >= entEnd) {
			$('#save').attr('disabled', 'disabled');
			document.getElementById("msg1").innerHTML =
				`Entered location (${enteredLoc}) must be within selected range (${dropdownLoc}).`;
			return;
		}

		// Check if RFI already exists
		var alreadyExists = checkalreadyenter(rfiid, enteredLoc);
		if (alreadyExists === 1) {
			$('#save').attr('disabled', 'disabled');
			document.getElementById("msg1").innerHTML =
				'RFI already issued for location ' + enteredLoc;
		} else {
			$('#save').removeAttr('disabled');
			document.getElementById("msg1").innerHTML = '';
		}
	}


	function check_datetime(a) {
		document.getElementById("msg1").innerHTML = '';
		var v1 = document.getElementById(a).value;
		var v2 = document.getElementById(a.replace('mt', 'md')).value;
		var cd = '<?php echo date('Y-m-d') ?>';
		var ct = '<?php date_default_timezone_set('Asia/Kolkata');
					echo date('H:i') ?>';
		var vt = v1.split(':');
		var nt = ct.split(':');
		if (v2 == cd) {
			var v1InMinutes = parseInt(vt[0]) * 60 + parseInt(vt[1]);
			var ctInMinutes = parseInt(nt[0]) * 60 + parseInt(nt[1]);
			var difference = v1InMinutes - ctInMinutes;
			if (difference < 0) {
				document.getElementById("msg1").innerHTML = 'Time selection can not be in previous time on same date';
				$('#save').attr('disabled', 'disabled');
			} else {
				$('#save').removeAttr('disabled');
				document.getElementById("msg1").innerHTML = '';
			}
		} else {
			$('#save').removeAttr('disabled');
			document.getElementById("msg1").innerHTML = '';
		}

	}

	function updateUserId() {
		const select = document.getElementById('userlist');
		const userIdDisplay = document.getElementById('selectedUserId');
		const selectedValue = select.value;

		if (selectedValue) {
			userIdDisplay.value = selectedValue;
		} else {
			userIdDisplay.value = '';
		}
	}
</script>

<script>
	function add_list_user() {
		var allUsers = document.getElementById("userlist");
		var selectedUsers = document.getElementById("userlistsel");
		var outputField = document.getElementById("seluser");

		for (let i = 0; i < allUsers.length; i++) {
			if (allUsers.options[i].selected) {
				// Prevent duplicates
				let alreadyExists = false;
				for (let j = 0; j < selectedUsers.length; j++) {
					if (selectedUsers.options[j].value === allUsers.options[i].value) {
						alreadyExists = true;
						break;
					}
				}

				if (!alreadyExists) {
					let option = document.createElement("option");
					option.value = allUsers.options[i].value;
					option.text = allUsers.options[i].text;
					selectedUsers.add(option);
				}
			}
		}

		update_user_selection();
	}

	function remove_list_user() {
		var selectedUsers = document.getElementById("userlistsel");
		var outputField = document.getElementById("seluser");

		if (selectedUsers.selectedIndex >= 0) {
			selectedUsers.remove(selectedUsers.selectedIndex);
		}

		update_user_selection();
	}

	function update_user_selection() {
		var selectedUsers = document.getElementById("userlistsel");
		var outputField = document.getElementById("seluser");

		let selectedValues = [];
		for (let i = 0; i < selectedUsers.length; i++) {
			selectedValues.push(selectedUsers.options[i].value);
		}

		outputField.value = selectedValues.join(",");
	}

	function Flow(rfiid, flowUsersCsv, muser) {
		document.getElementById("main_id").value = rfiid;
		document.getElementById("muser").value = muser;

		fetch("<?= base_url('index.php/Rfi/get_user_ajax') ?>", {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded"
				},
				body: `rfiid=${rfiid}`
			})
			.then(res => res.json())
			.then(data => {
				const userList = document.getElementById("userlist");
				userList.innerHTML = "";
				data.forEach(user => {
					const opt = document.createElement("option");
					opt.value = user.user_code;
					opt.text = user.fullname;
					userList.appendChild(opt);
				});

				const selectedList = document.getElementById("userlistsel");
				const outputField = document.getElementById("seluser");

				selectedList.innerHTML = "";
				if (flowUsersCsv && flowUsersCsv.trim() !== "") {
					const selectedIds = flowUsersCsv.split(",");
					selectedIds.forEach(id => {
						const found = [...userList.options].find(opt => opt.value === id);
						if (found) {
							const selOpt = document.createElement("option");
							selOpt.value = found.value;
							selOpt.text = found.text;
							selectedList.appendChild(selOpt);
						}
					});
					outputField.value = selectedIds.join(",");
				} else {
					outputField.value = "";
				}

				$('#Flow').modal('show');
			});
	}


	document.addEventListener("DOMContentLoaded", function() {
		const actionDropdown = document.getElementById("action2");
		const finalApprovedDiv = document.getElementById("finalApprovedDiv");
		if (actionDropdown) {
			actionDropdown.addEventListener("change", function() {
				if (this.value === "Approved") {
					finalApprovedDiv.style.display = "flex";
				} else {
					finalApprovedDiv.style.display = "none";
					document.getElementById("final_approved").checked = false;
				}
			});
		}
	});
</script>