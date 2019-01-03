@extends('layout.pages')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-lg-9">
                <div class="mt-2">
                    <form method="POST" action="/appointments/edit">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <h3 class="text-light ml-3">Edit an Appointment</h3>
                    <div>
                            <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">Event Name</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Ex.: Cassie's Birthday Party" aria-label="Username" aria-describedby="basic-addon1" name="ename" value="{{ $data->name }}">
                                  </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Event Description</span>
                                </div>
                                    <textarea name="edesc" placeholder=" Guests:" class="form-control" rows="5" style="resize:none;">{{ $data->desc }}</textarea>
                              </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Location</span>
                                </div>
                                    <input type="text" class="form-control" placeholder="Ex. Camille and Ed's Wedding Anniversary" name="elocation" value="{{ $data->location }}">
                            </div>
                            <div class="input-group mb-3">
                                    <input type="date" name="date" id="date" class="form-control" value="{{ explode( " ", $data->date )[0] }}">
                                </div>
                                <div class="input-group mb-3">
                                        <input type="time" name="time" id="time" class="form-control" value="{{ explode( " ", $data->date )[1] }}">
                                    </div>
                        <legend class="ml-0 text-light">Repeat</legend>
                        <div class="mb-3">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="repeat" id="radio1" value="None" @if( $data->repeat == "None" ) checked @endif>
                                <label class="form-check-label" for="radio1">
                                  None
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="repeat" id="radio2" value="option2" @if( $data->repeat != "None" ) checked @endif>
                                <label class="form-check-label" for="radio2">
                                    On
                                </label>
                            </div>
                        </div>
                        <div id="options" class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="repeatwhen" id="exampleRadios1" value="Daily" @if( $data->repeat == "Daily" ) checked @endif>
                                    <label class="form-check-label" for="exampleRadios1">
                                    Daily
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="repeatwhen" id="exampleRadios2" value="Weekly" @if( $data->repeat == "Weekly" ) checked @endif>
                                        <label class="form-check-label" for="exampleRadios2">
                                        Weekly
                                        </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="repeatwhen" id="exampleRadios2" value="Monthly" @if( $data->repeat == "Monthly" ) checked @endif>
                                        <label class="form-check-label" for="exampleRadios2">
                                        Monthly
                                        </label>
                                </div>
                            </div>
                            <input type="submit" value="Submit">
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
