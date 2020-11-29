@php
	use App\Http\Controllers\Patient;
	use Carbon\Carbon;
	$patient=new Patient();
	$AllDentist=$patient->AllDentist();
	$patientInfo=$patient->patientInfo();
	$Appointments=$patient->Appointments();
	$medical=$patient->medical();
	$noteChart=$patient->noteChart();
	$Prescription=$patient->Prescription();
	$photos=$patient->photos();
    $payments=$patient->payments();
	
@endphp
@extends('component/layout')
@section('contant')
@if (Session::has('user') && (session()->get('user')['userType']=='Patient'))
<div class="patients">
	<div class="row">
		<div class="col-md-3 patientInfo">
			<div class="infoCard">
				<div class="imgClass">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item active" role="presentation">
							<a id="home-tab" data-toggle="tab" href="#home" role="tab" class="active">
								<img src="../image/{{session()->get('user')['photo'] }}"alt="patientImg"/>
							</a>
						</li>
						<li class="nav-item" role="presentation">
							<a id="profile-tab" data-toggle="tab" href="#profile" role="tab">
								<h5>WELCOME {{session()->get('user')['firstName'] }} </h5>
							</a>
						</li>
					</ul>
				</div>
				@if (!$patientInfo->isEmpty())
					@foreach ($patientInfo as $item)
					<p>{{$item->firstName}} {{$item->MiddleName}} {{$item->LastName}} <br/>
						{{ Carbon::parse($item->birthDay)->diff(now())->format('%y') }} years<br/>
						{{$item->address}}<br/>
						{{$item->contactNo}}
					</p>
					@endforeach
					
				@else 
				<p>No Patient Data Added</p>
				@endif

			</div>
			<div>
				<h5>Up-coming Appointment</h5>
				@if (!$Appointments->isEmpty())
					@foreach ($Appointments as $item)
					<div class="Upcoming">
						{{Carbon::parse($item->date)->format('d.M.Y')}}  |  {{Carbon::parse($item->time)->format('h:m a')}}
					</div>
					@endforeach
				@else 
				<div class="Upcoming">
					<p>No Appointment added</p>
				</div>
				@endif
			</div>
	    </div>
		<div class="col-md-9 patientDetails">
			<div class="tab-content"  id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
					<div class="container">
						<div class="row homeHeader">
							<div class="col-md-2">Image:</div>
							<div class="col-md-2">Name:</div>
							<div class="col-md-2">Clinic Name:</div>
							<div class="col-md-3">Address:</div>
							<div class="col-md-2">Phone No:</div>
						</div>
						@foreach ($AllDentist as $item)
							<div class="row doctorList">
								<div class="col-md-2">
								<img src="../image/{{$item->photo}}" alt="doctor"/>
								</div>
								<div class="col-md-2">{{$item->firstName}} {{$item->lastName}}</div>
								<div class="col-md-2">{{$item->clinicName}}</div>
								<div class="col-md-3">{{$item->clinicAddress}}</div>
								<div class="col-md-2">{{$item->clinicPhone}}</div>
							</div>
						@endforeach
					</div>
				</div>
				<div class="tab-pane fade" id="profile" role="tabpanel">
					<div class="container">
						<h3>Dental Details</h3>
						<hr>
						<div class="row">
							<div class="col-md-4 offset-md-2">
								<button  class="btn btn-block" data-toggle="modal" data-target="#Medical"> <i class="fas fa-file-medical-alt"></i> Medical History</button>

							</div>
							<div class="col-md-4 offset-md-1">
								<button  class="btn btn-block" data-toggle="modal" data-target="#Chart"><i class="fas fa-teeth-open"></i> Dental Chart</button>

							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<button  class="btn btn-block" data-toggle="modal" data-target="#Note"><i class="fas fa-teeth-open"></i> Dental Note</button>

							</div>
							<div class="col-md-4">
								<button  class="btn btn-block" data-toggle="modal" data-target="#Prescription"><i class="fas fa-prescription-bottle-alt"></i> Prescription</button>

							</div>
							<div class="col-md-4">
								<button  class="btn btn-block" data-toggle="modal" data-target="#Appointments"><i class="fas fa-calendar-check"></i> Appointments</button>

							</div>
						</div>
						<div class="row">
							<div class="col-md-4 offset-md-2">
								<button  class="btn btn-block" data-toggle="modal" data-target="#Photos"><i class="fas fa-x-ray"></i> Photos</button>
							</div>
							<div class="col-md-4 offset-md-1">
								<button class="btn btn-block" data-toggle="modal" data-target="#Payments"><i class="fas fa-money-bill-alt"></i> Payments</button>
							</div>

						</div>
					</div>
				</div>
			</div>
			{{-- Start Medical History  --}}
				<div class="modal fade" id="Medical" tabindex="-1" aria-labelledby="exampleModalLabel3">
					<div class="modal-dialog">
						<div class="modal-content patientModel">
							<div class="modal-header">
								<h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-file-medical-alt"></i> Show Medical History</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								@if (!$medical->isEmpty())
								@foreach ($medical as $history)
									<p>{{$history->historyText}}</p>		
								@endforeach
								@else 
									<p>No Medical History Added</p>
								@endif
							</div>  
						</div>
					</div>
				</div>
			{{-- End Medical History  --}}

			{{-- Start Dental Chart  --}}
				<div class="modal fade" id="Chart" tabindex="-1" aria-labelledby="exampleModalLabel1">
					<div class="modal-dialog">
						<div class="modal-content patientModel">
							<div class="modal-header">
								<h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-teeth-open"></i> Show Dentalo Chart Patient</h5>
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
												data-target="#chartNote{{$i}}"
													@foreach ($noteChart as $color)
													@if ($color->teethNo==$i)
														style="background-color:{{$color->Teethcolor}}"
													@endif
													@endforeach />                                      
										@endfor
								</div>
							</div> 
							
						</div>
					</div>
				</div>
			{{-- End Dental Chart  --}}

			{{-- Start Dental Note  --}}
				@for ($i = 0; $i < 32; $i++)
				@foreach ($noteChart as $note)
				@if ($note->teethNo==$i)
					<div class="modal fade" id="chartNote{{$i}}" tabindex="-5" aria-labelledby="exampleModalLabel3">
						<div class="modal-dialog">
							<div class="modal-content patientModel">
								<div class="modal-header">
									<h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-user-injured"></i> Chart Note
									</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="row">
										<div class="col-md-6"><label>Date Note :</label></div>
										<div class="col-md-6"> <p>{{$note->noteDate}}</p></div>
									</div>
									<div class="row">
										<div class="col-md-6"><label>Procedure :</label></div>
									<div class="col-md-6"> <p>{{$note->Procedure}}</p></div>
									</div>
									<div class="row">
										<div class="col-md-6"><label>Teethcolor :</label></div>
										<div class="col-md-6"> <p><i class="fas fa-square-full green" style="color: {{$note->Teethcolor}}"></i> {{$note->Teethcolor}} </p></div>
									</div>
									<div class="row">
										<div class="col-md-6"><label>Note  :</label></div>
										<div class="col-md-6"> <p>{{$note->Note}}</p></div>
									</div>
								</div>  
							</div>
						</div>
					</div>
				@endif	
				@endforeach
				@endfor
			{{-- End Dental Note  --}}
			
			{{-- Start Prescription  --}}
				<div class="modal fade" id="Prescription" tabindex="-1" aria-labelledby="exampleModalLabel3">
					<div class="modal-dialog">
						<div class="modal-content patientModel">
							<div class="modal-header">
								<h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-prescription-bottle-alt"></i> Show Prescription</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								@if (!$Prescription->isEmpty())
									@foreach ($Prescription as $drug)
										<div class="row">
											<div class="col-md-6"><label> Drugs Name :</label></div>
											<div class="col-md-6"> <p>{{$drug->DrugsId}}</p></div>
										</div>
										<div class="row">
											<div class="col-md-6"><label>Quantity :</label></div>
										<div class="col-md-6"> <p>{{$drug->Quantity}}</p></div>
										</div>
										<div class="row">
											<div class="col-md-6"><label>Duration :</label></div>
											<div class="col-md-6"> <p>{{$drug->Duration}} </p></div>
										</div>
										<div class="row">
											<div class="col-md-6"><label>DosageFrequancy  :</label></div>
											<div class="col-md-6"> <p>{{$drug->DosageFrequancy}}</p></div>
										</div>
									@endforeach
								@else 
								<p>No Prescription Added</p>	
								@endif
							</div>  
						</div>
					</div>
				</div>
			{{-- End Prescription  --}}

			{{-- Start Appointment --}}
				<div class="modal fade" id="Appointments" tabindex="-1" aria-labelledby="exampleModalLabel3">
					<div class="modal-dialog">
						<div class="modal-content patientModel">
							<div class="modal-header">
								<h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-calendar-check"></i> Show Appointment</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								@if (!$Appointments->isEmpty())
									@foreach ($Appointments as $appoint)
										<div class="row">
											<div class="col-md-6"><label> Date :</label></div>
											<div class="col-md-6"> <p>{{$appoint->date}}</p></div>
										</div>
										<div class="row">
											<div class="col-md-6"><label> Time :</label></div>
											<div class="col-md-6"><p>{{Carbon::parse($appoint->time)->format('h:m a')}}</p></div>
										</div>
										<div class="row">
											<div class="col-md-6"><label>Note :</label></div>
											<div class="col-md-6"> <p>{{$appoint->note}} </p></div>
										</div>	
									@endforeach
								@else 
								<p>No Appointment Added</p>
								@endif
							</div>  
						</div>
					</div>
				</div>
			{{-- End Appointment --}}

			{{-- Start X-Ray Phoros  --}}
				<div class="modal fade" id="Photos" tabindex="-1" aria-labelledby="exampleModalLabel3">
					<div class="modal-dialog">
						<div class="modal-content patientModel">
							<div class="modal-header">
								<h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-user-injured"></i> X-Ray </h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								@if (!$photos->isEmpty())
								<ul class="nav nav-tabs" id="myTab" role="tablist">
									@for ($i = 1; $i <= count($photos) ; $i++)
										<li class="nav-item @if($i==1) active @endif" role="presentation">
										<a id="photo{{$i}}-tab" data-toggle="tab" href="#photo{{$i}}" role="tab"
											@if ($i==1)
											class="active"	
											@endif 
										>
										Photo {{$i}}
										</a>
										</li>	
									@endfor	
								</ul>
								<div class="tab-content"  id="myTabContent">
									@foreach ($photos as $index=>$item)
										<div class="tab-pane fade @if($index==0) show active @endif " id="photo{{$index+1}}" role="tabpanel">
											<div class="row">
												<div class="col-md-8"><img src="../image/{{$item->xRay}}" alt="x-ray"></div>
												<div class="col-md-4"><p>{{$item->note}}</p></div>
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
			{{-- End X-Ray Phoros  --}}

			{{-- Start Payment  --}}
			<div class="modal fade" id="Payments" tabindex="-1" aria-labelledby="exampleModalLabel3">
				<div class="modal-dialog">
					<div class="modal-content patientModel">
						<div class="modal-header">
							<h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-money-bill-alt"></i> Show Payment</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							@if (!$payments->isEmpty())
							@foreach ($payments as $payments)
								<div class="row">
									<div class="col-md-6"><label> Date of payment :</label></div>
									<div class="col-md-6"> <p>{{$payments->date}}</p></div>
								</div>
								<div class="row">
									<div class="col-md-6"><label> Total Amount to pay  :</label></div>
									<div class="col-md-6"> <p>{{$payments->Total}}</p></div>
								</div>
								<div class="row">
									<div class="col-md-6"><label> What did patient paid  :</label></div>
									<div class="col-md-6"> <p>{{$payments->paid}}</p></div>
								</div>
								<div class="row">
									<div class="col-md-6"><label> Remarks :</label></div>
									<div class="col-md-6"> <p>{{$payments->Remarks}}</p></div>
								</div>
							@endforeach
							@else 
							<p>No Payments Added</p>
							@endif
							
						</div>  
					</div>
				</div>
			</div>
			{{-- End Payment  --}}
			
		</div>
	</div>
</div>
@endif
@endsection
