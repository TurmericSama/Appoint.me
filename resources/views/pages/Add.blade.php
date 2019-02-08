@extends('layout.pages')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1">

            </div>
            <div class="col-md-11 col-sm-12 col-lg-10">
                <div class="mt-2">
                    <form id="add_event">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <h2 class="text-white ml-3 mb-3">Add an Appointment</h2>
                    {{--first form row--}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-alternative mb-3" id="ename" placeholder="Event Name: ">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-alternative" id="epart" placeholder="Participants:  John Doe,Emma Watson,">
                                    <input type="hidden" name="epartid" id="epartid">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <textarea name="edesc" id="edesc" rows="4" class="form-control form-control-alternative" placeholder="Event Description"></textarea>
                            </div>
                        </div>
                    {{--end of first form row--}}
                    </div>
                    {{--second form row--}}
                    <div class="row">
                        <span class="text-white h3 ml-3">Date</span>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="date" class="form-control form-control-alternative" id="date" name="date">
                            </div>
                        </div>
                        <span class="text-white h3">Start & End time</span>
                        <div class="input-group col-md-7 mb-3">
                               <input type="time" name="stime" id="stime" class="form-control">
                               <input type="time" name="etime" id="etime" class="form-control">
                        </div>
                    {{--end of second form row--}}
                    </div>
                    <legend class="h3 text-white">Repeat</legend>
                    <div class="mb-3 tab-content">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="repeat" id="radio1" class="custom-control-input" checked>
                            <label for="radio1" class="custom-control-label text-white">None</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="repeat" id="radio2" class="custom-control-input">
                            <label for="radio2" class="custom-control-label text-white">Repeat</label>
                        </div>
                    </div>
                    <div id="options" class="mb-3">
                        <legend class="h3 text-white">Repeat When</legend>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="repeatwhen" id="radio3" value="daily" class="custom-control-input">
                            <label for="radio3" class="custom-control-label text-white">Daily</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="repeatwhen" id="radio4" value="weekly" class="custom-control-input">
                            <label for="radio4" class="custom-control-label text-white">Weekly</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" name="repeatwhen" id="radio5" value="monthly" class="custom-control-input">
                            <label for="radio5" class="custom-control-label text-white">Monthly</label>
                        </div>
                    </div>
                            <input type="submit" value="Submit" class="btn btn-primary mb-4">
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
