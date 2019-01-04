<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/toastr.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
    <title>Appointments</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <a style="color:green;" class="navbar-brand" href="/index.php">Appoint.me</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>            
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="form-inline my-2 my-lg-0" id="login_form">
                <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                <input class="form-control mr-sm-2" type="text" placeholder="Username" id="uname" name="username" required>
                <input class="form-control mr-sm-2" type="password" placeholder="Password" id="pass" name="password" required>
                <button class="btn btn-outline-success my-2 my-sm-0">Login</button>                
            </form>
            <button class="btn btn-outline-primary my-2 my-sm-0 ml-2" onclick="javascript: window.location='/signup'">Signup</button>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-10">
                <div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <h1 class="display-3">Appointment Management System</h1>
                        <p class="lead">Create and manage personal and group events</p>
                        <hr class="my-2">
                        <p>Sample lang muna mga ser</p>
                        <p class="lead">
                            <a class="btn btn-primary btn-lg text-light" role="button">Learn Moar</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    $( "#login_form" ).on( "submit", e => {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/login",
            data: {
                _token: $( "#token" ).val(),
                username: $('#uname').val(),
                password: $('#pass').val()    
            }, 
            success: function (response) {
                response = JSON.parse( response )
                if(response.success == 1 ){
                    window.location = "/dash";
                } else{
                    toastr.warning('Wrong username or password');      
                }
            }
        });
    })
    
</script>