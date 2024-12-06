<div class="widgetbar">
    <!-- Button trigger modal -->
 
    @if($cri_type != 'N')
        @isset($value)
        <button type="button" data-toggle="modal" data-target="#exampleModalCenter{{$cri_id}}{{$student_id}}" class="btn btn-round btn-outline-success"><i class="feather icon-plus"></i></button>
        @else
        <button type="button" class="btn btn-primary-rgba" data-toggle="modal" data-target="#exampleModalCenter{{$cri_id}}{{$student_id}}"></i>Start</button>
        @endisset
    @endif

    <!-- Modal -->
    <div class="modal fade text-left" id="exampleModalCenter{{$cri_id}}{{$student_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle{{$cri_id}}" aria-hidden="true">
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
                                <input type="text" name='title' class="form-control" id="doctorname">
                            </div>
                            @if($cri_type == 'D')
                            <div class="form-group col-md-6">
                                <label for="doctordegree">Date</label>
                                <input type="date" name='end_date' class="form-control" id="doctordegree">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="doctordegree">Postpone Current</label>
                                <input type="checkbox" name='postpone' class="js-switch-primary" />
                            </div>
                            @endif
                            @if($cri_type == 'C')
                            <div class="form-group col-md-6">
                                <br><br>
                                <label for="doctordegree">is it completed?</label>
                                <input type="checkbox" name='completed' class="js-switch-primary" />
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