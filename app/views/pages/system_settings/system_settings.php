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
                    <div class="row mt-3">
                        <div class="col-12">
                            <h3 class="d-inline">System Settings</h3>
                        </div>
                        <?php foreach($data as $result) { ?>
                        <?php if($result['id']  == '3') { ?>
                            <div class="col-6 mt-2 mt-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="d-inline"><?php echo $result['setting']; ?></h3>
                                        <button class="btn btn-warning float-end edit_button" data-id="<?php echo $result['id']; ?>" data-bs-toggle="modal" data-bs-target="#editModal">
                                            <i class="fa fa-pen-square"></i>
                                            Edit
                                        </button>
                                    </div>
                                    <div class="card-body text-center">
                                        <?php echo $result['description']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php continue;} ?>
                        <?php if($result['id']  == '4') { ?>
                            <div class="col-6 mt-2 mt-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="d-inline"><?php echo $result['setting']; ?></h3>
                                        <button class="btn btn-warning float-end edit_button" data-id="<?php echo $result['id']; ?>" data-bs-toggle="modal" data-bs-target="#infoModal">
                                            <i class="fa fa-pen-square"></i>
                                            Edit
                                        </button>
                                    </div>
                                    <div class="card-body text-center">
                                        <?php
                                            $arr_description = explode("/", $result['description']);
                                            $description = array();
                                            $i = 0;
                                            while ($i < count($arr_description)) {
                                                $date=date_create($arr_description[$i]);
                                                array_push($description, date_format($date,"M. d, Y"));
                                                $i++;
                                            }
                                            echo implode(" - ", $description); 
                                         ?>
                                    </div>
                                </div>
                            </div>
                        <?php continue;} ?>
                            <div class="col-12 mt-2 mt-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="d-inline"><?php echo $result['setting']; ?></h3>
                                        <button class="btn btn-warning float-end edit_button" data-id="<?php echo $result['id']; ?>" data-bs-toggle="modal" data-bs-target="#editModal">
                                            <i class="fa fa-pen-square"></i>
                                            Edit
                                        </button>
                                    </div>
                                    <div class="card-body text-center">
                                        <?php echo $result['description']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit System Settings</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>system_settings/update">
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <h4><span class="edit_title"></span>:</h4>
                            <textarea class="form-control" name="description" id="description" rows="6"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Modal -->
        <div class="modal fade" id="infoModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="infoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h1 class="modal-title fs-5" id="infoModalLabel">School Year</h1>
                    </div>
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <p>Are you sure you want to change <b>current school year?</b> This will reset registered student in <b>manage student page</b> and the <b>assign subjects</b> for the teachers.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editYearModal">Yes</button>
                        </div>
                </div>
            </div>
        </div>
        
        <!-- Edit Year Modal -->
        <div class="modal fade" id="editYearModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="editYearModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h1 class="modal-title fs-5" id="editYearModalLabel">Edit System Settings</h1>
                    </div>
                    <form class="postForm" method="POST" action="<?php echo ROOT;?>system_settings/update_school_year">
                        <div class="modal-body">
                            <input class="form-control id" type="text" name="id" readonly hidden>
                            <input class="form-control old_description" type="text" name="old_description" readonly hidden>
                            <input class="form-control old_from" type="text" name="old_from" readonly hidden>
                            <h4><span class="edit_title"></span>:</h4>
                            <div class="input-group mb-2">
                                <span class="input-group-text w-25">From:</span>
                                <input class="form-control" type="date" name="from" id="from">
                            </div>
                            <div class="input-group">
                                <span class="input-group-text w-25">To:</span>
                                <input class="form-control" type="date" name="to" id="to">
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
            const sidebarName = document.querySelectorAll(".system_settings");
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

                        console.log(data);

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
                const path = '<?php echo ROOT; ?>system_settings/edit';
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
                        $('.edit_title').text(json['setting']);
                        $('#description').val(json['description']);
                        $('.old_description').val(json['description']);

                        const description = json['description'].split("/");
                        $('#from').val(description[0]);
                        $('#to').val(description[1]);
                        $('.old_from').val(description[0]);
                        
                    }
                });
            });

        </script>
    </main>
<?php include PATH_VIEW."/components/footer.php"; ?>