
@php
use App\Http\Controllers\DentistController;
$dentist=new DentistController();
$numberAppointment=$dentist->AppintmentNumber();
$numberPatient=$dentist->PatientNumber();
$userInfo=$dentist->userInfo();
$appointments=$dentist->AppointmentTody();
@endphp

<div class="dentistHome">
    <div class="container">
        <h2>
            Welcome Dr. @foreach ($userInfo as $item){{$item->firstName}} {{$item->lastName}}@endforeach
            <button id="clickme"><i class="fas fa-arrow-down"></i></button>
        </h2>

        <div id="AllItems">
            <div class="row">
                <div class="col-md-3">
                    <div class="TotalPat">
                        <i class="fas fa-users"></i>
                        <h5>Total Patient :  <span>{{$numberPatient}}</span></h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="TotalPat">
                        <i class="fas fa-notes-medical"></i>
                    <h5> Appointments : <span>{{$numberAppointment}}</span> </h5>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="TotalPat">
                        <i class="fas fa-user-plus"></i><br>
                        <button 
                            class="btn" 
                            data-toggle="modal" 
                            data-target="#addAppointment">
                            Add Appointment
                        </button>
                        
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="TotalPat">
                        <i class="fas fa-notes-medical"></i><br>
                        <button 
                            class="btn"
                            data-toggle="modal" 
                            data-target="#addPatient">
                            Add Patient
                        </button>
                      @extends('component/addPatient')
                      @extends('component/addAppointment')

                    </div>
                </div>
            </div>
        </div>
        <div class="appoinmentList">
            <h3>Up-coming Appointments</h3>
            <div class="row appoHeader">
                <div class="col-md-3">No :</div>
                <div class="col-md-3">Patient Name :</div>
                <div class="col-md-3">Time :</div>
            <div class="col-md-3">Note :</div>
            </div>
            <div class="AllItem">
                @foreach ($appointments as $index=>$item)
                    <div class="row item">
                        <div class="col-md-3">{{$index+1}} -</div>
                            <div class="col-md-3">{{$item->patientName}} </div>
                            <div class="col-md-3">{{$item->time}} </div>
                            <div class="col-md-3">{{$item->note}} </div>
                        </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

