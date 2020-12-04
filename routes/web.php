<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\DentistController;

use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('page/home');
});
Route::view('Services', 'page/services');
Route::view('AboutUs', 'page/aboutUs');
Route::view('ContactUs', 'page/contact');
Route::post('/sendMassage', [userController::class,'sendMassage']);
Route::post('/login', [userController::class,'Login']);
Route::post('/patient', [userController::class,'SignUpPatient']);
Route::post('/dentist', [userController::class,'SignUpDentist']);
Route::view('patientHome', 'page/patient');
Route::view('dentistHome', 'page/dentist');

Route::post('/addPatient', [DentistController::class,'addPatient']);
// Route::post('/addPatient', [DentistController::class,'addPatient']);
Route::post('/addDrug', [DentistController::class,'addDrug']);
Route::post('/addProcedure', [DentistController::class,'addProcedure']);
Route::post('/addAppointment', [DentistController::class,'addAppointment']);
Route::post('/editAppointment', [DentistController::class,'editAppointment']);
Route::post('/editAppointment2', [DentistController::class,'editAppointment2']);
Route::post('/editDrug', [DentistController::class,'editDrug']);
Route::post('/editProcedure', [DentistController::class,'editProcedure']);
Route::post('/editPatient', [DentistController::class,'editPatient']);
Route::post('/editProfile', [DentistController::class,'editProfile']);
Route::post('/EditPrescription/{id}', [DentistController::class,'EditPrescription']);
Route::post('/EditPhoto/{id}', [DentistController::class,'EditPhoto']);
Route::post('/editPayments/{id}', [DentistController::class,'editPayments']);
Route::post('/EditNote/{PatId}/{id}', [DentistController::class,'EditNote']);
Route::post('/deleteDrug', [DentistController::class,'deleteDrug']);
Route::post('/deleteappointment', [DentistController::class,'deleteappointment']);
Route::post('/deletePatient', [DentistController::class,'deletePatient']);
Route::post('/deleteProcedure', [DentistController::class,'deleteProcedure']);
Route::post('/resetPass', [DentistController::class,'resetPass']);
Route::post('/addMedical/{id}', [DentistController::class,'addMedical']);
Route::post('/addNote/{name}/{id}', [DentistController::class,'addNote']);
Route::post('/addPrescription/{id}', [DentistController::class,'addPrescription']);
Route::post('/addPhoto/{id}', [DentistController::class,'addPhoto']);
Route::post('/addPayments/{id}', [DentistController::class,'addPayments']);
Route::get('/searchPat', [DentistController::class,'searchPat']);

Route::get('/logout',  function () {
    session()->forget('user');
    return Redirect('/');    
});
