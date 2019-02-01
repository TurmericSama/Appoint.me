<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/nucleo.css')}}">
    <link rel="stylesheet" href="{{asset('css/argon.min.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"> --}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">


    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/argon.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/toastr.min.js')}}"></script>
    <title>Appointments</title>
</head>
<body class="bg-gradient-primary">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                
            </div>
            <div class="col-md-4 mt-6">
                <div class="card card-body align-items-center col-12">
                    <span class="h3 text-green mt-4">Appoint.me</span>
                    <span class="h5 text-default mt-4">Sign in</span>
                    <span id="divider"></span>
                    <div class="row">
                        <form id="login_form">
                        <div class="col-xs-12">
                            <div class="form-group">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token()}}">
                                <input type="text" class="form-control form-control-alternative col" id="username" name="username" placeholder="Username" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="password" class="form-control form-control-alternative" id="password" name="password" placeholder="Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input type="submit" value="Login" class="btn btn-success btn-block mt-3 mb-3">
                    </div>
                </form>
                </div>
            </div>
            <div class="col-md-4">
                
            </div>
        </div>
    </div>
</body>
</html>

<script>
    $( "#login_form" ).ajaxForm({
            url: "/login",
            type: "POST",
            success: function( res ) {
                res = JSON.parse( res )
                if( res.success == 1 ){
                    toastr.success('Login Success');
                    setTimeout(5000, window.location = "/dash");
                }
                else
                    toastr.warning('Something went wrong');
            }
        });
    
</script>