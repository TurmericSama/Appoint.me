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
                        res.data.forEach( cur => {
                            $( "#data" ).append( `
                                <tr data-toggle="modal" data-target="#dashmodal" onclick="document.getElementById('id').value = $(this).find('#eventid').text(); eventid();">
                                    <td id="eventid" hidden>${ cur.id }</td>
                                    <td max="12">${ cur.ename.replace(/\\/g,'') }</td>
                                    <td>${ cur.edate }</td>
                                    <td>${ cur.status }</td>
                                </tr>
                            `);
                            console.log(res)
                        });
                        }
                    }
                }
            });
        }

        function eventid(){
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