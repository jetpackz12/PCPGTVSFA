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
                            <h3 class="d-inline">Assignee List</h3>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row gap-2">
                                        <form class="col-12 postForm" method="POST" action="<?php echo ROOT; ?>manage_assignee/filter">
                                            <div class="input-group">
                                                <span class="w-auto input-group-text font-weight-bold">
                                                    Filter subject:
                                                </span>
                                                <select class="form-control" name="filter_subject" id="filter_subject" require>
                                                    <option value="" disabled selected>Please select subject</option>
                                                    <?php
                                                    foreach ($data2 as $subject) {
                                                        echo "<option value='" . $subject['id'] . "'>" . $subject['subject'] . ' - Grade: ' . $subject['grade'] . ' ( ' . $subject['section'] . " )</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <button type="submit" class="d-none d-md-inline btn btn-primary font-weight-bold w-25 text-center">
                                                    <i class="fa fa-filter"></i>
                                                    Filter
                                                </button>
                                            </div>
                                            <div class="mt-2 d-flex justify-content-center align-items-center">
                                                <button type="submit" class="d-inline d-md-none btn btn-primary font-weight-bold text-center w-50">
                                                    <i class="fa fa-filter"></i>
                                                    Filter
                                                </button>
                                            </div>
                                        </form>
                                        <div class="col-12">
                                            <table id="table" class="table table-bordered table-hover text-center">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Subjects</th>
                                                        <th>Assignee</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $counter = 1;
                                                    foreach ($data4 as $result) { ?>
                                                        <?php
                                                        $arr_subjects = explode(",", $result['subjects']);
                                                        $i = 0;
                                                        $filter_subject_id = $_SESSION['filter_subject_id'] ?? null;

                                                        while ($i < count($arr_subjects)) {

                                                            foreach ($data2 as $subject) {
                                                                if ($subject['id'] == $arr_subjects[$i] && $subject['id'] == $filter_subject_id) {
                                                        ?>
                                                                    <tr>
                                                                        <td><?php echo $counter++; ?></td>
                                                                        <td>
                                                                            <?php
                                                                            echo '
                                                                    <p>' . $subject['subject'] . ' - <b> ( Grade ' . $subject['grade'] . ' ' . $subject['section'] . ' )</b></p>
                                                                ';
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $result['faculty_fullname']; ?></td>
                                                                    </tr>
                                                        <?php
                                                                }
                                                            }
                                                            $i++;
                                                        }
                                                        ?>
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

        <script>
            const collapseFaculty = document.querySelectorAll("#collapseFaculty");
            collapseFaculty.forEach((node) => {
                node.classList.add("show")
            });
            const sidebarName = document.querySelectorAll(".manage_assignee");
            sidebarName.forEach((node) => {
                node.classList.add("active")
            });

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500
            });

            $('.postForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    cache: false,
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function(data) {
                        Toast.fire({
                            icon: 'success',
                            title: '<p class="text-center pt-2 text-black">Filter Success!</p>'
                        });

                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }
                });
            });
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
                            title: "Faculty List",
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
                            title: "Faculty List",
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
                            title: "Faculty List",
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