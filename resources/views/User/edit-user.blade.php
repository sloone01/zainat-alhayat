@section('title')
Log-Book App  Edit User
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
            <h4 class="page-title">Users</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit User</li>
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
                    <h5 class="card-title">Form row</h5>
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
                    @if (isset($error))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{{ $error }}</li>
                            </ul>
                        </div>
                    @endif
                     <form method="post" action="{{ route('update-user') }}">
                          {{ csrf_field()  }}
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Name</label>
                                <input type="text" class="form-control" value="{{ $user->name  }}" name="name" id="inputPassword4" placeholder="Full Name">
                                <input type="hidden" value="{{ $user->id  }}" name="id">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Email</label>
                                <input type="email" class="form-control" value="{{ $user->email  }}" name="email" id="inputPassword4" placeholder="Email">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Mobile</label>
                                <input type="text" class="form-control" value="{{ $user->mobile  }}" name="mobile" id="inputEmail4" placeholder="mobile">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Planet</label>
                                <select id="inputState" name="planet" class="form-control">
                                    <option value="Choose" selected>Choose...</option>
                                    @foreach($planets as $planet)
                                        <option @if($user->planet_id == $planet->id) selected @endif value="{{ $planet->id }}">{{ $planet->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputState">Role</label>
                                <select class="select2-multi-select form-control" name="roles[]" multiple="multiple">
                                        <option @if(in_array('Admin',$roles)) selected @endif value="Admin">Admin</option>
                                        <option @if(in_array('Resolver',$roles)) selected @endif value="Resolver">Resolver</option>
                                        <option @if(in_array('General',$roles)) selected @endif value="General">General</option>
                                        <option @if(in_array('Dep Admin',$roles)) selected @endif value="Dep Admin">Department Admin</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
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
