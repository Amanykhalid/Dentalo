@php
    use App\Http\Controllers\DentistController;
    $var=new DentistController();
    $clinics=$var->ClinicInfo();
    $userInfo=$var->UserInfo();

@endphp

<div class="dentistProfile">
    <form action="editProfile" method="POST" enctype="multipart/form-data">
    <div class="row">
        @csrf
        <div class="offset-md-1 col-md-5">
            <h4> <i class="fas fa-address-card"></i> My Information</h4>
            <div class="divImg">
                <img src="../image/@foreach($userInfo as $user){{$user->photo}}@endforeach" alt="doctor"/><br>
                <input type="file" name="DoctorImg" id="DoctorImg" class="inputfile" />
                <label for="DoctorImg"><i class="fas fa-camera"></i></label>
            </div>
                <label>First Name:</label>
                <input type="text" name="FirstName" class="form-control" value="@foreach($userInfo as $user){{$user->firstName}}@endforeach">
                <label>Last Name:</label>
                <input type="text" name="LastName" class="form-control" value="@foreach($userInfo as $user){{$user->lastName }}@endforeach">
                <label>Email </label>
                <input type="email" name="Email" class="form-control" value="@foreach($userInfo as $user){{$user->email}}@endforeach">
        </div>
        <div class="col-md-5">
            <h4><i class="fas fa-clinic-medical"></i>Clinic Information</h4>
            <div class="divImg">
                <img src="../image/@foreach($clinics as $object){{$object->photo}}@endforeach" alt="doctor"/><br>
                <input type="file" name="fileImg" id="fileImg" class="inputfile" />
                <label for="fileImg"><i class="fas fa-camera"></i></label>
            </div>
                <label>Clinic Name:</label>
                <input type="text" name="ClinicName" class="form-control" value="@foreach($clinics as $object){{$object->clinicName}}
                @endforeach">
                <label>Clinic No:</label>
                <input type="text" name="ClinicNo" class="form-control" value="@foreach($clinics as $object){{$object->clinicPhone}}
            @endforeach">
                <label>Clinic Address </label>
                <input type="text" name="Address" class="form-control" value="@foreach($clinics as $object){{$object->clinicAddress}}
            @endforeach">
        </div>
        <button class="btn btn-block" type="submit"> Save Change</button>
    </div>
    </form>
</div>