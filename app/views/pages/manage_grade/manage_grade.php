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
                                <h3 class="d-inline">Grade List</h3>
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
                                                    <th>Grade</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $counter = 1; foreach($data as $result) { ?>
                                                    <tr>
                                                        <td><?php echo $counter++; ?></td>
                                                        <td>
                                                            <?php echo $result['grade']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $result['description']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $result['status'] == 1 ? 'Active':'Inactive';?>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Action
                                                                </button>
                                                                <ul class="dropdown-menu p-2">
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
                                                                                    echo '<i class="fa fa-xmark-square"></i>
                                                                                    Disable';
                                                                                }
                                                                                else
                                                                                {
                                                                                    echo '<i class="fa fa-check-square"></i>
                                                                                    Enable';
                                                                                }
                                                                             ?>
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
                        <h1 class="modal-title fs-5" id="addModalLabel">Add New Grade</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_grade/store">
                        <div class="modal-body">
                            <div class="row gap-3 mt-3">
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text w-25">
                                            Grade:
                                        </span>
                                        <input class="form-control" type="number" name="grade" id="grade" placeholder="Please enter grade." required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text w-25">
                                            Description:
                                        </span>
                                        <input class="form-control" type="text" name="description" id="description" placeholder="( Optional ) Please enter description.">
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
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Grade</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_grade/update">
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <div class="row gap-3 mt-3">
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text w-25">
                                            Grade:
                                        </span>
                                        <input class="form-control" type="number" name="e_grade" id="e_grade" placeholder="Please enter grade." required readonly>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text w-25">
                                            Description:
                                        </span>
                                        <input class="form-control" type="text" name="e_description" id="e_description" placeholder="( Optional ) Please enter description." required>
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
                        <h1 class="modal-title fs-5" id="deleteModalLabel">Edit Grade Status</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>manage_grade/delete">
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <input class="form-control" type="text" name="status" id="status" readonly hidden>
                            <p>Are you sure you want to delete this grade?</p>
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
            const collapseGradeSectionSubjects = document.querySelectorAll("#collapseGradeSectionSubjects");
            collapseGradeSectionSubjects.forEach((node) => {
                node.classList.add("show")
            });
            const sidebarName = document.querySelectorAll(".manage_grade");
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
                const path = '<?php echo ROOT; ?>manage_grade/edit';
                const id = $(this).attr('data-id');
                $.ajax({
                    type     : "POST",
                    cache    : false,
                    url      : path,
                    data     : {id:id},
                    success  : function(data) {

                        const json = JSON.parse(data);
                        $('.id').val(json['id']);
                        $('#e_grade').val(json['grade']);
                        $('#e_description').val(json['description']);
                        $('#status').val(json['status']);
                    }
                });
            });

            $("#addModal").on("hidden.bs.modal", function(event) {
                $('#grade').val("");
                $('#description').val("");
            });

        </script>

        <script>
            $(function () {
                $("#table").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false, "ordering": false, "pageLength": 5,
                "buttons": [
                    {
                        extend: 'excel',
                        title: "Grade List",
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
                        title: "Grade List",
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
                        title: "Grade List",
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