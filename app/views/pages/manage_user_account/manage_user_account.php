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
                            <h3 class="d-inline">User Account List</h3>
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
                                        <th>Role</th>
                                        <th>Username</th>
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
                                            <td>
                                            <?php
                                                    $arr_multi_role = explode(",", $result['multi_role']);
                                                    foreach ($data2 as $role) {
                                                        if(in_array($role['id'], $arr_multi_role))
                                                        {
                                                            echo $role['role'].', ';
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $arr_multi_role = explode(",", $result['multi_role']);
                                                    $roles = '';
                                                    foreach ($data2 as $role) {
                                                        if($role['id'] == '1' && in_array($role['id'], $arr_multi_role) || $role['id'] > '5' && in_array($role['id'], $arr_multi_role))
                                                        {
                                                            $roles = $role['role'].', ';
                                                        }
                                                    }
                                                    echo empty($roles) ? 'No Role' : $roles;
                                                ?>
                                            </td>
                                            <td><?php echo $result['username']; ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                    </button>
                                                    <ul class="dropdown-menu p-2">
                                                        <li>
                                                            <button class="btn btn-warning w-100 edit_button" data-id="<?php echo $result['id']; ?>" data-bs-toggle="modal" data-bs-target="#editModal">
                                                                <i class="fa fa-pen-square"></i>
                                                                Edit Role
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

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit User Role</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_user_account/update">
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <div class="col-12">
                                <div class="input-group">
                                    <span class="input-group-text w-25">
                                        Role:
                                    </span>
                                    <select class="form-control" name="role" id="role" require>
                                        <option value="" selected disabled>Please select role.</option>
                                        <?php 
                                            foreach($data2 as $result) { 
                                                if($result['id'] == '1' || $result['id'] > '5')
                                                {
                                                    echo '<option value="'.$result['id'].'">'.$result['role'].'</option>';
                                                }
                                            }
                                        ?>
                                        <option value="remove">Remove Role</option>
                                    </select>
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
            const sidebarName = document.querySelectorAll(".manage_user_account");
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
                const path = '<?php echo ROOT; ?>manage_user_account/edit';
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
                        
                    }
                });
            });

        </script>

        <script>
            $(function () {
                $("#table").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false, "ordering": true, "pageLength": 5,
                "buttons": [
                    {
                        extend: 'excel',
                        title: "User Account List",
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
                        title: "User Account List",
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
                        title: "User Account List",
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