@extends('layout.pages')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-lg-9">
                <div class="mt-2">
                    <h3 class="text-light ml-3">Add an Appointment</h3>
                    <div>
                            <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">Event Name</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Ex.: Cassie's Birthday Party" aria-label="Username" aria-describedby="basic-addon1">
                                  </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Event Description</span>
                                </div>
                                    <textarea name="eventdesc" placeholder=" Guests:" class="form-control" rows="5" style="resize:none;"></textarea>
                              </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Location</span>
                                </div>
                                    <input type="text" class="form-control" placeholder="Ex. Camille and Ed's Wedding Anniversary">
                            </div>
                        <legend class="ml-0 text-light">Repeat</legend>
                        <div>
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
                        <div class="input-group mb-3">
                            <input type="datetime" name="date" id="date">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection