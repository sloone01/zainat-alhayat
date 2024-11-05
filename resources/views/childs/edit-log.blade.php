@section('title')
Call-Center Creat Log
@endsection
@extends('layouts.main')
@section('style')
<link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css">
<!-- Code Mirror css -->
<link href="{{ asset('assets/plugins/code-mirror/codemirror.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('rightbar-content')
<!-- Start Breadcrumbbar -->
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Logs</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Logs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New Log</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbbar -->
<!-- Start Contentbar -->
<div class="contentbar">
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Update Log</h5>

                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="post" action="{{ route('save-edit') }}">
                        {{ csrf_field()  }}
                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label for="inputCity">Planet</label>
                                <input type="hidden" name="planet" value="{{ $criterias[0]->id }}"/>
                                <select disabled id="problemChange" name="planet" class="form-control">
                                    <option value="Choose" selected>Choose...</option>
                                    @foreach($criterias as $planet)
                                    <option @if($planet->id == $log->planet_id) selected @endif value="{{ $planet->id }}">{{ $planet->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- <div class="form-group col-md-4">
                            <label for="inputCity">Techicien</label>
                                <select id="problemChange" name="tech_ref" class="form-control">
                                    <option value="Choose" selected>Choose...</option>
                                    @foreach($techs as $tech)
                                        <option @if($tech->id == $log->tech_ref) selected @endif value="{{ $tech->id }}">{{ $tech->name }}</option>
                                    @endforeach
                                </select>
                            </div> -->

                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Job Date</label>
                                <input type="date" class="form-control" value="{{ $log->job_date }}" name="job_date" id="inputPassword4" placeholder="Equipment No">
                            </div>



                            <!-- <div class="form-group col-md-4">
                            <label for="inputCity">Shift</label>
                                <select id="problemChange" name="shift" class="form-control">
                                    <option value="Choose" selected>Choose...</option>
                                    @foreach($shifts as $shift)
                                        <option @if($shift->id == $log->shift_id) selected @endif value="{{ $shift->id }}">{{ $shift->name }}</option>
                                    @endforeach
                                </select>
                            </div> -->



                            <div class="form-group col-md-4">
                                <label for="inputPassword4">MWO Number</label>
                                <input type="hidden" value="{{ $log->id }}" class="form-control" name="id">
                                <input type="text" value="{{ $log->mwo_number }}" class="form-control" name="mwo_number" id="inputPassword4" placeholder="MWO Number">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Tags No</label>
                                <input type="text" value="{{ $log->tags_no }}" class="form-control" name="tags_no" id="inputPassword4" placeholder="Tags No">
                            </div>


                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Spares Consumed</label>
                                <input type="text" value="{{ $log->spare_consumed }}" class="form-control" name="spare_consumed" id="inputPassword4" placeholder="Spares Consumed">
                            </div>

                        </div>
                        <div class="form-row">

                            <!-- <div class="form-group col-md-4">
                                <label for="inputPassword4">Time Taken For The Job</label>
                                <input type="text"  value="{{ $log->time_taken }}"  class="form-control" name="time_taken" id="inputPassword4" placeholder="Time Taken">
                            </div> -->

                            <!-- <div class="form-group col-md-4">
                            <label for="inputCity">Type of Job</label>
                                <select id="problemChange" name="type_of_job" class="form-control">
                                    <option value="Choose" selected>Choose...</option>
                                    @foreach($types as $type)
                                        <option @if($type->id == $log->type_of_job) selected @endif value="{{ $type->id }}">{{ $type->title }}</option>
                                    @endforeach
                                </select>
                            </div> -->


                        </div>
                        <div class="form-row">
                            <!-- <div class="form-group col-md-6">
                                <label for="inputPassword4">Defect Reported/Observation</label>
                                <textarea class="form-control" name="observation" id="exampleFormControlTextarea1" rows="3">{{ $log->observation }}</textarea>
                            </div> -->
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Repairing Done</label>
                                <textarea class="form-control" name="repairing" id="exampleFormControlTextarea1" rows="3">{{ $log->repairing }}</textarea>
                            </div>
                        </div>

                        <button type="submit" name='action' value="update" class="btn btn-primary">Update</button>
                        @if(\App\Providers\RoleHelper::isEngineer())
                        <button type="submit" name='action' value="change_status" class="btn btn-primary">Update & submit</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12">

        </div>
        <!-- End col -->
    </div> <!-- End row -->
</div>
<!-- End Contentbar -->
@endsection
@section('script')
<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
<!-- Summernote JS -->
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- Code Mirror JS -->
<script src="{{ asset('assets/plugins/code-mirror/codemirror.js') }}"></script>
<script src="{{ asset('assets/plugins/code-mirror/htmlmixed.js') }}"></script>
<script src="{{ asset('assets/plugins/code-mirror/css.js') }}"></script>
<script src="{{ asset('assets/plugins/code-mirror/javascript.js') }}"></script>
<script src="{{ asset('assets/plugins/code-mirror/xml.js') }}"></script>
<script src="{{ asset('assets/js/custom/custom-form-editor.js') }}"></script>
<script src="{{ asset('assets/js/javascript.js') }}" defer></script>
@endsection