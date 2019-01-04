@extends('layout.pages')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                <div>
                    <h3 class="text-light mt-2">Appointments</h3>
                </div>
                <table class="table table-bordeless table-light">
                	<th scope="col">Name</th>
					<th scope="col">When</th>
					<th scope="col">Status</th>
                	<th scope="col">Action</th>
                	@foreach( $data as $row )
                		<tr>
<<<<<<< HEAD
                			<td>{{ $row->name }}</td>
							<td>{{ $row->date }}</td>
                            <td></td>
=======
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->date }}</td>
                            @if( $row->date > \Carbon\Carbon::now())
                                <td>Up-coming</td>
                            @elseif( $row->date < \Carbon\Carbon::now())
                                <td>Finished</td>
                            @elseif( $row->date == \Carbon\Carbon::now())
                                <td>Now</td>
                            @endif 
>>>>>>> 7aa01337f6a5172dfb895e2efb1f5119a44c0d53
                			<td><a href="/appointments/edit?id={{ $row->id }}" class="btn btn-warning btn-sm">Edit</a>  <button type="button" onclick="delrec( {{ $row->id }} )" class="btn btn-danger btn-sm">Delete</button></td>
                		</tr>
                	@endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
