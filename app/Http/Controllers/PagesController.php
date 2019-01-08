<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PagesController extends Controller
{
    public function __construct() {
        $this->middleware( "auth" )->except( "Login", "SignUp", "LoginPost", "SignUpPost" );
        $query = "
            select
                b.*,
                if (
                    ( 
                        (
                            b.repeat=\"None\" and
                            date( b.date )=date( now() )
                        ) and time( now() )>=time( b.date )
                    ) or (
                        (
                            b.repeat=\"Daily\" and
                            date( now() )>=date( b.date )
                        ) and time( now() )>=time( b.date )
                    ) or (
                        (
                            b.repeat=\"Weekly\" and
                            datediff( date( b.date ), date( now() ) ) % 7=0
                        ) and time( now() )>=time( b.date )
                    ) or (
                        (
                            b.repeat=\"Monthly\" and
                            (
                                if( day( b.date ) > day( date( now() ) ), last_day( day( date( now() ) ) ), day( b.date ) )
                            )=day( date( now() ) )
                        ) and time( now() )>=time( b.date )
                    ), \"Ongoing\", \"Upcoming\" ) as status                 
            from
                guests a left join
                appointments b
            on
                a.appointment_id=b.id
        ";
    }

    public function Dash( Request $req ){        
        return view('pages.Dash');
    }

    public function DashFetch( Request $req ) {
        $uid = $req->session()->get( "user" )->id;
        $query = "
            select
                b.*,
                if (
                    ( 
                        (
                            b.repeat=\"None\" and
                            date( b.date )=date( now() )
                        ) and time( now() )>=time( b.date )
                    ) or (
                        (
                            b.repeat=\"Daily\" and
                            date( now() )>=date( b.date )
                        ) and time( now() )>=time( b.date )
                    ) or (
                        (
                            b.repeat=\"Weekly\" and
                            datediff( date( b.date ), date( now() ) ) % 7=0
                        ) and time( now() )>=time( b.date )
                    ) or (
                        (
                            b.repeat=\"Monthly\" and
                            (
                                if( day( b.date ) > day( date( now() ) ), last_day( day( date( now() ) ) ), day( b.date ) )
                            )=day( date( now() ) )
                        ) and time( now() )>=time( b.date )
                    ), \"Ongoing\", \"Upcoming\" ) as status                 
            from
                guests a left join
                appointments b
            on
                ( a.user_id=$uid and a.appointment_id=b.id ) or b.creator=$uid
        ";

        $tdata = DB::select( $query );
        $pdata = [];
        foreach( $tdata as $row ) {
            $arr = [
                "ename" => $row->name,
                "edate" => $row->date,
                "status" => $row->status
            ];
            array_push( $pdata, $arr );
        }
        $data[ "data" ] = $pdata;
        $data = json_encode( $data );
        echo $data;
    }

    public function Events( Request $req ) {
        $id = $req->session()->get( "user" )->id;
        $query = "select * from appointments where creator=$id";
        $data = DB::select( $query );

        return view( 'pages.Appointments', [
            "data" => $data
        ]);
    }

    public function User() {
        return view('pages.User');
    }

    public function Login( Request $req ) {
        if( $req->session()->get( "user" ) ) {
            return redirect( "/dash" );
        } else {
            return view('pages.Login' );
        }
    }

    public function LoginPost( Request $req ) {
        $uname = addslashes( $req->username );
        $passwd = addslashes( $req->password );
        $userq = "select * from users where uname=\"$uname\"";
        $success = 0;

        $userqres = DB::select( $userq );
        if( $userqres ) {
            if( $passwd == $userqres[0]->password ) {
                $req->session()->put( "user", $userqres[0] );
                $success = 1;
            }
        }

        $json = [ "success" => $success ];
        echo json_encode( $json );
    }

    public function Add( Request $req ) {
        return view('pages.Add');
    }

    public function AddPost( Request $req ) {
        $creator = $req->session()->get( "user" )->id;
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
                    `creator`,
                    `name`,
                    `desc`,
                    `location`,
                    `date`,
                    `start_time`,
                    `end_time`,
                    `repeat`
                ) values(
                    $creator,
                    \"$ename\",
                    \"$edesc\",
                    \"$elocation\",
                    \"$date\",
                    \"$stime\",
                    \"$etimme\",
                    \"$repeat\"
                )
        ";

        $success = 0;
        if( DB::insert( $query ) )
            $success = 1;
        $json = [ "success" => $success ];
        echo json_encode( $json );
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
        $date = addslashes( $req->date ). " " .addslashes( $req->time );
        $repeat = "None";
        if( $req->repeat != "None" )
            $repeat = addslashes( $req->repeatwhen );

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

        $success = 0;
        if( DB::update( $query ) )
            $success = 1;
        $json = [ "success" => $success ];
        echo json_encode( $json );  
    }

    public function Delete( Request $req ) {
        $id = addslashes( $req->id );

        $query = "delete from appointments where id=$id";
        $success = 0;

        if( DB::delete( $query ) )
            $success = 1;
        $json = [ "success" => $success ];
        echo json_encode( $json );
    }

    public function SignUp( Request $req ) {
        return view('pages.SignUp');
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

        $success = 0;
        if( DB::insert( $q ) )
            $success = 1;
        $json = [ "success" => $success ];
        echo json_encode( $json );        
    }

    public function Logout( Request $req ) {
        $req->session()->forget( "user" );
        return redirect( "/login" );
    }
}
