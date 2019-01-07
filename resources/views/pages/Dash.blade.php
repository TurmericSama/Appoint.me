@extends('layout.pages')

@section('content')
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="mt-2">
                    <h3 class="text-light">Dashboard</h3>
                </div>
                <table class="table table-bordeless table-light">
                	<th scope="col">Name</th>
					<th scope="col">When</th>
					<th scope="col">Status</th>
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
            console.log( "Entered sync" )
            $.ajax({
                url: "/dashfetch",
                success: function( res ) {
                    if( gres != res ) {                        
                        gres = res
                        res = JSON.parse( res )
                        $( "#data" ).text( "" )
                        res.data.forEach( cur => {
                            $( "#data" ).append( `
                                <tr>
                                    <td max="12">${ cur.ename }</td>
                                    <td>${ cur.edate }</td>
                                    <td>${ cur.status }</td>
                                </tr>
                            `)
                        })
                    }
                }
            })
        }
    </script>
@endsection