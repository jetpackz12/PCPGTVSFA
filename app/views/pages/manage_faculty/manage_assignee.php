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
                                                while ($i < count($arr_subjects)) {

                                                    foreach ($data2 as $subject) {
                                                        if ($subject['id'] == $arr_subjects[$i]) {
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