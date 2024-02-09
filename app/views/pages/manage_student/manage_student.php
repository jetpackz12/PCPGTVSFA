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
                            <h3 class="d-inline">Student List</h3>
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
                                        <th>Grade and Section</th>
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
                                            <td><?php echo $result['fname'] .' '. $result['mname'] .' '. $result['lname']; ?></td>
                                            <td><?php echo 'Grade '.$result['grade'] .' ( '. $result['section'] .' ) '?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                    </button>
                                                    <ul class="dropdown-menu p-2">
                                                        <li>
                                                            <button class="btn btn-primary w-100 mb-2 edit_button" data-id="<?php echo $result['id']?>" data-bs-toggle="modal" data-bs-target="#viewModal">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="btn btn-warning w-100 mb-2 edit_button" data-id="<?php echo $result['id']?>" data-bs-toggle="modal" data-bs-target="#editModal">
                                                                <i class="fa fa-pen-square"></i>
                                                                Edit
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="btn btn-danger w-100 edit_button" data-id="<?php echo $result['id']?>" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                                <i class="fa fa-trash"></i>
                                                                Delete
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php }?>
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
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">Add New Student</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_student/store">
                        <div class="modal-body">
                            <div class="row gap-3">
                                <div class="col-12 d-flex justify-content-center">
                                    <img class="img-thumbnail" src="<?php echo BOOTSTRAP; ?>/images/profile.png" alt="Student Image" id="image_profile" style="width: 320px; height: 270px;">
                                </div>
                            </div>
                            <div class="row mt-3 gap-3 gap-md-0">
                                <div class="col-12 col-md-6 input-group">
                                    <input class="form-control" type="file" id="image_file" name="image_file" required>
                                    <input class="form-control" type="text" id="image_file_name" name="image_file_name" readonly hidden>
                                </div>
                                <div class="col-12 col-md-6 input-group">
                                    <span class="input-group-text">
                                        Grade:
                                    </span>
                                    <select class="form-control" name="grade" id="grade" required>
                                        <option value="" selected disabled>Please select grade & section.</option>
                                        <?php 
                                            foreach($data2 as $result) { 
                                                if($result['status'] == 1)
                                                {
                                                    echo '<option value="'.$result['id'].'">'.'Grade '.$result['grade'].' ( '.$result['section'].' )'.'</option>';
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3 gap-3 gap-md-0 d-none" id="div_subject_list">
                                <h6 class="text-center text-decoration-underline"><span id="grade_subjects"></span> Subjects</h6>
                                <div class="col-12 d-flex flex-column flex-md-row flex-md-wrap justify-content-md-center align-items-md-center gap-4" id="subject_list">
                                </div>
                            </div>
                            <div class="row mt-3 gap-3 gap-md-0">
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Firstname:
                                    </span>
                                    <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Please enter firstname." required>
                                </div>
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Middlename:
                                    </span>
                                    <input class="form-control" type="text" name="middlename" id="middlename" placeholder="Please enter middlename." required>
                                </div>
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Lastname:
                                    </span>
                                    <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Please enter lastname." required>
                                </div>
                            </div>
                            <div class="row mt-3 gap-3 gap-md-0">
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Gender:
                                    </span>
                                    <select class="form-control" name="gender" id="gender" required>
                                        <option value="" selected disabled>Please select gender.</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Birthdate:
                                    </span>
                                    <input class="form-control" type="date" name="birthdate" id="birthdate" required>
                                </div>
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Phonenumber:
                                    </span>
                                    <input class="form-control" type="text" name="phonenumber" id="phonenumber" placeholder="Please enter phonenumber." required>
                                </div>
                            </div>
                            <div class="row mt-3 gap-3 gap-md-0">
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Province:
                                    </span>
                                    <input class="form-control" type="text" name="province" id="province" placeholder="Please enter province." required>
                                </div>
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Municipality:
                                    </span>
                                    <input class="form-control" type="text" name="municipality" id="municipality" placeholder="Please enter municipality." required>
                                </div>
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Village/Street:
                                    </span>
                                    <input class="form-control" type="text" name="village_street" id="village_street" placeholder="Please enter village/street." required>
                                </div>
                            </div>
                            <div class="row mt-3 gap-3 gap-md-0">
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Username:
                                    </span>
                                    <input class="form-control" type="text" name="username" id="username" placeholder="Please enter username." required>
                                </div>
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Password:
                                    </span>
                                    <input class="form-control" type="password" name="password" id="password" placeholder="Please enter password." required>
                                </div>
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Confirm password:
                                    </span>
                                    <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="Please enter confirm password." required>
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

        <!-- View Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h1 class="modal-title fs-5" id="viewModalLabel">View Student</h1>
                    </div>
                    <div class="modal-body">
                        <div class="row gap-3">
                            <div class="col-12 d-flex justify-content-center">
                                <img class="img-thumbnail" src="<?php echo BOOTSTRAP; ?>/images/profile.png" id="v_profile_image" alt="Student Image" style="width: 320px; height: 270px;">
                            </div>
                        </div>
                        <div class="row mt-3 gap-3 gap-md-0 text-center">
                            <p><b class="me-2">Fullname: </b><span id="v_fullname"></span></p>
                            <p><b class="me-2">Grade and Section: </b><span id="v_grade"></span></p>
                            <p><b class="me-2">Gender: </b><span id="v_gender"></span></p>
                            <p><b class="me-2">Birthdate: </b><span id="v_bday"></span></p>
                            <p><b class="me-2">Phonenumber: </b><span id="v_phonenumber"></span></p>
                            <p><b class="me-2">Address: </b><span id="v_address"></span></p>
                            <p><b class="me-2">Subjects: </b><span id="v_subjects"></span></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Student</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_student/update">
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <div class="row gap-3">
                                <div class="col-12 d-flex justify-content-center">
                                    <img class="img-thumbnail" src="<?php echo BOOTSTRAP; ?>/images/profile.png" alt="Student Image" id="e_image_profile" style="width: 320px; height: 270px;">
                                </div>
                            </div>
                            <div class="row mt-3 gap-3 gap-md-0">
                                <div class="col-12 col-md-6 input-group">
                                    <input class="form-control" type="file" id="e_image_file" name="e_image_file">
                                    <input class="form-control" type="text" id="e_image_file_name" name="e_image_file_name" readonly hidden>
                                </div>
                                <div class="col-12 col-md-6 input-group">
                                    <span class="input-group-text">
                                        Grade:
                                    </span>
                                    <select class="form-control" name="e_grade" id="e_grade" required>
                                        <?php 
                                            foreach($data2 as $result) { 
                                                if($result['status'] == 1)
                                                {
                                                    echo '<option value="'.$result['id'].'">'.'Grade '.$result['grade'].' ( '.$result['section'].' )'.'</option>';
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3 gap-3 gap-md-0 d-none" id="e_div_subject_list">
                                <h6 class="text-center text-decoration-underline"><span id="e_grade_subjects"></span> Subjects</h6>
                                <div class="col-12 d-flex flex-column flex-md-row flex-md-wrap justify-content-md-center align-items-md-center gap-4" id="e_subject_list">
                                </div>
                            </div>
                            <div class="row mt-3 gap-3 gap-md-0">
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Firstname:
                                    </span>
                                    <input class="form-control" type="text" name="e_firstname" id="e_firstname" placeholder="Please enter firstname." required>
                                </div>
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Middlename:
                                    </span>
                                    <input class="form-control" type="text" name="e_middlename" id="e_middlename" placeholder="Please enter middlename." required>
                                </div>
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Lastname:
                                    </span>
                                    <input class="form-control" type="text" name="e_lastname" id="e_lastname" placeholder="Please enter lastname." required>
                                </div>
                            </div>
                            <div class="row mt-3 gap-3 gap-md-0">
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Gender:
                                    </span>
                                    <select class="form-control" name="e_gender" id="e_gender" required>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Birthdate:
                                    </span>
                                    <input class="form-control" type="date" name="e_birthdate" id="e_birthdate" required>
                                </div>
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Phonenumber:
                                    </span>
                                    <input class="form-control" type="text" name="e_phonenumber" id="e_phonenumber" placeholder="Please enter phonenumber." required>
                                </div>
                            </div>
                            <div class="row mt-3 gap-3 gap-md-0">
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Province:
                                    </span>
                                    <input class="form-control" type="text" name="e_province" id="e_province" placeholder="Please enter province." required>
                                </div>
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Municipality:
                                    </span>
                                    <input class="form-control" type="text" name="e_municipality" id="e_municipality" placeholder="Please enter municipality." required>
                                </div>
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Village/Street:
                                    </span>
                                    <input class="form-control" type="text" name="e_village_street" id="e_village_street" placeholder="Please enter village/street." required>
                                </div>
                            </div>
                            <div class="row mt-3 gap-3 gap-md-0">
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Username:
                                    </span>
                                    <input class="form-control" type="text" name="e_username" id="e_username" placeholder="Please enter username." readonly required>
                                </div>
                                <div class="col-12 col-md-4 input-group">
                                    <input class="form-control" type="password" name="e_password_old" id="e_password_old" readonly hidden>
                                    <span class="input-group-text" style="width: 42%;">
                                        Password:
                                    </span>
                                    <input class="form-control" type="password" name="e_password" id="e_password" placeholder="Please enter password." required>
                                    <button type="button" class="input-group-text btn btn-secondary" id="e_password_button">
                                        <i class="fa fa-pen-square"></i>
                                    </button>
                                    <button type="button" class="input-group-text btn btn-secondary d-none" id="e_password_cancel">
                                        <i class="fa fa-ban"></i>
                                    </button>
                                </div>
                                <div class="col-12 col-md-4 input-group">
                                    <span class="input-group-text" style="width: 42%;">
                                        Confirm password:
                                    </span>
                                    <input class="form-control" type="password" name="e_confirm_password" id="e_confirm_password" placeholder="Please enter confirm password." required>
                                    <button type="button" class="input-group-text btn btn-secondary" id="e_confirm_password_button">
                                        <i class="fa fa-pen-square"></i>
                                    </button>
                                    <button type="button" class="input-group-text btn btn-secondary d-none" id="e_confirm_password_cancel">
                                        <i class="fa fa-ban"></i>
                                    </button>
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
                        <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Student</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_student/delete">
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <p>Are you sure you want to delete this student?</p>
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
            const sidebarName = document.querySelectorAll(".manage_student");
            sidebarName.forEach((node) => {
                node.classList.add("active")
            });
            let pass = '';

            const disabledFields = () => {
                $('#image_file').attr('disabled', true);
                $('#grade').attr('disabled', true);
                $('#gender').attr('disabled', true);
                $('#firstname').attr('disabled', true);
                $('#middlename').attr('disabled', true);
                $('#lastname').attr('disabled', true);
                $('#birthdate').attr('disabled', true);
                $('#phonenumber').attr('disabled', true);
                $('#province').attr('disabled', true);
                $('#municipality').attr('disabled', true);
                $('#village_street').attr('disabled', true);
                $('#username').attr('disabled', true);
                $('#password').attr('disabled', true);
                $('#confirm_password').attr('disabled', true);
            }
            
            const clearFields = () => {
                $('#image_profile').attr('src', '<?php echo BOOTSTRAP; ?>/images/profile.png');
                $('#image_file').val("");
                $('#image_file_name').val("");
                $('#grade').val("");
                $('#gender').val("");
                $('#firstname').val("");
                $('#middlename').val("");
                $('#lastname').val("");
                $('#birthdate').val("");
                $('#phonenumber').val("");
                $('#province').val("");
                $('#municipality').val("");
                $('#village_street').val("");
                $('#username').val("");
                $('#password').val("");
                $('#confirm_password').val("");
                $("#div_subject_list").addClass("d-none");
            }
            
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500
            });

            // jQuery
            $('.postForm').on('submit', function(e){
                e.preventDefault();
                $("#image_file").prop("disabled", true);
                $("#e_image_file").prop("disabled", true);
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
                                    disabledFields();
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
                const path = '<?php echo ROOT; ?>manage_student/edit';
                const id = $(this).attr('data-id');
                $.ajax({
                    type     : "POST",
                    cache    : false,
                    url      : path,
                    data     : {id:id},
                    success  : function(data) {

                        // console.log(data);
                        const json = JSON.parse(data);
                        let arrSubjects = {};

                        <?php 
                            foreach($data4 as $result) {
                        ?>
                            arrSubjects['<?php echo $result['id']; ?>'] = '<?php echo $result['subject']; ?>';
                        <?php
                            }
                        ?>

                        const subjects = json['subjects'].split(',');
                        let subject_list = '';
                        for (const iterator of subjects) {
                            if (iterator in arrSubjects) {
                                subject_list+=arrSubjects[iterator]+', ';
                            }
                        }

                        // console.log(json['grade_id']);
                        // View Modal
                        $('.id').val(json['id']);
                        $('#v_profile_image').attr("src", json['image_path']);
                        $('#v_fullname').text(json['fname'] + ' ' + json['mname'] + ' ' + json['lname']);
                        $('#v_grade').text('Gr. '+json['grade']+' ( '+json['section']+' )');
                        $('#v_gender').text(json['gender'] > 0 ? 'Male' : 'Female');
                        $('#v_bday').text(json['birthdate_format']);
                        $('#v_phonenumber').text(json['phonenumber']);
                        $('#v_address').text(json['village_street'] +' '+ json['municipality'] +', '+ json['province']);
                        $('#v_subjects').text(subject_list);

                        // Edit Modal
                        $('#e_image_profile').attr("src", json['image_path']);
                        $('#e_image_file_name').val(json['image_path']);
                        $('#e_grade').val(json['section_id']);
                        $('#e_firstname').val(json['fname']);
                        $('#e_middlename').val(json['mname']);
                        $('#e_lastname').val(json['lname']);
                        $('#e_gender').val(json['gender']);
                        $('#e_birthdate').val(json['birthdate']);
                        $('#e_phonenumber').val(json['phonenumber']);
                        $('#e_province').val(json['province']);
                        $('#e_municipality').val(json['municipality']);
                        $('#e_village_street').val(json['village_street']);
                        $('#e_username').val(json['username']);
                        $('#e_password_old').val(json['password']);
                        $('#e_password').val(json['password']);
                        $('#e_confirm_password').val(json['password']);
                        pass = json['password'];

                        editModalSubjects();
                        
                    }
                });
            });

            $("#addModal").on("hidden.bs.modal", function(event) {
                clearFields();
            });

            const addEventForAddModal = () => {
                $("#image_file").on('change', () => {
                    const formData = new FormData();
                    formData.append('file', image_file.files[0]);
                    formData.append('usertype', 1);

                    $.ajax({
                        type     : "POST",
                        dataType : "TEXT",
                        cache    : false,
                        contentType: false,
                        processData: false,
                        url      : "<?php echo ROOT."upload_image";?>",
                        data     : formData,
                        success  : function(data) {
                            const json = JSON.parse(data);

                            switch(json['response']) {
                                case '1':
                                    $("#image_profile").attr("src", json['message']);
                                    $("#image_file_name").val(json['message']);
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

                $("#grade").on('change', () => {
                    if($("#grade").val() > 0) 
                    {
                        const path = '<?php echo ROOT; ?>manage_student/show_subjects';
                        const section_id = $('#grade').val();
                        $.ajax({
                            type     : "POST",
                            cache    : false,
                            url      : path,
                            data     : {section_id:section_id},
                            success  : function(data) {
                                
                                const json = JSON.parse(data);

                                switch(json['response']) {
                                    case '1':

                                        $("#div_subject_list").removeClass("d-none");
                                        let checkList = '';
                                            for (let i = 0; i < json['message'].length; i++) {
                                                const element = json['message'][i];
                                                checkList += '<div class="form-check"><input class="form-check-input" type="checkbox" value="'+element['id']+'" name="check_list[]" id="check_'+element['id']+'" checked><label class="form-check-label" for="check_'+element['id']+'">'+element['subject']+'</label></div>';
                                                $('#grade_subjects').text('Grade '+element['grade']+'( '+element['section']+' )');
                                            }
                                        $("#subject_list").html(checkList);

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
                    }
                    else
                    {
                        $("#div_subject_list").addClass("d-none");
                    }
                });
            }

            const addEventForEditModal = () => {
                $("#e_image_file").on('change', () => {
                    const formData = new FormData();
                    formData.append('file', e_image_file.files[0]);
                    formData.append('usertype', 1);

                    $.ajax({
                        type     : "POST",
                        dataType : "TEXT",
                        cache    : false,
                        contentType: false,
                        processData: false,
                        url      : "<?php echo ROOT."upload_image";?>",
                        data     : formData,
                        success  : function(data) {
                            const json = JSON.parse(data);

                            switch(json['response']) {
                                case '1':
                                    $("#e_image_profile").attr("src", json['message']);
                                    $("#e_image_file_name").val(json['message']);
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
                $("#e_grade").on('change', () => {
                    if($("#e_grade").val() > 0) 
                    {
                        editModalSubjects();
                    }
                    else
                    {
                        $("#e_div_subject_list").addClass("d-none");
                    }
                });

                $('#e_password_button').on('click', () => {
                    $('#e_password').val("");
                    $('#e_confirm_password').val("");
                    $('#e_password_button').addClass('d-none');
                    $('#e_confirm_password_button').addClass('d-none');
                    $('#e_password_cancel').removeClass('d-none');
                    $('#e_confirm_password_cancel').removeClass('d-none');
                });

                $('#e_confirm_password_button').on('click', () => {
                    $('#e_password').val("");
                    $('#e_confirm_password').val("");
                    $('#e_password_button').addClass('d-none');
                    $('#e_confirm_password_button').addClass('d-none');
                    $('#e_password_cancel').removeClass('d-none');
                    $('#e_confirm_password_cancel').removeClass('d-none');
                });

                $('#e_password_cancel').on('click', () => {
                    $('#e_password').val(pass);
                    $('#e_confirm_password').val(pass);
                    $('#e_password_cancel').addClass('d-none');
                    $('#e_confirm_password_cancel').addClass('d-none');
                    $('#e_password_button').removeClass('d-none');
                    $('#e_confirm_password_button').removeClass('d-none');
                });

                $('#e_confirm_password_cancel').on('click', () => {
                    $('#e_password').val(pass);
                    $('#e_confirm_password').val(pass);
                    $('#e_confirm_password_cancel').addClass('d-none');
                    $('#e_password_cancel').addClass('d-none');
                    $('#e_password_button').removeClass('d-none');
                    $('#e_confirm_password_button').removeClass('d-none');
                });
            }

            function editModalSubjects() {
                const path = '<?php echo ROOT; ?>manage_student/show_subjects';
                const section_id = $('#e_grade').val();
                $.ajax({
                    type     : "POST",
                    cache    : false,
                    url      : path,
                    data     : {section_id:section_id},
                    success  : function(data) {
                        
                        const json = JSON.parse(data);

                        switch(json['response']) {
                            case '1':

                                $("#e_div_subject_list").removeClass("d-none");
                                let checkList = '';
                                    for (let i = 0; i < json['message'].length; i++) {
                                        const element = json['message'][i];
                                        checkList += '<div class="form-check"><input class="form-check-input" type="checkbox" value="'+element['id']+'" name="e_check_list[]" id="e_check_'+element['id']+'" checked><label class="form-check-label" for="e_check_'+element['id']+'">'+element['subject']+'</label></div>';
                                        $('#e_grade_subjects').text('Grade '+element['grade']+'( '+element['section']+' )');
                                    }
                                $("#e_subject_list").html(checkList);

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
            }

            init();

            function init() {
                addEventForAddModal();
                addEventForEditModal();
            }

        </script>

        <script>
            $(function () {
                $("#table").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false, "ordering": false, "pageLength": 5,
                "buttons": [
                    {
                        extend: 'excel',
                        title: "Student List",
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
                        title: "Student List",
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
                        title: "Student List",
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