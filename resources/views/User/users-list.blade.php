@section('title')
Zainat-Alhayat App - User
@endsection
@extends('layouts.main')
@section('style')

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
                    <li class="breadcrumb-item active" aria-current="page">Users List</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <!-- Button trigger modal -->
                <button type="button" onclick="window.location='{{ url("/add-user-page") }}'" class="btn btn-primary-rgba" data-toggle="modal" data-target="#exampleModalCenter"><i class="feather icon-plus mr-2"></i>Add User</button>
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
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Users List</h5>
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
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach(session('users') !== null ? session('users') : $users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->roles }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td><span class="badge badge-{{$user->IsActive ? 'primary' : 'danger'}}-inverse">{{ $user->IsActive ? 'Active' : 'In Active' }}</span></td>
                                    <td><form>
                                            <a href="{{ url('edit-user',$user->id) }}" class="text-primary mr-2"><i class="feather icon-edit-2"></i></a>
                                            <a href="{{ url('disable-user',$user->id) }}" href="#" class="text-{{$user->IsActive ? 'danger' : 'success'}}"><i class="feather icon-power"></i></a>
                                            <a href="{{ url('reset-password',$user->id) }}" href="#" class="text-danger"><i class="feather icon-refresh-ccw"></i></a>
                                        </form>

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
