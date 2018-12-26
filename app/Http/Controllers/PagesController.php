<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

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

    public function Login( Request $req ) {
        if( $req->session()->get( "user" ) ) {
            return redirect( "/dash" );
        } else {
            $error = "";
            if( $req->e == 1 )
                $error = "No such user";
            else if( $req->e == 2 )
                $error = "Wrong password";
            return view('pages.Login', [
                "error" => $error
            ]);
        }
    }

    public function LoginPost( Request $req ) {
        $uname = addslashes( $req->username );
        $passwd = addslashes( $req->password );
        $userq = "select * from users where uname=\"$uname\"";

        $userqres = DB::select( $userq );
        if( $userqres ) {
            if( $passwd == $userqres[0]->password ) {
                $req->session()->put( "user", $userqres[0] );
                return redirect( "/dash" );
            } else {
                return redirect( "/login?e=2" );
            }
        } else {
            return redirect( "/login?e=1" );
        }
    }

    public function Add(){
        return view('pages.Add');
    }

    public function SignUp(){
        return view('pages.SignUp');
    }

    public function Logout( Request $req ) {
        $req->session()->forget( "user" );
        return redirect( "/login" );
    }
}