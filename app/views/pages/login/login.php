<?php include PATH_VIEW."/components/header.php"; ?>
<body style="background-color: #E5E5E5;">
    <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card" style="width: 400px; height: 35%;">
            <div class="card-header text-center bg-primary">
                <h2>Login</h2>
            </div>
            <div class="card-body" style="background-color: #14213D;">
                <form class="frm" method="POST" action="<?php echo ROOT;?>login">
                    <div class="input-group mb-2">
                        <span class="input-group-text">
                            <i class="fa fa-user"></i>
                        </span>
                        <input class="form-control" type="text" name="username" id="username" placeholder="Please enter username" required>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>
                        <input class="form-control" type="password" name="password" id="password" placeholder="Please enter password" required>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-primary w-50">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('.frm').on('submit',function(e){
            e.preventDefault();

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500
            });
            
            $.ajax({
                type     : "POST",
                cache    : false,
                url      : $(this).attr('action'),
                data     : $(this).serialize(),
                success  : function(data) {
                    const json = JSON.parse(data);

                    switch(json['response']) {
                        case '1':
                                Toast.fire({
                                    icon: 'success',
                                    title: '<p class="text-center pt-2 text-bold text-black">' +json['message']+ '</p>'
                                });

                                setTimeout(function() {
                                    // location.reload();
                                    window.location.href = "/PCPGTVSFA/";
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
    </script>
</body>
</html>