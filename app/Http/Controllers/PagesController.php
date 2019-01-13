<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
$sent = [];

class PagesController extends Controller
{
    public function __construct() {
        $this->middleware( "auth" )->except( "Login", "SignUp", "LoginPost", "SignUpPost", "Fetch" );
    }

    public function Fetch( Request $req ) {
        $query = "
            select
                a.*,
                b.*
            from
                appointments a join
                users b
            on
                a.repeat!=\"Ended\" and
                time( now() )>=a.start_time and
                time( now() )<=a.end_time and
                a.date>=date( now() ) left join
                guests c
                    on
                        c.appointment_id=a.appointment_id and
                        if( c.user_id is not null, c.user_id, a.creator )=b.user_id
        ";

        $data = json_encode( DB::select( $query ) );

        echo $data;
    }

    public function tokenfieldget( Request $req ){
        $var = $req->data;
        $data = json_encode( DB::select("select concat(fname,\" \",lname) as name from users where concat(fname,\" \",lname) like \"%$var%\""));
        echo $data;
    }

    public function FetchPost( Request $req ) {
        // save sent notifs to db
        // tanginah mo ikaw na bahala 
    }

    public function Dash( Request $req ){        
        return view('pages.Dash');
    }

    public function DashFetch( Request $req ) {
        $uid = $req->session()->get( "user" )->user_id;
        $query = "
            select
                b.*,
                if (
                    ( 
                        (
                            b.repeat=\"None\" and
                            b.date=date( now() )
                        ) and (
                            time( now() )>=b.start_time and
                            time( now() )<=b.end_time
                        )
                    ) or (
                        (
                            b.repeat=\"Daily\" and
                            date( now() )>=b.date
                        ) and (
                            time( now() )>=b.start_time and
                            time( now() )<=b.end_time
                        )
                    ) or (
                        (
                            b.repeat=\"Weekly\" and
                            datediff( b.date, date( now() ) ) % 7=0
                        ) and (
                            time( now() )>=b.start_time and
                            time( now() )<=b.end_time
                        )
                    ) or (
                        (
                            b.repeat=\"Monthly\" and
                            (
                                if( day( b.date ) > day( date( now() ) ), last_day( day( date( now() ) ) ), day( b.date ) )
                            )=day( date( now() ) )
                        ) and (
                            time( now() )>=b.start_time and
                            time( now() )<=b.end_time
                        )
                    ), \"Ongoing\", \"Upcoming\" ) as status                 
            from
                appointments b left join
                guests a
            on
                ( a.user_id=$uid and a.appointment_id=b.appointment_id ) or b.creator=$uid
        ";

        $tdata = DB::select( $query );
        $pdata = [];
        foreach( $tdata as $row ) {
            $arr = [
                "id" => $row->appointment_id,
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
        return view( 'pages.Appointments' );
    }

    public function EventsFetch( Request $req ) {
        $id = $req->session()->get( "user" )->user_id;
        $query = "
            select
                b.*,
                if (
                    ( 
                        (
                            b.repeat=\"None\" and
                            b.date=date( now() )
                        ) and (
                            time( now() )>=b.start_time and
                            time( now() )<=b.end_time
                        )
                    ) or (
                        (
                            b.repeat=\"Daily\" and
                            date( now() )>=b.date
                        ) and (
                            time( now() )>=b.start_time and
                            time( now() )<=b.end_time
                        )
                    ) or (
                        (
                            b.repeat=\"Weekly\" and
                            datediff( b.date, date( now() ) ) % 7=0
                        ) and (
                            time( now() )>=b.start_time and
                            time( now() )<=b.end_time
                        )
                    ) or (
                        (
                            b.repeat=\"Monthly\" and
                            (
                                if( day( b.date ) > day( date( now() ) ), last_day( day( date( now() ) ) ), day( b.date ) )
                            )=day( date( now() ) )
                        ) and (
                            time( now() )>=b.start_time and
                            time( now() )<=b.end_time
                        )
                    ), \"Ongoing\", \"Upcoming\" ) as status                 
            from
                appointments b
            where
                b.creator=$id
        ";
        $data = json_encode( DB::select( $query ) );
        echo $data;
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
        $creator = $req->session()->get( "user" )->user_id;
        $ename = addslashes( $req->ename );
        $edesc = addslashes( $req->edesc );
        $date = addslashes( $req->date );
        $stime = addslashes( $req->stime );
        $etime = addslashes( $req->etime );
        $repeat = "None";
        if( $req->repeatwhen )
            $repeat = $req->repeatwhen;

        $query = "
            insert into
                appointments(
                    `creator`,
                    `name`,
                    `desc`,
                    `date`,
                    `epart`,
                    `start_time`,
                    `end_time`,
                    `repeat`
                ) values(
                    $creator,
                    \"$ename\",
                    \"$edesc\",
                    \"$date\",
                    \"$stime\",
                    \"$etime\",
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
        $query = "select * from appointments where appointment_id=$id";

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
        $stime = addslashes( $req->stime );
        $etime = addslashes( $req->etime );
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
                    `start_time`=\"$stime\",
                    `end_time`=\"$etime\",
                    `repeat`=\"$repeat\"
                where
                    appointment_id=$id
        ";

        $success = 0;
        if( DB::update( $query ) )
            $success = 1;
        $json = [ "success" => $success ];
        echo json_encode( $json );  
    }

    public function Delete( Request $req ) {
        $id = addslashes( $req->id );

        $query = "delete from appointments where appointment_id=$id";
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
        $fname = addslashes( $req->fname );
        $mname = addslashes( $req->mname );
        $lname = addslashes( $req->lname );
        $fb_id = addslashes( $req->fb_id );

        $q = "
            insert into users(
                uname,
                password,
                facebook_id,
                fname,
                lname
            ) values (
                \"$uname\",
                \"$passwd\",
                \"$fb_id\",
                \"$fname\",
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
