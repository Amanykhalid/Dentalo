
@php
use App\Http\Controllers\DentistController;
$var=new DentistController();
$clinics=$var->ClinicInfo();
$userInfo=$var->UserInfo();

@endphp
@extends('component/layout')
@section('contant')
@if (Session::has('user') && (session()->get('user')['userType']=='Dentist'))
{{-- @if ($error = Session::get('alert-success'))
	<div class="alert alert-success">
		{{ $error }}
	</div>
@endif
<form action="/logout">
    <button type="submit">
        logOut
    </button>
</form> --}}
<div class="dentistHome">

    <div class="row">
        <div class="col-md-3">
                
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item active" role="presentation">
                    <a id="home-tab" data-toggle="tab" href="#home" role="tab" class="active">
                        @foreach ($userInfo as $item)
                        <img src="../image/{{$item->photo}}" alt="Doctor">
                        @endforeach

                    </a> 
                </li>
                @foreach ($clinics as $item)
                    <h4><i class="fas fa-clinic-medical"></i>{{$item->clinicName}}</h4>
                @endforeach
                <li class="nav-item" role="presentation">
                    <a  id="Profile-tab" data-toggle="tab" href="#Profile" role="tab">
                        <i class="fas fa-user-md"></i>Profile
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a data-toggle="tab" href="#Drugs"  role="tab">
                        <i class="fas fa-pills"></i>Drugs List
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a data-toggle="tab" href="#Procedure"  role="tab">
                        <i class="fas fa-tooth"></i>Procedure List
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a data-toggle="tab" href="#Appoinments"  role="tab">
                        <i class="far fa-calendar-check"></i>My Appointments
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a data-toggle="tab" href="#Patient" role="tab">
                        <i class="fas fa-user-injured"></i>My Patient
                    </a>
                </li>
                <h4><i class="fas fa-cogs"></i>Setting</h4>
                <li class="nav-item" role="presentation">
                    <a href="#password" data-toggle="tab"  role="tab">
                        <i class="fas fa-lock-open"></i>Change Pasword
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-9">
            @if ($error = $errors->first('email'))
            <div class="alert alert-danger">
              <i class="fas fa-times-circle"></i>{{ $error }} 
            </div>
          @endif
            <div class="tab-content"  id="myTabContent">
                
                <div class="tab-pane fade" id="Profile" role="tabpanel">
                    {{ view('component/dentistProfile') }}
                </div>
               

                <div class="tab-pane fade" id="Drugs" role="tabpanel">
                    {{view('component/DrugsList')}}
                </div>

                <div class="tab-pane fade" id="Procedure" role="tabpanel">
                    {{view('component/procedures')}}
                </div>
               
                <div class="tab-pane fade" id="Appoinments" role="tabpanel">
                    {{view('component/appointments')}}
                </div>
                <div class="tab-pane fade" id="Patient" role="tabpanel" >
                    {{view('component/patientsList')}}
                </div>
                <div class="tab-pane fade" id="password" role="tabpanel">
                     {{view('component/changePassword')}}
                </div>
              
                <div class="tab-pane fade show active" id="home"  role="tabpanel">
                    {{ view('component/dentistHome') }}
                </div>
                
            </div>

        </div>
    </div>

</div>
@endif
@stop
@section('script')
@stop

