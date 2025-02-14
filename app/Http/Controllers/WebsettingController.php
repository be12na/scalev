<?php

namespace App\Http\Controllers;

use App\Models\Websetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WebsettingController extends Controller
{
    public function index(){

        $dataList = Websetting::orderBy('urut','asc')->get();

        return view('setting.index',compact('dataList'));
    }

    public function store(Request $request){

        $data =  Websetting::where('slug',$request->slug)->first();

        if($data->type == 3){

            $rules = [          
               
                'content' => ['required','image','mimes:jpeg,png,jpg,webp','max:10240'],
               
            ];
    
            $messages = [
                'required' => ':attribute '.$data->heading.' harus diisi',
                
            ];
    
            $attributes = [
                'content'  => 'Value '.$data->heading
            ];
    
            $validated = Validator::make($request->all(), $rules, [], $attributes)->validate();

            if($request->content){

                if($data->content){
    
                    if (Storage::disk('public')->exists($data->content)) {
                        Storage::disk('public')->delete($data->content);
                        
                    }
    
                }
                
                $path =  $request->file('content')->store('setting','public');

                
            }else{
                $path = $data->content;  
            }

            $dataUpdate = $path;

          

        }else{

            $rules = [          
               
                'content' => ['required'],
               
            ];
    
            $messages = [
                'required' => ':attribut '.$data->heading.' harus diisi',
                
            ];
    
            $attributes = [
                'content'  => 'Value '.$data->heading
            ];
    
            $validated = Validator::make($request->all(), $rules, [], $attributes)->validate();


            $dataUpdate = $request->content;
    

        }

        $data->content = $dataUpdate;

        $data->save();

        Websetting::setValue($data->slug, $data->content);

        
        return redirect()->back()->with('success', 'Setting updated successfully!');

    }
}
