@extends('layout.pages')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-lg-9">
                <div class="mt-2">
                    <h3 class="text-light ml-3">Add an Appointment</h3>
                    <div>
                        <div class="input-group input-group-sm mb-3 col-6">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Event Name</span>
                            </div>
                                <input type="text" class="form-control" placeholder="Ex. Camille and Ed's Wedding Anniversary" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="form-group ml-3">
                            <label for="desc" class="text-light">Event Description</label>
                            <textarea name="desc" id="desc" class="form-control" cols="" rows="4" placeholder="Ex. Event sponsors: Coca-cola," style="resize:none;"></textarea>
                            <small id="helpId" class="hello">Enter the event's description</small>
                        </div>
                        <div class="input-group input-group-sm ml-3 mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Location</span>
                                </div>
                                    <input type="text" class="form-control" placeholder="Ex. Camille and Ed's Wedding Anniversary" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <legend class="col-form-label col-sm-2 pt-0 text-light">Repeat</legend>
                        <div class="ml-3">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                  None
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                <label class="form-check-label" for="exampleRadios2">
                                    On
                                </label>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection