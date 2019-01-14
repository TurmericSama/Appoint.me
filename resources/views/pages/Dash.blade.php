@extends('layout.pages')

@section('content')
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <input type="text" id="id" hidden>
                <div class="mt-2">
                    <h3 class="text-light">Dashboard</h3>
                </div>
                <table class="table table-bordeless table-light table-hover">
                	<th scope="col">Name</th>
					<th scope="col">When</th>
					<th scope="col">Status</th>
                    <tbody id="data">
                    </tbody>
                </table>
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
                    <div id="event-name-div">
                        <h5>Event Name</h5>
                        <div id="event-name">
                        </div>
                    </div>
                    <div id="event-desc">
                        <h6></h6>
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
                        $( "#data" ).text( "" );
                        res.data.forEach( cur => {
                            $( "#data" ).append( `
                                <tr class="emp" data-toggle="modal" data-target="#dashmodal" onclick="document.getElementById('id').value = $(this).find('#eventid').text(); eventid();">
                                    <td id="eventid" hidden>${ cur.id }</td>
                                    <td max="12">${ cur.ename }</td>
                                    <td>${ cur.edate }</td>
                                    <td>${ cur.status }</td>
                                </tr>
                            `);
                        });
                    }
                }
            });
        }

        function eventid(){
            var masaya = $('#id').val()
            $('.modal-body').html('')
            $.ajax({
                type: "get",
                url: "/dashgetinfo",
                data: {
                    id : masaya
                },
                success: function (res) {
                    res = JSON.parse(res)
                    res.forEach(cur =>{
                        $('#event-name').html(cur.name)
                    })
                }
            });
        }

    </script>
@endsection