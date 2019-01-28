@extends('layout.pages')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-lg-9">
                <div class="mt-2">
                    <form id="edit_event">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $data->appointment_id }}">
                    <h3 class="text-light ml-3">Edit an Appointment</h3>
                    <div>
                            <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">Event Name</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Ex.: Cassie's Birthday Party" aria-label="Username" aria-describedby="basic-addon1" name="ename" value="{{ $d = str_replace('\\','',$data->name)}}">
                                  </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Event Description</span>
                                </div>
                                    <textarea name="edesc" placeholder=" Guests:" class="form-control" rows="5" style="resize:none;">{{ $data->desc }}</textarea>
                              </div>
                              <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Participants</span>
                                </div>
                            <input name="epart" type="text" id="epart" rows="3" style="resize:none;" class="form-control" value="{{ $fname }}">
                            <input type="text" name="epartid" id="epartid" value="{{ $id }}">
                            </div>
                            <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Date</span>
                                    </div>
                                <input type="date" name="date" id="date" class="form-control" value="{{ $data->date }}">
                            </div>  
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Time</span>
                                </div>
                                <input type="time" name="stime" id="stime" class="form-control" value="{{ $data->start_time }}">
                                <input type="time" name="etime" id="etime" class="form-control" value="{{ $data->end_time }}">
                            </div>
                        <legend class="ml-0 text-light">Repeat</legend>
                        <div class="mb-3">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="repeat" id="radio1" value="None" @if( $data->repeat == "None" ) checked @endif checked>
                                <label class="form-check-label" for="radio1">
                                  None
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="repeat" id="radio2" value="option2" @if( $data->repeat != "None" ) checked @endif>
                                <label class="form-check-label" for="radio2">
                                    On
                                </label>
                            </div>
                        </div>
                        <div id="options" class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="repeatwhen" id="exampleRadios1" value="Daily" @if( $data->repeat == "Daily" ) checked @endif>
                                    <label class="form-check-label" for="exampleRadios1">
                                    Daily
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="repeatwhen" id="exampleRadios2" value="Weekly" @if( $data->repeat == "Weekly" ) checked @endif>
                                        <label class="form-check-label" for="exampleRadios2">
                                        Weekly
                                        </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="repeatwhen" id="exampleRadios2" value="Monthly" @if( $data->repeat == "Monthly" ) checked @endif>
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
    
    $('#edit_event').ajaxForm({
        url: "/appointments/edit",
        type: "POST",
        success: function(response){
            response = JSON.parse(response)
            if(response.success  == 1){
                toastr.success("Event update success");
            } 
            else{
                toastr.danger("Something went wrong");
            }
        }
    });

    function split( val ) {
            return val.split( /,\s*/ );
        }
        function extractLast( term ) {
            return split( term ).pop();
        }

        $('#epart').autocomplete({
            source: function( req, res){
                neym = $('#epart').val()
                neym = split( neym )
                neym = neym[ neym.length -1]
                $.ajax({
                    type: "get",
                    url: "/tokenfieldget",
                    data: {
                        name : neym
                    },
                    success: function (response) {
                        response = JSON.parse(response)
                        source = []
                        arr = {}
                        for (let i = 0; i < response.length; i++) {
                            source.push( response[i].label);
                            arr[response[i].label] = response[i].value;
                        } 
                        res( $.ui.autocomplete.filter( source, extractLast( req.term ) ) )
                        console.log(source)    
                    }
                });
            },
            focus: function() {
            // prevent value inserted on focus
            return false;
            },
            select: function (event, ui){
                $('#epartid').val( function(){
                    return this.value + arr[ui.item.label] + ",";
                });
                var terms = split( this.value );
                // remove the current input
                terms.pop();
                // add the selected item
                terms.push( ui.item.label );
                // add placeholder to get the comma-and-space at the end
                terms.push( "" );
                this.value = terms.join( "," );
                return false;
            }
        });


    </script>


@endsection
