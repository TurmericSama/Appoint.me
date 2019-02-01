<!DOCTYPE html>
<html lang="en">
<head>
    <!--beginning of head-->
        <title>Appoint.me</title>
    <!--metadata-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--links and scripts-->
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

    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
                /* display: none; <- Crashes Chrome on hover */
            -webkit-appearance: none;
            margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
        }
    </style>
</head>
<body class="bg-gradient-primary">
        <nav class="navbar navbar-horizontal navbar-expand-md navbar-dark bg-gradient-primary">
                <div class="container">
                    <a class="navbar-brand text-secondary" href="/login">Appoint.me</a>
                    {{--taga open ng navbar--}}
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbar-default">
                        <div class="navbar-collapse-header">
                            <div class="row">
                                <div class="col-6 collapse-brand">
                                    <a href="/login">
                                        Appoint.me
                                    </a>
                                </div>
                                {{--taga close ng navbar--}}
                                <div class="col-6 collapse-close">
                                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
                                        <span></span>
                                        <span></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <ul class="navbar-nav ml-lg-auto">
                            <li class="nav-item">
                                <a class="nav-link nav-link-icon" href="/dash">
                                    Home
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-link-icon" href="#" id="navbar-default_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Appointments
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
                                    <a class="dropdown-item" href="/appointments/add">Add Event</a>
                                    <a class="dropdown-item" href="/appointments">View Appointments</a>
                                    {{-- <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Something else here</a> --}}
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-link-icon" href="/addperson">
                                    Add Person
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-link-icon " href="/logout">
                                    Logout
                                </a>
                            </li>
                        </ul>
                        
                    </div>
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
                $('#radio3').prop('checked', false);
                $('#radio4').prop('checked', false);
                $('#radio5').prop('checked', false);

            } else {
                 $('#options').show();
            }
        });   
    });

    function delrec( id ) {
        if( confirm('Are you sure you want to delete this Event') ) {
            $.ajax({
                type: "GET",
                url: "appointments/delete",
                data: {
                    id : id
                },
                success: function (response) {
                    res = JSON.parse(response)
                    if( res.success == 1){
                        toastr.success('Operation success');
                    } else{
                        toastr.warning('Operation failed successfully');
                    }
                }
            });
        } else{
            alert('Operation canceled');
        }
    }
</script>