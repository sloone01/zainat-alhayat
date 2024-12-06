@section('title') 
Zainat Alhayat- Files
@endsection 
@extends('layouts.main')
@section('style')

@endsection 
@section('rightbar-content')
<!-- Start Breadcrumbbar -->                    
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Session Files</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Session</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Files</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary-rgba" data-toggle="modal" data-target="#exampleModalCenter"><i class="feather icon-plus mr-2"></i>Add File</button>
                <!-- Modal -->
                <div class="modal fade text-left" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Add File</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form enctype="multipart/form-data" method="post" action="{{ route('file-upload') }}">
                            <div class="modal-body">
                                
                                    {{ csrf_field()  }}
                                    <input type="hidden" name="session_id" value="{{ $session_id }}"/>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="doctorid">Description</label>
                                            <input type="text" name="desc" class="form-control" id="doctorid">
                                        </div>                                                    
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="doctorpic">File</label>
                                            <input type="file" name='file' class="form-control" id="doctorpic">
                                        </div>
                                    </div>                                                
                                </form>
                            
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="feather icon-plus mr-2"></i>Save</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
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
         
        @foreach($files as $f)
        <div class="col-lg-6 col-xl-3">
            <div class="card doctor-box m-b-30">
                <div class="card-body text-center">
                <img src="{{ asset('storage/'.$f->path) }}" alt="Uploaded Image" width="300">
                    <div class="doctor-detail">
                        <p>{{ $f->description }}</p>
                    </div>                                
                </div>
                <div class="card-footer text-center">
                    <div class="row">
                        <div class="col-12">
                            <h4><i class="feather icon-trash text-muted"></i></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <!-- End col -->                
    </div>
    <!-- End row -->
</div>
<!-- End Contentbar -->
@endsection 
@section('script')

@endsection 