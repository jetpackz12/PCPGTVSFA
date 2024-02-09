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
                                <?php
                                    if(isset($_SESSION['multi_role']))
                                    {
                                        $arr_multi_role = explode(",",$_SESSION['multi_role']['permission']);
                                        if(in_array("Advisory", $arr_multi_role))
                                        {
                                ?>
                                            <a class="btn btn-primary" href="<?php echo ROOT;?>manage_advisory" style="width: 80px; height: 45px;">
                                                <i class="fa fa-reply"></i>
                                            </a>
                                <?php
                                        }
                                    }
                                ?>
                                <p class="d-none d-md-inline">Advisory Student List</p>
                            </h3>
                            <?php
                                if(count($data) > 0 && $data4['status_sum'] > 0)
                                {
                                    echo '
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal" style="height: 45px;">
                                            <i class="fa fa-edit"></i>
                                            Update Requirements
                                        </button>
                                        ';
                                }
                                else if(count($data) < 1)
                                {
                                    echo '
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal" style="height: 45px;">
                                            <i class="fa fa-plus-circle"></i>
                                            Add Requirements
                                        </button>
                                        ';
                                }
                            ?>
                        </div>
                        <div class="col-12">
                            <div class="card">
                              <div class="card-body">  
                              <div class="row mb-2 gap-2">
                                <div class="col-12 col-md-2">
                                    <?php
                                        if($data4['status_sum'] > 0)
                                        {
                                            echo '
                                                <button class="btn btn-primary w-100 edit_button" data-bs-toggle="modal" data-bs-target="#charedAllModal">
                                                    <i class="fa fa-signature"></i>
                                                    Chared All
                                                </button>
                                                ';
                                        }
                                    ?>
                                </div>
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
                                                        <td><b><?php echo empty($result['requirements'])?'No Requirements':$result['requirements'];?></b></td>
                                                        <td><b><?php echo $result['status'] == 1 ? 'Pending':'OK';?></b></td>
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
                                                                    <li>
                                                                        <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_advisory_students/chared">
                                                                            <input class="form-control" type="text" name="id" value="<?php echo $result['id']?>" readonly hidden>
                                                                            <input class="form-control" type="text" name="status" value="<?php echo $result['status']?>" readonly hidden>
                                                                            <button class="btn btn-primary w-100 mb-2">
                                                                                <i class="fa fa-signature"></i>
                                                                                Chared
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                    <li>
                                                                        <button class="btn btn-warning w-100 mb-2 edit_button" data-id="<?php echo $result['id']?>" data-bs-toggle="modal" data-bs-target="#editModal">
                                                                            <i class="fa fa-pen-square"></i>
                                                                            Edit Requirements
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <?php 
                                                                }
                                                                else
                                                                {
                                                                    echo '<b>Chared</b>';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php }?>
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

        <!-- Add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">Add Requirements</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_advisory_students/store">
                        <div class="modal-body">
                            <input class="form-control" type="text" name="advisory_id" value="<?php echo $data2?>" readonly hidden>
                            <textarea class="form-control" name="student_ids" id="student_ids" rows="3" readonly hidden><?php foreach($data3 as $result) {echo ",".$result['id'];}?></textarea>
                            <div class="row mt-3 gap-3">
                                <div class="col-12">
                                    <label for="requirements" class="form-label">Requirements</label>
                                    <textarea class="form-control requirements" name="requirements" id="requirements" rows="3"></textarea>
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

        <!-- Update Modal -->
        <div class="modal fade" id="updateModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h1 class="modal-title fs-5" id="addModalLabel">Update Requirements</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_advisory_students/update_requirements">
                        <div class="modal-body">
                            <input class="form-control" type="text" name="advisory_id" value="<?php echo $data2?>" readonly hidden>
                            <div class="row mt-3 gap-3">
                                <div class="col-12">
                                    <label for="requirements" class="form-label">Requirements</label>
                                    <textarea class="form-control requirements" name="requirements" id="requirements" rows="3"></textarea>
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

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Requirements</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_advisory_students/update">
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <div class="row mt-3 gap-3">
                                <div class="col-12">
                                    <label for="requirements" class="form-label">Requirements</label>
                                    <textarea class="form-control" name="e_requirements" id="e_requirements" rows="3"></textarea>
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

        <!-- Chared All Modal -->
        <div class="modal fade" id="charedAllModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h1 class="modal-title fs-5" id="deleteModalLabel">Chared All Student</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_advisory_students/chared_all">
                        <div class="modal-body">
                            <input class="form-control" type="text" name="advisory_id" value="<?php echo $data2?>" readonly hidden>
                            <p>Are you sure you want to chared all student?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-primary">Yes</button>
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
                        $('.requirements').prop("disabled", true);

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
                const path = '<?php echo ROOT; ?>manage_advisory_students/edit';
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
                        $('#e_requirements').val(json['requirements']);
                        
                    }
                });
            });

            $("#addModal").on("hidden.bs.modal", function(event) {
                $('#requirements').val("");
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