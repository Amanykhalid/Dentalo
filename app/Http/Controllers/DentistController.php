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






class DentistController extends Controller
{
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

    // All Payments 
    function AllPayment($patId)
    {
        $data=Payments::select('*')->where('payments.patientId',$patId)->get();
        return $data;

    }

    // All Photos 
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
            return redirect()->back()->with('success_alter','Add New Patient');
        }
        else{
            return redirect()->back()->with('field_alter','Field to Add New Patient');
        }

    }

    // Add Appointment 
    function addAppointment(Request $req)
    {
        $userId=session()->get('user')['id']; 
        $appointment=new Appointments();
        $appointment->DentistId=$userId;
        $appointment->patientName=$req->patientName;
        $appointment->date=$req->date;
        $appointment->time=$req->time;
        $appointment->note=$req->note;
        $appointment->patientId=$req->id;
        $appointment->save();
        return redirect()->back()->with('success_alter','Add New Appointments');
    }

    
}
