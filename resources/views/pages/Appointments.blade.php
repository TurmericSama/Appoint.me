@extends('layout.pages')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                <div>
                    <h2 class="text-white mt-2">Appointments</h2>
                </div>
                <table class="table table-light table-hover">
                    <thead class="thead-light">
                        <th scope="col">Name</th>
					    <th scope="col">When</th>
					    <th scope="col">Status</th>
                	    <th></th>
                    </thead>
                    <tbody id="data">
                		
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $( document ).ready( e => {
            gres = ""
            setInterval( check, 1000 )
        })

        function check() {
            console.log( "Entered sync" );
            $.ajax({
                url: "/eventsfetch",
                success: function( res ) {
                    console.log( res )
                    if( gres != res ) {
                        gres = res
                        res = JSON.parse( res );
                        $( "#data" ).html("");
                        if(res.length == 0){
                            $('#data').append(
                                '<tr><td align="center" colspan="4">Wow, much empty!<td></tr>'
                            );
                        }
                        res.forEach( cur => {
                            $( "#data" ).append( `
                                <tr>
                                    <td>${ cur.name }</td>
                                    <td>${ cur.date }</td>
                                    <td>${ cur.status }</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="/appointments/edit?id=${ cur.appointment_id}">Edit</a>
                                                 <button class="dropdown-item text-red" onclick="delrec(${ cur.appointment_id }) ">Delete</button>
                                            </div>
                                        </div>
                                    </td>
                                    
                                </tr>
                            `);
                        });
                    }
                }
            });
        }
    </script>
@endsection
