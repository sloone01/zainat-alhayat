@section('title')
    Soyuz - Single Product
@endsection
@extends('layouts.main')
@section('style')
    <!-- Slick css -->
    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/plugins/slick/slick.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/assets/plugins/slick/slick-theme.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('rightbar-content')
    <!-- Start Breadcrumbbar -->
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Single Ticket Details</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Tickets</a></li>
                        <li class="breadcrumb-item"><a href="#">Single Ticket</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Single Ticket</li>
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
            <div class="col-md-129 col-lg-12 col-xl-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9 col-lg-9 col-xl-9">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="media">
                                            <img class="align-self-center mr-3" src="/assets/images/users/men.svg" alt="Generic placeholder image">
                                            <div class="media-body">
                                                <h6 class="mt-0">{{ $ticket->getCreator->name }}</h6>
                                                <p class="text-muted mb-0">{{ $ticket->problem->title }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="open-email-head">
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">{{ $ticket->created_at }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <hr class="bg-secondary border-2 border-top border-secondary">
                                <div class="row">
                                    <div class="col-lg-9 col-xl-9">
                                        <p><span class="badge badge-light font-16">{{ $ticket->problem->title }}</span></p>
                                        <h2 class="font-22">{{ $ticket->subject }}</h2>
                                        <p class="mb-4">{!! $ticket->details !!}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-lg-3 col-xl-3">
                                <div class="card border-light m-b-30">
                                    <div class="card-header">Status</div>
                                    <div class="card-body">
                                        <span class="badge badge-success">{{ $ticket->process_status }}</span>
                                        <span class="badge badge-success">{{ $ticket->query_status }}</span>
                                        <span class="badge badge-success">{{ $ticket->assign_status }}</span>
                                        <span class="badge badge-success">{{ $ticket->resolving_type ?? '' }}</span>
                                        <span class="badge badge-success">{{ $ticket->process_by->name ?? '' }}</span>
                                        <span class="badge badge-success">{{ $ticket->updated_at }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Ticket Details</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="review-tab-line" data-toggle="tab" href="#review-line" role="tab" aria-controls="review-line" aria-selected="false"><i class="feather icon-file-text mr-2"></i>Discussion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="guide-tab-line" data-toggle="tab" href="#guide-line" role="tab" aria-controls="guide-line" aria-selected="false"><i class="feather icon-book-open mr-2"></i>Guide</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="defaultTabContentLine">
                            <div class="tab-pane fade show active" id="review-line" role="tabpanel" aria-labelledby="review-tab-line">
                                <div class="col-lg-12">
                                    <div class="email-rightbar">
                                        <div class="card email-open-box m-b-10">
                                            @foreach($ticket->ticketComments as $comment)
                                                <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="media">
                                                            <img class="align-self-center mr-3" src="/assets/images/users/men.svg" alt="Generic placeholder image">
                                                            <div class="media-body">
                                                                <h6 class="mt-0">{{ $comment->belong_to->name }}</h6>
                                                                <p class="text-muted mb-0">{{ $comment->belong_to->email }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="open-email-head">
                                                            <ul class="list-inline mb-0">
                                                                <li class="list-inline-item">{{ $comment->created_at }}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h6 class="mt-0"><span class="badge badge-success">{{ $comment->type }}</span></h6>
                                                       <p class="text-muted">{!! $comment->comment !!}</p>
                                                        @foreach($comment->inner_comments as $in_comment)
                                                            <div class="bg-secondary-rgba p-1" style="border:1px solid #ACADB0;">
                                                                <p>{{$in_comment->belong_to->name}}-{{$in_comment->created_at}}</p>
                                                                <h5 style="color: grey; margin: auto;">{{$in_comment->comment}}</h5>
                                                            </div>
                                                        @endforeach
                                                        @if($comment->type == 'Query')
                                                            <div class="chat-bottom">
                                                                <div class="chat-messagebar">
                                                                    <form action="{{ route('answer-query') }}" method="post">
                                                                         {{ csrf_field() }}
                                                                        <input type="hidden" name="sender" value="creator">
                                                                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                                                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span><i class="feather icon-email"></i></span>
                                                                            </div>
                                                                            <input type="text" name="answer" class="form-control" placeholder="Type a message..." aria-label="Text">
                                                                            <div class="input-group-append">
                                                                                <button class="btn btn-round btn-primary-rgba" type="submit" id="button-addonsend"><i class="feather icon-send"></i></button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @endif

                                                    </div>

                                                </div>
                                            </div>
                                                <hr class="bg-secondary border-2 border-top border-secondary">
                                            @endforeach
                                            <div class="col-lg-12">
                                                <div class="email-rightbar">
                                                    <div class="card m-b-30 bg-secondary-rgba">
                                                        <div class="card-header">
                                                            <h5 class="card-title">New Message</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <form method="post" action="{{ route('add-comment') }}">
                                                                {{ csrf_field()  }}
                                                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                                                <div class="form-group row">
                                                                    <div class="col-sm-12">
                                                                        <textarea name="comment" class="summernote"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row text-right">
                                                                    <div class="col-sm-12">
                                                                        <button type="submit" name="action" value="open" class="btn btn-primary-rgba my-1"><i class="feather icon-send mr-2"></i>Open Again</button>
                                                                        <button type="submit" name="action" value="close" class="btn btn-success-rgba my-1"><i class="feather icon-save mr-2"></i>Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="guide-line" role="tabpanel" aria-labelledby="guide-tab-line">
                                <ul>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Consectetur adipiscing elit</li>
                                    <li>Integer molestie lorem at massa</li>
                                    <li>Facilisis in pretium nisl aliquet</li>
                                    <li>Nulla volutpat aliquam velit
                                        <ul>
                                            <li>Phasellus iaculis neque</li>
                                            <li>Purus sodales ultricies</li>
                                            <li>Vestibulum laoreet porttitor sem</li>
                                            <li>Ac tristique libero volutpat at</li>
                                        </ul>
                                    </li>
                                    <li>Faucibus porta lacus fringilla vel</li>
                                    <li>Aenean sit amet erat nunc</li>
                                    <li>Eget porttitor lorem</li>
                                </ul>
                            </div>
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
    <!-- Slick js -->
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom-email.js') }}"></script>
    <script src="{{ asset('/assets/plugins/slick/slick.min.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/custom-ecommerce-single-product.js') }}"></script>
@endsection
