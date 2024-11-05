@section('title')
    LogBook App criterias
@endsection
@extends('layouts.main')
@section('style')

@endsection
@section('rightbar-content')
<!-- Start Breadcrumbbar -->
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Criterias List</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Management</a></li>
                    <li class="breadcrumb-item"><a href="#">Criterias</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Criterias</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary-rgba" onclick="window.location='{{ url("/add-criteria") }}'" data-toggle="modal" data-target="#exampleModalCenter"><i class="feather icon-plus mr-2"></i>Add Criteria</button>
                <!-- Modal -->
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
            @if (isset($message))
                <div class="alert alert-success">
                    <ul>
                        <li>{{ $message }}</li>
                    </ul>
                </div>
            @endif
            @if (session('message') !== null)
                <div class="alert alert-success">
                    <ul>
                        <li>{{ session('message') }}</li>
                    </ul>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">criterias List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>

                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Classes</th>
                                    <th>Status</th>
                                    <th>Create Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($criterias as $planet)
                                <tr>
                                    <td>{{$planet->id}}</td>
                                    <td>{{$planet->name}}</td>
                                    <td>{{$planet->classes}}</td>
                                    <td><span class="{{ $planet->status == 'ACT' ? 'badge badge-info-inverse' :
                                        'badge badge-danger-inverse' }}">{{ $planet->status }}</span></td>
                                    <td>{{ $planet->created_at}}</td>
                                    <td>
                                        <a href="{{ url('activate-planet',$planet->id) }}" href="#" class="text-{{$planet->status == 'ACT' ? 'danger' : 'success'}}"><i class="feather icon-power"></i></a>
                                        <a href="{{ url('edit-criteria',$planet->id) }}" href="#" class="text-info"><i class="feather icon-edit-2"></i></a>
                                        <a href="{{ url('delete-planet',$planet->id) }}" href="#" class="text-danger"><i class="feather icon-trash-2"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
</div>
<!-- End Contentbar -->
@endsection
@section('script')

@endsection
