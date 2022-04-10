<?php 

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\User;

class AvatarController extends Controller
{
    public function get(){
        $id=\Auth::user()->id;
        $info=DB::table('users')->where('id',$id)->first();
        $filename=$info->image;
        $file=Storage::disk('public')->get($filename);
        return new Response($file);
    }

    public function update(Request $request){
        $id=\Auth::user()->id;
        $image=$request->file('image');

        $data = $request->validate([
            'image'   => ['required', 'mimes:jpg,png,jpeg,gif,tiff,svg|max:2048'],
      
        ]);

        if ($data){
            $path=$image->store('public');
            $regex="/.+\/(.+\..+)/";
            $route=array();
            preg_match($regex,$path,$route);
            $filename=$route[1];
            User::where('id',$id)->update([
                'image'=>$filename
            ]);

            return response()->json(['success'=>'You have successfully uploaded your image.']);
        }
       
    }
}