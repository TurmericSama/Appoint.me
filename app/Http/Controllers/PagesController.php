<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function Dash(){
        return view('pages.Dash');
    }

    public function Events(){
        return view('pages.Appointments');
    }

    public function User(){
        return view('pages.User');
    }

    public function Login(){
        return view('pages.Login');
    }

    public function Add(){
        return view('pages.Add');
    }

    public function SignUp(){
        return view('pages.SignUp');
    }

    public function Logout(){
        return view('pages.Login');
    }
}
