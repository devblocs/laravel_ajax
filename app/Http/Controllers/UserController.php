<?php

namespace App\Http\Controllers;

use Validator;
use App\UserDetail;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){

        $userdetails = UserDetail::all();
        return view('user')->with('userdetails', $userdetails);
    }

    public function create(Request $req){

        //return response()->json($req->all());

        $filename="";
        $skills = "";
        
        $rules = [
            'bio' => 'required',
            'about' => 'required|max:100'
        ];

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->getMessageBag()>toArray()
            ]);
        }else{
         
            if( $req->hasFile('profile_pic')) {
                $image = $req->file('profile_pic');
                $path = public_path(). '/images/';
                $filename = time().rand().'.' . $image->getClientOriginalExtension();
                $image->move($path, $filename);
            }

            if($req->has('skills')){
                $skills = implode(',', $req->skills);
            }

            if($req->has('job_type')){
                $job_type = implode(',', $req->job_type);
            }

            $ud = ['bio' => $req->bio, 'gender' => $req->gender, 'about' => $req->about, 'profile_pic' => $filename, 'skills' => $skills, 'job_type' => $job_type];

            $userdetail = UserDetail::create($ud);

            if($userdetail){

                $skills = explode(',', $userdetail->skills);
                $job_type = explode(',', $userdetail->job_type);
                return response()->json(['status' => true, 'bio' => $userdetail->bio, 'about' => $userdetail->about, 'gender' => $userdetail->gender, 'profile_pic' => $userdetail->profile_pic, 'skills' => $skills, 'job_type' => $job_type]);
            }

            return response()->json(['status' => false]); 
        }
    }
}
