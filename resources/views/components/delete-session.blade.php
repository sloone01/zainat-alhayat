<div class="widgetbar">
    <!-- Button trigger modal -->
    <i data-toggle="modal" data-target="#EditModalCenter{{$session->id}}" class="feather icon-edit-2 mr-2"></i>
    <i onclick="window.location.href='{{ url("delete-session", $session['id']) }}'" class="feather icon-trash mr-2"></i>
    <i onclick="window.location.href='{{ url("add-session-file", $session['id']) }}'" class="feather icon-refresh-ccw mr-2"></i>
    <!-- Modal -->
    <div class="modal fade text-left" id="EditModalCenter{{$session->id}}" tabindex="-1" role="dialog" aria-labelledby="EditModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalCenterTitle">Edit Session</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('edit-session') }}">
                        {{ csrf_field()  }}
                    
                
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            <input type="hidden" value="{{ $session->id }}" name='session_id' class="form-control" name="id">
                                <label for="doctorname">Title</label>
                                <input type="text" name='title' value="{{ $session->title }}" class="form-control" id="doctorname">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="doctorname">Order</label>
                                <input type="number" name='order' value="{{ $session->order }}" class="form-control" id="doctorname">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="doctorname">Details</label>
                                <textarea
                                class="form-control"
                                id="content" 
                                name="details" 
                                rows="8" 
                                cols="50">{{$session->description}}</textarea>
                            </div>
                           
                            <div class="form-group col-md-6">
                                <label for="doctordegree">Start Time</label>
                                <input type="Time" name='start_time' value="{{ $session->start_time }}" class="form-control" id="doctordegree">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="doctordegree">End Time</label>
                                <input type="Time" name='end_time' value="{{ $session->end_time }}" class="form-control" id="doctordegree">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"></i>Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>