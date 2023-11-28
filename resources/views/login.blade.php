<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Assesment - Annisa Dinda Gantini">
    <meta name="author" content="Annisa Dinda Gantini">

    <title>Assessment - Annisa Dinda Gantini</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-5">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Pujasera Flamingo</h1>
                                    </div>
                                    <form class="user" method="POST" action="javascript:void(0)" id="formLogin">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="Password" required>
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block" type="submit">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
      $(document).ready(() => {
        $('#formLogin').on('submit',(function(e) {
          e.preventDefault();
          var formData = new FormData(this);
  
          $.ajax({
            method  : 'POST',
            url     : "{{ route('auth.login') }}",
            data    : formData,
            contentType: false,
            processData: false,
            success: function(data, status, xhr) {
              try {
                var result = JSON.parse(xhr.responseText);
                if (result.status == true) {
                  swal({
                    title: "Login Success",
                    icon: "success",
                  }).then((acc) => {
                    window.location.href = "{{ route('dashboard') }}";
                  });
                } else {
                  $("#username").focus();
                  swal({
                    icon: "warning",
                    title: "Warning",
                    text: result.message,
                  });
                }
              } catch (e) {
                $("#username").focus();
                swal({
                  title: "",
                  text: "Sistem error.",
                  icon: "warning"
                });
              }
            },
            error: function(data) {
              $("#username").focus();
              swal({
                title: "Warning !",
                text: "A system error has occurred.",
                icon: "warning"
              });
            }
          });
        }));
      });
    </script>

</body>

</html>