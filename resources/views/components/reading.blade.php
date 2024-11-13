<div class="widgetbar">
    <!-- Button trigger modal -->
    
    
    <button type="button" class="btn btn-primary-rgba" data-toggle="modal" data-target="#exampleModalCenter{{$student_id}}"></i>Next</button>


    <!-- Modal -->
    <div class="modal fade text-left" id="exampleModalCenter{{$student_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Set Done</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('add-reading') }}">
                        {{ csrf_field()  }}

                    
                        <div class="form-row">
                            <div class="form-group col-md-11">
                                <label for="inputEmail4">Supervisor</label>
                                <select class="select2-multi-select" placeholer="Select" name="sup">
                                    @foreach($sups as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            <input type="hidden" value="{{ $student_id }}" name='child_id' class="form-control" name="id">
                                <label for="doctorname">Title</label>
                                <input type="text" name='title' class="form-control" id="doctorname">
                            </div>
                           
                            <div class="form-group col-md-6">
                                <label for="doctordegree">Start Date</label>
                                <input type="date" name='start_date' class="form-control" id="doctordegree">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="doctordegree">End Date</label>
                                <input type="date" name='end_date' class="form-control" id="doctordegree">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"></i>Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>