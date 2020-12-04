
@php
use App\Http\Controllers\DentistController;
$var=new DentistController();
$clinics=$var->ClinicInfo();
$userInfo=$var->UserInfo();
$allPatients=$var->allPatients();
$AllOppintments=$var->AllOppintments();
$allDrugs=$var->allDrugs();
$allProcedures=$var->allProcedures();

@endphp

@extends('component/layout')
@section('contant')
@if (Session::has('user') && (session()->get('user')['userType']=='Dentist'))
@if ($error = Session::get('alert-success'))
	<div class="alert alert-success">
		{{ $error }}
	</div>
@endif
 
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
<script>

    // Add Patient 
    
    for (let index = 1; index < 3; index++) {
        $(document).on('click','.savePatient'+index,function(e){
            e.preventDefault();
            var formatDate=new FormData($('.patientForm'+index)[0]);
            $.ajax({
                type:'post',
                url:"/addPatient",
                data: formatDate,
                processData: false,
                contentType: false,
                cache: false
                ,success: function (data) {
                    if(data.status==true){
                        $('.success_msg').show();
                    }else{
                        $('.filed_msg').show();

                    }
                }
                ,error: function (reject) {
                
                },
            });
        });
    }
        
    // Delete Patient 
    $(document).on('click', '.delete_patient', function (e) {
            e.preventDefault();
            var patient_id =  $(this).attr('patient_id');

            $.ajax({
                type: 'post',
                url: "/deletePatient",
                data: {
                    '_token': "{{csrf_token()}}",
                    'id' :patient_id
                },
                success: function (data) {

                    if(data.status == true){
                        $('#delete_msg').show();
                    }
                    $('.patientRow'+data.id).remove();
                }, error: function (reject) {

                }
            });
    });
    
    // Add Appointment
    for (let index = 1; index < 4; index++) {
      
        $(document).on('click','.ajaxApointment'+index,function(e){
            e.preventDefault();
            var formatDate=new FormData($('.appointForm')[0]);
            $.ajax({
                type:'post',
                url:"/addAppointment",
                data:formatDate,
                processData: false,
                contentType: false,
                cache: false
                ,success: function (data) {
                    if(data.status==true){
                        $('.success_appoint').show();
                    }
                    $('input[name=patientName]').val('');
                    $('input[name=date]').val('');
                    $('input[name=time]').val('');
                    $('input[name=note]').val('');


                }
                ,error: function (reject) {
                
                },
            });
        });
    }

    // Delete Appointment 
    $(document).on('click', '.delete_appointment', function (e) {
        e.preventDefault();
        var appoint_id =  $(this).attr('appoint_id');

        $.ajax({
            type: 'post',
            url: "/deleteappointment",
            data: {
                '_token': "{{csrf_token()}}",
                'id' :appoint_id
            },
            success: function (data) {
                if(data.status == true){
                    $('#delete_appoint').show();
                }
                $('.appointmentRow'+data.id).remove();
            }, error: function (reject) {

            }
        });
    });

    <?php foreach($allPatients as $item){ ?>
        // Edit Patient 
        $(document).on('click','.update_patient'+{{$item->id}},function (e) {
            e.preventDefault();
            var formDataPat = new FormData($('.PatientFormUpdate'+{{$item->id}})[0]);
            $.ajax({
                type: 'post',
                url: '/editPatient',
                enctype: 'multipart/form-data',
                data:formDataPat,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    if(data.status == true){
                        $('.success_edit'+{{$item->id}}).show();
                    }
                }, error: function (reject) {
                    
                }
            });
        });

        // Edit Appointment 
        $(document).on('click','.appointEdit'+{{$item->id}},function (e) {
            e.preventDefault();
            var formDataPat = new FormData($('.appointEditForm'+{{$item->id}})[0]);
            $.ajax({
                type: 'post',
                url: '/editAppointment',
                enctype: 'multipart/form-data',
                data:formDataPat,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    if(data.status == true){
                        $('.success_appoint'+{{$item->id}}).show();
                    }
                }, error: function (reject) {
                    
                }
            });
        });

    <?php } ?>

    <?php foreach($AllOppintments as $item){ ?>
     // Edit Appointment2 
            $(document).on('click','.editAppoint2'+{{$item->id}},function (e) {
                e.preventDefault();
                var formDataPat = new FormData($('.editAppointment2'+{{$item->id}})[0]);
                $.ajax({
                    type: 'post',
                    url: '/editAppointment2',
                    enctype: 'multipart/form-data',
                    data:formDataPat,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        if(data.status == true){
                            $('.success_appoint2'+{{$item->id}}).show();
                        }
                    }, error: function (reject) {
                        
                    }
                });
            });
    <?php } ?>

    // Add Drug 
    $(document).on('click','.add_drug',function(e){
        e.preventDefault();
        var formatDate=new FormData($('.drug_form')[0]);
        $.ajax({
            type:'post',
            url:"/addDrug",
            data:formatDate,
            processData: false,
            contentType: false,
            cache: false
            ,success: function (data) {
                if(data.status==true){
                    $('.success_drug').show();
                }
                $('input[name=DrugName]').val('');
                $('input[name=GenericName]').val('');
                $('input[name=BrandName]').val('');
                $('input[name=Cost]').val('');
            }
            ,error: function (reject) {
            
            },
        });
    });

    // Delete Drug 
    $(document).on('click', '.deleteDrug', function (e) {
        e.preventDefault();
        var drug_id =  $(this).attr('drug_id');

        $.ajax({
            type: 'post',
            url: "/deleteDrug",
            data: {
                '_token': "{{csrf_token()}}",
                'id' :drug_id
            },
            success: function (data) {
                if(data.status == true){
                    $('#delete_drug').show();
                }
                $('.DrugRow'+data.id).remove();
            }, error: function (reject) {

            }
        });
    });

    <?php foreach($allDrugs as $item){ ?>
     // Edit Drugs 
            $(document).on('click','.editDrug'+{{$item->id}},function (e) {
                e.preventDefault();
                var formDataPat = new FormData($('.editDrugForm'+{{$item->id}})[0]);
                $.ajax({
                    type: 'post',
                    url: '/editDrug',
                    enctype: 'multipart/form-data',
                    data:formDataPat,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        if(data.status == true){
                            $('.success_Edit_Drug'+{{$item->id}}).show();
                        }
                    }, error: function (reject) {
                        
                    }
                });
            });
    <?php } ?>

    // Add Procedure
    $(document).on('click','.add_Procedure',function(e){
        e.preventDefault();
        var formatDate=new FormData($('.Procedure_form')[0]);
        $.ajax({
            type:'post',
            url:"/addProcedure",
            data:formatDate,
            processData: false,
            contentType: false,
            cache: false
            ,success: function (data) {
                if(data.status==true){
                    $('.success_Procedure').show();
                }
                $('input[name=ProcedureName]').val('');
            }
            ,error: function (reject) {
            
            },
        });
    }); 

    // Delete Procedure 
    $(document).on('click', '.deleteProcedure', function (e) {
        e.preventDefault();
        var Procedure_id =  $(this).attr('Procedure_id');
        $.ajax({
            type: 'post',
            url: "/deleteProcedure",
            data: {
                '_token': "{{csrf_token()}}",
                'id' :Procedure_id
            },
            success: function (data) {
                if(data.status == true){
                    $('#Procedure_drug').show();
                }
                $('.ProcedureRow'+data.id).remove();
            }, error: function (reject) {

            }
        });
    });

    <?php foreach($allProcedures as $item){ ?>
     // Edit Procedure 
            $(document).on('click','.editProcedure'+{{$item->id}},function (e) {
                e.preventDefault();
                var formDataPat = new FormData($('.editProcedureForm'+{{$item->id}})[0]);
                $.ajax({
                    type: 'post',
                    url: '/editProcedure',
                    enctype: 'multipart/form-data',
                    data:formDataPat,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        if(data.status == true){
                            $('.success_Edit_Procedure'+{{$item->id}}).show();
                        }
                    }, error: function (reject) {
                        
                    }
                });
            });
    <?php } ?>



    

 
</script>
@stop

