@extends('layout.pages')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                <div>
                    <h3 class="text-light mt-2">Appointments</h3>
                </div>
                <table>
                	<th>Name</th>
                	<th>Description</th>
                	<th>Location</th>
                	<th>Date</th>
                	<th>Repeat</th>
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