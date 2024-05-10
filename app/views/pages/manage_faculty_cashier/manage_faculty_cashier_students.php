<?php include PATH_VIEW."/components/header.php"; ?>

<body>
<?php include PATH_VIEW."/components/navbar.php"; ?>
     <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row mt-3 gap-3">
                        <div class="col-12 d-flex justify-content-between">
                            <h3 class="d-inline">
                                <a class="btn btn-primary" href="<?php echo ROOT;?>manage_faculty_cashier" style="width: 80px; height: 45px;">
                                    <i class="fa fa-reply"></i>
                                </a>
                                <p class="d-none d-md-inline">School Treasurer Student List</p>
                            </h3>
                        </div>
                        <div class="col-12">
                            <div class="card">
                              <div class="card-body">  
                              <div class="row mb-2 gap-2">
                                <!-- <div class="col-12 col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-text w-25">
                                            Grade:
                                        </span>
                                        <select class="form-control" name="grade" id="grade">
                                            <option value="" selected disabled>Please select grade.</option>
                                            <option value="1">All</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-text w-25">
                                            Section:
                                        </span>
                                        <select class="form-control" name="section" id="section">
                                            <option value="" selected disabled>Please select section.</option>
                                            <option value="1">All</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-2">    
                                    <button class="btn btn-primary w-100">
                                        <i class="fa fa-signature"></i>
                                        Chared All
                                    </button>
                                </div> -->
                              </div>
                                <div class="row">
                                    <div class="col-12">
                                        <table id="table" class="table table-bordered table-hover text-center">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Profile</th>
                                                <th>Fullname</th>
                                                <th>Grade and Section</th>
                                                <th>Adviser</th>
                                                <th>Requirements</th>
                                                <th>Payment method</th>
                                                <th>Reference Number</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php $counter = 1; foreach($data as $result) { ?>
                                                    <tr>
                                                        <td><?php echo $counter++; ?></td>
                                                        <td>
                                                            <img class="img-thumbnail" src="<?php echo $result['image_path']; ?>" alt="Profile Image" style="width: 50px; height: 50px;">
                                                        </td>
                                                        <td><?php echo $result['student_fullname']?></td>
                                                        <td><?php echo 'Grade '.$result['grade'] .' ( '. $result['section'] .' ) '?></td>
                                                        <td><?php echo $result['adviser_fullname']?></td>
                                                        <td class="d-flex flex-column"><span><?php echo $result['payable']?></span> <b>Payable: <i class="fa fa-peso-sign"></i> <?php echo $result['amount']?></b></td>
                                                        <td><b><?php echo empty($result['payment_method']) ? 'Pending':$result['payment_method']?></b></td>
                                                        <td><b><?php echo empty($result['reference_number']) ? 'N/A':$result['reference_number']?></b></td>
                                                        <td><b><?php echo $result['status'] == 1 ? 'Pending':'OK'?></b></td>
                                                        <td>
                                                            <?php 
                                                                if($result['status'] == 1) 
                                                                {
                                                            ?>
                                                            <div class="dropdown">
                                                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                                </button>
                                                                <ul class="dropdown-menu p-2">
                                                                    <?php
                                                                        if(!empty($result['payment_method']))
                                                                        {
                                                                    ?>
                                                                            <li>
                                                                                <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_faculty_cashier_students/chared">
                                                                                    <input class="form-control" type="text" name="id" value="<?php echo $result['id']?>" readonly hidden>
                                                                                    <input class="form-control" type="text" name="status" value="<?php echo $result['status']?>" readonly hidden>
                                                                                    <button class="btn btn-primary w-100 mb-2">
                                                                                        <i class="fa fa-signature"></i>
                                                                                        Cleared
                                                                                    </button>
                                                                                </form>
                                                                            </li>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                    <li>
                                                                        <button class="btn btn-warning w-100 mb-2 edit_button" data-id="<?php echo $result['id']?>" data-bs-toggle="modal" data-bs-target="#editModal">
                                                                            <i class="fa fa-money-bill"></i>
                                                                            Payment
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <?php 
                                                                }
                                                                else
                                                                {
                                                                    echo '<b>Cleared</b>';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                              </div>
                              <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h1 class="modal-title fs-5" id="editModalLabel">Payment</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_faculty_cashier_students/update">
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <div class="row mt-3 gap-3">
                                <div class="col-12 input-group">
                                    <span class="input-group-text" style="width: 35%;">
                                        Payable:
                                    </span>
                                    <input class="form-control" type="number" name="payable" id="payable" readonly>
                                </div>
                                <div class="col-12 input-group">
                                    <span class="input-group-text" style="width: 35%;">
                                        Payment method:
                                    </span>
                                    <select class="form-control" name="payment_method" id="payment_method" required>
                                        <option value="" selected disabled>Please select payment method.</option>
                                    </select>
                                </div>
                                <div class="col-12 input-group" id="div_reference_number" hidden>
                                    <span class="input-group-text" style="width: 35%;">
                                        Reference Number:
                                    </span>
                                    <input class="form-control" type="number" name="reference_number" id="reference_number" placeholder="Please enter reference number.">
                                </div>
                                <div class="col-12 input-group">
                                    <span class="input-group-text" style="width: 35%;">
                                        Amount:
                                    </span>
                                    <input class="form-control" type="number" name="amount" id="amount" placeholder="Please enter amount." required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500
            });

            // jQuery
            $('.postForm').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    type     : "POST",
                    cache    : false,
                    url      : $(this).attr('action'),
                    data     : $(this).serialize(),
                    success  : function(data) {

                        // console.log(data);

                        const json = JSON.parse(data);

                        switch(json['response']) {
                            case '1':
                                    Toast.fire({
                                        icon: 'success',
                                        title: '<p class="text-center pt-2 text-black">' +json['message']+ '</p>'
                                    });

                                    setTimeout(() => {
                                        location.reload();
                                    },1500);

                                break;
                            default:
                                    Toast.fire({
                                        icon: 'error',
                                        title: '<p class="text-center pt-2">' +json['message']+ '</p>'
                                    });
                                break;
                        }
                    }
                });
            });

            $('.edit_button').on('click', function() {
                const path = '<?php echo ROOT; ?>manage_faculty_cashier_students/edit';
                const id = $(this).attr('data-id');
                $.ajax({
                    type     : "POST",
                    cache    : false,
                    url      : path,
                    data     : {id:id},
                    success  : function(data) {
                        
                        // console.log(data);
                        const json = JSON.parse(data);
                        $('.id').val(json['id']);
                        $('#payable').val(json['payable_amount']);
                        $('#amount').val(json['amount']);
                        $('#reference_number').val(json['reference_number']);

                        const arr_payment_method = json['fee_payment_method'].split(',');
                        
                        let i = 0;
                        let result = '<option value="" selected disabled>Please select payment method.</option>';
                        while (i < arr_payment_method.length) {
                            const payment_method = arr_payment_method[i] == '1' ? 'Walk In':'Gcash';
                            result += '<option value="'+payment_method+'">'+payment_method+'</option>';
                            i++;
                        }
                        $('#payment_method').html(result);
                        $('#payment_method').val(json['payment_method']);
                        
                    }
                });
            });

            $("#editModal").on("hidden.bs.modal", function(event) {
                $('#payment_method').html('<option value="" selected disabled>Please select payment method.</option>');
                $('#reference_number').val("");
                $('#div_reference_number').prop("hidden", true);
            });

            $('#payment_method').on('change', function() {
                if($('#payment_method').val() == "Gcash")
                {
                    $('#div_reference_number').prop("hidden", false);
                }
                else
                {
                    $('#div_reference_number').prop("hidden", true);
                    $('#reference_number').val("");
                }
            });

        </script>

        <script>
            $(function () {
                $("#table").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false, "ordering": true, "pageLength": 10,
                "buttons": [
                    {
                        extend: 'excel',
                        title: "Faculty Member Student List",
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(xlsx) {
                            const sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row c', sheet).each(function () {
                                $(this).attr('s', '51');
                            });
                        }
                    }
                    , 
                    {
                        extend: 'pdf',
                        title: "Faculty Member Student List",
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(doc) {
                            doc.defaultStyle.alignment = 'center';
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    }
                    ,
                    {
                        extend: 'print',
                        title: "Faculty Member Student List",
                        exportOptions: {
                            stripHtml: false,
                            columns: ':visible',
                        }
                    }
                    ,"colvis"]
                }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
            });
        </script>

    </main>
<?php include PATH_VIEW."/components/footer.php"; ?>