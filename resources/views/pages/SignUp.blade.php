<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/signup.css')}}">
    <title>Signup</title>
    @if( $success == 1 )
        <script>alert( "Signup successful" )</script>
    @endif
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div>Signup</div>
                <div>
                    <form method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-row">
                            <div class="form-group col-3">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" placeholder="Username" aria-label="Username" name="username">
                            </div>
                            <div class="form-group col-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" placeholder="Password" aria-label="Username" name="password">
                            </div>
                            <div class="form-group col-3">
                                <label for="E-mail">E-mail</label>
                                <input type="text" class="form-control" placeholder="E-mail" aria-label="Username" name="email">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="First Name" aria-label="Username" name="fname"><br>
                            </div>
                        </div>
                        
                        <div class="form-group w-25">
                            <input type="text" class="form-control" placeholder="Middle Name" aria-label="Username" name="mname"><br>
                        </div>
                        <div class="form-group w-25">
                            <input type="text" class="form-control" placeholder="Last Name" aria-label="Username" name="lname"><br>
                        </div>
                        <input type="submit" value="Create Account" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>