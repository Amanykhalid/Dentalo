@php
use App\Http\Controllers\DentistController;
$dentist=new DentistController();
$allPatients=$dentist->allPatients();
// $photos=$dentist->AllPhoto();
$red="red"; $green="green" ; 
$blue="blue" ; $yellow="yellow" ; $purple="purple";
@endphp

<div class="patientsList">
    <div class="container mainForm">
        <div class="row">
            <h3> <i class="fas fa-user-injured"></i> Patients List</h3>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="input-group flex-nowrap">
                        <div class="input-group-prepend">
                            <span class="input-group-text"
                            id="addon-wrapping"><i class="fas fa-search"></i>
                            </span>
                        </div>
                    <input type="text" class="form-control"
                        placeholder="Search" aria-label="Search"
                        id="myInput"
                        aria-describedby="addon-wrapping" name="search"
                        onkeyup="myFunction()"
                    />
                
                </div>
                </form>
            </div>
            <div class="col-md-4 offset-md-2">
                <button class="btn" data-toggle="modal" data-target="#addPatient">Add Patient</button>
            </div>
        </div>
        <div class="alert alert-danger" id="delete_msg" style="display: none;">  
            <h5><i class="fas fa-exclamation-triangle"></i>  The patient was deleted</h5>
       </div>
        <div class="row rowHeader">
            <div class="col-md-1">No.</div>
            <div class="col-md-2">Patient Name</div>
            <div class="col-md-2">Note</div>
            <div class="col-md-2">Contact-No</div>
            <div class="col-md-2">address</div>
            <div class="col-md-1">Update</div>
            <div class="col-md-1">Delete</div>
        </div>
        <div class="allitems mainForm"  id="myUL" >
            @foreach ($allPatients as $indx=>$item)
                <div class="row patientRow{{$item->id}}" id="PatientClass">
                    <div class="col-md-1">{{$indx+1}}</div>
                    <div class="col-md-2 patientdetials" data-toggle="modal" data-target="#PatientDetials{{$item->id}}" id="PatientName">
                         {{$item->firstName}}  {{$item->LastName}}
                    </div>
                    <div class="col-md-2">{{$item->note}}</div>
                    <div class="col-md-2">{{$item->contactNo}}</div>
                    <div class="col-md-2">{{$item->address}}</div>
                    <div class="col-md-1">
                            <button class="btn" type="submit" data-toggle="modal" data-target="#editPatient{{$item->id}}">
                              <i class="fas fa-edit"></i>
                            </button>
                    </div>
                    <div class="col-md-1">
                        <form action="/deletePatient" method="POST">
                            @csrf
                            <button class="btn delete_patient" patient_id="{{$item->id}}"  type="submit">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            <!-- Start Edit Patient Modal -->
                  <div class="modal fade" id="editPatient{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel2">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-user-injured"></i> Edit Patient</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-success success_edit{{$item->id}}"style="display: none;">
                                    The patient was successfully modified
                                </div>
                                <div class="alert alert-danger field_edit"  style="display: none;">
                                    Patient modification failed
                                </div>
                            <form  method="POST" class="PatientFormUpdate{{$item->id}}" enctype="multipart/form-data">
                                @csrf
                                <input type="text" style="display: none;" class="form-control" value="{{$item->id}}" name="patient_id">
                                <input type="text" name="firstName" class="form-control" required value="{{$item->firstName}} {{$item->MiddleName}} {{$item->LastName}}">
                                <input type="text" name="note" class="form-control"value="{{$item->note}} " required>
                                <input type="text" name="contactNo" class="form-control" value="{{$item->contactNo}}" required>
                                <input type="text" name="address" class="form-control" value="{{$item->address}}" required>
                                <input type="date" name="birthDay" class="form-control" value="{{$item->birthDay}}" required>
                                <div class="genderform form-control">
                                    <label for="gemder">Gender</label>
                                    <input type="radio" name="gender" value="male" @if ($item->gender=="male")
                                    checked
                                    @endif >
                                        Male
                                    <input  type="radio" name="gender" value="female" @if ($item->gender=="female")
                                    checked
                                    @endif >
                                        Female
                                </div>
                                <input type="email" name="email" class="form-control" value="{{$item->email}}" required>
                                    <button  class="btn btn-block update_patient{{$item->id}}">Edit Patient</button>
                            </form>
                            </div>  
                        </div>
                    </div>
                </div>
            <!-- End Edit Patient Modal -->
              
                <!-- Start Edit Patient Detials Modal -->
                   <div class="modal fade" id="PatientDetials{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel3">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-user-injured"></i> Edit Patient</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body patients">
                                <button 
                                type="submit" class="btn btn-block" data-toggle="modal" data-target="#Chart{{$indx+1}}"><i class="fas fa-teeth-open"></i>
                                Dental Chart
                                </button> 
                                <button type="submit" class="btn btn-block" data-toggle="modal" data-target="#Medical{{$indx+1}}"><i class="fas fa-file-medical-alt"></i>  Medical History
                                </button>
                                <button type="submit" class="btn btn-block" data-toggle="modal" data-target="#Prescription{{$indx+1}}"><i class="fas fa-prescription-bottle-alt"></i>  Prescription</button>
                                <button type="submit" class="btn btn-block" data-toggle="modal" data-target="#Appointments{{$indx+1}}"><i class="fas fa-calendar-check"></i> Appointments</button>
                                <button type="submit" class="btn btn-block" data-toggle="modal" data-target="#Photos{{$indx+1}}"><i class="fas fa-image"></i>  Photos</button>
                                <button type="submit" class="btn btn-block" data-toggle="modal" data-target="#Payments{{$indx+1}}"><i class="fas fa-money-bill-alt"></i> Payments</button>
                            </div>  
                        </div>
                    </div>
                   </div>
                <!-- End Edit Patient Detials Modal -->
            @endforeach
        
            @foreach ($allPatients as $indx=>$item)
            {{-- Start Add Payments  --}}
                   <div class="modal fade" id="Payments{{$indx+1}}" tabindex="-1" aria-labelledby="exampleModalLabel3">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-user-injured"></i> Add Payment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <form 
                                @if ($dentist->AllPayment($item->id)->isEmpty())
                                    action="/addPayments/{{$item->id}}"
                                @else 
                                    action="/editPayments/{{$item->id}}"
                                @endif
                                    method="POST"
                            >
                                @csrf
                                @if ($dentist->AllPayment($item->id)->isEmpty())
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="date">
                                            Date of payment :
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" name="date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="total">
                                            Total Amount to pay :
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" name="total" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="paid">
                                            What did patient paid :
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" name="paid" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="remark">
                                            Remarks :
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="remarks" class="form-control" required>
                                    </div>
                                </div>
                                <button class="btn btn-block">Add Payment</button>
                                @else
                                @foreach ($dentist->AllPayment($item->id) as $pay)
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="date">
                                            Date of payment :
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                    <input type="date" name="date" value="{{$pay->date}}"  class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="total">
                                            Total Amount to pay :
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" name="total" value="{{$pay->Total}}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="paid">
                                            What did patient paid :
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" name="paid" value="{{$pay->paid}}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="remark">
                                            Remarks :
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="remarks" value="{{$pay->Remarks}}" class="form-control" required>
                                    </div>
                                </div>
                                <button class="btn btn-block">Edit Payment</button>
                                @endforeach 
                                @endif

                            </form>
                            </div>  
                        </div>
                    </div>
                  </div>
            {{-- End Add Payments  --}}
            @endforeach

            @foreach ($allPatients as $index=>$item)
            {{-- Start Add Photo  --}}
                <div class="modal fade" id="Photos{{$index+1}}" tabindex="-1" aria-labelledby="exampleModalLabel3">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-user-injured"></i> Add X_Ray</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body Photo">
                                <form
                                    enctype="multipart/form-data"
                                    action="addPhoto/{{$item->id}}"
                                    method="POST"
                                >
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="photoRay">x-Ray Photo</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="divImg">
                                            <input type="file" name="photo" id="photo{{$index}}" class="form-control inputfile" required>
                                            <label for="photo{{$index}}"><i class="fas fa-camera"></i> Add Photo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="note"> Note </label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="note" class="form-control" required>
                                        </div>
                                    </div>
                                    <button class="btn btn-block" type="submit"> Add Photo</button> 
                                </form>
                                <button class="btn btn-block"  data-toggle="modal" data-target="#ShowPhoto{{$index}}"> Show Photos</button>                       

                               
                            </div>  
                        </div>
                    </div>
                </div>
            {{-- End Add Photo  --}}
            @endforeach

            @foreach ($allPatients as $index=>$item)
            {{-- Start Show X-Ray Photos  --}}
                <div class="modal fade" id="ShowPhoto{{$index}}" tabindex="-1" aria-labelledby="exampleModalLabel3">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
								<h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-user-injured"></i> X-Ray </h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body ShowPhoto">
								@if (!$dentist->AllPhoto($item->id)->isEmpty())
								<ul class="nav nav-tabs" id="myTab" role="tablist">
									@foreach ($dentist->AllPhoto($item->id) as $index=>$photo)
										<li class="nav-item @if($index==0) active @endif" role="presentation">
                                            <a id="photoXRay{{$index+1}}" data-toggle="tab" href="#photoRay{{$photo->id}}"      role="tab"
										    @if ($index==0)
											class="active"	
											@endif 
										    >
                                                Photo {{$index+1}}
										    </a>
										</li>	
									@endforeach
								</ul>
								<div class="tab-content"  id="myTabContent">
									@foreach ($dentist->AllPhoto($item->id) as $i=>$photoXRay)
										<div class="tab-pane fade @if($i==0) show active @endif " id="photoRay{{$photoXRay->id}}" role="tabpanel">
											<div class="row">
												<div class="col-md-8"><img src="../image/{{$photoXRay->xRay}}" alt="x-ray"></div>
												<div class="col-md-4"><p>{{$photoXRay->note}}</p></div>
											</div>
										</div>
								@endforeach
								</div>
								@else 
								<p>No Photos added</p>
								@endif
								
							</div>   
                        </div>
                    </div>
                </div>
            {{-- End Show X-Ray Photos  --}}
            @endforeach

            @foreach ($allPatients as $indx=>$item)
            {{-- Start Add Appointments  --}}
                <div class="modal fade" id="Appointments{{$indx+1}}" tabindex="-1" aria-labelledby="exampleModalLabel2">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="AppointmentTitle"><i class="far fa-calendar-check"></i>Add Appointment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-success success_appoint{{$item->id}}"style="display: none;">
                                    The Appointment was successfully Added
                                </div>
                            <form 
                                method="POST"
                                @if ($dentist->AppointmentInfo($item->id)->isEmpty())
                                    class="appointForm1"
                                @else 
                                @endif
                                    class="appointEditForm{{$item->id}}"
                            >
                                @csrf
                                @if ($dentist->AppointmentInfo($item->id)->isEmpty())
                                @foreach ($dentist->PatientInfo($item->id) as $Pat)
                                    <input type="text" name="patientName2"
                                            value="{{$Pat->firstName}} {{$Pat->LastName}}"
                                        class="form-control" placeholder="Patient Name" required
                                    >
                                    <input type="text" style="display: none;" class="form-control" value="{{$Pat->id}}" name="appoint_id">
                                @endforeach
                                    <input type="date" name="date2" class="form-control" placeholder="Date" required>
                                    <input type="time" name="time2" class="form-control" placeholder="Time" required>
                                    <input type="text" name="note2" class="form-control" placeholder="Note" required>
                                    <button  class="btn btn-block ajaxApointment3">Add Appointment</button>
                                @else
                                    @foreach ($dentist->AppointmentInfo($item->id) as $appoint)
                                    <input type="text" style="display: none;" class="form-control" value="{{$item->id}}" name="appoint_id_edit">
                                        <input type="text" name="patientName"
                                            value="{{$appoint->patientName}}"
                                            class="form-control" placeholder="Patient Name" required
                                        >
                                        <input type="date" name="date" class="form-control" placeholder="Date"    value="{{$appoint->date}}" required>
                                        <input type="time" name="time" class="form-control" placeholder="Time" value="{{$appoint->time}}" required>
                                        <input type="text" name="note" class="form-control" placeholder="Note" value="{{$appoint->note}}"required>
                            <button type="submit" class="btn btn-block appointEdit{{$item->id}}">Edit Appointment</button>
                                    @endforeach
                                @endif
                            </form>
                            </div>  
                        </div>
                    </div>
                </div>
            {{-- End Add Appointments  --}}
            @endforeach
            
            @foreach ($allPatients as $indx=>$item)
            {{-- Start Medical History  --}}
              <div class="modal fade" id="Medical{{$indx+1}}" tabindex="-1"  aria-labelledby="exampleModalLabel2">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-user-injured"></i> Medical History</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-success success_Medical{{$item->id}}" style="display: none;">  
                                <i class="fas fa-check-circle"></i> Added New Medical History Success
                            </div>
                            <div class="alert alert-success success_edit_Medical{{$item->id}}" style="display: none;">  
                                <i class="fas fa-check-circle"></i> Edit Medical History Success
                            </div>
                            @if($dentist->getMecial($item->id)->isEmpty())
                            <form action="POST" class="addMedical{{$item->id}}">
                                @csrf
                                <div class="row">
                                    <input type="text" style="display: none;" class="form-control" value="{{$item->id}}" name="patient_id">
                                    <textarea name="medicalHesitory" class="form-control" required cols="30" rows="5"></textarea>
                                </div>
                                <button class="btn btn-bolck add_History{{$item->id}}"> Add Medical Hestoriy</button>
                            </form>
                            @else
                            @foreach ($dentist->getMecial($item->id) as $medical)
                            <form action="POST" class="editMedical{{$medical->patientId}}">
                                @csrf
                                <div class="row">
                                    <input type="text" style="display: none;" class="form-control" value="{{$item->id}}" name="patient_id2">
                                    <textarea name="medicalHesitory2" class="form-control" required cols="30" rows="5">{{$medical->historyText}}
                                    </textarea>
                                </div>
                                <button class="btn btn-bolck Edit_History{{$medical->patientId}}"> Edit Medical Hestoriy</button>
                            </form>
                            @endforeach 
                            @endif
                        </div>  
                    </div>
                </div>
              </div>                                
            {{-- End Medical History  --}}
            @endforeach

            @foreach ($allPatients as $indx=>$item)
            {{-- Start Prescription  --}}
              <div class="modal fade" id="Prescription{{$indx+1}}" tabindex="-1" aria-labelledby="exampleModalLabel3">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-user-injured"></i>Prescription</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-success success_Prescription{{$item->id}}" style="display: none;">  
                                <i class="fas fa-check-circle"></i> Added New Prescription Success
                            </div>
                        @if ($dentist->allPrescription($item->id)->isEmpty())
                        <form class="addPrescription{{$item->id}}">
                            @csrf
                            <div class="row">
                                <input type="text" style="display: none;" class="form-control" value="{{$item->id}}" name="patient_id">
                                <div class="col-md-6">
                                    <label for="DrugsId">Drug Name :</label>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" name="DrugsId">
                                        @foreach ($dentist->allDrugs() as $item)
                                            <option value="{{$item->DrugName}}">{{$item->DrugName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="Quantity">Quantity :</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="Quantity" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="Duration">Duration :</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="Duration" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="DosageFrequancy">Dosage Frequancy :</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="DosageFrequancy" class="form-control">
                                </div>
                            </div>
                            <button class="btn btn-block add_Prescription{{$item->id}}"> Add Prescription</button>
                        </form>
                        @else
                        <div class="alert alert-success success_edit_Prescription{{$item->id}}"style="display: none;">
                            <i class="fas fa-check-circle"></i>The Prescription was successfully modified
                        </div>
                        @foreach ($dentist->allPrescription($item->id) as $pres)
                        <form class="EditPrescription{{$pres->patientId}}">
                            @csrf
                            <input type="text" style="display: none;" class="form-control" value="{{$item->id}}" name="patient_id2"> 
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="drugs">Drug Name :</label>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" name="DrugsId2">
                                        @foreach ($dentist->allDrugs() as $item)
                                            <option 
                                                value="{{$item->DrugName}}"
                                                @if($item->DrugName == $pres->DrugsId)
                                                selected
                                                @endif
                                            >
                                                {{$item->DrugName}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="drugs">Quantity :</label>
                                </div>
                                <div class="col-md-6">
                                <input type="number" name="Quantity2" class="form-control" value="{{$pres->Quantity}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="drugs">Duration :</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="Duration2" class="form-control" value="{{$pres->Duration}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="drugs">Dosage Frequancy :</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="DosageFrequancy2" class="form-control" value="{{$pres->DosageFrequancy}}">
                                </div>
                            </div>
                            <button class="btn btn-block Edit_Prescription{{$pres->patientId}}"> Edit Prescription</button> 
                        </form>
                        @endforeach
                        @endif                            
                        </div>  
                    </div>
                </div>
                </div>
            {{-- End  Prescription --}}
            @endforeach

            @foreach ($allPatients as $indx=>$item)
            {{-- Start Dental Chart  --}}
              <div class="modal fade" id="Chart{{$indx+1}}" tabindex="-1" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-user-injured"></i> Edit Patient</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body Chart">
                            <div class="mainChartImg">
                                <img src="../image/olderchart.png" alt="olderChart"/>
                                @for ($i = 0; $i < 32; $i++)
                                    <img src="../image/Ellipse65.png" alt="tooth"
                                        id="toothD{{$i}}" class="tooth" data-toggle="modal" 
                                        data-target="#chartNote{{$i}}{{$indx+1}}"
                                            @foreach ($dentist->getNote($item->id,$i) as $color)
                                                style="background-color:{{$color->Teethcolor}}"
                                            @endforeach                                       
                                    />
                                                                                
                                @endfor
                            </div>
                        </div> 
                        
                    </div>
                </div>
               </div>  
            {{-- End Dental Chart  --}}
            @endforeach

            @foreach ($allPatients as $indx=>$item)
            @for ($i = 0; $i < 32; $i++)
            {{-- Start Dental Note  --}}
             <div class="modal fade" id="chartNote{{$i}}{{$indx+1}}" tabindex="-5" aria-labelledby="exampleModalLabel3">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-user-injured"></i> Chart Note
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-success success_note{{$item->id}}{{$i}}" style="display: none;">  
                                <h5><i class="fas fa-check-circle"></i> Added New Note Success</h5>
                            </div>
                            <div class="alert alert-success success_edit_note{{$item->id}}{{$i}}"style="display: none;">
                                <i class="fas fa-check-circle"></i>The Note was successfully modified
                            </div>
                            <form 
                                method="POST"
                                @if ($dentist->getNote($item->id,$i)->isEmpty())
                                    class="addNote{{$item->id}}{{$i}}"
                                @else 
                                    class="EditNote{{$item->id}}{{$i}}"
                                @endif
                            >
                                @csrf
                                    @if ($dentist->getNote($item->id,$i)->isEmpty())
                                    <input type="text" style="display: none;" class="form-control" value="{{$item->id}}" name="patient_id_teeth">
                                    <input type="text" style="display: none;" class="form-control" value="{{$i}}" name="teeth_id">    
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="dateNote">Note Date :</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" name="noteDate2" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="Procedure">Procedure  :</label> 
                                            </div>
                                            <div class="col-md-6">
                                                <select name="Procedure" class="form-control">
                                                    @foreach ($dentist->allProcedures() as $Procedure)
                                                    <option value="{{$Procedure->ProcedureName}}">
                                                        {{$Procedure->ProcedureName}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="Teethcolor">Teeth color  :</label> 
                                            </div>
                                            <div class="col-md-6">
                                            <input name="Teethcolor" type ="radio" value = "{{$red}}"
                                            > 
                                                <i class="fas fa-square-full red" style="color: red"></i> 
                                                <input name="Teethcolor" type ="radio" value = "{{$green}}">
                                                    
                                                <i class="fas fa-square-full green" style="color: green"></i> 
                                                <input name="Teethcolor" type ="radio" value = "{{$blue}}"
                                                    >
                                                <i class="fas fa-square-full blue" style="color: blue"></i> 
                                                <input name="Teethcolor" type ="radio" value = "{{$yellow}}"
                                                >
                                                <i class="fas fa-square-full yellow" style="color: yellow"></i> 
                                                <input name="Teethcolor" type ="radio" value = "{{$purple}}"
                                                    >
                                                <i class="fas fa-square-full Purple" style="color: purple"></i> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="Note">Note  :</label> 
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="Note2" required class="form-control">
                                            </div>
                                        </div>
                                    <button class="btn btn-block add_Note_Chart{{$item->id}}{{$i}}">
                                            Add Note
                                        </button>
                                    @else
                                        @foreach ($dentist->getNote($item->id,$i) as $tooth)
                                        <input type="text" style="display: none;" class="form-control" value="{{$item->id}}" name="patient_id_teeth_edit">
                                        <input type="text" style="display: none;" class="form-control" value="{{$i}}" name="teeth_id_edit">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="dateNote3">Note Date :</label>
                                                </div>
                                                <div class="col-md-6">
                                                <input type="date" name="noteDate3" value="{{$tooth->noteDate}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="Procedure3">Procedure  :</label> 
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="Procedure3" class="form-control">
                                                        @foreach ($dentist->allProcedures() as $Procedure)
                                                        <option value="{{$Procedure->ProcedureName}}" name="Procedure3"
                                                            @if ($Procedure->ProcedureName == $tooth->Procedure)
                                                            selected
                                                            @endif
                                                        >
                                                            {{$Procedure->ProcedureName}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="Teethcolor2">Teeth color  :</label> 
                                                </div>
                                                <div class="col-md-6">
                                                <input name="Teethcolor2" type ="radio" value = "{{$red}}"
                                                    @if ($tooth->Teethcolor==$red)
                                                        checked
                                                    @endif 
                                                > 
                                                    <i class="fas fa-square-full red" style="color: red"></i> 
                                                    <input name="Teethcolor2" type ="radio" value = "{{$green}}"
                                                        @if ($tooth->Teethcolor==$green)
                                                            checked
                                                        @endif 
                                                    >
                                                        
                                                    <i class="fas fa-square-full green" style="color: green"></i> 
                                                    <input name="Teethcolor2" type ="radio" value = "{{$blue}}"
                                                        @if ($tooth->Teethcolor==$blue)
                                                        checked
                                                        @endif 
                                                    >
                                                    <i class="fas fa-square-full blue" style="color: blue"></i> 
                                                    <input name="Teethcolor2" type ="radio" value = "{{$yellow}}"
                                                        @if ($tooth->Teethcolor==$yellow)
                                                        checked
                                                        @endif 
                                                    >
                                                    <i class="fas fa-square-full yellow" style="color: yellow"></i> 
                                                    <input name="Teethcolor2" type ="radio" value = "{{$purple}}"
                                                        @if ($tooth->Teethcolor==$purple)
                                                            checked
                                                        @endif 
                                                    >
                                                    <i class="fas fa-square-full Purple" style="color: purple"></i> 
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="Note3">Note  :</label> 
                                                </div>
                                                <div class="col-md-6">
                                                <input type="text" name="Note3" value="{{$tooth->Note}}" class="form-control">
                                                </div>
                                            </div>
                                            <button class="btn btn-block Edit_note{{$item->id}}{{$i}}" >
                                                Edit Note
                                            </button>
                                        @endforeach
                                    @endif                    
                            </form>
                        </div>  
                    </div>
                </div>
             </div>
            {{-- End Dental Note  --}} 
            @endfor
            @endforeach 
          
        </div>
        <script>
            function myFunction() {
                var input, filter, ul, li, a, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                ul = document.getElementById("myUL");
                PatientClass=ul.document.getElementById('PatientClass')
                for (i = 0; i < PatientClass.length; i++) {
                    a = PatientClass[i].getElementById("PatientName")[0];
                    txtValue = a.textContent || a.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        li[i].style.display = "";
                    } else {
                        li[i].style.display = "none";
                    }
                }
            }
        </script>
    </div>
        
</div>