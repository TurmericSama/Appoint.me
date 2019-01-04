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
                    @foreach( $data as $row )
                		<tr>
                			<td>{{ $row->name }}</td>
							<td>{{ $row->date }}</td>
                            <td>{{ $row->status }}</td>                			
                		</tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection