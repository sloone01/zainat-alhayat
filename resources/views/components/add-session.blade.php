@section('style')
                        <!-- Summernote css -->
<link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" type="text/css">
<!-- Code Mirror css -->
<link href="{{ asset('assets/plugins/code-mirror/codemirror.css') }}" rel="stylesheet" type="text/css">
@endsection

<div class="widgetbar">
    <!-- Button trigger modal -->

    <button type="button" class="btn btn-primary-rgba btn-block btn-lg font-16" data-toggle="modal" data-target="#exampleModalCenter{{$day}}"><i class="feather icon-plus mr-2"></i>Add</button>


    <!-- Modal -->
    <div class="modal fade text-left" id="exampleModalCenter{{$day}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Add Session</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('add-session') }}">
                        {{ csrf_field()  }}

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="hidden" value="{{ $day }}" name='day' class="form-control" name="id">
                                <label for="doctorname">Title</label>
                                <input type="text" name='title' class="form-control" id="doctorname">
                            </div>

                            <div class="form-group col-md-6">
                                <input type="hidden" value="{{ $timetable }}" name='timetable' class="form-control" name="id">
                                <label for="doctorname">Order</label>
                                <input type="number" name='order' class="form-control" id="doctorname">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="doctorname">Details</label>
                                <textarea
                                class="form-control"
                                id="content" 
                                name="details" 
                                rows="8" 
                                cols="50">{{ old('content', $content ?? '') }}</textarea>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="doctordegree">Start Time</label>
                                <input type="Time" name='start_time' class="form-control" id="doctordegree">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="doctordegree">End Time</label>
                                <input type="Time" name='end_time' class="form-control" id="doctordegree">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"></i>Save</button>

                        
                        
                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>