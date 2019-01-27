@extends('layout.pages')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="mt-2">
                    <h3 class="text-light">Profile</h3>
                    <form id="profile">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Name</span>
                            </div>
                                <input type="text" class="form-control" name="name" id="name" value="{{ $data->fname}}" placeholder="Name" readonly>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Username</span>
                            </div>
                        <input type="text" class="form-control" name="uname" id="uname" value="{{ $data->uname}}" placeholder="Username" readonly>
                        </div>
                        <div id="update">
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">New Password</span>
                                </div>
                                    <input type="password" class="form-control" name="npass" id="npass" placeholder="Enter new Password">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Confirm Password</span>
                                </div>
                                    <input type="password" class="form-control" name="cpass" id="cpass" placeholder="Reenter new Password again...">
                            </div>
                        </div>
                        <input type="submit" value="Submit" id="submit" class="btn btn-primary">
                    </form>
                    <button id="trigger" class="btn btn-success" value="view">Update Account Information</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready( function(){
            $('#update').hide();
            $('#submit').hide();
        })

        $('#trigger').click( function(){
            if( $('#trigger').val() == "view"){
            $('#name').attr('readonly', false);
            $('#uname').attr('readonly', false);
            $('#update').show();
            $('#trigger').val('cancel');
            $('#trigger').html('Cancel'); 
            $('#submit').show();
            } else{
                $('#trigger').html('Update Account Information');
                $('#update').hide();
                $('#trigger').val('view');
                $('#name').attr('readonly', true);
                $('#uname').attr('readonly', true);
                $('#submit').hide();
            }
        })

        $( "#profile" ).ajaxForm({
            url: "/user",
            type: "POST",
            success: function( res ) {
                res = JSON.parse( res )
                if( res.success == 1 )
                    toastr.success('All account information has been updated');
                else if( res.success == 2 ){
                    toastr.success("Username and Name has been updated");
                } else if( res.success == 3){
                    toastr.success("Username has been updated");
                } else if( res.success == 4 ){
                    toastr.success("Name has been updated");
                }else
                    toastr.warning('Something went wrong');
            }
        })

    </script>

@endsection