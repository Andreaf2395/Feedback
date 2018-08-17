<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Image_dtls;
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
            $imagename = $college_code.'_'.mt_rand(1,100).'_'.$image->getClientOriginalName(); 
            $destination=public_path($dir.'/'.$imagename);

            //add image details to database
            $file= new Image_dtls;
            $file->clg_id=$clg_id;
            $file->clg_code=$college_code;
            $file->filepath=$destination;
            $file->save();

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

             return response()->json(['image_name'=>$imagename]);
        }
        
    


    public function deleteImage(Request $request)
    {

    	$filename=request('filename');
    	  $clg_id=request('college_id');
    	  Log::info('deleting '.'images/'.$clg_id.'/'.$filename);
        $dir = 'images/'.$clg_id;
    	 File::delete($dir.'/'.$filename);

        $files = File::files($dir);
        
         if(empty($files))
         {
            Log::info('HERE HERE HERE ');
            Log::info($files);
             return response()->json(['empty'=> true]);   
         }
           
    
    }






}
