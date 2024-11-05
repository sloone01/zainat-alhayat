<div class="widgetbar">
    <!-- Button trigger modal -->
    @isset($value)
    {{$value}}
    <button type="button" class="btn btn-primary-rgba" data-toggle="modal" data-target="#exampleModalCenter{{$cri_id}}"></i>Done</button>
    @else
    <button type="button" class="btn btn-primary-rgba" data-toggle="modal" data-target="#exampleModalCenter{{$cri_id}}"></i>Start</button>
    @endisset

    <!-- Modal -->
    <div class="modal fade text-left" id="exampleModalCenter{{$cri_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle{{$cri_id}}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle{{$cri_id}}">Set Done</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('add-performance') }}">
                        {{ csrf_field()  }}
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            <input type="hidden" value="{{ $cri_id }}" name='criteria_id' class="form-control" name="id">
                            <input type="hidden" value="{{ $student_id }}" name='child_id' class="form-control" name="id">
                            <input type="hidden" value="{{ $class_id }}" name='class_id' class="form-control" name="id">
                                <label for="doctorname">Title</label>
                                <input type="text" name='title' @if($cri_type == 'N') readonly value="@isset($value) {{$value+1}} @else 1 @endisset" @endif class="form-control" id="doctorname">
                            </div>
                            @if($cri_type == 'D')
                            <div class="form-group col-md-6">
                                <label for="doctordegree">Date</label>
                                <input type="date" name='end_date' class="form-control" id="doctordegree">
                            </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary"></i>Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>