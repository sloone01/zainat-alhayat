@section('title')
Log-Book - Logs
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
            <h4 class="page-title">Logs</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Logs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Logs</li>
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
                    <h5 class="card-title">Logs</h5>
                    <div class="widgetbar">
                <!-- Button trigger modal -->
                <button type="button" onclick="window.location='{{ url("/create-log") }}'" class="btn btn-primary-rgba" data-toggle="modal" data-target="#exampleModalCenter"><i class="feather icon-plus mr-2"></i>Add Log</button>
                <!-- Modal -->
            </div>
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
                                                <label for="inputEmail4">MOW Number</label>
                                                <input type="text" class="form-control" name="mow_number" id="inputPassword4" placeholder="MOW Number">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Reference</label>
                                                <input type="text" class="form-control" name="reference" id="inputEmail4" placeholder="Key ....">
                                            </div>
                                            <div class="form-group col-md-3">
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
                                            <div class="form-group col-md-2">
                                                <label for="inputEmail4">Created Date</label>
                                                <input type="date" class="form-control" name="job_date" id="inputPassword4" placeholder="Job Date">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Classes</label>
                                                <select class="select2-multi-select" placeholer="Select"  multiple="multiple" name="types[]">
                                                    @foreach($classes as $class)
                                                        <option @if(session('filters') !== null && in_array($pro->id,session('filters')['types'])) selected @endif value="{{ $class->id }}">{{ $class->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Techiciens</label>
                                                <select class="select2-multi-select"  multiple="multiple"  name="techs[]">
                                                    @foreach($techs as $tech)
                                                        <option  @if(session('filters') !== null && in_array($dep->id ,session('filters')['techs'])) selected @endif  value="{{ $tech->id }}">{{ $tech->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="inputEmail4">Job Date</label>
                                                <input type="date" class="form-control" name="job_date" id="inputPassword4" placeholder="Job Date">
                                            </div>
                                            <div class="form-group col-md-1">
                                            <label for="inputEmail4">Search</label>
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
                                    <th>Created at</th>
                                    <th>Job Date</th>
                                    <th>Planet</th>
                                    <th>Status</th>
                                    <th>Techicien</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach(session('tickets') !== null ? session('tickets') :  $worklogs as $log)
                                <tr>
                                    <td><a href="{{ url("single-student",$log->id) }}">{{$log->id}}</a> </td>
                                    <td>{{$log->created_at}}</td>
                                    <td>{{$log->job_date}}</td>
                                    <td>{{$log->jobType->title}}</td>
                                    <td>{{$log->planet->name}}</td>
                                    <form method="get" action="{{ url("edit-log",$log->id) }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{$log->id}}">
                                    <td>{{$log->tech->name }}</td>
                                    <td>
                                            <div class="single-dropdown">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary-rgba dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @if($log->status == 'new')
                                                            <button type="submit" name="assign" onclick="return confirm('Sure Want Edit?')" class="dropdown-item btn">Edit</button>
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
