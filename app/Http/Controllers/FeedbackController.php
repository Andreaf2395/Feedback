<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\clg_feedback;
use App\faculty;
use Log;

class FeedbackController extends Controller
{
	public function fetch_form(){
			$colleges=DB::table('elsi_college_dtls')->select('college_name','id','district')->Orderby('college_name')->get();

		 return view('feedback.form_feedback',['colleges'=> $colleges]);
	}
   

   


    public function getfaculty($id)
    {
    	$faculty=DB::Table('elsi_teachers_dtls')->where('clg_id',$id)
                    ->select('name','designation','contact_num','emailid')
                    ->get();
    	
    	return response()->json(['faculty'=>$faculty]);
 
    }

    public function store(Request $request)
    {
        //dd($request->all());


        $input=$request->validate([
            'college' => 'required',
            'no_students'=> 'required|numeric|min:0',
            'comment' => 'required',
            'labimage'=> 'required',
            'faculty_name'=>'regex: ^[a-zA-Z]+$|max:100',
            'designation'=>'regex: ^[a-zA-Z]+$|max:100',
            'mobile'=>'numeric|digits:10',
            'email'=>'email',
            ],
            [ 'college.required'=> 'Please select the college name',
              'no_students.required'=>'Please mention the number of students that have been trained in the lab ',
              'no_students.numeric'=>'This field requires a number',
              'no_students.min'=> 'Number of students can not be negative',
              'comment.required'=>'Please comment on how the lab is being used ',
              'labimage.required'=>'Please upload few images of the lab',
              'faculty_name.regex'=>'Please enter aplabets only.',
              'faculty_name.max'=>'Not more than 100 characters allowed.',
              'desigantion.regex'=>'Please enter aplabets only.',
              'designation.max'=>'Not more than 100 characters allowed.',
              'mobile.numeric'=>'Please insert numbers only',
              'mobile.digits'=>'Please enter a 10 digit number.',
              'email'=> 'Please enter a valid email address.',
            
            ]);

        Log:info('In store');

        
        $faculty= new faculty;
        $faculty->clg_id=$request->input('college');
        $faculty_name=$request->input('faculty_name');
        $designation=$request->input('designation');
        $email=$request->input('email');
        $contact_no=$request->input('contact_no');
        
        if(isset($faculty_name)){
            for($i=0;$i<count($faculty_name) ;$i++)
           {
            $faculty->faculty_name=$faculty_name[$i];
            $faculty->designation=$designation[$i];
            $faculty->mobile_no=$contact_no[$i];
            $faculty->email=$email[$i];
            $faculty->save();
           }
        }
       
        

        $details= new clg_feedback;
        $details->clg_id = $request->input('college');
        $details->no_students = $request->input('no_students');
        $details->lab_usage = $request->input('comment');
        $details->save();
        return view('feedback.success');
    }

    public function fetch_new_form(){
        return view('feedback.imageupload');
    }

}
