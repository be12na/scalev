<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserBaruMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'whatsapp' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

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

        event(new Registered($user));

        Auth::login($user);

        Mail::to($user->email)->send(new UserBaruMail($user));

        
        $this->sendWa($user->name,$user->email,$user->username,$user->whatsapp);

        return redirect(route('dashboard', absolute: false));
    }
}
