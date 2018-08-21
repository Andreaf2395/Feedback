<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\clg_feedback;
use App\faculty;
use App\elsi_teachers_dtls;
use Log;
use Redirect;

class FeedbackController extends Controller
{
	public function fetch_form(){
			$colleges=DB::table('elsi_college_dtls')->select('college_name','id','district')->Orderby('college_name')->get();
		 return view('feedback.form_feedback',['colleges'=> $colleges]);
	}
   

   


    public function getfaculty($id)
    {
    	$faculty=DB::Table('elsi_teachers_dtls')->where('clg_id',$id)
                    ->select('id','name','designation','contact_num','emailid')
                    ->get();
    	return response()->json(['faculty'=>$faculty]);
 
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'college' => 'required',
            'no_students'=> 'required|numeric|min:0|max:100000',
            'comment' => 'required',
            'labimage'=> 'required',
            ],
            [ 'college.required'=> 'Please select the college name',
              'no_students.required'=>'Please mention the number of students that have been trained in the lab ',
              'no_students.numeric'=>'This field requires a number',
              'no_students.min'=> 'Number of students can not be negative',
              'comment.required'=>'Please comment on how the lab is being used ',
              'labimage.required'=>'Please upload few images of the lab',
            
            ]);

        if ($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $details= new clg_feedback;
        $details->clg_id = $request->input('college');
        $details->no_students = $request->input('no_students');
        $details->lab_usage = $request->input('comment');
        $details->lab_incharge=$request->input('lab_incharge');
        $details->save();
        return view('project');
    }

    public function fetch_new_form(){
        return view('feedback.imageupload');
    }


    public function storefaculty(Request $request){
      $validator = Validator::make($request->all(), [
            'faculty_name'=>'required|regex: /^[a-zA-Z]+$/|max:100',
            'designation'=>'required|regex: /^[a-zA-Z]+$/|max:100',
            'contact_no'=>'required|numeric|digits:10',
            'email'=>'required|email',
            ],
            [ 
              'faculty_name.regex'=>'Please enter aplabets only.',
              'faculty_name.max'=>'Not more than 100 characters allowed.',
              'desigantion.regex'=>'Please enter aplabets only.',
              'designation.max'=>'Not more than 100 characters allowed.',
              'mobile.numeric'=>'Please insert numbers only',
              'mobile.digits'=>'Please enter a 10 digit number.',
              'email'=> 'Please enter a valid email address.',
            
            ]);

        if ($validator->fails()) {
            Log::info('validation fail!!!');
             return array(
                    'fail' => true,
                    'errors' => $validator->errors()
                );
        }
        $faculty= new elsi_teachers_dtls;
        $faculty->clg_id=$request->input('clg_id');
        $faculty->name=$request->input('faculty_name');
        $faculty->designation=$request->input('designation');
        $faculty->emailid=$request->input('email');
        $faculty->contact_num=$request->input('contact_no');
        $faculty->status='Active';
        $faculty->save();
              log::info("sdfhh");

    }

}
