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
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Event Name</span>
                            </div>
                            <input type="text" class="form-control" name="ename" id="ename" placeholder="Ex.: Kalasag: 13th meetup">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Event Description</span>
                            </div>
                            <textarea name="edesc" id="edesc" cols="30" rows="5" class="form-control" style="resize:none;" placeholder="The event will feature recent developments to the company's growth"></textarea>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Participants</span>
                                </div>
                               <input type="text" name="epart" id="epart" class="form-control" placeholder="Participants">
                               <input type="hidden" name="epartid" id="epartid">
                            </div>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Date</span>
                            </div>
                            <input type="date" name="date" id="date" class="form-control">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Time</span>
                                </div>
                               <input type="time" name="stime" id="stime" class="form-control">
                               <input type="time" name="etime" id="etime" class="form-control">
                            </div>
                        <legend class="text-light">Repeat</legend>
                        <div class="mb-3">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="repeat" id="radio1" class="custom-control-input" checked>
                                <label for="radio1" class="custom-control-label">None</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="repeat" id="radio2" class="custom-control-input">
                                <label for="radio2" class="custom-control-label">Repeat</label>
                            </div>
                        </div>
                        <div id="options" class="mb-3">
                        <legend class="text-light">Repeat When</legend>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="repeatwhen" id="radio3" value="daily" class="custom-control-input">
                            <label for="radio1" class="custom-control-label">Daily</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="repeatwhen" id="radio4" value="weekly" class="custom-control-input">
                            <label for="radio1" class="custom-control-label">Weekly</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="repeatwhen" id="radio5" value="monthly" class="custom-control-input">
                            <label for="radio1" class="custom-control-label">Monthly</label>
                        </div>
                        </div>
                            <input type="submit" value="Submit" class="btn btn-primary">
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $( "#add_event" ).ajaxForm({
            url: "/appointments/add",
            type: "POST",
            success: function( res ) {
                res = JSON.parse( res )
                if( res.success == 1 )
                    toastr.success('Event creation successful');
                else
                    toastr.warning('Something went wrong');
            }
        })

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
