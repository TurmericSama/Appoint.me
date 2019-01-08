@extends('layout.pages')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1">

            </div>
            <div class="col-md-11 col-sm-12 col-lg-9">
                <div class="mt-2">
                    <form id="add_event">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <h3 class="text-dark ml-3 mb-5">Add an Appointment</h3>
                    <div>
                            
                        <div class="input-field ">
                            <input id="first_name" type="text" class="validate">
                            <label for="first_name">First Name</label>
                        </div>
                        <div class="input-field">
                            <input id="last_name" type="text" class="validate">
                            <label for="last_name">Last Name</label>
                        </div>

                        <div class="input-field">
                            <input type="text" name="ename" id="ename" required>
                            <label for="ename">Event Name</label>
                        </div>
                        <div class="input-field">
                            <textarea name="edesc" id="edesc" class="materialize-textarea"></textarea>
                            <label for="edesc">Event Desc</label>
                        </div>
                        <div class="input-field">
                            <textarea name="eguests" id="eguests" class="materialize-textarea"></textarea>
                            <label for="eguests">Event Guests</label>
                        </div>
                        <div class="input-field">
                            <textarea name="elocation" id="elocation" class="materialize-textarea"></textarea>
                            <label for="elocation">Event Location</label>
                        </div>
                        <div class="input-field">
                            <input type="text" name="edate" id="edate" class="datepicker">
                            <label for="edate">Event Date</label>
                        </div>
                        <div class="input-field">
                            <input type="text" name="stime" id="stime" class="timepicker">
                            <label for="stime">Start Time</label>
                        </div>
                        <div class="input-field">
                            <input type="text" name="edate" id="edate" class="timepicker">
                            <label for="edate">End Time</label>
                        </div>
                        <legend>Repeat</legend>
                        <div class="mb-3">
                            <p>
                                <label>
                                    <input name="repeat" type="radio" id="radio1" checked/>
                                    <span class="text-dark">None</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input name="repeat" id="radio2" type="radio"/>
                                    <span class="text-dark">On</span>
                                </label>
                            </p>
                        </div>
                        <div id="options" class="mb-3">
                        <legend>Repeat When</legend>
                            <p>
                                <label>
                                    <input name="repeatwhen" id="rep" type="radio"/>
                                    <span class="text-dark">Daily</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input name="group1" id="rep" type="radio"/>
                                    <span class="text-dark">Weekly</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input name="group1" id="rep" type="radio"/>
                                    <span class="text-dark">Monthly</span>
                                </label>
                            </p>
                        </div>
                            <input type="submit" value="Submit" class="btn btn-primary">
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $( "#add_form" ).ajaxForm({
            url: "/appointments/add",
            type: "post",
            success: function( res ) {
                res = JSON.parse( res )
                if( res.success == 1 )
                    window.location = "/appointments"
                else
                    alert( "Adding failed successfuly" )
            }
        })
        $(document).ready(function(){
            $('.datepicker').datepicker();
        });  
    </script>
@endsection
