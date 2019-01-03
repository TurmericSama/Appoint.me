@extends('layout.pages')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                <div>
                    <h3 class="text-light mt-2">Appointments</h3>
                </div>
                <table class="table table-bordeless table-light table-responsive">
                	<th scope="col">Name</th>
                	<th scope="col">Description</th>
                	<th scope="col">Location</th>
                	<th scope="col">Date</th>
                	<th scope="col">Repeat</th>
                	<th scope="col">Action</th>
                	@foreach( $data as $row )
                		<tr>
                			<td>{{ $row->name }}</td>
                			<td>{{ $row->desc }}</td>
                			<td>{{ $row->location }}</td>
                			<td>{{ $row->date }}</td>
                			<td>{{ $row->repeat }}</td>
<<<<<<< HEAD
                			<td><a href="" class="btn btn-warning btn-sm">Edit</a><div class="divider"></div><a href="" class="btn btn-danger btn-sm">Delete</a></td>
=======
                			<td><a href="/appointments/edit?id={{ $row->id }}" class="btn btn-warning btn-sm">Edit</a>  <a href="" class="btn btn-danger btn-sm">Delete</a></td>
>>>>>>> 3a59b98c8e5c953602de046f6c8bb8ee9d9b3f14
                		</tr>
                	@endforeach
                </table>
            </div>
        </div>
    </div>
@endsection