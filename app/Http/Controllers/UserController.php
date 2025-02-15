<?php

namespace App\Http\Controllers;

use App\Mail\UserBaruMail;
use App\Models\User;
use App\Notifications\PesanWhatsApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;


use Illuminate\Validation\Rules;

class UserController extends Controller
{
    private function sendWa($name,$email,$username,$wa){

        $pesan = "Halo, *".$name."*\nKami dengan senang hati menyambut Anda sebagai bagian dari tim kami.\n\nUsername Anda : *".$username."*\nEmail anda : *".$email."*\nNo. WhatsApp Anda : *".$wa."* \n\nKami berharap Anda dapat memberikan kontribusi terbaik dan berkembang bersama kami.\nJika ada pertanyaan, jangan ragu untuk menghubungi tim HRD kami";

        $url = 'https://wa4307.cloudwa.my.id/api/v1/messages';
        $token = 'u5638a6c7962f407.0541d180357043edb2710574e1199043';
        $nowa = $wa;

        $response = Http::withToken($token)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, [
                'recipient_type' => 'individual',
                'to' => $nowa,
                'type' => 'text',
                'text' => [
                    'body' => $pesan 
                ]
            ]);

        return $response;
    
    }

    public function index(Request $request) {

        $dataList = User::orderBy('created_at','desc');

        $dataList = $dataList->whereNotIn('id',[Auth::user()->id]);

        if($request->cari){

            $dataList = $dataList->where('name', 'like', "%{$request->cari}%")
            ->orWhere('username', 'like', "%{$request->cari}%")
            ->orWhere('whatsapp', 'like', "%{$request->cari}%")
            ->orWhere('email', 'like', "%{$request->cari}%");


        }
       
        $dataList = $dataList->paginate(50)->withQueryString();

        return view('user.index',compact('dataList'));
    }

    public function create() {

        return view('user.create');
    }

    public function store(Request $request){
        $rules = [          
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'whatsapp' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
		];

        $attributes = [

            'name'  => 'Name',
            'username'  => 'Username',
            'whatsapp'  => 'Whatsapp',
            'email'  => 'Email',
            'password'  => 'Password',
        
        ];

        $validated = Validator::make($request->all(), $rules, [], $attributes)->validate();

        $phone = $request->whatsapp;

        $phone = preg_replace('/\D/', '', $phone);

        // Jika nomor diawali "0", ganti dengan "62"
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // Jika nomor diawali "+62", hapus "+"
        if (substr($phone, 0, 3) === '620') {
            $phone = '62' . substr($phone, 2);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'whatsapp' => $phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Mail::to($user->email)->send(new UserBaruMail($user));

        $this->sendWa($user->name,$user->email,$user->username,$user->whatsapp);

        return redirect()->route('user.index')->with('success', 'User created successfully!');
       
    }

    public function edit($id) {

        $user = User::find($id);

        return view('user.edit',compact('user'));
    }

    public function update($id, Request $request){

        $user = User::find($id);

        $rules = [          
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'whatsapp' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
		];

        $attributes = [

            'name'  => 'Name',
            'username'  => 'Username',
            'whatsapp'  => 'Whatsapp',
            'email'  => 'Email',
            'password'  => 'Password',
        
        ];

        $validated = Validator::make($request->all(), $rules, [], $attributes)->validate();

        $phone = $request->whatsapp;

        $phone = preg_replace('/\D/', '', $phone);

        // Jika nomor diawali "0", ganti dengan "62"
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // Jika nomor diawali "+62", hapus "+"
        if (substr($phone, 0, 3) === '620') {
            $phone = '62' . substr($phone, 2);
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->whatsapp = $phone;
        $user->email = $request->email;

        if($request->password){
            $user->password = Hash::make($request->password);
        }

        $user->save();

        Mail::to($user->email)->send(new UserBaruMail($user));

        $this->sendWa($user->name,$user->email,$user->username,$user->whatsapp);
     
         

        // dd(response()->json($response->json()));
    
        

        
       
        return redirect()->route('user.index')->with('success', 'User updated successfully!');

    }

    public function delete($id, Request $request){
        $user = User::find($id);

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully!');

    }

}
