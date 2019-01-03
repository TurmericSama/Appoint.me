@extends('layout.pages')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                <div>
                    <h3 class="text-light mt-2">Appointments</h3>
                </div>
                <table class="table table-bordeless">
                	<th scope="col">Name</th>
                	<th scope="col">Description</th>
                	<th scope="col">Location</th>
                	<th scope="col">Date</th>
                	<th scope="col">Repeat</th>
                	@foreach( $data as $row )
                		<tr>
                			<td>{{ $row->name }}</td>
                			<td>{{ $row->desc }}</td>
                			<td>{{ $row->location }}</td>
                			<td>{{ $row->date }}</td>
                			<td>{{ $row->repeat }}</td>
                		</tr>
                	@endforeach
                </table>
            </div>
        </div>
    </div>
@endsection