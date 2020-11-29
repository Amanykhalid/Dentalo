<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;


class Patient extends Controller
{
    // Get All Dentist 
    function AllDentist()
    {
        $data=DB::table('users')
        ->select('users.*')
        ->where('users.userType','Dentist')
        ->join('clinic','clinic.dentisId','users.id')
        ->select('clinic.*','users.*')
        ->get();
        return $data;
    }

    // Get Patient Info 
    function patientInfo()
    {
        $patientEmail=session()->get('user')['email'];
        $data=DB::table('patients')
        ->select('patients.*')
        ->where('patients.email',$patientEmail)
        ->get();
        return $data;
    }

    // Get Appointemant 
    function Appointments()
    {
        $patientEmail=session()->get('user')['email'];
        $data=DB::table('patients')
        ->where('patients.email',$patientEmail)
        ->join('appointments','appointments.patientId','patients.id')
        ->select('appointments.*')
        ->get();
        return $data;
    }

    // Get Medical History 
    function medical()
    {
        $patientEmail=session()->get('user')['email'];
        $data=DB::table('patients')
        ->where('patients.email',$patientEmail)
        ->join('medical_history','medical_history.patientId','patients.id')
        ->select('medical_history.*')
        ->get();
        return $data;
    }

    // Get Dentalo Note 
    function noteChart()
    {
        $patientEmail=session()->get('user')['email'];
        $data=DB::table('patients')
        ->join('dental_chart','dental_chart.paitentId','patients.id')
        ->where('patients.email',$patientEmail)
        ->select('dental_chart.*')
        ->get();
        return $data;
    }

    // Get Prescription 
    function Prescription()
    {
        $patientEmail=session()->get('user')['email'];
        $data=DB::table('patients')
        ->join('prescription','prescription.patientId','patients.id')
        ->where('patients.email',$patientEmail)
        ->select('prescription.*')
        ->get();
        return $data;
    }

    // Get X-Ray 
    function photos()
    {
        $patientEmail=session()->get('user')['email'];
        $data=DB::table('patients')
        ->join('photos','photos.patientId','patients.id')
        ->where('patients.email',$patientEmail)
        ->select('photos.*')
        ->get();
        return $data;
    }

    // Get Payment 
    function payments()
    {
        $patientEmail=session()->get('user')['email'];
        $data=DB::table('patients')
        ->join('payments','payments.patientId','patients.id')
        ->where('patients.email',$patientEmail)
        ->select('payments.*')
        ->get();
        return $data;
    }

}
