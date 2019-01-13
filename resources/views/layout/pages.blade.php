<!DOCTYPE html>
<html lang="en">
<head>
    <!--beginning of head-->
        <title>Appoint.me</title>
    <!--metadata-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--links and scripts-->
<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<link rel="stylesheet" href="{{asset('css/bootstrap-tokenfield.min.css')}}">
<link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/bootstrap-tokenfield.min.js')}}"></script>
<script src="{{asset('js/jquery.form.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/toastr.min.js')}}"></script>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <a style="color:green;" class="navbar-brand" href="/">Appoint.me</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" on></span>
        </button>            
                
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/dash">Home<span class="sr-only"></span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Appointments
                    </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/appointments/add">Add an Appointment</a>
                            <a class="dropdown-item" href="/appointments">My Appointments</a>
                        </div>
                </li>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle user" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Account
                    </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/user">Profile</a>
                            <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="/logout">Logout</a>
                            </div>
                </div>
            </ul>
        </div>
    </nav>
    @yield('content')
</body>
</html>

<script>
    $(document).ready(function () {
        $('#options').hide();
        $("input[type='radio']").on("change", function() {        
            if ($("#radio1").is(':checked')) {
                $('#options').hide();
            } else {
                 $('#options').show();
            }
        })

        
    });

    function delrec( id ) {
        if( confirm('Are you sure you want to delete this Event') ) {
            window.location = "/appointments/delete?id=" + id;
        } else{
            alert('Operation canceled');
        }
    }
</script>