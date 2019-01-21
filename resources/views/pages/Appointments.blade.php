@extends('layout.pages')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                <div>
                    <h3 class="text-light mt-2">Appointments</h3>
                </div>
                <table class="table table-bordeless table-light table-hover">
                	<th scope="col">Name</th>
					<th scope="col">When</th>
					<th scope="col">Status</th>
                	<th scope="col">Action</th>
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
                                    <td><a href="/appointments/edit?id=${ cur.appointment_id }" class="btn btn-warning btn-sm">Edit</a>  <button type="button" onclick="delrec( ${ cur.appointment_id } )" class="btn btn-danger btn-sm">Delete</button></td>
                                </tr>
                            `);
                        });
                    }
                }
            });
        }
    </script>
@endsection
