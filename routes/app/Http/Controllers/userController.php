<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

use App\Models\User;
use App\Models\Clinic;
use App\Models\massage;


class UserController extends Controller
{
    //
    function Login(Request $req)
    {
        $errors = new MessageBag; // initiate MessageBag
        $user=User::where(['email'=>$req->email])->first();
        if( !($user && Hash::check($req->password , $user ->password)))
        {
            $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);
            return Redirect::back()->withErrors($errors);      
        }else{
            if($user->userType == 'Patient')
            {
                $req->session()->put('user',$user);
                return Redirect::to('patientHome')->with('alert-success', 'You are now logged in. as Patient');
            }
            else
            {
                $req->session()->put('user',$user);
                return Redirect::to('dentistHome')->with('alert-success', 'You are now logged in. as Dentist');   
            }
        } 
        
    }
    function dentistDetiel(){

    }

    function SignUpPatient(Request $req)
    {
        $userEmail = DB::table('users')->where('email',$req->email)->get()->count();
        if($userEmail == 0){
            $user=new User();
            // $user->id=$req->session()->get('user')['id'];
            $user->firstName=$req->firstName;
            $user->lastName=$req->lastName;
            if($req->hasFile('photoPat')){
                $photoPat=$req->file('photoPat');
                $filePat=time() . '.' . $photoPat->getClientOriginalExtension();
                Image::make($photoPat)->resize(300,300)->save(public_path('/image/' . $filePat));
                $user->photo=$filePat;
            }
            $user->email=$req->email;
            $user->password=Hash::make($req->password);
            $user->userType='Patient';
            $user->save();
            $req->session()->put('user',$user);
            return Redirect::to('patientHome')->with('alert-success', 'You are now Patient in Site.');
        }
        else{
            $errors = new MessageBag(['email' => ['the email unvalid']]);
            return Redirect::back()->withErrors($errors);
        }
    }

    function SignUpDentist(Request $req)
    {
        $userEmail = DB::table('users')->where('email',$req->email)->get()->count();
        if($userEmail == 0){
            $user=new User();
            $clinic=new Clinic();
            $user->id=$req->session()->get('user')['id'];
            $user->firstName=$req->firstName;
            $user->lastName=$req->lastName;
            if($req->hasFile('photoDen')){
                $photoDen=$req->file('photoDen');
                $fileDen=time() . '.' . $photoDen->getClientOriginalExtension();
                Image::make($photoDen)->resize(300,300)->save(public_path('/image/' . $fileDen));
                $user->photo=$fileDen;
            }
            $user->email=$req->email;
            $user->password=Hash::make($req->password);
            $user->userType='Dentist';
            $user->save();
            $clinic->dentisId= $user->id;
            $clinic->clinicName=$req->clinicName;
            $clinic->clinicPhone=$req->clinicPhone;
            if($req->hasFile('photoCli')){
                $photoCli=$req->file('photoCli');
                $fileCli=time() . '.' . $photoCli->getClientOriginalExtension();
                Image::make($photoCli)->resize(300,300)->save(public_path('/image/' . $fileCli));
                $clinic->photo=$fileCli;
            }
            $clinic->clinicAddress=$req->clinicAddress;
            $clinic->save();
            $req->session()->put('user',$user);
            return Redirect::to('dentistHome')->with('alert-success', 'You are now Dentist in Site.');
        }
        else{
            $errors = new MessageBag(['email' => ['the email unvalid']]);
            return Redirect::back()->withErrors($errors);
        }
    }

    // Start Send Massage
    function sendMassage(Request $req)
    {
        $massage=new massage();
        $massage->FirstName=$req->FirstName;
        $massage->LastName=$req->LastName;
        $massage->Phone=$req->Phone;
        $massage->Email=$req->Email;
        $massage->Massage=$req->Massage;
        $massage->save();
        $Success = new MessageBag(['Done' => ['Amany']]);
        return Redirect::to('ContactUs')->withErrors($Success);

        // return redirect('/ContactUs');


    }
    // End Send Massage


}