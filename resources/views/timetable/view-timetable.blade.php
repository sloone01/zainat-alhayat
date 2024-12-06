@section('title') 
Zainat-Alhayat - Timetables
@endsection 
@extends('layouts.main')
@section('style')
<!-- Dragula css -->
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/plugins/dragula/dragula.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/code-mirror/codemirror.css') }}" rel="stylesheet" type="text/css">
@endsection 
@section('rightbar-content')
<!-- Start Breadcrumbbar -->                    
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">Timetables</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Timetables</a></li>
                </ol>
            </div>
        </div>
        
    </div>          
</div>
<!-- End Breadcrumbbar -->
<!-- Start Contentbar -->    
<div class="contentbar">

<form method="post" action="{{ route('search-timetable') }}">
    {{ csrf_field()  }}
    <div class="row"> 
        <div class="form-group col-md-4">
            <label for="doctordegree">Date</label>
            <input type="date" name='table_date' value="{{ $timetable->start_date }}" class="form-control" id="doctordegree">
        </div>


        <div class="form-group col-md-4">
            <label for="inputEmail4">Classes</label>
            <select class="select2-multi-select" name='class_id' placeholer="Select">
                <option>Select..</option>
                @foreach($classes as $class)
                <option  @if($timetable->level_id == $class->id) selected @endif @isset($filters) @if(in_array($class->id,$filters['classes'])) @endif @endisset value="{{ $class->id }}">{{ $class->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-1">
            <label for="inputEmail4">بحث</label>
            <button type="submit" name="action" value="noprint" class="btn btn-primary">Search</button>
        </div>
    </div>
</form>
    <!-- Start row -->
    <div class="row"> 
    @php
        $days = [
            1 => 'Sunday',
            2 => 'Monday',
            3 => 'Tuesday',
            4 => 'Wedensday',
            5 => 'Thursday',
        ];
    @endphp

    @foreach ($days as $key => $value)
        <div class="col-lg-2 col-xl-2">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ $value }}</h5>
                </div>
                <div class="card-body">
                
                @foreach($sessions->where('day',$key) as $session)
                    <div id="kanban-board-one">
                        <div class="card bg-primary-rgba m-b-20">
                            <div class="card-body">
                                <div class="row align-items-center mb-3">
                                    <div class="col-8">
                                        <div class="kanban-tag">
                                            <h5 class="mb-0">{{ $session->title }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <div class="kanban-comment">
                                            <p>{!! nl2br(e($session->description)) !!}</p>
                                            <span class="font-14">{{ $session->start_time }} -> {{ $session->end_time }}
                                            <x-delete-session :sups="$sups" :session="$session"></x-delete-session>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                    {{ csrf_field() }}
                    <x-add-session :sups="$sups" :day="$key" :timetable="$timetable->id"></x-add-session>
                    
                </div>
            </div>
        </div> 
    @endforeach
    </div>
    <!-- End row --> 
</div>
<!-- End Contentbar -->
@endsection 
@section('script')
<!-- Dragula js -->
<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
<!-- Summernote JS -->
<script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/dragula/dragula.min.js') }}"></script>
<script src="{{ asset('assets/js/custom/custom-kanban.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/custom/custom-form-select.js') }}"></script>
<script src="{{ asset('assets/js/javascript.js') }}" defer></script>

<script src="{{ asset('assets/plugins/code-mirror/codemirror.js') }}"></script>
<script src="{{ asset('assets/plugins/code-mirror/htmlmixed.js') }}"></script>
<script src="{{ asset('assets/plugins/code-mirror/css.js') }}"></script>
<script src="{{ asset('assets/plugins/code-mirror/javascript.js') }}"></script>
<script src="{{ asset('assets/plugins/code-mirror/xml.js') }}"></script>
<script src="{{ asset('assets/js/custom/custom-form-editor.js') }}"></script>
@endsection 