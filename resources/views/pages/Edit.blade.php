@extends('layout.pages')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-1">

            </div>
            <div class="col-md-6 col-sm-12 col-lg-11">
                {{--new--}}
                    <div class="mt-2">
                            <form id="edit_event">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <h2 class="text-white ml-3 mb-3">Edit Appointment</h2>
                            {{--first form row--}}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-alternative mb-3" id="ename" placeholder="Event Name: " value="{{ $d = str_replace('\\','',$data->name)}}">
                                        <div class="form-group">
                                        <input type="text" class="form-control form-control-alternative" id="epart" placeholder="Participants:  John Doe,Emma Watson," value="{{$fname}}">
                                            <input type="hidden" name="epartid" id="epartid">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                    <textarea name="edesc" id="edesc" rows="4" class="form-control form-control-alternative" placeholder="Event Description">{{ $data->desc}}</textarea>
                                    </div>
                                </div>
                            {{--end of first form row--}}
                            </div>
                            {{--second form row--}}
                            <div class="row">
                                <span class="text-white h3 ml-3">Date</span>
                                <div class="col-md-3">
                                    <div class="form-group">
                                    <input type="date" class="form-control form-control-alternative" id="date" name="date" value="{{$data->date}}">
                                    </div>
                                </div>
                                <span class="text-white h3">Start & End time</span>
                                <div class="input-group col-md-7 mb-3">
                                <input type="time" name="stime" id="stime" class="form-control" value="{{$data->start_time}}">
                                <input type="time" name="etime" id="etime" class="form-control" value="{{$data->end_time}}">
                                </div>
                            {{--end of second form row--}}
                            </div>
                            <legend class="h3 text-white">Repeat</legend>
                            <div class="mb-3 tab-content">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="repeat" id="radio1" class="custom-control-input" @if( $data->repeat == "None") checked @endif>
                                    <label for="radio1" class="custom-control-label text-white">None</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="repeat" id="radio2" class="custom-control-input" @if( $data->repeat !== "None") checked @endif>
                                    <label for="radio2" class="custom-control-label text-white">Repeat</label>
                                </div>
                            </div>
                            <div id="options" class="mb-3">
                                <legend class="h3 text-white">Repeat When</legend>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="repeatwhen" id="radio3" value="daily" class="custom-control-input" @if( $data->repeat == "daily") checked @endif>
                                    <label for="radio3" class="custom-control-label text-white">Daily</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="repeatwhen" id="radio4" value="weekly" class="custom-control-input" @if( $data->repeat == "weekly") checked @endif>
                                    <label for="radio4" class="custom-control-label text-white">Weekly</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="repeatwhen" id="radio5" value="monthly" class="custom-control-input" @if( $data->repeat == "monthly") checked @endif>
                                    <label for="radio5" class="custom-control-label text-white">Monthly</label>
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
    
    var epartval;
    var epartid;

    $(document).ready( function(){
        epartval = $('#epart').val();
        epartval = epartval.split(',');
        var epartid = $('#epartid').val();
        epartid = epartid.split(',');
        eplength = epartval.length;
        epidlength = epartid.length; 
    });


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
