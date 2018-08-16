<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;
use Image;

class ImageUploadController extends Controller
{
    //


    public function uploadImage(Request $request)
    {
    		
         $validator = Validator::make($request->all(),[
                'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048|dimensions:min_width=600,min_height=300',
                'college_id'=> 'required',
            ],[
                'image.image'=>' The file must be an image. ',
                'image.dimensions'=>'The dimensions of the file should be 600x300',
                'image.max' => 'Maximum file size should 2MB. ',
                'college_id'=> 'Please select a college first. '
            ]);
                
            if ($validator->fails())
                return array(
                    'fail' => true,
                    'errors' => $validator->errors()
                );
            

            $clg_id=request('college_id');
            $dir='images/'.$clg_id;
            if(!File::exists($dir)) {
                File::makeDirectory($dir, $mode = 0777, true);
            }


            $image =$request->file('image');
            $college_code=DB::table('elsi_college_dtls')->where('id',$clg_id)->value('clg_code');
            $imagename = $college_code.'_'.$image->getClientOriginalName(); 
            $destination=public_path($dir.'/'.$imagename);


            Log::info($destination);
            $newimage=Image::make($image);
            if($newimage->width() >= 600 && $newimage->height() >= 300)
            {  
             $newimage = Image::make($image->getRealPath())->resize(600, 300);
            }
            $newimage->save($destination,80);

            /*
            $extension = $request->file('image')->getClientOriginalExtension();
            $clg_id=request('college_id');
            $dir = 'images/'.$clg_id;
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $request->file('image')->move($dir, $filename);
            $path=$dir.'/'.$filename;*/
            

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



////new part
    public function newimageupload(Request $request){



           $validator = Validator::make($request->all(),[
                'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048|dimensions:min_width=600,min_height=300',
                'college_id'=> 'required',
            ],[
                'image.image'=>' The file must be an image. ',
                'image.min_width'=> 'The file width should be 600',
                'image.min_height'=>'The file height should be 300',
                'image.max' => 'Maximum file size should 2MB. ',
                'college_id'=> 'Please select a college first. '
            ]);
                
             $clg_id=request('college_id');

            if ($validator->fails())
                return array(
                    'fail' => true,
                    'errors' => $validator->errors()
                );
            
            $dir='images/'.$clg_id;
            if(!File::exists($dir)) {
                File::makeDirectory($dir, $mode = 0777, true);
            }
            $image =$request->file('image');
            $college_code=DB::table('elsi_college_dtls')->where('id',$clg_id)->value('clg_code');
            $imagename = $college_code.'_'.$image->getClientOriginalName(); 
            $destination=public_path('/images/'.$clg_id.'/'.$imagename);


             Log::info($destination);
            $newimage=Image::make($image);
            if($newimage->width() >= 600 && $newimage->height() >= 300)
            {  
             $newimage = Image::make($image->getRealPath())->resize(600, 300);
            }
            $newimage->save($destination,80);
        



    }





}
