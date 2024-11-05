@section('title')
Log Book App - Home
@endsection
@extends('layouts.main')
@section('style')
<!-- Apex css -->
<link href="{{ asset('assets/plugins/apexcharts/apexcharts.css') }}" rel="stylesheet" type="text/css" />
<!-- jvectormap css -->
<link href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" type="text/css" />
<!-- Slick css -->
<link href="{{ asset('assets/plugins/slick/slick.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/slick/slick-theme.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('rightbar-content')

<!-- Start Breadcrumbbar -->
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Dashboard</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
        <div class="col-lg-12 col-xl-9">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12 col-xl-4">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h4>{{ $data['all_tickets']  }}<i class="feather icon-arrow-up text-success ml-1"></i></h4>
                                    <p class="font-14 mb-0">Logs</p>
                                </div>
                                <div class="col-5 text-right">
                                    <div id="apex-area1-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End col -->
                <!-- Start col -->
                <div class="col-lg-12 col-xl-4">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h4>{{ $data['closed_tickets']  }}<i class="feather icon-arrow-down text-danger ml-1"></i></h4>
                                    <p class="font-14 mb-0">Closed Tickets</p>
                                </div>
                                <div class="col-5">
                                    <div id="apex-area2-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End col -->
                <!-- Start col -->
                <div class="col-lg-12 col-xl-4">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h4>{{ $data['pending_tickets']  }}<i class="feather icon-arrow-up text-success ml-1"></i></h4>
                                    <p class="font-14 mb-0">Pending Tickets</p>
                                </div>
                                <div class="col-5">
                                    <div id="apex-area3-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End col -->
                <!-- Start col -->
                <div class="col-lg-12 col-xl-6">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h5 class="card-title mb-0">New Leads</h5>
                                </div>
                                <div class="col-3">
                                    <div class="dropdown">
                                        <button class="btn btn-link p-0 font-18 float-right" type="button" id="newLeads" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-horizontal-"></i></button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="newLeads">
                                            <a class="dropdown-item font-13" href="#">Refresh</a>
                                            <a class="dropdown-item font-13" href="#">Export</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pl-0 py-0">
{{--                           {!! $chart->container() !!}--}}
                        </div>
                    </div>
                </div>
                <!-- End col -->
                <!-- Start col -->
                <div class="col-lg-12 col-xl-6">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h5 class="card-title mb-0">Ticket Status</h5>
                                </div>
                                <div class="col-3">
                                    <div class="dropdown">
                                        <button class="btn btn-link p-0 font-18 float-right" type="button" id="ticketStatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-horizontal-"></i></button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ticketStatus">
                                            <a class="dropdown-item font-13" href="#">Refresh</a>
                                            <a class="dropdown-item font-13" href="#">Export</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                        <div class="card-body crm-tab-widget">--}}
{{--                            <div class="row align-items-center">--}}
{{--                                <div class="col-12 col-sm-5 p-0">--}}
{{--                                    <div class="nav flex-column nav-pills" id="v-pills-ticket-tab" role="tablist" aria-orientation="vertical">--}}
{{--                                        <a class="nav-link active" id="v-pills-support-tab" data-toggle="pill" href="#v-pills-support" role="tab" aria-controls="v-pills-support" aria-selected="true"><i class="feather icon-circle font-12 mr-1"></i>Support<span class="float-right font-14 text-muted">50</span></a>--}}
{{--                                        <a class="nav-link" id="v-pills-sales-tab" data-toggle="pill" href="#v-pills-sales" role="tab" aria-controls="v-pills-sales" aria-selected="false"><i class="feather icon-circle font-12 mr-1"></i>Sales<span class="float-right font-14 text-muted">65</span></a>--}}
{{--                                        <a class="nav-link" id="v-pills-product-tab" data-toggle="pill" href="#v-pills-product" role="tab" aria-controls="v-pills-product" aria-selected="false"><i class="feather icon-circle font-12 mr-1"></i>Product<span class="float-right font-14 text-muted">85</span></a>--}}
{{--                                        <a class="nav-link" id="v-pills-hiring-tab" data-toggle="pill" href="#v-pills-hiring" role="tab" aria-controls="v-pills-hiring" aria-selected="false"><i class="feather icon-circle font-12 mr-1"></i>Hiring<span class="float-right font-14 text-muted">32</span></a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-12 col-sm-7 p-0">--}}
{{--                                    <div class="tab-content" id="v-pills-ticket-tabContent">--}}
{{--                                        <div class="tab-pane fade show active" id="v-pills-support" role="tabpanel" aria-labelledby="v-pills-support-tab">--}}
{{--                                            <div id="apex-operation-status1-chart"></div>--}}
{{--                                        </div>--}}
{{--                                        <div class="tab-pane fade" id="v-pills-sales" role="tabpanel" aria-labelledby="v-pills-sales-tab">--}}
{{--                                            <div id="apex-operation-status2-chart"></div>--}}
{{--                                        </div>--}}
{{--                                        <div class="tab-pane fade" id="v-pills-product" role="tabpanel" aria-labelledby="v-pills-product-tab">--}}
{{--                                            <div id="apex-operation-status3-chart"></div>--}}
{{--                                        </div>--}}
{{--                                        <div class="tab-pane fade" id="v-pills-hiring" role="tabpanel" aria-labelledby="v-pills-hiring-tab">--}}
{{--                                            <div id="apex-operation-status4-chart"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>
        <!-- End col -->
        <!-- Start col -->
        <div class="col-lg-12 col-xl-3">
            <div class="card m-b-30">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <h5 class="card-title mb-0">Admins Details</h5>
                        </div>
                        <div class="col-3">
                            <div class="dropdown">
{{--                                <button class="btn btn-link p-0 font-18 float-right" type="button" id="widgetRevenue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-horizontal-"></i></button>--}}
{{--                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="widgetRevenue">--}}
{{--                                    <a class="dropdown-item font-13" href="#">Refresh</a>--}}
{{--                                    <a class="dropdown-item font-13" href="#">Export</a>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="user-slider">
                    @foreach($data['admins'] as $admin)
                    <div class="user-slider-item">
                        <div class="card-body text-center">
                            <span class="action-icon badge badge-primary-inverse">JD</span>
                            <h5>{{ $admin->name }}</h5>
                            <p>{{ $admin->email }}</p>
                            <p><span class="badge badge-primary-inverse">{{ $admin->name }}</span></p>
                            <div class="button-list mt-4">
                                <button type="button" class="btn btn-round btn-secondary-rgba"><i class="feather icon-phone"></i></button>
                                <button type="button" class="btn btn-round btn-secondary-rgba"><i class="feather icon-mail"></i></button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <!-- End col -->
    </div>
    <!-- End row -->
</div>
<script src="{{ \ArielMejiaDev\LarapexCharts\LarapexChart::cdn() }}"></script>
{!! $chart->script() !!}
<!-- End Contentbar -->
@endsection
@section('script')
<!-- Apex js -->

<script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/plugins/apexcharts/irregular-data-series.js') }}"></script>
<!-- jVector Maps js -->
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- Slick js -->
<script src="{{ asset('assets/plugins/slick/slick.min.js') }}"></script>
<!-- Custom Dashboard js -->
<script src="{{ asset('assets/js/custom/custom-dashboard.js') }}"></script>
@endsection
