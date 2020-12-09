
@php
use App\Http\Controllers\DentistController;
use Carbon\Carbon;
$dentist=new DentistController();
$appointmentInfo=$dentist->AllOppintments();
// $GetAppointments=$dentist->GetAppointments();
@endphp


<div class="appointements">
    <div class="container mainForm">
            <div class="row">
                <h3> <i class="far fa-calendar-check"></i> Appointments List</h3>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group flex-nowrap">
                        <div class="input-group-prepend">
                            <span class="input-group-text"
                            id="addon-wrapping"><i class="fas fa-search"></i></span>
                        </div>
                            <input type="text" class="form-control"
                            placeholder="Search" aria-label="Search"
                            aria-describedby="addon-wrapping"/>
                    </div>
                </div>
                <div class="col-md-4 offset-md-2">
                    <button class="btn" data-toggle="modal" data-target="#addAppointment">Add Appointment</button>
                </div>
            </div>
            <div class="alert alert-danger" id="delete_appoint" style="display: none;">  
                <h5><i class="fas fa-exclamation-triangle"></i>  The appointment was deleted</h5>
           </div>
            <div class="row rowHeader">
                <div class="col-md-1">No.</div>
                <div class="col-md-2">Patient Name</div>
                <div class="col-md-2">Date</div>
                <div class="col-md-2">Time</div>
                <div class="col-md-2">Note</div>
                <div class="col-md-1">Update</div>
                <div class="col-md-1">Delete</div>
            </div>

        <div class="allitems">
            @foreach ($appointmentInfo as $indx=>$item)
                <div class="row appointmentRow{{$item->id}}">
                    <div class="col-md-1">{{$indx+1}}</div>
                    <div class="col-md-2">{{$item->patientName}}</div>
                    <div class="col-md-2">{{Carbon::parse($item->date)->format('d.M.Y')}}</div>
                    <div class="col-md-2">{{Carbon::createFromFormat('H:i:s', $item->time)->format('h:i a')}}</div>
                    <div class="col-md-2">{{$item->note}}</div>
                    <div class="col-md-1">
                       <button class="btn" type="submit" data-toggle="modal" data-target="#editOppointment{{$item->id}}">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div class="col-md-1">
                        <form  method="POST">
                            @csrf
                            <button class="btn delete_appointment" appoint_id={{$item->id}}>
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @foreach ($appointmentInfo as $indx=>$item)
     <!-- Start Edit Appointment Modal -->
        <div class="modal fade" id="editOppointment{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel2">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AppointmentTitle"><i class="far fa-calendar-check"></i>Edit Appointment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success success_appoint2{{$item->id}}"style="display: none;">
                            The Appointment was successfully Modified
                        </div>
                        
                    @foreach ($dentist->GetAppointments($item->id) as $indx=>$appoit)
                    <form class="editAppointment2{{$appoit->id}}" method="POST">
                            @csrf
                            <input type="text" style="display: none;" class="form-control" value="{{$appoit->id}}" name="appoint2_id">
                            <input type="text" name="patientName2" class="form-control" required value="{{$item->patientName}}">
                            <input type="date" name="date2" class="form-control"value="{{$appoit->date}}" required>
                            <input type="time" name="time2" class="form-control" value="{{$appoit->time}}" required>
                            <input type="text" name="note2" class="form-control" value="{{$appoit->note}}" required>
                            <button  class="btn btn-block editAppoint2{{$appoit->id}}">Edit Appointment</button>
                    </form>
                    @endforeach
                    </div>  
                </div>
            </div>
        </div>
    <!-- End Edit Appointment Modal -->
    @endforeach
 <!-- Start Add Appointment Modal -->
 {{-- <div class="modal fade" id="addOppointment" tabindex="-1" aria-labelledby="exampleModalLabel2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AppointmentTitle"><i class="far fa-calendar-check"></i>Add Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success success_appoint"style="display: none;">
                    <i class="fas fa-check-circle"></i> Appointment was successfully Added
                </div>
                <form  method="POST" class="appointForm">
                    @csrf
                    <input type="text" style="display: none;" class="form-control" value="0" name="appoint_id">
                    <input type="text" name="patientName" class="form-control" placeholder="Patient Name" required>
                    <input type="date" name="date" class="form-control" placeholder="Date" required>
                    <input type="time" name="time" class="form-control" placeholder="Time" required>
                    <input type="text" name="note" class="form-control" placeholder="Note" required>
                    <button class="btn btn-block ajaxApointment1">Add Appointment</button>
                </form>
            </div>  
        </div>
    </div>
</div> --}}
<!-- End Add Appointment Modal -->

</div>
