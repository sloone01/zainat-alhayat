@section('title')
Zainat-Alhayat - Logs
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
            <h4 class="page-title">Childs</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Childs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Childs</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <!-- Button trigger modal -->

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
                    <h5 class="card-title">{{ $worklogs->count() }} Students</h5>
                </div>
                <div class="card-body">
                    <div class="row">

                        <!-- Start col -->
                        <div class="col-lg-12">
                            <div class="card m-b-30">

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
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <form method="post" action="{{ route('search-reading') }}">
                                        {{ csrf_field()  }}
                                        <div class="form-row">

                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Key</label>
                                                <input type="text" class="form-control" value="@isset($filters) {{ $filters['key'] }} @endisset" name="key" id="inputEmail4" placeholder="Key ....">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Status</label>
                                                <select class="select2-multi-select form-control" name="status[]" multiple="multiple">
                                                    @foreach (\App\Providers\SearchHelper::$statusFilter as $statusType => $typeArray)
                                                    <optgroup label="{{ $statusType }}">
                                                        @foreach ($typeArray as $key => $value)
                                                        <option if() @isset($filters) @if(in_array($value,$filters['status'])) selected @endif @endisset value="{{$value}}">{{$key}}</option>
                                                        @endforeach
                                                    </optgroup>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="inputEmail4">Teacher</label>
                                                <select class="select2-multi-select" placeholer="Select" name="supes" id='problemChange'>
                                                    <option value="0">All</option>
                                                    @foreach($sups as $sup)
                                                    <option  @if($sup_id == $sup->id) selected @endif @isset($filters) @if(in_array($sup->id,$filters['sups'])) @endif @endisset value="{{ $sup->id }}">{{ $sup->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="row">
                                        <div class="form-group col-md-1">
                                                <button type="submit" name="action" value="noprint" class="btn btn-primary">Search</button>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <button type="submit" name="action" value="print" class="btn btn-primary-rgba" data-toggle="modal" data-target="#exampleModalCenter"></i>Print</button>
                                            </div>

                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        
                        <!-- End col -->
                    </div>
                    <div class="table-responsive">
                
                        <table id="default-datatable" class="display table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Stage</th>
                                    <th>Supervisor</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(session('tickets') !== null ? session('tickets') : $worklogs as $i=>$student)
                                <tr>
                                    <td><a href="{{ url("single-student",$student->id) }}">{{$i+1}}</a> </td>
                                    <td>{{$student->name}}</td>
                                    <td>{{$student->title}}</td>
                                    <td>{{$student->supervisor ? $student->supervisor->name : ""}}</td>
                                    <td>{{$student->start_date}}</td>
                                    <td>{{$student->end_date }}</td>
                                    <td>
                                            {{ csrf_field() }}
                                            <x-reading :sups="$sups" :sid="$student->user_id"></x-reading>
 
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

<script>
    document.getElementById('levelSelect').addEventListener('change', function () {
        const selectedLevelId = this.value;
        console.log('changed')
        if (selectedLevelId != 1) {
            // Redirect to the route with the selected level ID
            window.location.href = "{{ route('student-list', '') }}/${selectedLevelId}";
        }
    });
</script>

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
<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2" defer></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/custom/custom-form-select.js') }}"></script>
<script src="{{ asset('assets/js/javascript.js') }}" defer></script>
@endsection