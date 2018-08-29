<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\clg_feedback;
use App\faculty;
use App\elsi_teachers_dtls;
use Log;
use App\project_dtls;
use Redirect;
use Session;

class FeedbackController extends Controller
{
	public function fetch_form(){
			$colleges=DB::table('elsi_college_dtls')->select('college_name','id','district')->Orderby('college_name')->get();
		 return view('feedback.form_feedback',['colleges'=> $colleges]);
	}
   

   


    public function getfaculty($id)
    {
      Session::put('college_id',$id);
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
            'lab_incharge'=>'required',
            ],
            [ 'college.required'=> 'Please select the college name',
              'no_students.required'=>'Please mention the number of students that have been trained in the lab ',
              'no_students.numeric'=>'This field requires a number',
              'no_students.min'=> 'Number of students can not be negative',
              'comment.required'=>'Please comment on how the lab is being used ',
              'labimage.required'=>'Please upload few images of the lab',
              'lab_incharge.required'=>'Please select a lab incharge.',
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
        return view('feedback.project_form');
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
        $faculty->remark='feedback_form_entry';
        $faculty->save();
              log::info("sdfhh");

    }





    //store project dtls
    public function store_project(Request $request){
      Log::info('in store project');
      Log::info($request->all());
     
    //$request->validate( [
       $validator = Validator::make($request->all(), [
      'project.*.project_name'=>'bail|required|max:100',
      'project.*.no_participants'=>'bail|required|numeric|min:0|max:100000',
      'project.*.category'=> 'required',
      'project.*.description'=>'required',
    ],[
        'project.*.project_name.required'=>'Please mention the project name.',
        'project_name.*.max'=>'Not more than 100 characters allowed.',
        'project.*.no_participants.required'=>'Please mention the number of participants ',
        'project.*.no_participants.numeric'=>'This field requires a number',
        'project.*.no_participants.min'=> 'Number of students can not be negative',
        'project.*.category.required'=>'Please select a category',
        'project.*.description.required'=> 'Please describe your project',
    ]);

       $projects=$request->input('project');
       log::info($request->all());
       //$no_clones=count($projects);
       $errors=$validator->errors();

           if ($validator->fails()) {
            Log::info('validation fail!!!');
             return response()->json(array(
                    //'no_clones'=>$no_clones,
                    'fail' => true,
                    'errors' => $errors,
                  )
                );
        }

     /*
      $project_name=$request->input('project_name');
      $no_participants=$request->input('no_participants');
      $category=$request->input('category');
      $description=$request->input('description');
      for($i=0;$i<count($project_name);$i++)
      {
         $storedata= new project_dtls;
        $storedata->projectname=$project_name[$i];
        $storedata->no_participants=$no_participants[$i];
        $storedata->category=$category[$i];
        $storedata->description=$description[$i];
        $storedata->save();
        //Log::info($storedata);
      }
      */

      foreach($projects as $project)
      {
        $storedata= new project_dtls;
        $storedata->projectname=$project['project_name'];
        $storedata->no_participants=$project['no_participants'];
        $storedata->category=$project['category'];
        $storedata->description=$project['description'];
        $storedata->save();
      }
    
      return Redirectview('feedback.success');
    }

}
