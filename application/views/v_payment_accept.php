<header class="page-header">
    <div class="container-fluid">
        <h2 class="no-margin-bottom">Road Details</h2>
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
                <?php if (strpos($mauth, '101') > -1) { ?>
                    <a href="#add" onclick="add()" data-toggle="modal" class="btn btn-primary btn-sm rounded-0 pull-right"><i class="fa fa-plus"></i> Add New Payment</a>
                <?php } ?>
            </div>


            <div class="col-md-12" style="overflow-x: auto">
                <table class="table table-hover w-100 small table-bordered" id="example" ui-options='{"paging": { "enabled": true },"filtering": { "enabled": true },"sorting": { "enabled": true }}'>

                    <thead style="background-color: #464b58; color:white;">
                        <tr>
                            <td>#</td>
                            <td>Payment Name</td>
                            <td>Description</td>
                            <td>Logic</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody style="background-color: white;">
                        <?php
                        $i = 1;
                        if (!empty($getPayList)) {
                            foreach ($getPayList as $obj) { ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $obj->pname ?? ''; ?></td>
                                    <td><?= $obj->detail ?? ''; ?></td>
                                    <td><?= $obj->logic ?? ''; ?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-sm btn-info open-view-modal" data-title="View Payment" data-url="<?= base_url('PaymentMethod/view/' . $obj->cid); ?>">
                                            View
                                        </a>

                                        <a href="javascript:void(0);" class="btn btn-sm btn-warning open-edit-modal" data-title="Edit Payment" data-url="<?= base_url('PaymentMethod/edit/' . $obj->cid); ?>">
                                            Edit
                                        </a>

                                        <a href="javascript:void(0);" class="btn btn-sm btn-danger delete-payment" data-id="<?= $obj->cid; ?>">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else { ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">No records found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="modal" id="add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Add New Payment
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                </div>
                <form id="SavePay">
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-sm-3 offset-1"><label>Payment Name:</label></div>
                            <div class="col-sm-7">
                                <input type="text" id="pname" name="pname" class="form-control" required>
                                <span class="text-danger small" id="error-pname"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3 offset-1"><label>Description:</label></div>
                            <div class="col-sm-7">
                                <input type="text" id="details" name="details" class="form-control" required>
                                <span class="text-danger small" id="error-details"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3 offset-1"><label>Logic:</label></div>
                            <div class="col-sm-7">
                                <input type="text" id="logic" name="logic" class="form-control" required>
                                <span class="text-danger small" id="error-logic"></span>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer justify-content-end">
                        <input type="button" value="Save" class="btn btn-primary btn-sm rounded-0" id="btnSavePay">
                        <button type="button" class="btn btn-default btn-sm border rounded-0" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT CASE  -->
    <div class="modal" id="edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Edit Payment
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="EditPay">
                    <div class="modal-body">
                        <input type="hidden" id="edit-id" name="cid">

                        <div class="form-group row">
                            <div class="col-sm-3 offset-1"><label>Payment Name:</label></div>
                            <div class="col-sm-7">
                                <input type="text" id="edit-pname" name="pname" class="form-control">
                                <span class="text-danger small" id="error-edit-pname"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 offset-1"><label>Description:</label></div>
                            <div class="col-sm-7">
                                <input type="text" id="edit-details" name="details" class="form-control">
                                <span class="text-danger small" id="error-edit-details"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 offset-1"><label>Logic:</label></div>
                            <div class="col-sm-7">
                                <input type="text" id="edit-logic" name="logic" class="form-control">
                                <span class="text-danger small" id="error-edit-logic"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="button" class="btn btn-primary btn-sm" id="btnUpdatePay">Update</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT CASE  -->


    <!-- View Payment Modal -->
    <div class="modal fade" id="viewPaymentModal" tabindex="-1" role="dialog" aria-labelledby="viewPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="viewPaymentModalLabel">View Payment</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-4 font-weight-bold">Payment Name:</div>
                        <div class="col-md-8" id="modalPaymentName">Loading...</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 font-weight-bold">Description:</div>
                        <div class="col-md-8" id="modalDescription"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 font-weight-bold">Logic:</div>
                        <div class="col-md-8" id="modalLogic"></div>
                    </div>
                </div>
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
                <form action="<?= base_url('index.php/Road/Road_update') ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-sm-3 offset-1">
                            <input type="hidden" name="krid" id="krid">
                            <input type="file" onchange="readText(event)" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <textarea id="output" name="output" rows="4" cols="50"></textarea>
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
</div>

<script>
    $(document).ready(function() {
        $('.open-view-modal').on('click', function() {
            var url = $(this).data('url');
            var title = $(this).data('title') || 'View Payment';

            $('#viewPaymentModalLabel').text(title);
            $('#modalPaymentName').text('Loading...');
            $('#modalDescription').text('');
            $('#modalLogic').text('');
            $('#viewPaymentModal').modal('show');

            $.getJSON(url, function(response) {
                if (response.status === 'success') {
                    $('#modalPaymentName').text(response.data.payment_name || 'N/A');
                    $('#modalDescription').text(response.data.description || 'N/A');
                    $('#modalLogic').text(response.data.logic || 'N/A');
                } else {
                    $('#modalPaymentName').text('Error');
                    $('#modalDescription').text(response.message || 'Could not fetch data');
                    $('#modalLogic').text('');
                }
            }).fail(function() {
                $('#modalPaymentName').text('Error');
                $('#modalDescription').text('Could not connect to server.');
                $('#modalLogic').text('');
            });
        });
    });

    // SAVE DATA //

    $(document).ready(function() {
        const table = $('#example').DataTable();
        $('#btnSavePay').on('click', function() {
            $('#error-pname').text('');
            $('#error-details').text('');
            $('#error-logic').text('');

            let pname = $('#pname').val().trim();
            let details = $('#details').val().trim();
            let logic = $('#logic').val().trim();
            let hasError = false;

            if (!pname) {
                $('#error-pname').text('Payment name is required.');
                hasError = true;
            }

            if (!details) {
                $('#error-details').text('Description is required.');
                hasError = true;
            }

            if (!logic) {
                $('#error-logic').text('Logic is required.');
                hasError = true;
            }

            if (hasError) return;

            $.ajax({
                url: '<?= base_url('PaymentMethod/save') ?>',
                type: 'POST',
                data: {
                    pname,
                    details,
                    logic
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#add').modal('hide');
                        $('#SavePay')[0].reset();
                        location.reload();
                    } else {
                        alert(response.message || 'Something went wrong.');
                    }
                },
                error: function() {
                    alert("Server error. Try again.");
                }
            });
        });

        // Optional: clear errors on modal close
        $('#add').on('hidden.bs.modal', function() {
            $('#SavePay')[0].reset();
            $('#error-pname, #error-details, #error-logic').text('');
        });
    });

    // EDIT DATA //

    $(document).ready(function() {
        $('.open-edit-modal').on('click', function() {
            const url = $(this).data('url');

            $.get(url, function(response) {
                if (response.status === 'success') {
                    const data = response.data;
                    $('#edit-id').val(data.cid);
                    $('#edit-pname').val(data.pname);
                    $('#edit-details').val(data.detail);
                    $('#edit-logic').val(data.logic);
                    $('#edit').modal('show');
                } else {
                    alert('Failed to load payment.');
                }
            }, 'json');
        });

        $('#btnUpdatePay').on('click', function() {
            $('#error-edit-pname, #error-edit-details, #error-edit-logic').text('');

            let cid = $('#edit-id').val().trim();
            let pname = $('#edit-pname').val().trim();
            let details = $('#edit-details').val().trim();
            let logic = $('#edit-logic').val().trim();
            let hasError = false;

            if (!pname) {
                $('#error-edit-pname').text('Payment name is required.');
                hasError = true;
            }
            if (!details) {
                $('#error-edit-details').text('Description is required.');
                hasError = true;
            }
            if (!logic) {
                $('#error-edit-logic').text('Logic is required.');
                hasError = true;
            }

            if (hasError) return;

            $.ajax({
                url: '<?= base_url('PaymentMethod/update') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    cid,
                    pname,
                    details,
                    logic
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#edit').modal('hide');
                        $('#EditPay')[0].reset();
                        location.reload();
                    } else {
                        alert(response.message || 'Something went wrong.');
                    }
                },
                error: function() {
                    alert("Server error.");
                }
            });
        });

        $('#edit').on('hidden.bs.modal', function() {
            $('#EditPay')[0].reset();
            $('#error-edit-pname, #error-edit-details, #error-edit-logic').text('');
        });
    });

    // DELETE DATA //

    $(document).ready(function() {
        $('body').on('click', '.delete-payment', function() {
            const cid = $(this).data('id');

            if (confirm('Are you sure you want to delete this payment?')) {
                $.ajax({
                    url: '<?= base_url('PaymentMethod/delete') ?>',
                    type: 'POST',
                    data: {
                        cid
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert('Deleted successfully.');
                            location.reload(); // or refresh DataTable
                        } else {
                            alert(response.message || 'Failed to delete.');
                        }
                    },
                    error: function() {
                        alert('Server error.');
                    }
                });
            }
        });
    });
</script>