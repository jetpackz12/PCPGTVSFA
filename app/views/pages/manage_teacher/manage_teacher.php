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
                            <h3 class="d-inline">Teacher List</h3>
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
                                        <th>Address</th>
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
                                        <td><?php echo $result['fname'] .' '. $result['mname'] .' '. $result['lname']; ?></td>
                                        <td><?php echo $result['village_street'] .' '. $result['municipality'] .', '. $result['province']?></td>
                                        <td><?php echo $result['status'] == 1 ? 'Active':'Inactive'; ?></td>
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
                                                            <?php 
                                                                if($result['status'] == 1) 
                                                                {
                                                                    echo '<i class="fa fa-user-xmark"></i>
                                                                    Disable';
                                                                }
                                                                else
                                                                {
                                                                    echo '<i class="fa fa-user-check"></i>
                                                                    Enable';
                                                                }
                                                            ?>
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
                        <h1 class="modal-title fs-5" id="addModalLabel">Add New Teacher</h1>
                    </div>
                    <form class="addForm" method="POST" action="<?php echo ROOT;?>manage_teacher/store">
                        <div class="modal-body">
                            <div class="row gap-3 gap-md-0">
                                <div class="col-12 col-md-6 d-flex justify-content-center align-items-center flex-column">
                                    <h4>Picture</h4>
                                    <input class="form-control" type="file" id="image_file" required>
                                    <input class="form-control" type="text" id="image_file_name" name="image_file_name" readonly hidden>
                                    <img class="img-thumbnail" src="<?php echo BOOTSTRAP; ?>/images/profile.png" id="image_profile" alt="Student Image" style="width: 550px; height: 400px;">
                                </div>
                                <div class="col-12 col-md-6 d-flex justify-content-center align-items-center flex-column">
                                    <h4>Signature</h4>
                                    <div class="w-100 d-flex flex-row gap-1">
                                        <button type="button" class="btn btn-warning w-100" id="save">Save</button>
                                        <button type="button" class="btn btn-primary w-100" id="clear">Clear</button>
                                        <button type="button" class="btn btn-primary w-100 d-none" id="cancel">Cancel save signature</button>
                                    </div>
                                    <div class="w-100 h-100" id="div_signature_pad">
                                        <canvas class="border border-1 border-black w-100 h-100" id="signature_pad" width="550" height="400"></canvas>
                                        <input class="form-control" type="text" name="sign_name" id="sign_name" readonly hidden>
                                    </div>
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
                        <h1 class="modal-title fs-5" id="viewModalLabel">View Teacher</h1>
                    </div>
                    <div class="modal-body">
                        <div class="row gap-3">
                            <div class="col-12 d-flex justify-content-center">
                                <img class="img-thumbnail" src="<?php echo BOOTSTRAP; ?>/images/profile.png" id="v_profile_image" alt="Student Image" style="width: 320px; height: 270px;">
                            </div>
                        </div>
                        <div class="row mt-3 gap-3 gap-md-0 text-center">
                            <p><b class="me-2">Fullname: </b><span id="v_fullname"></span></p>
                            <p><b class="me-2">Gender: </b><span id="v_gender"></span></p>
                            <p><b class="me-2">Birthdate: </b><span id="v_bday"></span></p>
                            <p><b class="me-2">Phonenumber: </b><span id="v_phonenumber"></span></p>
                            <p><b class="me-2">Address: </b><span id="v_address"></span></p>
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
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Teacher</h1>
                    </div>
                    <form class="updateForm" method="POST" action="<?php echo ROOT;?>manage_teacher/update">
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <div class="row gap-3 gap-md-0">
                                <div class="col-6 d-flex justify-content-center align-items-center flex-column">
                                    <h4>Picture</h4>
                                    <input class="form-control" type="file" id="e_image_file">
                                    <input class="form-control" type="text" id="e_image_file_name" name="e_image_file_name" readonly hidden>
                                    <img class="img-thumbnail" src="<?php echo BOOTSTRAP; ?>/images/profile.png" id="e_image_profile" alt="Student Image" style="width: 550px; height: 400px;">
                                </div>
                                <div class="col-6 d-flex justify-content-center align-items-center flex-column">
                                        <input class="form-control" type="text" name="e_sign_name" id="e_sign_name" readonly hidden>
                                    <h4>Signature</h4>
                                    <div class="w-100 d-flex flex-row gap-1">
                                        <input class="form-control" type="text" name="save_value" id="save_value" readonly hidden>
                                        <button type="button" class="btn btn-warning w-100 d-none" id="e_save">Save</button>
                                        <button type="button" class="btn btn-primary w-100 d-none" id="e_clear">Clear</button>
                                        <button type="button" class="btn btn-primary w-100" id="e_cancel">Cancel save signature</button>
                                    </div>
                                    <div class="w-100 h-100 d-none" id="e_div_signature_pad">
                                        <canvas class="border border-1 border-black w-100 h-100" id="e_signature_pad" width="550" height="400"></canvas>
                                    </div>
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
                                        <option value="" selected disabled>Please select gender.</option>
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
                        <h1 class="modal-title fs-5" id="deleteModalLabel">Edit Teacher Status</h1>
                    </div>
                    <form class="deleteForm" method="POST" action="<?php echo ROOT;?>manage_teacher/delete">
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <input class="form-control" type="text" name="status" id="status" readonly hidden>
                            <p>Are you sure you want to edit this teacher status?</p>
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
            const collapseAdvisoryTeacher = document.querySelectorAll("#collapseAdvisoryTeacher");
            collapseAdvisoryTeacher.forEach((node) => {
                node.classList.add("show")
            });
            const sidebarName = document.querySelectorAll(".manage_teacher");
            sidebarName.forEach((node) => {
                node.classList.add("active")
            });
            // Add Modal
            const canvas = document.getElementById("signature_pad");

            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(250,250,250)'
            });

            // Edit Modal
            const e_canvas = document.getElementById("e_signature_pad");

            const e_signaturePad = new SignaturePad(e_canvas, {
                backgroundColor: 'rgb(250,250,250)'
            });

            let pass = '';

            const disabledFields = () => {
                $('#image_file').attr('disabled', true);
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
                $('#sign_name').val("");
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
                signaturePad.clear();
                $('#clear').removeClass('d-none');
                $('#save').removeClass('d-none');
                $('#cancel').addClass('d-none');
                $('#div_signature_pad').removeClass('d-none');
                $('#save_value').val("");
                $('#e_clear').addClass('d-none');
                $('#e_save').addClass('d-none');
                $('#e_cancel').removeClass('d-none');
                $('#e_div_signature_pad').addClass('d-none');
            }
            
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500
            });

            // jQuery
            $('.addForm').on('submit', function(e){
                e.preventDefault();

                if(signaturePad.isEmpty())
                {
                    Toast.fire({
                        icon: 'error',
                        title: '<p class="text-center pt-2">Failed, No signature please add one</p>'
                    });
                    return;
                }
                
                if($("#div_signature_pad").is(':visible'))
                {
                    Toast.fire({
                            icon: 'error',
                            title: '<p class="text-center pt-2">Failed, Please save signature</p>'
                        });
                    return;
                }

                $("#image_file").prop("disabled", true);
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

            $('.updateForm').on('submit', function(e){
                e.preventDefault();

                if(e_signaturePad.isEmpty() && $('#save_value').val() != '')
                {
                    Toast.fire({
                        icon: 'error',
                        title: '<p class="text-center pt-2">Failed, No signature please add one</p>'
                    });
                    return;
                }
                
                if($("#e_div_signature_pad").is(':visible'))
                {
                    Toast.fire({
                            icon: 'error',
                            title: '<p class="text-center pt-2">Failed, Please save signature</p>'
                        });
                    return;
                }

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

            $('.deleteForm').on('submit', function(e){
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
                const path = '<?php echo ROOT; ?>manage_teacher/edit';
                const id = $(this).attr('data-id');
                $.ajax({
                    type     : "POST",
                    cache    : false,
                    url      : path,
                    data     : {id:id},
                    success  : function(data) {

                        // console.log(data);
                        const json = JSON.parse(data);
                        
                        // View Modal
                        $('.id').val(json['id']);
                        $('#v_profile_image').attr("src", json['image_path']);
                        $('#v_fullname').text(json['fname'] + ' ' + json['mname'] + ' ' + json['lname']);
                        $('#v_gender').text(json['gender'] > 0 ? 'Male' : 'Female');
                        $('#v_bday').text(json['birthdate_format']);
                        $('#v_phonenumber').text(json['phonenumber']);
                        $('#v_address').text(json['village_street'] +' '+ json['municipality'] +', '+ json['province']);

                        // Edit Modal
                        $('#e_image_profile').attr('src', json['image_path']);
                        $('#e_image_file_name').val(json['image_path']);
                        $('#e_sign_name').val(json['image_name']);
                        $('#e_gender').val(json['gender']);
                        $('#e_firstname').val(json['fname']);
                        $('#e_middlename').val(json['mname']);
                        $('#e_lastname').val(json['lname']);
                        $('#e_birthdate').val(json['birthdate']);
                        $('#e_phonenumber').val(json['phonenumber']);
                        $('#e_province').val(json['province']);
                        $('#e_municipality').val(json['municipality']);
                        $('#e_village_street').val(json['village_street']);
                        $('#e_username').val(json['username']);
                        $('#e_password_old').val(json['password']);
                        $('#e_password').val(json['password']);
                        $('#e_confirm_password').val(json['password']);
                        $('#status').val(json['status']);
                        
                    }
                });
            });

            $("#addModal").on("hidden.bs.modal", function(event) {
                clearFields();
            });

            $("#editModal").on("hidden.bs.modal", function(event) {
                clearFields();
            });

            const addEventForAddModal = () => {

                $('#clear').on('click', () => {
                    signaturePad.clear();
                });

                $('#save').on('click', () => {
                    const signName = $('#sign_name').val();
                    if(signName == '')
                    {
                        Toast.fire({
                            icon: 'error',
                            title: '<p class="text-center pt-2">Failed, Please choose picture.</p>'
                        });
                        return;
                    }

                    if(signaturePad.isEmpty())
                    {
                        Toast.fire({
                            icon: 'error',
                            title: '<p class="text-center pt-2">Failed, No signature please add one</p>'
                        });
                        return;
                    }

                    // Get the data URI of the canvas image
                    const dataURL = canvas.toDataURL();

                    $.ajax({
                        type     : "POST",
                        url      : "<?php echo ROOT."upload_image/signature";?>",
                        data: { 
                            imgBase64: dataURL,
                            signName : signName
                        }
                    }).done(function(o) {
                        $('#clear').addClass('d-none');
                        $('#save').addClass('d-none');
                        $('#cancel').removeClass('d-none');
                        $('#div_signature_pad').addClass('d-none');
                    });
                });

                $('#cancel').on('click', () => {
                    signaturePad.clear();
                    $('#clear').removeClass('d-none');
                    $('#save').removeClass('d-none');
                    $('#cancel').addClass('d-none');
                    $('#div_signature_pad').removeClass('d-none');
                });

                $("#image_file").on('change', () => {
                    const formData = new FormData();
                    formData.append('file', image_file.files[0]);
                    formData.append('usertype', 2);

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
                                    $('#sign_name').val(json['file_name']);
                                    signaturePad.clear();
                                    $('#clear').removeClass('d-none');
                                    $('#save').removeClass('d-none');
                                    $('#cancel').addClass('d-none');
                                    $('#div_signature_pad').removeClass('d-none');
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
            }

            const addEventForEditModal = () => {

                $('#e_clear').on('click', () => {
                    e_signaturePad.clear();
                });

                $('#e_save').on('click', () => {
                    const signName = $('#e_sign_name').val();
                    if(signName == '')
                    {
                        Toast.fire({
                            icon: 'error',
                            title: '<p class="text-center pt-2">Failed, Please choose picture.</p>'
                        });
                        return;
                    }

                    if(e_signaturePad.isEmpty())
                    {
                        Toast.fire({
                            icon: 'error',
                            title: '<p class="text-center pt-2">Failed, No signature please add one</p>'
                        });
                        return;
                    }

                    // Get the data URI of the canvas image
                    const dataURL = e_canvas.toDataURL();

                    $.ajax({
                        type     : "POST",
                        url      : "<?php echo ROOT."upload_image/signature";?>",
                        data: { 
                            imgBase64: dataURL,
                            signName : signName
                        }
                    }).done(function(o) {
                        $('#e_clear').addClass('d-none');
                        $('#e_save').addClass('d-none');
                        $('#e_cancel').removeClass('d-none');
                        $('#e_div_signature_pad').addClass('d-none');
                    });
                });

                $('#e_cancel').on('click', () => {
                    e_signaturePad.clear();
                    $('#save_value').val('cancel');
                    $('#e_clear').removeClass('d-none');
                    $('#e_save').removeClass('d-none');
                    $('#e_cancel').addClass('d-none');
                    $('#e_div_signature_pad').removeClass('d-none');
                });

                $("#e_image_file").on('change', () => {
                    const formData = new FormData();
                    formData.append('file', e_image_file.files[0]);
                    formData.append('usertype', 2);

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
                                    $('#e_sign_name').val(json['file_name']);
                                    e_signaturePad.clear();
                                    $('#save_value').val('cancel');
                                    $('#e_clear').removeClass('d-none');
                                    $('#e_save').removeClass('d-none');
                                    $('#e_cancel').addClass('d-none');
                                    $('#e_div_signature_pad').removeClass('d-none');
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
                })

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
                        title: "Teacher List",
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
                        title: "Teacher List",
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
                        title: "Teacher List",
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