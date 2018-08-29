<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\project_dtls;
use Log;

class SubmitController extends Controller
{
    public function create()
    {
    	return view();
    }
    public function store()
    {
        $storedata= new project_dtls;
        Log::info('in submitcontroller');
    	$storedata->projectname = request('projectname');
    	$storedata->participant = request('participant');
    	$storedata->category = request('category');
    	$storedata->image = request('photo');
    	$storedata->description = request('description');
        $storedata->save();

        return view('feedback.success');
    }
}
