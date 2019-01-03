<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PagesController extends Controller
{
    public function __construct() {
        $this->middleware( "auth" )->except( "Login", "SignUp", "LoginPost", "SignUpPost" );
    }

    public function Dash(){
        $data = DB::select("select * from appointments");
        return view('pages.Dash', ["data" => $data ]);
    }

    public function Events(){
        $data = DB::select( "select * from appointments" );

        return view('pages.Appointments', [
            "data" => $data
        ]);
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

    public function Add( Request $req ) {
        $success = "";

        if( $req->success == 1 )
            $success = "Appointment added successfully";
        return view('pages.Add', [
            "success" => $success
        ]);
    }

    public function AddPost( Request $req ) {
        $ename = addslashes( $req->ename );
        $edesc = addslashes( $req->edesc );
        $elocation = addslashes( $req->elocation );
        $date = addslashes( $req->date ). " " .addslashes( $req->time );
        $repeat = "None";
        if( $req->repeatwhen )
            $repeat = $req->repeatwhen;

        $query = "
            insert into
                appointments(
                    `name`,
                    `desc`,
                    `location`,
                    `date`,
                    `repeat`
                ) values(
                    \"$ename\",
                    \"$edesc\",
                    \"$elocation\",
                    \"$date\",
                    \"$repeat\"
                )
        ";

        DB::insert( $query );
        return redirect( "/appointments/add?success=1" );
    }

    public function Edit( Request $req ) {
        $id = addslashes( $req->id );
        $query = "select * from appointments where id=$id";

        $data = DB::select( $query )[0];
        return view( "pages.Edit", [
            "data" => $data
        ]);
    }

    public function EditPost( Request $req ) {
        $id = addslashes( $req->id );
        $ename = addslashes( $req->ename );
        $edesc = addslashes( $req->edesc );
        $elocation = addslashes( $req->elocation );
        $date = addslashes( $req->date );
        $repeat = addslashes( $req->repeat );

        $query = "
            update appointments
                set
                    `name`=\"$ename\",
                    `desc`=\"$edesc\",
                    `location`=\"$elocation\",
                    `date`=\"$date\",
                    `repeat`=\"$repeat\"
                where
                    id=$id
        ";

        DB::update( $query );
        return redirect( "/appointments/edit?id=". $id );
    }

    public function Delete( Request $req ) {
        
    }

    public function SignUp( Request $req ) {
        $success = 0;
        if( $req->success == 1 )
            $success = 1;
        return view('pages.SignUp', [
            "success" => $success
        ]);
    }

    public function SignUpPost( Request $req ) {
        $uname = addslashes( $req->username );
        $passwd = addslashes( $req->password );
        $email = addslashes( $req->email );
        $fname = addslashes( $req->fname );
        $mname = addslashes( $req->mname );
        $lname = addslashes( $req->lname );
        $fb_id = addslashes( $req->facebook_id );

        $q = "
            insert into users(
                uname,
                password,
                email,
                fname,
                mname,
                lname
            ) values (
                \"$uname\",
                \"$passwd\",
                \"$email\",
                \"$fname\",
                \"$mname\",
                \"$lname\"
            )
        ";

        DB::insert( $q );
        return redirect( "/signup?success=1" );
    }

    public function Logout( Request $req ) {
        $req->session()->forget( "user" );
        return redirect( "/login" );
    }
}
