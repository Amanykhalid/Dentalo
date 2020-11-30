
@php
use App\Http\Controllers\DentistController;
use Carbon\Carbon;

$dentist=new DentistController();
$appointmentInfo=$dentist->AllOppintments();
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
                    <button class="btn" data-toggle="modal" data-target="#addOppointment">Add Appointment</button>
                </div>
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
                <div class="row">
                    <div class="col-md-1">{{$indx+1}}</div>
                    <div class="col-md-2">{{$item->patientName}}</div>
                    <div class="col-md-2">{{Carbon::parse($item->date)->format('d.M.Y')}}</div>
                    <div class="col-md-2">{{Carbon::parse($item->time)->format('h:m a')}}</div>
                    <div class="col-md-2">{{$item->note}}</div>
                    <div class="col-md-1">
                        <form action="/editAppoint/{{$item->id}}"></form>
                        @csrf
                       <button class="btn" type="submit" data-toggle="modal" data-target="#addOppointment{{$item->id}}">
                            <input type="text" name="id" value="{{$item->id}}" style="display: none">

                            <i class="fas fa-edit"></i>
                        </button>
                       <!-- Start Edit Appointment Modal -->
                        <div class="modal fade" id="addOppointment{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel2">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="AppointmentTitle"><i class="far fa-calendar-check"></i>Edit Appointment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="/editAppointment/{{$item->id}}" method="POST">
                                            @csrf
                                            <input type="text" name="patientName" class="form-control" required value="{{$item->patientName}}">
                                            <input type="date" name="date" class="form-control"value="{{$item->date}}" required>
                                            <input type="time" name="time" class="form-control" value="{{$item->time}}" required>
                                            <input type="text" name="note" class="form-control" value="{{$item->note}}" required>
                                            <button type="submit" class="btn btn-block">Edit Appointment</button>
                                        </form>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <!-- End Edit Appointment Modal -->
                    </div>
                    <div class="col-md-1">
                        <form action="/deleteappointment" method="POST">
                            @csrf
                            <button class="btn" type="submit">
                                <input type="text" name="appoint2" value="{{$item->id}}" style="display: none">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
 <!-- Start Add Appointment Modal -->
 <div class="modal fade" id="addOppointment" tabindex="-1" aria-labelledby="exampleModalLabel2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AppointmentTitle"><i class="far fa-calendar-check"></i>Add Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/addAppointment/0" method="POST">
                    @csrf
                    <input type="text" name="patientName" class="form-control" placeholder="Patient Name" required>
                    <input type="date" name="date" class="form-control" placeholder="Date" required>
                    <input type="time" name="time" class="form-control" placeholder="Time" required>
                    <input type="text" name="note" class="form-control" placeholder="Note" required>
                    <button type="submit" class="btn btn-block">Add Appointment</button>
                </form>
            </div>  
        </div>
    </div>
</div>
<!-- End Add Appointment Modal -->

</div>
