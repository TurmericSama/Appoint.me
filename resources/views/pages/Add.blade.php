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
                    <h3 class="text-light ml-3 mb-3">Add an Appointment</h3>
                    <div>
                            <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">Event Name</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Ex.: Cassie's Birthday Party" id="ename" name="ename" required>
                                  </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Event Description</span>
                                </div>
                                    <textarea name="edesc" id="edesc" placeholder=" Ex.: Come and join the Cassie's 1st celebration of birth..." class="form-control" rows="5" style="resize:none;" required></textarea>
                              </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Event Guests</span>
                                </div>
                                <input type="text" multiple>
                              </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Location</span>
                                </div>
                                    <input type="text" class="form-control" placeholder="Ex.: 2 Fatima Ave, Valenzuela, Metro Manila" name="elocation" id="elocation" required>
                            </div>
                            <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Date</span>
                                        </div>
                                    <input type="date" name="date" id="date" class="form-control col-3" required>
                                </div>
                                <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Time</span>
                                            </div>
                                        <input type="time" name="time" id="time" class="form-control col-2" required>
                                    </div>
                        <legend class="ml-0 text-light">Repeat</legend>
                        <div class="mb-3">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="repeat" id="radio1" value="None" checked>
                                <label class="form-check-label" for="radio1">
                                  None
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="repeat" id="radio2" value="option2">
                                <label class="form-check-label" for="radio2">
                                    On
                                </label>
                            </div>
                        </div>
                        <div id="options" class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="repeatwhen" id="exampleRadios1" value="Daily">
                                    <label class="form-check-label" for="exampleRadios1">
                                    Daily
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="repeatwhen" id="exampleRadios2" value="Weekly">
                                        <label class="form-check-label" for="exampleRadios2">
                                        Weekly
                                        </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="repeatwhen" id="exampleRadios2" value="Monthly">
                                        <label class="form-check-label" for="exampleRadios2">
                                        Monthly
                                        </label>
                                </div>
                            </div>
                            <input type="submit" value="Submit">
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
    </script>
@endsection
