<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\hash;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use App\Models\users;
use App\Models\clinic;
use App\Models\Drugs;
use App\Models\Procedures;
use App\Models\Appointments;
use App\Models\Patients;
use App\Models\Payments;
use App\Models\Photos;
use App\Models\Prescription;
use App\Models\MedicalHistory;
use App\Models\DentaloChart;
// use Faker\Provider\Medical;
use App\Http\Traits\GeneralTrait;

class DentistController extends Controller
{
    use GeneralTrait;
    // Clinic Information 
    function ClinicInfo()
    {
       $userId=session()->get('user')['id']; 
       $data=clinic::select('*')->where('clinic.dentisId',$userId)->get();
       return $data;  
    }

    // User Informaton
    function UserInfo()
    {
        $userId=session()->get('user')['id']; 
        $data=users::select('users.*')->where('users.id',$userId)->get();
        return $data;  
    }

    // All Drugs 
    function allDrugs()
    {
        $userId=session()->get('user')['id']; 
        $data=Drugs::select('*')->where('drugs.dentistId',$userId)->get();
        return $data;  
    }

    // All Procedures 
    function allProcedures()
    {
        $userId=session()->get('user')['id']; 
        $data=Procedures::select('procedures.*')->where('procedures.dentistId',$userId)->get();
        return $data;
    }

    // All Appointment 
    function AllOppintments()
    {
        $userId=session()->get('user')['id']; 
        $data=Appointments::select('*')->where('appointments.dentistId',$userId)->orderby('date','asc')->get();
        return $data;
    }

    // All patient 
    function allPatients()
    {
        $userId=session()->get('user')['id']; 
        $data=Patients::select('*')->where('patients.dentistId',$userId)->get();
        return $data;
    }

    // All Appointments for Today 
    function AppointmentTody()
    {
        $userId=session()->get('user')['id']; 
        $data=Appointments::select('*')->where('appointments.dentistId',$userId)->where('appointments.date',DATE_FORMAT(now(),"y-m-d"))->orderby('time','asc')->get();
        return $data;
    }

    // Patient Payments 
    function AllPayment($patId)
    {
        $data=Payments::select('*')->where('payments.patientId',$patId)->get();
        return $data;

    }

    // Patient Photos 
    function AllPhoto($patId)
    {
        $data=Photos::select('*')->where('photos.patientId',$patId)->get();
        return $data;
    }

    // Patient appointment 
    function AppointmentInfo($patId)
    {
        $userId=session()->get('user')['id']; 
        $data=Appointments::select('*')->where('appointments.patientId',$patId)->where('appointments.DentistId',$userId)->get();
        return $data;
    }

    // Get Appointment by Id 
    function GetAppointments($appointmentId)
    {
        $data=Appointments::select('*')->where('id',$appointmentId)->get();
        return $data;

    }

    // Patient Medical History 
    function getMecial($patId)
    {
        $data=MedicalHistory::select('*')->where('medical_history.patientId',$patId)->get();
        return $data;
    }

    // Patient Prescription
    function allPrescription($patId)
    {
        $data=Prescription::select('*')->where('prescription.patientId',$patId)->get();
        return $data;
    }
    
    // Patient Teeth Notes 
    function getNote($patId,$teeth)
    {
        $data=DentaloChart::select('*')->where('dental_chart.paitentId',$patId)->where('dental_chart.teethNo',$teeth)->get();
        return $data;
    }

    // Get Patient Info 
    function PatientInfo ($patId)
    {
        $data=Patients::select('*')->where('patients.id',$patId)->get();
        return $data;
    }

    // Add Patient 
    function addPatient(Request $req)
    {
        $userId=session()->get('user')['id']; 
        $dataEmail=Patients::select('*')->where('patients.email',$req->email)->get();
        if($dataEmail->isEmpty())
        {
            $patient=new Patients();
            $patient->dentistId=$userId;
            $patient->firstName=$req->firstName;
            $patient->MiddleName=$req->middleName;
            $patient->LastName=$req->lastName;
            $patient->birthDay=$req->birthDay;
            $patient->gender=$req->gender;
            $patient->contactNo=$req->contact;
            $patient->email=$req->email;
            $patient->address=$req->address;
            $patient->note=$req->note;
            $patient->save();
            return response()->json([
                'status'=>true,
                'msg'=>'Added New Patient Success'
            ]);
        }
        else{
            return response()->json([
                'status'=>false,
                'msg'=>'Patient Already Exits'
            ]);        
        }

    }

    // Delete Patient 
    function deletePatient(Request $req)
    {
        Patients::find($req->id)->delete();
        return response()->json([
            'status'=>true,
            'msg'=>'Deleted Patients Done',
            'id'=>$req->id
        ]);
    }

    // Edit Patient 
    function editPatient(Request $req)
    {
        $dataEmail=Patients::select('*')->where('email',$req->email)->get();
        $patEmail=Patients::select('email')->where('id',$req->patient_id)->first();
        // update date  
        if($dataEmail->isEmpty() || ($patEmail['email'] == $req->email))
        {    
            $patientName=explode(" ",$req->firstName);
            Patients::select('*')->where('id',$req->patient_id)->update([
                'firstName'=>$patientName[0],
                'MiddleName'=>$patientName[1],
                'LastName'=>$patientName[2],
                'birthDay'=>$req->birthDay,
                'gender'=>$req->gender,
                'contactNo'=>$req->contactNo,
                'email'=>$req->email,
                'note'=>$req->note,
                'address'=>$req->address,
            ]);
            return response()->json([
                'status' => true,
            ]);
        }
        else
        { 
            return response()->json([
                'status' => false,
            ]);
       }
       
    }

    // Add Appointment 
    function addAppointment(Request $req)
    {
        $userId=session()->get('user')['id']; 
        $appointment=new Appointments();
        $appointment->DentistId=$userId;
        $appointment->patientId=$req->appoint_id;
        $appointment->patientName=$req->patientName2;
        $appointment->date=$req->date2;
        $appointment->time=$req->time2;
        $appointment->note=$req->note2;
        $appointment->save();
        return response()->json([
            'status' => true,
        ]);
    }

    // Edit Appointment 
    function editAppointment(Request $req)
    {
        Appointments::select('*')->where('patientId',$req->appoint_id_edit)->update([
            'patientName'=>$req->patientName,
            'date'=>$req->date,
            'time'=>$req->time,
            'note'=>$req->note
        ]);
        return response()->json([
            'status' => true,
        ]);

    }

    // Edit Appointment2 
    function editAppointment2(Request $req)
    {
        Appointments::select('*')->where('id',$req->appoint2_id)->update([
            'patientName'=>$req->patientName2,
            'date'=>$req->date2,
            'time'=>$req->time2,
            'note'=>$req->note2
        ]);
        return response()->json([
            'status' => true,
        ]);

    }

    // Delete Appointment 
    function deleteappointment(Request $req)
    {
        Appointments::find($req->id)->delete();
        return response()->json([
            'status'=>true,
            'id'=>$req->id
        ]);
    }
    
    // Add drug 
    function addDrug(Request $req)
    {
        $userId=session()->get('user')['id']; 
        $drug=new Drugs();
        $drug->dentistId=$userId;
        $drug->DrugName=$req->DrugName;
        $drug->GenericName=$req->GenericName;
        $drug->BrandName=$req->BrandName;
        $drug->Cost=$req->Cost;
        $drug->save();
        return response()->json([
            'status'=>true,
        ]);

    }

    // Delete Drug 
    function deleteDrug(Request $req)
    {
        Drugs::find($req->id)->delete();
        return response()->json([
            'status'=>true,
            'id'=>$req->id
        ]);
    }

    // Edit Drug 
    function editDrug(Request $req)
    {
        Drugs::select('*')->where('id',$req->drug_id)->update([
            'DrugName'=>$req->DrugName,
            'GenericName'=>$req->GenericName,
            'BrandName'=>$req->BrandName,
            'Cost'=>$req->Cost
        ]);
        return response()->json([
            'status' => true,
        ]);
    }

    // Add Procedure
    function addProcedure(Request $req)
    {
        $userId=session()->get('user')['id'];
        $procedure=new Procedures();
        $procedure->dentistId=$userId;
        $procedure->ProcedureName=$req->ProcedureName;
        $procedure->save();
        return response()->json([
            'status' => true,
        ]);
    }

    // Delete Procedure 
    function deleteProcedure(Request $req)
    {
        Procedures::where('id',$req->id)->delete();
        return response()->json([
            'status'=>true,
            'id'=>$req->id
        ]);
    }

    // Edit Procedure
    function editProcedure(Request $req)
    {
        Procedures::select('*')->where('id',$req->Procedure_id)->update([
            'ProcedureName'=>$req->ProcedureName,
        ]);
        return response()->json([
            'status' => true,
        ]);
    }

    // Add Medcial Histroy 
    function addMedical(Request $req)
    {
        $medical=new MedicalHistory();
        $medical->patientId=$req->patient_id;
        $medical->historyText=$req->medicalHesitory;
        $medical->save();
        return	response()->json([
            'status' => true,
        ]);
    }

    // Get All Medical 
    function AllMedical ()
    {
        $data=MedicalHistory::select('*')->get();
        return $data;
    }

    // Edit Medicl History 
    function editHistory(Request $req)
    {
        MedicalHistory::where('patientId',$req->patient_id2)->update([
            'historyText'=>$req->medicalHesitory2,
        ]);
        return	response()->json([
            'status' => true,
        ]);
    }

    // Add Chart Note 
    function addNote(Request $req)
    {
        $DentaloChart=new DentaloChart();
        $DentaloChart->paitentId=$req->patient_id_teeth;
        $DentaloChart->noteDate=$req->noteDate2;
        $DentaloChart->Procedure=$req->Procedure;
        $DentaloChart->Teethcolor=$req->Teethcolor;
        $DentaloChart->Note=$req->Note2;
        $DentaloChart->teethNo=$req->teeth_id;
        $DentaloChart->save();
        return	response()->json([
            'status' => true,
        ]);
    }

    // Edit Note 
    function EditNote(Request $req)
    {
        DentaloChart::where('teethNo',$req->teeth_id_edit)->where('paitentId',$req->patient_id_teeth_edit)->update([
            'noteDate'=>$req->noteDate3,
            'Procedure'=>$req->Procedure3,
            'Teethcolor'=>$req->Teethcolor2,
            'Note'=>$req->Note3
        ]);
        return	response()->json([
            'status' => true,
        ]);
    }

    // Add Prescription
    function addPrescription(Request $req)
    {
        $Prescription=new Prescription();
        $Prescription->patientId=$req->patient_id;
        $Prescription->DrugsId=$req->DrugsId;
        $Prescription->Quantity=$req->Quantity;
        $Prescription->Duration=$req->Duration;
        $Prescription->DosageFrequancy=$req->DosageFrequancy;
        $Prescription->save();
        return	response()->json([
            'status' => true,
        ]); 
    }

    // Edit Prescription
    function EditPrescription(Request $req)
    {
        Prescription::where('patientId',$req->patient_id2)->update([
            'DrugsId'=>$req->DrugsId2,
            'Quantity'=>$req->Quantity2,
            'Duration'=>$req->Duration2,
            'DosageFrequancy'=>$req->DosageFrequancy2
        ]);
        return	response()->json([
            'status' => true,
        ]);
    }


    // JSON EXAMPLE 

    function allpatientjson()
    {
        $data=Patients::select('*')->get();
        return response()->json($data);
    }

    function patientById(Request $req)
    {
       $data= Patients::select('*')->find($req->id);
       if(!$data){
         return  $this->returnError('011','this Patient is not Found');
       }
       return $this->returnData('patient',$data);
    }

    
}
