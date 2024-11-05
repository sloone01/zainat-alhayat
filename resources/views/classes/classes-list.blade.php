@section('title')
    LogBook - Classes
@endsection
@extends('layouts.main')
@section('style')

@endsection
@section('rightbar-content')
    <!-- Start Breadcrumbbar -->
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Classes List</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Management</a></li>
                        <li class="breadcrumb-item"><a href="#">Classes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Classes</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary-rgba" onclick="window.location='{{ url("/add-class") }}'" data-toggle="modal" data-target="#exampleModalCenter"><i class="feather icon-plus mr-2"></i>Add Class</button>
                    <!-- Modal -->
                    <div class="modal fade text-left" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Add Class</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="appointno">No</label>
                                                <input type="text" class="form-control" id="appointno">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="appointpatient">Patient Name</label>
                                                <input type="text" class="form-control" id="appointpatient">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="appointdoctor">Doctor Name</label>
                                                <input type="text" class="form-control" id="appointdoctor">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="appointdate">Date</label>
                                                <input type="date" class="form-control" id="appointdate">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="appointtime">Time</label>
                                                <input type="time" class="form-control" id="appointtime">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="appointpatientid">Patient ID</label>
                                                <input type="text" class="form-control" id="appointpatientid">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="appointdoctorid">Doctor ID</label>
                                                <input type="text" class="form-control" id="appointdoctorid">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="appointtype">Type</label>
                                                <select id="appointtype" class="form-control">
                                                    <option selected>Select Type...</option>
                                                    <option value="new">New</option>
                                                    <option value="old">Old</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="appointpaystatus">Payment Status</label>
                                                <select id="appointpaystatus" class="form-control">
                                                    <option selected>Select Payment Status...</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="success">Success</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary"><i class="feather icon-plus mr-2"></i>Add Class</button>
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
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Classes List</h5>
                    </div>
                    <div class="card-body">
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
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Class</th>
                                    <th>Status</th>
                                    <th>Create Date</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($classes as $job)
                                    <tr>
                                        <td>{{$job->id}}</td>
                                        <td>{{$job->title}}</td>
                                        <td><span class="{{ $job->status == 'ACT' ? 'badge badge-info-inverse' :
                                        'badge badge-danger-inverse' }}">{{ $job->status }}</span></td>
                                        <td>{{ $job->created_at}}</td>
                                        <td>
                                            <a href="{{ url('change-status-job',$job->id) }}" href="#" class="text-{{$job->status == 'ACT' ? 'danger' : 'success'}}"><i class="feather icon-power"></i></a>
                                            <a href="{{ url('edit-class-page',$job->id) }}" href="#" class="text-info"><i class="feather icon-edit-2"></i></a>
                                            <a href="{{ url('delete-jobType',$job->id) }}" href="#" class="text-danger"><i class="feather icon-trash-2"></i></a>
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
