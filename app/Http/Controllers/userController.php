<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\hash;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use App\Models\clinic;
use App\Models\users;



class userController extends Controller
{
    //
    function Login(Request $req)
    {
                $user=users::where(['email'=>$req->email])->select('users.*')->first();
                                
                if(!$user || !Hash::check($req->password , $user ->password))
                {
                    return redirect()->back()->with('altert-File','Password is Erorr');
                }
                else{
                    $req->session()->put('user',$user);
                        if($user['userType']=="Patient"){
                            return redirect('/patientHome')->with("alert-success","You Are Login As Patient");
                        }
                        else{
                            return redirect('/dentistHome')->with("alert-success","You Are Login As Dentist");
                        }
                    
                }
           
        
    }

    function SignUpPatient(Request $req)
    {
        $user=DB::table('users')->where('users.email',$req->email)->select('users.*')->get();
        if($user->isEmpty()){
            $patient=new users();
            $patient->email=$req->email;
            $patient->firstName=$req->firstName;
            $patient->lastName=$req->lastName;
            $patient->userType='Patient';
            $photoPat=$req->file('photoPat');
            $newPhoto=time().$photoPat->getClientOriginalName();
            Image::make($photoPat)->resize(300,300)->save(public_path('image/'.$newPhoto));
            $patient->photo=$newPhoto;
            $patient->password=Hash::make($req->password);
            $patient->save();
            $req->session()->put('user',$user);
            return redirect('/patientHome')->with("alert-success","You Are Login As Patient");;
        }else{
            return redirect()->back()->with('altert-File','Patient is Already Register');

        }

    }

    function SignUpDentist(Request $req)
    {
        $user=DB::table('users')->where('users.email',$req->email)->select('users.*')->get();
        if($user->isEmpty()){
            $dentist=new users();
            $dentist->email=$req->email;
            $dentist->firstName=$req->firstName;
            $dentist->lastName=$req->lastName;
            $dentist->userType='Dentist';
            $photoDen=$req->file('photoDen');
            $newPhoto=time().$photoDen->getClientOriginalName();
            Image::make($photoDen)->resize(300,300)->save(public_path('image/'.$newPhoto));
            $dentist->photo=$newPhoto;
            $dentist->password=Hash::make($req->password);
            $dentist->save();
            $clinic=new clinic();
            $clinic->dentisId=$dentist->id;
            $clinic->clinicName=$req->clinicName;
            $clinic->clinicPhone=$req->clinicPhone;
            $clinic->clinicAddress=$req->clinicAddress;
            $photoCli=$req->file('photoCli');
            $newCli=time().$photoCli->getClientOriginalName();
            Image::make($photoCli)->resize(300,300)->save(public_path('image/'.$newCli));
            $clinic->photo=$newCli;
            $clinic->save();
            $req->session()->put('user',$user);

            return redirect('/dentistHome')->with("alert-success","You Are Login As Dentist");;
        }else{
            return redirect()->back()->with('altert-File','Dentist is Already Register');

        }

    }
}
