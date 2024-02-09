<?php include PATH_VIEW."/components/header.php"; ?>

<body>
<?php include PATH_VIEW."/components/navbar.php"; ?>
     <main>
        <div class="container-fluid">
            <div class="row">
                <div class="d-none d-md-block col-md-3 col-xl-2 sidebar" style="height: 92vh;">
                    <?php include PATH_VIEW."/components/sidebar.php"; ?>
                </div>
                <div class="col-12 col-md-9 col-xl-10">
                    <div class="row mt-3 gap-3">
                        <div class="col-12">
                            <h3 class="d-inline">Faculty List</h3>
                            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="fa fa-plus-circle"></i>
                                Add New
                            </button>
                        </div>
                        <div class="col-12">
                            <div class="card">
                              <div class="card-body">
                                <table id="table" class="table table-bordered table-hover text-center">
                                  <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Profile</th>
                                        <th>Fullname</th>
                                        <th>Position</th>
                                        <th>Hadle Subjects</th>
                                        <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $counter = 1; foreach($data4 as $result) { ?>
                                        <tr>
                                            <td><?php echo $counter++; ?></td>
                                            <td>
                                                <img class="img-thumbnail" src="<?php echo $result['image_path']; ?>" alt="Profile Image" style="width: 50px; height: 50px;">
                                            </td>
                                            <td><?php echo $result['faculty_fullname']; ?></td>
                                            <td>
                                                <?php
                                                    $arr_multi_role = explode(",", $result['multi_role']);
                                                    foreach ($data5 as $role) {
                                                        if(in_array($role['id'], $arr_multi_role))
                                                        {
                                                            echo $role['role'].', ';
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    $arr_subjects = explode(",", $result['subjects']);
                                                    $i = 0;
                                                    while($i < count($arr_subjects)) {
                                                        
                                                        foreach($data2 as $subject) {
                                                            if($subject['id'] == $arr_subjects[$i])
                                                            {
                                                                echo '
                                                                    <p>'.$subject['subject'].' - <b> ( Grade '.$subject['grade'].' '.$subject['section'].' )</b></p>
                                                                ';
                                                            }
                                                        }

                                                        $i++;
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                    </button>
                                                    <ul class="dropdown-menu p-2">
                                                        <li>
                                                            <form method="GET" action="<?php echo ROOT;?>manage_faculty_member_students">
                                                                <input class="form-control" type="text" name="faculty_id" value="<?php echo $result['id']?>" readonly hidden>
                                                                <input class="form-control" type="text" name="subjects" value="<?php echo $result['subjects']?>" readonly hidden>
                                                                <button type="submit" class="btn btn-primary w-100 mb-2">
                                                                    <i class="fa fa-eye"></i>
                                                                    View
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <button class="btn btn-warning w-100 mb-2 edit_button" data-id="<?php echo $result['id']; ?>" data-bs-toggle="modal" data-bs-target="#editModal">
                                                                <i class="fa fa-pen-square"></i>
                                                                Edit
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="btn btn-danger w-100 edit_button" data-id="<?php echo $result['id']; ?>" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                                <i class="fa fa-trash"></i>
                                                                Delete
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
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
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">Add New Faculty Member</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_faculty/store">
                        <div class="modal-body">
                            <div class="row mt-3 gap-3">
                                <div class="col-12 input-group">
                                    <span class="input-group-text w-25">
                                        Teacher:
                                    </span>
                                    <select class="form-control" name="teacher" id="teacher" required>
                                        <option value="" selected disabled>Please select teacher.</option>
                                        <?php 
                                            foreach($data3 as $result) { 
                                                if($result['status'] == 1)
                                                {
                                                    echo '<option value="'.$result['id'].'">'.$result['fname'].' '.$result['mname'].' '.$result['lname'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <h6><b>List of Subjects.</b></h6>
                                    <?php 
                                        foreach($data as $section) {
                                    ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>
                                                <b><?php echo 'Grade ' . $section['grade'] . ' ( ' . $section['section'] . ' )'; ?></b>
                                            </h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 d-flex flex-wrap gap-4">
                                                    <?php
                                                        foreach($data2 as $subject) {
                                                            if($section['id'] == $subject['section_id'])
                                                            {
                                                                echo '
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="subject[]" value="'.$subject['id'].'" id="'.'subject'.$subject['id'].'">
                                                                        <label class="form-check-label" for="'.'subject'.$subject['id'].'">
                                                                            '.$subject['subject'].'
                                                                        </label>
                                                                    </div>    
                                                                ';
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    ?>
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
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Faculty Member</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_faculty/update">
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <div class="row mt-3 gap-3">
                                <div class="col-12 input-group">
                                    <span class="input-group-text w-25">
                                        Teacher:
                                    </span>
                                    <select class="form-control e_teacher" name="e_teacher" required>
                                        <?php 
                                            foreach($data3 as $result) { 
                                                if($result['status'] == 1)
                                                {
                                                    echo '<option value="'.$result['id'].'">'.$result['fname'].' '.$result['mname'].' '.$result['lname'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <h6><b>List of Subjects.</b></h6>
                                    <?php 
                                        foreach($data as $section) {
                                    ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>
                                                <b><?php echo 'Grade ' . $section['grade'] . ' ( ' . $section['section'] . ' )'; ?></b>
                                            </h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 d-flex flex-wrap gap-4">
                                                    <?php
                                                        foreach($data2 as $subject) {
                                                            if($section['id'] == $subject['section_id'])
                                                            {
                                                                echo '
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="e_subject[]" value="'.$subject['id'].'" id="'.'e_subject'.$subject['id'].'">
                                                                        <label class="form-check-label" for="'.'e_subject'.$subject['id'].'">
                                                                            '.$subject['subject'].'
                                                                        </label>
                                                                    </div>    
                                                                ';
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    ?>
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

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Faculty Member</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_faculty/delete">
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <input class="form-control e_teacher" type="text" name="e_teacher" readonly hidden>
                            <p>Are you sure you want to delete this faculty member?</p>
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
            const collapseFaculty = document.querySelectorAll("#collapseFaculty");
            collapseFaculty.forEach((node) => {
                node.classList.add("show")
            });
            const sidebarName = document.querySelectorAll(".manage_faculty");
            sidebarName.forEach((node) => {
                node.classList.add("active")
            });

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
                                    $('#teacher').prop('disabled', true);
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
                const path = '<?php echo ROOT; ?>manage_faculty/edit';
                const id = $(this).attr('data-id');
                $.ajax({
                    type     : "POST",
                    cache    : false,
                    url      : path,
                    data     : {id:id},
                    success  : function(data) {

                        const json = JSON.parse(data);
                        $('.id').val(json['id']);
                        $('.e_teacher').val(json['user_id']);
                        $('#e_teacher_old').val(json['user_id']);
                        $('#e_teacher_old').val(json['user_id']);

                        const arr_subjects = json['subjects'].split(",");
                        
                        for (const i of arr_subjects) {
                            $('#e_subject'+i).prop('checked', true);
                        }
                    }
                });
            });

            $("#addModal").on("hidden.bs.modal", function(event) {
                $('#teacher').val("");
            });

            $("#editModal").on("hidden.bs.modal", function(event) {
                const subjects = '<?php echo count($data2);?>'
                let i = 1;
                while(i <= subjects) {
                    $('#e_subject'+i).prop('checked', false);
                    i++;
                }
            });

        </script>

        <script>
            $(function () {
                $("#table").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false, "ordering": false, "pageLength": 5,
                "buttons": [
                    {
                        extend: 'excel',
                        title: "Faculty List",
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
                        title: "Faculty List",
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
                        title: "Faculty List",
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