<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('js/jquery-3.3.1.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/signup.css')}}">
    <title>Signup</title>
</head>
<body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
                <a style="color:green;" class="navbar-brand" href="/index.php">Appoint.me</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>            
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <button class="btn btn-outline-primary my-2 my-sm-0 ml-2" onclick="javascript: window.location='/login'">Login</button>
                </div>
            </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1">

            </div>
            <div class="col-md-11">
                <div><h3 class="mt-3 mb-3 text-light">Signup</h3></div>
                <div>
                    <form method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-row">
                            <div class="form-group col-2">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" placeholder="Username" aria-label="Username" name="username" required>
                            </div>
                            <div class="form-group col-2">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" placeholder="Password" aria-label="Username" name="password" required>
                            </div>
                            <div class="form-group col-3">
                                <label for="E-mail">E-mail</label>
                                <input type="text" class="form-control" placeholder="E-mail" aria-label="Username" name="email" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-3">
                                <label for="fname">Firstname</label>
                                <input type="text" class="form-control" placeholder="First Name" aria-label="Username" name="fname" required>
                            </div>
                            <div class="form-group col-3">
                                <label for="mname">Middlename</label>
                                <input type="text" class="form-control" placeholder="Middle Name" aria-label="Username" name="mname" required>
                            </div>
                            <div class="form-group col-3">
                                <label for="lname">Lastname</label>
                                <input type="text" class="form-control" placeholder="Last Name" aria-label="Username" name="lname" required>
                            </div>
                        </div>
                        <input type="submit" value="Create Account" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>