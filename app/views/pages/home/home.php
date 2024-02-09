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
                    <div class="row mt-2">
                        <div class="col-12 col-md-4">
                            <div class="card text-white">
                                <div class="card-body" style="background-color: #14213D;">
                                    TOTAL OF STUDENTS
                                    <span class="border border-white float-end p-2"><?php echo $data2['total_student']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card text-white">
                                <div class="card-body" style="background-color: #14213D;">
                                    TOTAL OF TEACHERS
                                    <span class="border border-white float-end p-2"><?php echo $data3['total_teacher']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card text-white">
                                <div class="card-body" style="background-color: #14213D;">
                                    TOTAL OF ADVISORY
                                    <span class="border border-white float-end p-2"><?php echo $data4['total_adviser']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card text-white">
                                <div class="card-body"  style="background-color: #14213D;">
                                    TOTAL OF CLEARED STUDENTS
                                    <span class="border border-white float-end p-2"><?php echo $data6['total']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card text-white">
                                <div class="card-body" style="background-color: #14213D;">
                                    TOTAL OF NOT CLEARED STUDENTS
                                    <span class="border border-white float-end p-2"><?php echo $data5['total']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Enrollees</h3>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <canvas id="barChart" style="min-height: 359px; height: 359px; max-height: 359px; max-width: 100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
        </div>

        <script>

            const sidebarName = document.querySelectorAll(".home");
            sidebarName.forEach((node) => {
                node.classList.add("active")
            });
            const titleName = "";

            const dataChart = {
                labels  : [
                    <?php foreach($data as $enrollees) { ?>
                    '<?php 
                        $enrollee = array();
                        $enrollees_date = explode("/", $enrollees['school_year']);
                        $i = 0;
                        while ($i < count($enrollees_date)) {
                            $date=date_create($enrollees_date[$i]);
                            array_push($enrollee, date_format($date,"M. d, Y"));
                            $i++;
                        }
                        echo implode(" / ", $enrollee);
                    ?>',
                    <?php } ?>
                ],
                datasets: [
                    {
                        label               : 'Enrollees',
                        backgroundColor     : 'rgb(13,110,253,0.7)',
                        borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius          : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data                : [
                            <?php foreach($data as $enrollees) { ?>
                            <?php echo $enrollees['enrollees']?>,
                            <?php } ?>
                        ]
                    }
                ]
            }
            
            let barChartCanvas = $('#barChart').get(0).getContext('2d');
            let barChartData = $.extend(true, {}, dataChart);
            let temp0 = dataChart.datasets[0];
            barChartData.datasets[0] = temp0;

            let barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                legend: {
                    display: false
                },
                datasetFill             : false
            };

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            });

        </script>

    </main>
<?php include PATH_VIEW."/components/footer.php"; ?>