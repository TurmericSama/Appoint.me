<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signup</title>
    @if( $success == 1 )
        <script>alert( "Signup successful" )</script>
    @endif
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div id="main-card">
                <div>Signup</div>
                <div>
                    <form method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" name="username"><br>
                            <input type="password" class="form-control" placeholder="Password" aria-label="Username" name="password"><br>
                            <input type="text" class="form-control" placeholder="Email" aria-label="Username" name="email"><br>
                            <input type="text" class="form-control" placeholder="First Name" aria-label="Username" name="fname"><br>
                            <input type="text" class="form-control" placeholder="Middle Name" aria-label="Username" name="mname"><br>
                            <input type="text" class="form-control" placeholder="Last Name" aria-label="Username" name="lname"><br>
                            <input type="text" class="form-control" placeholder="Facebook ID" aria-label="Username" name="facebook_id"><br>
                        </div>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>