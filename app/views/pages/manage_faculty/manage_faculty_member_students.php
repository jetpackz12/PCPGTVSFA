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
                                        if(in_array("Assign Subjects", $arr_multi_role))
                                        {
                                ?>
                                            <a class="btn btn-primary" href="<?php echo ROOT;?>manage_faculty" style="width: 80px; height: 45px;">
                                                <i class="fa fa-reply"></i>
                                            </a>
                                <?php
                                        }
                                    }
                                ?>
                                <p class="d-none d-md-inline">Faculty Member Student List</p>
                            </h3>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal" style="height: 45px;">
                                <i class="fa fa-plus-circle"></i>
                                Add Requirements
                            </button>
                        </div>
                        <div class="col-12">
                            <div class="card">
                              <div class="card-body">  
                                <?php if(count($data3) > 0) { ?>
                                <div class="row mb-2 gap-2">
                                    <form class="postForm d-flex p-0" method="POST" action="<?php echo ROOT;?>manage_faculty_member_students/chared_all">
                                    <input class="form-control" type="text" name="faculty_id" value="<?php echo $data4?>" readonly hidden>
                                        <div class="col-12 col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-text w-25">
                                                    Subject:
                                                </span>
                                                <select class="form-control" name="subject_filter" id="subject_filter">
                                                    <option value="" selected disabled>Please select subject for multiple charing.</option>
                                                    <?php 
                                                        $arr_subjects = explode(",", $data2);

                                                        foreach($data as $result) { 
                                                            if($result['status'] == 1 && in_array($result['id'], $arr_subjects))
                                                            {
                                                                echo '<option value="'.$result['id'].'">'.'Gr. '.$result['grade'] . ' ( ' . $result['section'] .' -'.$result['subject'].' )'.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    <option value="All">All Subjects</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-2">    
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fa fa-signature"></i>
                                                Chared All
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="col-12">
                                        <table id="table" class="table table-bordered table-hover text-center">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Profile</th>
                                                <th>Fullname</th>
                                                <th>Subject, Grade and Section</th>
                                                <th>Adviser</th>
                                                <th>Requirements</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php $counter = 1; foreach($data3 as $result) { ?>
                                                    <tr>
                                                        <td><?php echo $counter++; ?></td>
                                                        <td>
                                                            <img class="img-thumbnail" src="<?php echo $result['image_path']; ?>" alt="Profile Image" style="width: 50px; height: 50px;">
                                                        </td>
                                                        <td><?php echo $result['student_fullname']?></td>
                                                        <td><?php echo $result['subject']?> - <b><?php echo 'Grade '.$result['grade'] .' ( '. $result['section'] .' ) '?></b></td>
                                                        <td><?php echo $result['teacher_fullname']?></td>
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
                                                                        <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_faculty_member_students/chared">
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
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_faculty_member_students/store">
                        <div class="modal-body">
                            <input class="form-control" type="text" name="faculty_id" value="<?php echo $data4?>" readonly hidden>
                            <input class="form-control" type="text" name="student_ids" id="students" readonly hidden>
                            <div class="row mt-3 gap-3">
                                <div class="col-12 input-group">
                                    <span class="input-group-text w-25">
                                        Subject:
                                    </span>
                                    <select class="form-control" name="subject" id="subject" required>
                                        <option value="" selected disabled>Please select subject.</option>
                                        <?php 
                                            $arr_subjects = empty($data5) ? explode(",", $data2) : explode(",", $data5);
                                            
                                            foreach($data as $result) { 
                                                if($result['status'] == 1 && in_array($result['id'], $arr_subjects))
                                                {
                                                    echo '<option value="'.$result['id'].'">'.'Gr. '.$result['grade'] . ' ( ' . $result['section'] .' -'.$result['subject'].' )'.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="requirements" class="form-label">Requirements</label>
                                    <textarea class="form-control" name="requirements" id="requirements" rows="3"></textarea>
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
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_faculty_member_students/update">
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <div class="row mt-3 gap-3">
                                <div class="col-12 input-group">
                                    <span class="input-group-text w-25">
                                        Student:
                                    </span>
                                    <input class="form-control" type="text" name="e_student" id="e_student" disabled>
                                </div>
                                <div class="col-12 input-group">
                                    <span class="input-group-text w-25">
                                        Subject:
                                    </span>
                                    <input class="form-control" type="text" name="e_subject" id="e_subject" disabled>
                                </div>
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
                                    $('#subject').prop('disabled', true);
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
                const path = '<?php echo ROOT; ?>manage_faculty_member_students/edit';
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
                        $('#e_student').val(json['student_fullname']);
                        $('#e_subject').val(json['subject'] + '- Grade ' + json['grade'] + ' ( ' + json['section'] + ' )');
                        $('#e_requirements').val(json['requirements']);
                        
                    }
                });
            });

            $("#addModal").on("hidden.bs.modal", function(event) {
                $('#subject').val("");
                $('#requirements').val("");
            });

            $("#subject").on("change", () => {
                const path = '<?php echo ROOT; ?>manage_faculty_member_students/get_student_ids';
                const subject_id = $("#subject").val();
                $.ajax({
                    type     : "POST",
                    cache    : false,
                    url      : path,
                    data     : {subject_id:subject_id},
                    success  : function(data) {

                        const json = JSON.parse(data);
                        $('#students').val(json['response']);
                        
                    }
                });
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