@section('title')
Log-Book App  Edit Criteria
@endsection
@extends('layouts.main')
@section('style')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css">
    <!-- Code Mirror css -->
    <link href="{{ asset('assets/plugins/code-mirror/codemirror.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('rightbar-content')
<!-- Start Breadcrumbbar -->
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Criterias</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Criterias</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Criteria</li>
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
                    <h5 class="card-title">Update Criteria</h5>
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
                     <form method="post" action="{{ route('saveEditCri') }}">
                          {{ csrf_field()  }}
                          <input type="hidden" value="{{ $id }}" name='cri_id' class="form-control" name="id">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Name</label>
                                <input type="text" class="form-control" value="{{$name}}" name="name" id="inputPassword4" placeholder="Full Name">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputCity">Class</label>
                                <select class="select2-multi-select form-control" name="levels[]" multiple="multiple">
                                    @foreach($Levels as $planet)
                                        <option value="{{ $planet->id }}">{{ $planet->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputState">Type</label>
                                <select class="select2-multi-select form-control" name="cri_type">
                                        <option @if($tpe == 'C') selected @endif value='C'>Completed/Not Completed</option>
                                        <option @if($tpe == 'D') selected @endif Value='D'>Date Considerable</option>
                                        <option @if($tpe == 'N') selected @endif value='N'>Numeric Sequence</option>
                                </select>
                            </div>
                            
                           
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Submit</button>
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

    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom-form-select.js') }}"></script>
@endsection
