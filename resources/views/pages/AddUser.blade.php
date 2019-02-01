@extends('layout.pages')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1">

            </div>
            <div class="col-md-11">
                <h2 class="text-white mb-3 mt-3">Add People</h2>
                <form id="adduser">
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token()}}">
                    <div class="row">    
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" id="fname" name="fname" class="form-control form-control-alternative" placeholder="Firstname">
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" id="lname" name="lname" class="form-control form-control-alternative" placeholder="Lastname">
                            </div>
                        </div>   
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="psid" id="psid" class="form-control form-control-alternative" placeholder="PSID: 2068929911300019">
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Add Person" class="btn btn-primary btn-block col-md-6">
                </form>
            </div>
        </div>
    </div>    
    <script>
        $('#adduser').ajaxForm({
            url: "/addperson",
            method: "post",
            success: function(res){
                res = JSON.parse(res)
                if( res.success == 1){
                    toastr.success("Success");
                } else{
                    toastr.warning("Operation Failed");
                }
            }
        })
    </script>
@endsection