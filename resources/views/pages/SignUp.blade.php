<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="{{'css/toastr.min.css'}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/toastr.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/signup.css')}}">
    <title>Signup</title>
</head>
<body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
                <a style="color:green;" class="navbar-brand" href="/index.php">Appoint.me</a>            
            </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1">

            </div>
            <div class="col-md-11">
                <div><h3 class="mt-3 mb-3 text-light">Signup</h3></div>
                <div>
                    <form id="add_form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-row">
                            <div class="form-group col-2">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" placeholder="Username" aria-label="Username" id="username" name="username" required>
                            </div>
                            <div class="form-group col-2">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" placeholder="Password" aria-label="Username" id="password" name="password" required>
                            </div>
                            <div class="form-group col-2">
                                <label for="password">Facebook ID</label>
                                <input type="text" class="form-control" placeholder="2023423423445681" id="fb_id" name="fb_id" required maxlength="16">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-3">
                                <label for="fname">Firstname</label>
                                <input type="text" class="form-control" placeholder="First Name" aria-label="Username" id="fname" name="fname" required>
                            </div>
                            <div class="form-group col-3">
                                <label for="lname">Lastname</label>
                                <input type="text" class="form-control" placeholder="Last Name" aria-label="Username" id="lname" name="lname" required>
                            </div>
                        </div>
                        <input type="submit" value="Create Account" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $( "#add_form" ).ajaxForm({
            url: "/signup",
            type: "POST",
            success: function( res ) {
                res = JSON.parse( res )
                if( res.success == 1 ){
                    toastr.success( "Signup successful" )
                    window.location = '/login'
                }
                else
                    toastr.danger( "Something went wrong" )
            }
        })
    </script>
</body>
</html>