<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\patient;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\User;
use App\Models\DrugModel;
use App\Models\Procedures;
use App\Models\medical_history;
use App\Models\NoteChart;
use App\Models\Prescription;
use App\Models\X_Ray_Photo;
use App\Models\payments;
class DentistController extends Controller
{

    // Get Clinic Information
    function ClinicInfo()
    {
        $userId=session()->get('user')['id'];
        $data2=DB::table('clinic')
        ->join('users','users.id','dentisId')
        ->select('clinic.*')
        ->where('clinic.dentisId',$userId)
        ->get();
        return $data2;
    }

    // Get User Information
    function UserInfo()
    {
        $userId=session()->get('user') ['id'];
        $data=DB::table('users')
        ->select('users.*')
        ->where('users.id',$userId)
        ->get();
        return $data; 
    }
   
    // Get All Appointments For this Day 
    function AppointmentTody()
    {
        $userId=session()->get('user')['id'];
        $data=DB::table('appointments')
        ->join('users','users.id','DentistId')
        ->select('appointments.*')
        ->where('appointments.DentistId',$userId)
        ->where('appointments.date',DATE('yy-m-d'))
        ->orderBy('time','asc')
        ->get();
        return $data;
    }
   
    // Get the count of appointments for dentist
    function AppintmentNumber()
    {
        $userId=session()->get('user')['id'];
        return Appointment::where('DentistId',$userId)->count();
    }

    // Get the count of Patients for dentist
    function PatientNumber()
    {
        $userId=session()->get('user')['id'];
        return patient::where('dentistId',$userId)->count();
    }

    // Edit Dentist Information
    function editProfile(Request $req)
    {
      
        $userId=session()->get('user')['id'];
        if($req->hasFile('fileImg')){
            $photo=$req->file('fileImg');
            $fileName=time() .$photo->getClientOriginalName();
            Image::make($photo)->resize(300,300)->save(public_path('/image/' . $fileName));
        DB::table('clinic')
        ->where('clinic.dentisId',$userId)
        ->select('clinic.*')
        ->update(['clinicName'=>$req->ClinicName , 'clinicPhone'=>$req->ClinicNo ,'clinicAddress'=>$req->Address,'photo'=>$fileName]);
        }
        if($req->hasFile('DoctorImg')){
            $photoDoctor=$req->file('DoctorImg');
            $fileNamedo=time() .$photoDoctor->getClientOriginalName();
            Image::make($photoDoctor)->resize(300,300)->save(public_path('/image/' . $fileNamedo));
        DB::table('users')
        ->where('users.id',$userId)
        ->select('users.*')
        ->update(['firstName'=>$req->FirstName,'lastName'=>$req->LastName,'email'=>$req->Email,'photo'=>$fileNamedo]);
        }
        return Redirect::to('dentistHome');
        
        

    }

    // Get All Appointments for dentist 
    function AllOppintments()
    {
        $userId=session()->get('user')['id'];
        $data=DB::table('appointments')
        ->select('appointments.*')
        ->where('appointments.DentistId',$userId)
        ->orderBy('date','asc')
        ->orderBy('time','asc')
        ->get();
        return $data;
    }

    // Add New Appointments To Appointments Dentist List
    function addAppointment(Request $req)
    {
        $appointment=new Appointment();
        $appointment->dentistId=$req->session()->get('user')['id'];
        if($req->id==0){
            $appointment->patientId=0;
        }else{
            $appointment->patientId=$req->id;
        }
        $appointment->patientName=$req->patientName;
        $appointment->date=$req->date;
        $appointment->time=$req->time;
        $appointment->note=$req->note;
        $appointment->save();
        return Redirect::to('dentistHome');
    }

    //Delete Appointment
    function deleteappointment(Request $req)
    {
         DB::table('appointments')
        ->select('appointments.*')
        ->where('appointments.id',$req->appoint2)
        ->delete();
        return Redirect::to('dentistHome');
    }

    // Edit Appointment 
    function editAppointment(Request $req)
    {
       $data= DB::table('appointments')
        ->select('appointments.*')
        ->where('appointments.id',$req->id)
        ->update(['patientName'=>$req->patientName,'date'=>$req->date ,'time'=>$req->time ,'note'=>$req->note]);
        return redirect('/dentistHome');
    }

    // Edit Appointment2 
    function editAppointment2(Request $req)
    {
        $data= DB::table('appointments')
        ->select('appointments.*')
        ->where('appointments.patientId',$req->id)
        ->update(['patientName'=>$req->patientName,'date'=>$req->date ,'time'=>$req->time ,'note'=>$req->note]);
        return redirect('/dentistHome');
    }

    // Get All Drugs
    function allDrugs()
    {
        $userId=session()->get('user')['id'];
        return DB::table('drugs')
        ->select('drugs.*')
        ->where('drugs.dentistId',$userId)
        ->get();
    }

     //Add Drug
    function addDrug(Request $req)
    {
        $userId=session()->get('user')['id'];
        $newDrug=new DrugModel();
        $newDrug->dentistId=$userId;
        $newDrug->DrugName=$req->DrugName;
        $newDrug->GenericName=$req->GenericName;
        $newDrug->BrandName=$req->BrandName;
        $newDrug->Cost=$req->Cost;
        $newDrug->save();
        return Redirect::to('dentistHome');
    }

    // Delete Drug 
    function deleteDrug(Request $req)
    {
        DB::table('drugs')
        ->select('drugs.*')
        ->where('drugs.id',$req->id)
        ->delete();
        return Redirect::to('dentistHome');
    }

    // Edit Drugs 
    function editDrug(Request $req)
    {
        $data= DB::table('drugs')
        ->select('drugs.*')
        ->where('drugs.id',$req->id)
        ->update(['DrugName'=>$req->DrugName,'GenericName'=>$req->GenericName ,'BrandName'=>$req->BrandName ,'Cost'=>$req->Cost]);
        return redirect()->back();
    }

    // Get All Procedures
    function allProcedures()
    {
        $userId=session()->get('user')['id'];
        $data=DB::table('procedures')
        ->select('procedures.*')
        ->where('procedures.dentistId',$userId)
        ->get();
        return $data;
    }

    // Add Procedure 
    function addProcedure(Request $req)
    {
        $userId=session()->get('user')['id'];
        $procedures=new Procedures();
        $procedures->dentistId=$userId;
        $procedures->ProcedureName=$req->ProcedureName;
        $procedures->save();
        return redirect()->back();
    }

    // Delete Procedure
    function deleteProcedure(Request $req)
    {
        DB::table('procedures')
        ->select('procedures.*')
        ->where('procedures.id',$req->id)
        ->delete();
        return Redirect::to('dentistHome');
    }

    // Edit Procedure 
    function editProcedure(Request $req)
    {
        DB::table('procedures')
        ->select('procedures.*')
        ->where('procedures.id',$req->id)
        ->update(['ProcedureName'=>$req->ProcedureName]);
        return redirect()->back();
    }

    // Get All Patients List for Dentist 
    function allPatients()
    {
        $userId=session()->get('user')['id'];
        $data=DB::table('patients')
        ->select('patients.*')
        ->where('patients.dentistId',$userId)
        ->get();
        return $data;

    }

     // Add New Patient To Patients Dentist List 
     function addPatient(Request $req)
     {
        $userEmail = DB::table('patients')->where('email',$req->email)->get();
        if($userEmail->isEmpty()){
         $patient=new patient();
         $patient->dentistId=$req->session()->get('user')['id'];
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
         return Redirect::to('dentistHome');
        }else{
            $errors = new MessageBag(['email' => ['The Patient is is already registered in anther dentist']]);
            return Redirect::back()->withErrors($errors);
        }
     }

    // Delete Patient 
    function deletePatient(Request $req)
    {
        DB::table('patients')
        ->select('patients.*')
        ->where('patients.id',$req->id)
        ->delete();
        return redirect()->back();
    }

    //Edit Patient 
    function editPatient(Request $req)
    {
        $firstName= explode(' ', $req->firstName, 3);
        DB::table('patients')
        ->select('patients.*')
        ->where('patients.id',$req->id)
        ->update(['firstName'=>$firstName[0],'MiddleName'=>$firstName[1],'LastName'=>$firstName[2],'note'=>$req->note,'contactNo'=>$req->contactNo,'address'=>$req->address,'gender'=>$req->gender]);
        return redirect()->back();
    }

    // Change Password 
    function resetPass(Request $req)
    {
       $errors = new MessageBag; // initiate MessageBag
       if(Hash::check($req->CurrentPassword , session()->get('user')['password']))
       {
           if($req->NewPassword == $req->ConNewPassword)
           {
               DB::table('users')
               ->where('users.id',session()->get('user')['id'])
               ->update(['password'=>Hash::make($req->NewPassword)]);
               return redirect('dentistHome');
           }
           else
           {
            $errors = new MessageBag(['password' => ['2 Password is Not identical']]);
            return redirect('dentistHome')->withErrors($errors);
           }
       }
       else
       {
        $errors = new MessageBag(['password' => ['Password is not Valid']]);
        return redirect('dentistHome')->withErrors($errors); 
       }   

    }

    //Add Medcial Hestoriy
    function addMedical(Request $req)
    {
      $medical=new medical_history();
      $medical->patientId=$req->id;
      $medical->historyText=$req->medicalHesitory; 
      $medical->save();
      return redirect()->back(); 
    }

    // Add Note To Chart 
    function addNote(Request $req)
    {
        $noteChart = new NoteChart();
        $noteChart->paitentId=$req->name;
        $noteChart->teethNo=$req->id;
        $noteChart->noteDate=$req->noteDate;
        $noteChart->Procedure=$req->Procedure;
        $noteChart->Teethcolor=$req->Teethcolor;
        $noteChart->Note=$req->Note;
        $noteChart->save();
        return redirect()->back();
    }

    // Get All Medical History For Patient 
    function getMecial($id)
    {
        $data=DB::table('medical_history')
        ->select('medical_history.*')
        ->where('medical_history.patientId',$id)
        ->get();
        return $data;
    }

    // Get Note Chart 
    function getNote($idPat,$idTeeth)
    {
        $data=DB::table('dental_chart')
        ->select('dental_chart.*')
        ->where('dental_chart.paitentId',$idPat)
        ->where('dental_chart.teethNo',$idTeeth)
        ->get();
        return $data; 
    }

    // Edit Note Chart 
    function EditNote(Request $req)
    {
        DB::table('dental_chart')
        ->select('dental_chart.*')
        ->where('dental_chart.paitentId',$req->PatId)
        ->where('dental_chart.teethNo',$req->id)
        ->update(['noteDate'=>$req->noteDate,'Procedure'=>$req->Procedure,'Teethcolor'=>$req->Teethcolor,'Note'=>$req->Note]);
        return redirect()->back();
    }

    // add Prescription 
    function addPrescription(Request $req)
    {
        $prescription=new Prescription();
        $prescription->patientId=$req->id;
        $prescription->DrugsId=$req->DrugsId;
        $prescription->Quantity=$req->Quantity;
        $prescription->Duration=$req->Duration;
        $prescription->DosageFrequancy=$req->DosageFrequancy;
        $prescription->save();
        return redirect()->back();
    }

    // Get All Prescription 
    function allPrescription($idPat)
    {
        $data=DB::table('prescription')
        ->select('prescription.*')
        ->where('prescription.patientId',$idPat)
        ->get();
        return $data;
    }

    // Edit Prescription
    function EditPrescription(Request $req)
    {
        DB::table('prescription')
        ->where('prescription.patientId',$req->id)
        ->update(['DrugsId'=>$req->DrugsId,'Quantity'=>$req->Quantity,'Duration'=>$req->Duration,'DosageFrequancy'=>$req->DosageFrequancy]);
        return redirect()->back();
    }

    // Get Patient Info 
    function PatientInfo($PatId)
    {
        $data=DB::table('patients')
        ->select('patients.*')
        ->where('patients.id',$PatId)
        ->get();
        return $data;
    }

    // Get Appointment Info 
    function AppointmentInfo($patId)
    {
        $data=DB::table('appointments')
        ->select('appointments.*')
        ->where('appointments.patientId',$patId)
        ->get();
        return $data;
    }

    // Add X-Ray Photo 
    function addPhoto(Request $req)
    {
        $x_Ray=new X_Ray_Photo();
        $x_Ray->patientId=$req->id;
        if($req->hasFile('photo')){
            $photo=$req->file('photo');
            $fileName=time() . '.' . $photo->getClientOriginalExtension();
            Image::make($photo)->resize(300,300)->save(public_path('/image/' . $fileName));
            $x_Ray->xRay=$fileName;
        }

        $x_Ray->note=$req->note;
        $x_Ray->save();
        return redirect()->back();
    }

    // Get X_Ray Photo 
    function AllPhoto($patId)
    {
        $data=DB::table('photos')
        ->select('photos.*')
        ->where('photos.patientId',$patId)
        ->get();
        return $data;
    }

    // Edit X_Ray Photo 
    function EditPhoto(Request $req)
    {
        DB::table('photos')
        ->where('photos.patientId',$req->id)
        ->update(['xRay'=>$req->photo,'note'=>$req->note]);
        return redirect()->back();
    }

    // Add Payments 
    function addPayments(Request $req)
    {
        $payment=new payments();
        $payment->patientId=$req->id;
        $payment->date=$req->date;
        $payment->Total=$req->total;
        $payment->paid=$req->paid;
        $payment->Remarks=$req->remarks;
        $payment->save();
        return redirect()->back();
    }

    // Get Payments
    function AllPayment($patId)
    {
        $data=DB::table('payments')
        ->select('payments.*')
        ->where('payments.patientId',$patId)
        ->get();
        return $data;
    }

    // Edit Payments 
    function editPayments(Request $req)
    {
        DB::table('payments')
        ->where('payments.patientId',$req->id)
        ->update(['date'=>$req->date,'Total'=>$req->total,'paid'=>$req->paid,'Remarks'=>$req->remarks]);
        return redirect()->back();
    }

    // Search Patient 
    function searchPat(Request $req)
    {
        $userId=session()->get('user')['id'];
        $data=DB::table('patients')
        ->select('patients.*')
        ->where('patients.dentistId',$userId)
        ->where('firstName', 'LIKE', '%' . $req->name . '%')
        ->where('LastName', 'LIKE', '%' . $req->name . '%')
        ->get();
        return view('dentistHome',['searchPat'=>$data]);
    }

    // Get All Dentist 
    function AllDentist()
    {
        $data=DB::table('users')
        ->select('users.*')
        ->where('users.userType','Dentist')
        ->join('clinic','clinic.dentisId','id')
        ->get();
        return $data;
    }
    
}
