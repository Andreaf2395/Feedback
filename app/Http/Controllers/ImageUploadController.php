<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Log;

class ImageUploadController extends Controller
{
    //


    public function uploadImage(Request $request)
    {
    		
           $validator = Validator::make($request->all(),[
        		'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        		'college_id'=> 'required',
    		],[
                'image.image'=>' The file must be an image. ',
                'image.max' => 'Maximum file size should 2MB. ',
                'college_id'=> 'Please select a college first. '
            ]);
                
            if ($validator->fails())
                return array(
                    'fail' => true,
                    'errors' => $validator->errors()
                );
            
            
            $extension = $request->file('image')->getClientOriginalExtension();
            $clg_id=request('college_id');
            $dir = 'images/'.$clg_id;
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $request->file('image')->move($dir, $filename);
            $path=$dir.'/'.$filename;
             Log::info('this is the path '.$path);

             $files = File::files($dir);

             foreach($files as $file)
             {
                $file_dtls[]=pathinfo($file);

             }
              return response()->json(['files'=>$file_dtls]);
        }
        
    


    public function deleteImage(Request $request)
    {

    	$filename=request('filename');
    	  $clg_id=request('college_id');
    	  Log::info('deleting '.'images/'.$clg_id.'/'.$filename);
        $dir = 'images/'.$clg_id;
    	 File::delete($dir.'/'.$filename);

         $files = File::files($dir);

             foreach($files as $file)
             {
                $file_dtls[]=pathinfo($file);
             }

         if(empty($file_dtls))
            return response()->json(['empty'=> true]);   
        return response()->json(['files'=>$file_dtls]);
    }
}
