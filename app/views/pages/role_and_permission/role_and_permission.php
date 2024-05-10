<?php include PATH_VIEW . "/components/header.php"; ?>

<body>
    <?php include PATH_VIEW . "/components/navbar.php"; ?>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="d-none d-md-block col-md-3 col-xl-2 sidebar" style="height: 92vh;">
                    <?php include PATH_VIEW . "/components/sidebar.php"; ?>
                </div>
                <div class="col-12 col-md-9 col-xl-10">
                    <div class="row mt-3 gap-3">
                        <div class="col-12">
                            <h3 class="d-inline">Role <span class="d-none d-md-inline">And Permission</span> List</h3>
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
                                                <th>Roles</th>
                                                <th>Permission</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $counter = 1;
                                            foreach ($data as $result) {
                                                if ($result['id'] > '1' && $result['id'] < '6') {
                                                    continue;
                                                }
                                            ?>
                                                <tr>
                                                    <td><?php echo $counter++; ?></td>
                                                    <td>
                                                        <?php echo $result['role']; ?>
                                                    </td>
                                                    <td class="d-flex justify-content-center align-items-center flex-wrap gap-2">
                                                        <p><?php echo $result['permission']; ?></p>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <ul class="dropdown-menu p-2">
                                                                <li>
                                                                    <button class="btn btn-warning w-100 mb-2 edit_button" data-id="<?php echo $result['id']; ?>" data-bs-toggle="modal" data-bs-target="#editModal">
                                                                        <i class="fa fa-pen-square"></i>
                                                                        Edit
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <button class="btn btn-danger w-100 mb-2 edit_button" data-id="<?php echo $result['id']; ?>" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
                        <h1 class="modal-title fs-5" id="addModalLabel">Add New Role And Permission</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT; ?>role_and_permission/store">
                        <div class="modal-body">
                            <div class="row mt-3 gap-3">
                                <div class="col-12 input-group">
                                    <span class="input-group-text w-25">
                                        Role:
                                    </span>
                                    <input class="form-control" type="text" name="role" id="role" placeholder="Please enter role." required>
                                </div>
                                <div class="col-12">
                                    <h6>Please select permissions below.</h6>
                                </div>
                                <div class="col-12 d-flex flex-column gap-3 ps-4">
                                    <div class="form-check">
                                        <input class="form-check-input check" type="checkbox" name="check[]" value="Dashboard" id="check_dashboard" checked>
                                        <label class="form-check-label text-bold" for="check_dashboard">
                                            Dashboard
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input check" type="checkbox" name="check[]" value="Manage Student" id="check_manage_student" checked>
                                        <label class="form-check-label text-bold" for="check_manage_student">
                                            Manage Student
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input check" type="checkbox" name="check[]" value="Manage Advisory And Teacher" id="check_manage_advisory_and_teacher" checked>
                                        <label class="form-check-label text-bold" for="check_manage_advisory_and_teacher">
                                            Manage Advisory And Teacher
                                        </label>
                                    </div>
                                    <div class="d-flex flex-row gap-3 ms-5">
                                        <div class="form-check">
                                            <input class="form-check-input check" type="checkbox" name="check[]" value="Advisory" id="check_advisory" checked>
                                            <label class="form-check-label text-bold" for="check_advisory">
                                                Advisory
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input check" type="checkbox" name="check[]" value="Teacher" id="check_teacher" checked>
                                            <label class="form-check-label text-bold" for="check_teacher">
                                                Teacher
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input check" type="checkbox" name="check[]" value="Manage Faculty" id="check_manage_faculty" checked>
                                        <label class="form-check-label text-bold" for="check_manage_faculty">
                                            Manage Faculty
                                        </label>
                                    </div>
                                    <div class="d-flex flex-row gap-3 ms-5">
                                        <div class="form-check">
                                            <input class="form-check-input check" type="checkbox" name="check[]" value="Assign Subjects" id="check_assign_subjects" checked>
                                            <label class="form-check-label text-bold" for="check_assign_subjects">
                                                Assign Subjects
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input check" type="checkbox" name="check[]" value="Subject Assignee" id="check_subject_assignee" checked>
                                            <label class="form-check-label text-bold" for="check_subject_assignee">
                                                Subject Assignee
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input check" type="checkbox" name="check[]" value="School Treasurer" id="check_cashier" checked>
                                            <label class="form-check-label text-bold" for="check_cashier">
                                                School Treasurer
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input check" type="checkbox" name="check[]" value="Other Signatory" id="other_signatory" checked>
                                            <label class="form-check-label text-bold" for="other_signatory">
                                                Register Other Signatory
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input check" type="checkbox" name="check[]" value="Grade Section And Subjects" id="check_grade_section_and_subjects" checked>
                                        <label class="form-check-label text-bold" for="check_grade_section_and_subjects">
                                            Grade, Section And Subjects
                                        </label>
                                    </div>
                                    <div class="d-flex flex-row gap-3 ms-5">
                                        <div class="form-check">
                                            <input class="form-check-input check" type="checkbox" name="check[]" value="Grade" id="check_grade" checked>
                                            <label class="form-check-label text-bold" for="check_grade">
                                                Grade
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input check" type="checkbox" name="check[]" value="Section" id="check_section" checked>
                                            <label class="form-check-label text-bold" for="check_section">
                                                Section
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input check" type="checkbox" name="check[]" value="Subjects" id="check_subjects" checked>
                                            <label class="form-check-label text-bold" for="check_subjects">
                                                Subjects
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input check" type="checkbox" name="check[]" value="Manage User Account" id="check_manage_user_account" checked>
                                        <label class="form-check-label text-bold" for="check_manage_user_account">
                                            Manage User Account
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input check" type="checkbox" name="check[]" value="Fees Management" id="check_fees_management" checked>
                                        <label class="form-check-label text-bold" for="check_fees_management">
                                            Fees Management
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input check" type="checkbox" name="check[]" value="Role and Permission" id="check_role_and_permission" checked>
                                        <label class="form-check-label text-bold" for="check_role_and_permission">
                                            Role and Permission
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input check" type="checkbox" name="check[]" value="System Settings" id="check_system_settings" checked>
                                        <label class="form-check-label text-bold" for="check_system_settings">
                                            System Settings
                                        </label>
                                    </div>
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
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Advisory</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT; ?>role_and_permission/update">
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <input class="form-control" type="text" name="e_role_old" id="e_role_old" readonly hidden>
                            <div class="row mt-3 gap-3">
                                <div class="col-12 input-group">
                                    <span class="input-group-text w-25">
                                        Role:
                                    </span>
                                    <input class="form-control" type="text" name="e_role" id="e_role" required>
                                </div>
                                <div class="col-12">
                                    <h6>Please select permissions below.</h6>
                                </div>
                                <div class="col-12 d-flex flex-column gap-3 ps-4">
                                    <div class="form-check">
                                        <input class="form-check-input e_check" type="checkbox" name="e_check[]" value="Dashboard" id="e_check_dashboard">
                                        <label class="form-check-label text-bold" for="e_check_dashboard">
                                            Dashboard
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input e_check" type="checkbox" name="e_check[]" value="Manage Student" id="e_check_manage_student">
                                        <label class="form-check-label text-bold" for="e_check_manage_student">
                                            Manage Student
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input e_check" type="checkbox" name="e_check[]" value="Manage Advisory And Teacher" id="e_check_manage_advisory_and_teacher">
                                        <label class="form-check-label text-bold" for="e_check_manage_advisory_and_teacher">
                                            Manage Advisory And Teacher
                                        </label>
                                    </div>
                                    <div class="d-flex flex-row gap-3 ms-5">
                                        <div class="form-check">
                                            <input class="form-check-input e_check" type="checkbox" name="e_check[]" value="Advisory" id="e_check_advisory">
                                            <label class="form-check-label text-bold" for="e_check_advisory">
                                                Advisory
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input e_check" type="checkbox" name="e_check[]" value="Teacher" id="e_check_teacher">
                                            <label class="form-check-label text-bold" for="e_check_teacher">
                                                Teacher
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input e_check" type="checkbox" name="e_check[]" value="Manage Faculty" id="e_check_manage_faculty">
                                        <label class="form-check-label text-bold" for="e_check_manage_faculty">
                                            Manage Faculty
                                        </label>
                                    </div>
                                    <div class="d-flex flex-row gap-3 ms-5">
                                        <div class="form-check">
                                            <input class="form-check-input e_check" type="checkbox" name="e_check[]" value="Assign Subjects" id="e_check_assign_subjects">
                                            <label class="form-check-label text-bold" for="e_check_assign_subjects">
                                                Assign Subjects
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input check" type="checkbox" name="e_check[]" value="Subject Assignee" id="e_check_subject_assignee">
                                            <label class="form-check-label text-bold" for="e_check_subject_assignee">
                                                Subject Assignee
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input e_check" type="checkbox" name="e_check[]" value="School Treasurer" id="e_check_cashier">
                                            <label class="form-check-label text-bold" for="e_check_cashier">
                                                School Treasurer
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input check" type="checkbox" name="e_check[]" value="Other Signatory" id="e_other_signatory">
                                            <label class="form-check-label text-bold" for="e_other_signatory">
                                                Register Other Signatory
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input e_check" type="checkbox" name="e_check[]" value="Grade Section And Subjects" id="e_check_grade_section_and_subjects">
                                        <label class="form-check-label text-bold" for="e_check_grade_section_and_subjects">
                                            Grade, Section And Subjects
                                        </label>
                                    </div>
                                    <div class="d-flex flex-row gap-3 ms-5">
                                        <div class="form-check">
                                            <input class="form-check-input e_check" type="checkbox" name="e_check[]" value="Grade" id="e_check_grade">
                                            <label class="form-check-label text-bold" for="e_check_grade">
                                                Grade
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input e_check" type="checkbox" name="e_check[]" value="Section" id="e_check_section">
                                            <label class="form-check-label text-bold" for="e_check_section">
                                                Section
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input e_check" type="checkbox" name="e_check[]" value="Subjects" id="e_check_subjects">
                                            <label class="form-check-label text-bold" for="e_check_subjects">
                                                Subjects
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input e_check" type="checkbox" name="e_check[]" value="Manage User Account" id="e_check_manage_user_account">
                                        <label class="form-check-label text-bold" for="e_check_manage_user_account">
                                            Manage User Account
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input e_check" type="checkbox" name="e_check[]" value="Fees Management" id="e_check_fees_management">
                                        <label class="form-check-label text-bold" for="e_check_fees_management">
                                            Fees Management
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input e_check" type="checkbox" name="e_check[]" value="Role and Permission" id="e_check_role_and_permission">
                                        <label class="form-check-label text-bold" for="e_check_role_and_permission">
                                            Role and Permission
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input e_check" type="checkbox" name="e_check[]" value="System Settings" id="e_check_system_settings">
                                        <label class="form-check-label text-bold" for="e_check_system_settings">
                                            System Settings
                                        </label>
                                    </div>
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
                        <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Role And Permission</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT; ?>role_and_permission/delete">
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <p>Are you sure you want to delete this role?</p>
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
            const sidebarName = document.querySelectorAll(".role_and_permission");
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
            $('.postForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function(data) {

                        // console.log(data);

                        const json = JSON.parse(data);

                        switch (json['response']) {
                            case '1':
                                Toast.fire({
                                    icon: 'success',
                                    title: '<p class="text-center pt-2 text-black">' + json['message'] + '</p>'
                                });

                                setTimeout(() => {
                                    location.reload();
                                }, 1500);

                                break;
                            default:
                                Toast.fire({
                                    icon: 'error',
                                    title: '<p class="text-center pt-2">' + json['message'] + '</p>'
                                });
                                break;
                        }
                    }
                });
            });

            $('.edit_button').on('click', function() {
                const path = '<?php echo ROOT; ?>role_and_permission/edit';
                const id = $(this).attr('data-id');
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: path,
                    data: {
                        id: id
                    },
                    success: function(data) {

                        // console.log(data);
                        const json = JSON.parse(data);
                        $('.id').val(json['id']);
                        $('#e_role').val(json['role']);
                        $('#e_role_old').val(json['role']);

                        $('#e_check_dashboard').prop('checked', false);
                        $('#e_check_manage_student').prop('checked', false);
                        $('#e_check_manage_advisory_and_teacher').prop('checked', false);
                        $('#e_check_advisory').prop('checked', false);
                        $('#e_check_teacher').prop('checked', false);
                        $('#e_check_manage_faculty').prop('checked', false);
                        $('#e_check_assign_subjects').prop('checked', false);
                        $('#e_check_subject_assignee').prop('checked', false);
                        $('#e_check_cashier').prop('checked', false);
                        $('#e_other_signatory').prop('checked', false);
                        $('#e_check_grade_section_and_subjects').prop('checked', false);
                        $('#e_check_grade').prop('checked', false);
                        $('#e_check_section').prop('checked', false);
                        $('#e_check_subjects').prop('checked', false);
                        $('#e_check_manage_user_account').prop('checked', false);
                        $('#e_check_fees_management').prop('checked', false);
                        $('#e_check_role_and_permission').prop('checked', false);
                        $('#e_check_system_settings').prop('checked', false);

                        const arr_permissions = json['permission'].split(",");
                        let i = 0;
                        while (i < arr_permissions.length) {
                            switch (arr_permissions[i]) {
                                case 'Dashboard':
                                    $('#e_check_dashboard').prop('checked', true);
                                    break;
                                case 'Manage Student':
                                    $('#e_check_manage_student').prop('checked', true);
                                    break;
                                case 'Manage Advisory And Teacher':
                                    $('#e_check_manage_advisory_and_teacher').prop('checked', true);
                                    break;
                                case 'Advisory':
                                    $('#e_check_advisory').prop('checked', true);
                                    break;
                                case 'Teacher':
                                    $('#e_check_teacher').prop('checked', true);
                                    break;
                                case 'Manage Faculty':
                                    $('#e_check_manage_faculty').prop('checked', true);
                                    break;
                                case 'Assign Subjects':
                                    $('#e_check_assign_subjects').prop('checked', true);
                                    break;
                                case 'Subject Assignee':
                                    $('#e_check_subject_assignee').prop('checked', true);
                                    break;
                                case 'School Treasurer':
                                    $('#e_check_cashier').prop('checked', true);
                                    break;
                                case 'Other Signatory':
                                    $('#e_other_signatory').prop('checked', true);
                                    break;
                                case 'Grade Section And Subjects':
                                    $('#e_check_grade_section_and_subjects').prop('checked', true);
                                    break;
                                case 'Grade':
                                    $('#e_check_grade').prop('checked', true);
                                    break;
                                case 'Section':
                                    $('#e_check_section').prop('checked', true);
                                    break;
                                case 'Subjects':
                                    $('#e_check_subjects').prop('checked', true);
                                    break;
                                case 'Manage User Account':
                                    $('#e_check_manage_user_account').prop('checked', true);
                                    break;
                                case 'Fees Management':
                                    $('#e_check_fees_management').prop('checked', true);
                                    break;
                                case 'Role and Permission':
                                    $('#e_check_role_and_permission').prop('checked', true);
                                    break;
                                case 'System Settings':
                                    $('#e_check_system_settings').prop('checked', true);
                                    break;
                            }
                            i++;
                        }

                        if (!$('#e_check_advisory').prop('checked') && !$('#e_check_teacher').is(':checked')) {
                            $('#e_check_advisory').prop('disabled', true);
                            $('#e_check_teacher').prop('disabled', true);
                        }

                        if (!$('#e_check_assign_subjects').is(':checked') && !$('#e_check_subject_assignee').is(':checked') && !$('#e_check_cashier').is(':checked') && !$('#e_other_signatory').is(':checked')) {
                            $('#e_check_assign_subjects').prop('disabled', true);
                            $('#e_check_subject_assignee').prop('disabled', true);
                            $('#e_check_cashier').prop('disabled', true);
                            $('#e_other_signatory').prop('disabled', true);
                        }

                        if (!$('#e_check_grade').is(':checked') && !$('#e_check_section').is(':checked') && !$('#e_check_subjects').is(':checked')) {
                            $('#e_check_grade').prop('disabled', true);
                            $('#e_check_section').prop('disabled', true);
                            $('#e_check_subjects').prop('disabled', true);
                        }

                    }
                });
            });

            $("#addModal").on("hidden.bs.modal", function(event) {
                $('#role').val("");
                $(".check").prop("checked", true);
                $(".check").prop("disabled", false);
            });

            $("#editModal").on("hidden.bs.modal", function(event) {
                $(".e_check").prop("checked", false);
                $('.e_check').prop('disabled', false);
            });

            const addEventForAddModal = () => {
                $('#check_manage_advisory_and_teacher').on("change", () => {
                    if ($('#check_manage_advisory_and_teacher').is(':checked')) {
                        $('#check_advisory').prop('disabled', false);
                        $('#check_teacher').prop('disabled', false);
                        $('#check_advisory').prop('checked', true);
                        $('#check_teacher').prop('checked', true);
                    } else {
                        $('#check_advisory').prop('disabled', true);
                        $('#check_teacher').prop('disabled', true);
                        $('#check_advisory').prop('checked', false);
                        $('#check_teacher').prop('checked', false);
                    }
                });

                $('#check_advisory').on("change", () => {
                    if (!$('#check_advisory').is(':checked') && !$('#check_teacher').is(':checked')) {
                        $('#check_manage_advisory_and_teacher').prop('checked', false);
                        $('#check_advisory').prop('disabled', true);
                        $('#check_teacher').prop('disabled', true);
                    }
                });

                $('#check_teacher').on("change", () => {
                    if (!$('#check_advisory').is(':checked') && !$('#check_teacher').is(':checked')) {
                        $('#check_manage_advisory_and_teacher').prop('checked', false);
                        $('#check_advisory').prop('disabled', true);
                        $('#check_teacher').prop('disabled', true);
                    }
                });

                $('#check_manage_faculty').on("change", () => {
                    if ($('#check_manage_faculty').is(':checked')) {
                        $('#check_assign_subjects').prop('disabled', false);
                        $('#check_cashier').prop('disabled', false);
                        $('#check_assign_subjects').prop('checked', true);
                        $('#check_cashier').prop('checked', true);
                        $('#check_subject_assignee').prop('disabled', false);
                        $('#check_subject_assignee').prop('checked', true);
                        $('#other_signatory').prop('disabled', false);
                        $('#other_signatory').prop('checked', true);
                    } else {
                        $('#check_assign_subjects').prop('disabled', true);
                        $('#check_cashier').prop('disabled', true);
                        $('#check_assign_subjects').prop('checked', false);
                        $('#check_cashier').prop('checked', false);
                        $('#check_subject_assignee').prop('disabled', true);
                        $('#check_subject_assignee').prop('checked', false);
                        $('#other_signatory').prop('disabled', true);
                        $('#other_signatory').prop('checked', false);
                    }
                });

                $('#check_assign_subjects').on("change", () => {
                    if (!$('#check_assign_subjects').is(':checked') && !$('#check_subject_assignee').is(':checked') && !$('#check_cashier').is(':checked') && !$('#other_signatory').is(':checked')) {
                        $('#check_manage_faculty').prop('checked', false);
                        $('#check_assign_subjects').prop('disabled', true);
                        $('#check_subject_assignee').prop('disabled', true);
                        $('#check_cashier').prop('disabled', true);
                        $('#other_signatory').prop('disabled', true);
                    }
                });

                $('#check_subject_assignee').on("change", () => {
                    if (!$('#check_assign_subjects').is(':checked') && !$('#check_subject_assignee').is(':checked') && !$('#check_cashier').is(':checked') && !$('#other_signatory').is(':checked')) {
                        $('#check_manage_faculty').prop('checked', false);
                        $('#check_assign_subjects').prop('disabled', true);
                        $('#check_subject_assignee').prop('disabled', true);
                        $('#check_cashier').prop('disabled', true);
                        $('#other_signatory').prop('disabled', true);
                    }
                });

                $('#check_cashier').on("change", () => {
                    if (!$('#check_assign_subjects').is(':checked') && !$('#check_subject_assignee').is(':checked') && !$('#check_cashier').is(':checked') && !$('#other_signatory').is(':checked')) {
                        $('#check_manage_faculty').prop('checked', false);
                        $('#check_assign_subjects').prop('disabled', true);
                        $('#check_subject_assignee').prop('disabled', true);
                        $('#check_cashier').prop('disabled', true);
                        $('#other_signatory').prop('disabled', true);
                    }
                });

                $('#other_signatory').on("change", () => {
                    if (!$('#check_assign_subjects').is(':checked') && !$('#check_subject_assignee').is(':checked') && !$('#check_cashier').is(':checked') && !$('#other_signatory').is(':checked')) {
                        $('#check_manage_faculty').prop('checked', false);
                        $('#check_assign_subjects').prop('disabled', true);
                        $('#check_subject_assignee').prop('disabled', true);
                        $('#check_cashier').prop('disabled', true);
                        $('#other_signatory').prop('disabled', true);
                    }
                });

                $('#check_grade_section_and_subjects').on("change", () => {
                    if ($('#check_grade_section_and_subjects').is(':checked')) {
                        $('#check_grade').prop('disabled', false);
                        $('#check_section').prop('disabled', false);
                        $('#check_subjects').prop('disabled', false);
                        $('#check_grade').prop('checked', true);
                        $('#check_section').prop('checked', true);
                        $('#check_subjects').prop('checked', true);
                    } else {
                        $('#check_grade').prop('disabled', true);
                        $('#check_section').prop('disabled', true);
                        $('#check_subjects').prop('disabled', true);
                        $('#check_grade').prop('checked', false);
                        $('#check_section').prop('checked', false);
                        $('#check_subjects').prop('checked', false);
                    }
                });

                $('#check_grade').on("change", () => {
                    if (!$('#check_grade').is(':checked') && !$('#check_section').is(':checked') && !$('#check_subjects').is(':checked')) {
                        $('#check_grade_section_and_subjects').prop('checked', false);
                        $('#check_grade').prop('disabled', true);
                        $('#check_section').prop('disabled', true);
                        $('#check_subjects').prop('disabled', true);
                    }
                });

                $('#check_section').on("change", () => {
                    if (!$('#check_grade').is(':checked') && !$('#check_section').is(':checked') && !$('#check_subjects').is(':checked')) {
                        $('#check_grade_section_and_subjects').prop('checked', false);
                        $('#check_grade').prop('disabled', true);
                        $('#check_section').prop('disabled', true);
                        $('#check_subjects').prop('disabled', true);
                    }
                });

                $('#check_subjects').on("change", () => {
                    if (!$('#check_grade').is(':checked') && !$('#check_section').is(':checked') && !$('#check_subjects').is(':checked')) {
                        $('#check_grade_section_and_subjects').prop('checked', false);
                        $('#check_grade').prop('disabled', true);
                        $('#check_section').prop('disabled', true);
                        $('#check_subjects').prop('disabled', true);
                    }
                });
            }

            const addEventForEditModal = () => {

                $('#e_check_manage_advisory_and_teacher').on("change", () => {
                    if ($('#e_check_manage_advisory_and_teacher').is(':checked')) {
                        $('#e_check_advisory').prop('disabled', false);
                        $('#e_check_teacher').prop('disabled', false);
                        $('#e_check_advisory').prop('checked', true);
                        $('#e_check_teacher').prop('checked', true);
                    } else {
                        $('#e_check_advisory').prop('disabled', true);
                        $('#e_check_teacher').prop('disabled', true);
                        $('#e_check_advisory').prop('checked', false);
                        $('#e_check_teacher').prop('checked', false);
                    }
                });

                $('#e_check_advisory').on("change", () => {
                    if (!$('#e_check_advisory').is(':checked') && !$('#e_check_teacher').is(':checked')) {
                        $('#e_check_manage_advisory_and_teacher').prop('checked', false);
                        $('#e_check_advisory').prop('disabled', true);
                        $('#e_check_teacher').prop('disabled', true);
                    }
                });

                $('#e_check_teacher').on("change", () => {
                    if (!$('#e_check_advisory').is(':checked') && !$('#e_check_teacher').is(':checked')) {
                        $('#e_check_manage_advisory_and_teacher').prop('checked', false);
                        $('#e_check_advisory').prop('disabled', true);
                        $('#e_check_teacher').prop('disabled', true);
                    }
                });

                $('#e_check_manage_faculty').on("change", () => {
                    if ($('#e_check_manage_faculty').is(':checked')) {
                        $('#e_check_assign_subjects').prop('disabled', false);
                        $('#e_check_cashier').prop('disabled', false);
                        $('#e_check_assign_subjects').prop('checked', true);
                        $('#e_check_cashier').prop('checked', true);
                        $('#e_check_subject_assignee').prop('disabled', false);
                        $('#e_check_subject_assignee').prop('checked', true);
                        $('#e_other_signatory').prop('disabled', false);
                        $('#e_other_signatory').prop('checked', true);
                    } else {
                        $('#e_check_assign_subjects').prop('disabled', true);
                        $('#e_check_cashier').prop('disabled', true);
                        $('#e_check_assign_subjects').prop('checked', false);
                        $('#e_check_cashier').prop('checked', false);
                        $('#e_check_subject_assignee').prop('disabled', false);
                        $('#e_check_subject_assignee').prop('checked', true);
                        $('#e_other_signatory').prop('disabled', false);
                        $('#e_other_signatory').prop('checked', true);
                    }
                });

                $('#e_check_assign_subjects').on("change", () => {
                    if (!$('#e_check_assign_subjects').is(':checked')  && !$('#e_check_subject_assignee').is(':checked') && !$('#e_check_cashier').is(':checked') && !$('#e_other_signatory').is(':checked')) {
                        $('#e_check_manage_faculty').prop('checked', false);
                        $('#e_check_assign_subjects').prop('disabled', true);
                        $('#e_check_cashier').prop('disabled', true);
                        $('#e_check_subject_assignee').prop('disabled', true);
                        $('#e_other_signatory').prop('disabled', true);
                    }
                });

                $('#e_check_subject_assignee').on("change", () => {
                    if (!$('#e_check_assign_subjects').is(':checked')  && !$('#e_check_subject_assignee').is(':checked') && !$('#e_check_cashier').is(':checked') && !$('#e_other_signatory').is(':checked')) {
                        $('#e_check_manage_faculty').prop('checked', false);
                        $('#e_check_assign_subjects').prop('disabled', true);
                        $('#e_check_cashier').prop('disabled', true);
                        $('#e_check_subject_assignee').prop('disabled', true);
                        $('#e_other_signatory').prop('disabled', true);
                    }
                });

                $('#e_check_cashier').on("change", () => {
                    if (!$('#e_check_assign_subjects').is(':checked')  && !$('#e_check_subject_assignee').is(':checked') && !$('#e_check_cashier').is(':checked') && !$('#e_other_signatory').is(':checked')) {
                        $('#e_check_manage_faculty').prop('checked', false);
                        $('#e_check_assign_subjects').prop('disabled', true);
                        $('#e_check_cashier').prop('disabled', true);
                        $('#e_check_subject_assignee').prop('disabled', true);
                        $('#e_other_signatory').prop('disabled', true);
                    }
                });

                $('#e_check_grade_section_and_subjects').on("change", () => {
                    if ($('#e_check_grade_section_and_subjects').is(':checked')) {
                        $('#e_check_grade').prop('disabled', false);
                        $('#e_check_section').prop('disabled', false);
                        $('#e_check_subjects').prop('disabled', false);
                        $('#e_check_grade').prop('checked', true);
                        $('#e_check_section').prop('checked', true);
                        $('#e_check_subjects').prop('checked', true);
                    } else {
                        $('#e_check_grade').prop('disabled', true);
                        $('#e_check_section').prop('disabled', true);
                        $('#e_check_subjects').prop('disabled', true);
                        $('#e_check_grade').prop('checked', false);
                        $('#e_check_section').prop('checked', false);
                        $('#e_check_subjects').prop('checked', false);
                    }
                });

                $('#e_check_grade').on("change", () => {
                    if (!$('#e_check_grade').is(':checked') && !$('#e_check_section').is(':checked') && !$('#e_check_subjects').is(':checked')) {
                        $('#e_check_grade_section_and_subjects').prop('checked', false);
                        $('#e_check_grade').prop('disabled', true);
                        $('#e_check_section').prop('disabled', true);
                        $('#e_check_subjects').prop('disabled', true);
                    }
                });

                $('#e_check_section').on("change", () => {
                    if (!$('#e_check_grade').is(':checked') && !$('#e_check_section').is(':checked') && !$('#e_check_subjects').is(':checked')) {
                        $('#e_check_grade_section_and_subjects').prop('checked', false);
                        $('#e_check_grade').prop('disabled', true);
                        $('#e_check_section').prop('disabled', true);
                        $('#e_check_subjects').prop('disabled', true);
                    }
                });

                $('#e_check_subjects').on("change", () => {
                    if (!$('#e_check_grade').is(':checked') && !$('#e_check_section').is(':checked') && !$('#e_check_subjects').is(':checked')) {
                        $('#e_check_grade_section_and_subjects').prop('checked', false);
                        $('#e_check_grade').prop('disabled', true);
                        $('#e_check_section').prop('disabled', true);
                        $('#e_check_subjects').prop('disabled', true);
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
            $(function() {
                $("#table").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "ordering": false,
                    "pageLength": 5,
                    "buttons": [{
                            extend: 'excel',
                            title: "Role And Permission List",
                            exportOptions: {
                                columns: ':visible'
                            },
                            customize: function(xlsx) {
                                const sheet = xlsx.xl.worksheets['sheet1.xml'];
                                $('row c', sheet).each(function() {
                                    $(this).attr('s', '51');
                                });
                            }
                        },
                        {
                            extend: 'pdf',
                            title: "Role And Permission List",
                            exportOptions: {
                                columns: ':visible'
                            },
                            customize: function(doc) {
                                doc.defaultStyle.alignment = 'center';
                                doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                            }
                        },
                        {
                            extend: 'print',
                            title: "Role And Permission List",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                            }
                        }, "colvis"
                    ]
                }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
            });
        </script>
    </main>
    <?php include PATH_VIEW . "/components/footer.php"; ?>