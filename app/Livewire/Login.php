<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function render()
    {
        return view('livewire.login')->extends('layouts.app');
    }

    public function submit()
    {

        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) {
            // Authentication successful
            return redirect()->intended('/');
        } else {
            // Authentication failed
            session()->flash('error', 'Email or password incorrect.');
        }
    }

    public function redirectToRegister()
    {
        // Redirect to your registration route
        return redirect()->to('/register');
    }
}
