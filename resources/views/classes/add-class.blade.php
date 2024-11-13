@section('title')
Zainat-Alhayat App Add JobType
@endsection
@extends('layouts.main')
@section('style')
@endsection
@section('rightbar-content')
<!-- Start Breadcrumbbar -->
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Classes</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Management</a></li>
                    <li class="breadcrumb-item"><a href="#">Classes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Class</li>
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
        <div class="col-lg-9">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">New Class</h5>
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
                     <form action="{{ route('save-class') }}" method="post">
                         {{ csrf_field() }}
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Title</label>
                                <input type="text" class="form-control" name="title" id="inputPassword4" placeholder="Title">
                            </div>
            

                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
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
@endsection
