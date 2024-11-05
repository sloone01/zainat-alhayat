@section('title')
Soyuz - Datatable
@endsection
@extends('layouts.main')
@section('style')
<!-- DataTables css -->
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive Datatable css -->
<link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('rightbar-content')
<!-- Start Breadcrumbbar -->
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Tickets</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Tickets</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Tickets</li>
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
                    <h5 class="card-title">Tickets</h5>
                </div>
                <div class="card-body">
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
                                    <form method="post" action="{{ route('search-tickets-admin') }}">
                                        {{ csrf_field()  }}
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Subject</label>
                                                <input type="text" class="form-control" name="subject" id="inputPassword4" placeholder="Title">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Reference</label>
                                                <input type="text" class="form-control" name="reference" id="inputEmail4" placeholder="Key ....">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4">Status</label>
                                                <select class="select2-multi-select form-control" name="status[]" multiple="multiple">
                                                    @foreach (\App\Providers\SearchHelper::$statusFilter as $statusType => $typeArray)
                                                        <optgroup label="{{ $statusType }}">
                                                            @foreach ($typeArray as $key => $value)
                                                            <option @if(session('filters') !== null && in_array($value,session('filters')['status'])) selected @endif value="{{$value}}">{{$key}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Problem</label>
                                                <select class="select2-multi-select" placeholer="Select"  multiple="multiple" name="problems[]">
                                                    @foreach($problems as $pro)
                                                        <option @if(session('filters') !== null && in_array($pro->id,session('filters')['problems'])) selected @endif value="{{ $pro->id }}">{{ $pro->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Assigned Department</label>
                                                <select class="select2-multi-select"  multiple="multiple"  name="departments[]">
                                                    @foreach($departments as $dep)
                                                        <option  @if(session('filters') !== null && in_array($dep->id ,session('filters')['deps'])) selected @endif  value="{{ $dep->id }}">{{ $dep->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="inputEmail4">Priority</label>
                                                <select class="select2-multi-select"  multiple="multiple"  name="priorities[]">
                                                    <option @if(session('filters') !== null && in_array('Low',session('filters')['priorities'])) selected @endif >Low</option>
                                                    <option @if(session('filters') !== null && in_array('Normal',session('filters')['priorities'])) selected @endif >Normal</option>
                                                    <option @if(session('filters') !== null && in_array('High',session('filters')['priorities'])) selected @endif >High</option>
                                                    <option @if(session('filters') !== null && in_array('Critical',session('filters')['priorities'])) selected @endif>Critical</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">

                        </div>
                        <!-- End col -->
                    </div>
                    <div class="table-responsive">
                        <table id="default-datatable" class="display table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Created by</th>
                                    <th>Created at</th>
                                    <th>Subject</th>
                                    <th>Problem</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Department</th>
                                    <th>Hold By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach(session('tickets') !== null ? session('tickets') :  $tickets as $ticket)
                                <tr>
                                    <td><a href="{{ url("single-ticket",$ticket->id) }}">{{$ticket->id}}</a> </td>
                                    <td>{{$ticket->getCreator->name}}</td>
                                    <td>{{$ticket->created_at}}</td>
                                    <td>{{$ticket->subject}}</td>
                                    <td>{{$ticket->problem->title}}</td>
                                    <td>
                                        <span class="badge badge-pill badge-{{ $ticket->priority =='High' ? 'danger' : 'primary' }}">{{$ticket->priority}}</span></td>
                                    <td>{{$ticket->process_status}}</td>
                                    <form method="post" action="{{ route('assign-ticket') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{$ticket->id}}">
                                    <td>{{$ticket->problem->department->name }}</td>
                                    <td>{{ $ticket->process_by->name ?? '' }}</td>
                                    <td>
                                            <div class="single-dropdown">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary-rgba dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @if($ticket->assign_status == 'NotAssigned')
                                                            <button type="submit" name="assign" onclick="return confirm('Sure Want Assign?')" class="dropdown-item btn">Assign</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </td>

                                    </form>
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
<!-- Datatable js -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/custom/custom-table-datatable.js') }}"></script>

<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/custom/custom-form-select.js') }}"></script>

@endsection
