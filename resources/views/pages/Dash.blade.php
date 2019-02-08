@extends('layout.pages')

@section('content')
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-md-3">
                <div class="row">
                    <h2 class="ml-4 mb-3 text-white">Dashboard</h2>
                </div>
                <div class="col-md-12">
                    <div class="card card-stats mb-4 mb-lg">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Events today</h5>
                                    <span class="h2 font-weight-bold mb-0">di ko pa alam</span>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="col-md-12">
                        <div class="card card-stats mb-4 mb-lg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total Events this month</h5>
                                        <span class="h2 font-weight-bold mb-0">di ko pa alam</span>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
            </div>
            <div class="col-md-9 col-sm-12 col-lg-9">
                <input type="text" id="id" hidden>
                <div class="table-responsive">
                    <table class="table align-items-center table-hover table-light mt-5">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">When</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody id="data">
                        </tbody>
                    </table>
                </div>
                    
            </div>
        </div>
    </div>
    

    <div class="modal fade" id="dashmodal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="dashmodal">Event Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div id="event-name-div" class="mb-3">
                        <h6>Event Name</h6>
                        <div id="event-name"class="ml-4">
                        </div>
                    </div>
                    <div id="event-desc" class="mb-3">
                        <h6>Event Description</h6>
                        <div class="input-group ml-4">
                            <textarea id="event-desc-input" cols="30" readonly></textarea>
                        </div>
                    </div>
                    <div id="event-date">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
    <script>        
        $( document ).ready( e => {
            gres = ""
            setInterval( check, 1000 )
        });

        function check() {
            console.log( "Entered sync" );
            $.ajax({
                url: "/dashfetch",
                success: function( res ) {
                    if( gres != res ) {                        
                        gres = res
                        res = JSON.parse( res );    
                        $( "#data" ).html("");
                        if(res.data.length == 0){
                            $('#data').append(
                                '<tr data-toggle="modal" data-target="#dashmodal"><td colspan="4" align="center">Wow, much empty</td></tr>'
                            );
                        } else {
                            d = new Date()
                            start_time = new Date()
                            end_time = new Date()
                            res.data.forEach( cur => {
                                status = "Upcoming"
                                stime = cur.start_time.split( ":" )
                                etime = cur.end_time.split( ":" )
                                start_time.setHours( stime[0] )
                                start_time.setMinutes( stime[1] )
                                start_time.setSeconds( 0 )
                                end_time.setHours( etime[0] )
                                end_time.setMinutes( stime[1] )
                                end_time.setSeconds( 0 )
                                cur_date = new Date( cur.edate )                           
                                switch( cur.repeat ) {
                                    case "None": {    
                                        console.log( "inside none" )
                                        if( cur_date >= d && cur_date <= d ) {
                                            if( start_time >= d && end_time <= d )
                                                status = "Ongoing"
                                        } else if( d > cur_date )
                                            status = "Ended"
                                        break
                                    }
                                    case "Daily": {                                        
                                        if( cur_date >= d ) {
                                            if( d >= start_time && d <= end_time )
                                                status = "Ongoing"
                                        }
                                        break
                                    } 
                                    case "Weekly": {       
                                        console.log( "inside weekly" )
                                        if( d >= cur.date ) {
                                            if( ( date_diff( d, cur_date ) % 7 == 0 || ( cur_date >= d && cur_date <= d ) ) && ( time >= start_time && time <= end_time ) )
                                                status = "Ongoing"
                                        }
                                        break
                                    } 
                                    case "Monthly": {                                
                                        console.log( "inside monthly" )
                                        if( d >= cur.date ) {
                                            if( count_of_days( d.getMonth() ) < count_of_days( cur_date.getMonth() ) ) {
                                                if( d.getDate() == count_of_days( d.getMonth() ) ) {
                                                    if( time >= start_time && time <= end_time )
                                                        status = "Ongoing"
                                                }
                                            } else if( d.getDate() == cur_date.getDate() )
                                                status = "Ongoing"
                                        }
                                        break
                                    }
                                }
                                
                                $( "#data" ).append(`
                                    <tr data-toggle="modal" data-target="#dashmodal" onclick="document.getElementById('id').value = $(this).find('#eventid').text(); eventid();">
                                        <td id="eventid" hidden>${ cur.id }</td>
                                        <td max="12">${ cur.ename.replace(/\\/g,'') }</td>
                                        <td>${ cur.edate }</td>
                                        <td>${ status }</td>
                                    </tr>
                                `);
                            });
                        }
                    }
                }
            });
        }

        function date_diff( x, y ) {
            z = x - y
            return Math.floor( ( ( z / 60000 ) / 60 ) / 24 )
        }

        function count_of_days( x ) {
            var now = new Date();
            return new Date( now.getFullYear(), x + 1, 0 ).getDate();
        }

        function eventid() {
            var masaya = $('#id').val()
            $.ajax({
                type: "get",
                url: "/dashgetinfo",
                data: {
                    id : masaya
                },
                success: function (res) {
                    res = JSON.parse(res)
                    res.forEach(cur =>{
                        $('#event-name').html(cur.name.replace(/\\/g,''))
                        $('#event-desc-input').val(cur.desc.replace(/\\/g,''))
                    })
                }
            });
        }

    </script>
@endsection