@section('title')
Zainat-Alhayat App - Incoming Tickets
@endsection
@extends('layouts.main')
@section('style')
<!-- DataTables css -->
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
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
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
                                    <th>Query Status</th>
                                    <th>Hold By</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td><a href="{{ url("single-ticket",$ticket->id) }}">{{$ticket->id}}</a> </td>
                                    <td>{{$ticket->getCreator->name}}</td>
                                    <td>{{$ticket->created_at}}</td>
                                    <td>{{$ticket->subject}}</td>
                                    <td>{{$ticket->problem->title}}</td>
                                    <td><span class="badge badge-pill badge-{{ $ticket->priority =='High' ? 'danger' : 'primary' }}">{{$ticket->priority}}</span></td>
                                    <td>{{$ticket->process_status}}</td>
                                    <td>{{$ticket->query_status}}</td>
                                    <td>{{ $ticket->process_by->name ?? '' }}</td>
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
@endsection
