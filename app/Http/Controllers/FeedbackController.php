<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\clg_feedback;
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
            ],
            [ 'college.required'=> 'Please select the college name',
              'no_students.required'=>'Please mention the number of students that have been trained in the lab ',
              'no_students.numeric'=>'This field requires a number',
              'no_students.min'=> 'Number of students can not be negative',
              'comment.required'=>'Please comment on how the lab is being used ',
            
            ]);

        Log:info('In store');
        $details= new clg_feedback;
        $details->clg_name = $request->input('college');
        $details->no_students = $request->input('no_students');
        $details->lab_usage = $request->input('comment');
        $details->image1  =$request->input('file_name');
        $details->save();
        return view('feedback.success');
    }

    public function fetch_new_form(){
        return view('feedback.imageupload');
    }

}
