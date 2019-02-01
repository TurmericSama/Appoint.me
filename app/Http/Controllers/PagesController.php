<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PagesController extends Controller
{
    public function __construct() {
        $this->middleware( "auth" )->except( "Login", "SignUp", "LoginPost", "SignUpPost", "Fetch", "FetchPost", "GetSent" );
    }

    public function tokenfieldget( Request $req ){
        $uid = $req->session()->get( "user" )->user_id;
        $var = $req->name;
        $data = json_encode( DB::select("select fname as label, user_id as value from users where fname like \"%$var%\" and user_id != $uid"));
        echo $data;
    }
    
    //fetches all events today
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
                        c.appointment_id=a.appointment_id
            where
                if( c.user_id is not null, c.user_id, a.creator )=b.user_id                        
        ";
        $data = json_encode( DB::select( $query ) );
        echo $data;
    }

    //fetches all recorded events that are already sent
    public function GetSent( Request $req ){
        $ret = [];
        $data = DB::select("select appointment_id, user_id from sent_notifs where for_date=date( now() )");
        foreach( $data as $x ) {
            $t = [
                "uid" => $x->user_id,
                "aid" => $x->appointment_id
            ];

            array_push( $ret, $t );
        }

        echo json_encode( $ret );
    }

    //inserts events events that has already occured
    public function FetchPost( Request $req ) {
        $query = "
            insert into 
                sent_notifs( appointment_id, user_id, for_date )
            values
                ( $req->aid, $req->uid, date( now() ) )
        ";
        DB::insert( $query );
    }

    
    public function Dash( Request $req ){
        return view('pages.Dash');
    }

    public function info( Request $req){
        $id = $req->id;
        $success = json_encode(DB::select("select * from appointments where appointment_id = $id"));
        echo $success;
    }

    public function DashFetch( Request $req ) {
        $uid = $req->session()->get( "user" )->user_id;
        $query = " select * from appointments where (`repeat` != \"deleted\") and date = now()
        ";

        $tdata = DB::select( $query );
        $pdata = [];

        foreach( $tdata as $row ) {
            $arr = [
                "id" => $row->appointment_id,
                "ename" => $row->name,
                "edate" => $row->date,
                "status" => $row->status,
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
        select * from appointments where creator = $id and `repeat` != \"deleted\"";
        $data = json_encode( DB::select( $query ) );
        echo $data;
    }

    public function User( Request $req ) {
        $id = $req->session()->get( "user" )->user_id;
        $data =  DB::select("select uname, fname, password from users where user_id = $id")[0];
        return view('pages.User', [ "data" => $data]);
    }

    public function UserPost( Request $req ){
        $id = $req->session()->get( "user" )->user_id;
        $fname = addslashes($req->name);
        $uname = addslashes($req->uname);
        $npass = addslashes($req->npass);
        $cpass = addslashes($req->cpass);

        //if new and confirm pass is equal and all fields are not the same from database
        if( $npass == $cpass ){
            $password = addslashes(password_hash($npass, PASSWORD_BCRYPT));
            $query1 = DB::table('users')->select('uname')->where('user_id', $id)->value();
            $query2 = DB::table('users')->select('fname')->where('user_id', $id)->value();
            if( $uname !== $query1 && $fname !== $query2 )
            $query3 = DB::table('users')->select('password')->where('user_id', $id)->value();
            if( !password_verify($npass, $query3) )
            $query4 = DB::table('users')->where('user_id', $id)->update(array('fname' => $fname, 'uname' => $uname, 'password' => $password));
            if( $query ){
                $success = 1;
            }
        } //if password is not changed and fname and uname is changed
          elseif( empty( $npass ) && empty( $cpass ) ){
            $query1 = DB::table('users')->select('uname')->where('user_id', $id)->value();
            $query2 = DB::table('users')->select('fname')->where('user_id', $id)->value();
            if( $uname == $query1 && $fname == $query2 )
            $query = DB::table('users')->where('user_id', $id)->update(array('fname' => $fname, 'uname' => $uname));
            if( $query ){
                $success = 2;
            }
        } //if password and fname is not changed but uname is changed
          elseif( empty( $npass ) && empty( $cpass ) ){
            $query1 = DB::table('users')->select('uname')->where('user_id', $id)->value();
            $query2 = DB::table('users')->select('fname')->where('user_id', $id)->value();
            if( $uname !== $query1 && $fname == $query2 )
            $query = DB::table('users')->where('user_id', $id)->update(array('uname' => $uname));
            if($query){
                $success = 3;
            }
        } //if password and uname is not changed but fname is changed
          elseif( empty( $npass ) && empty( $cpass ) ){
            $query1 = DB::table('users')->select('uname')->where('user_id', $id)->value();
            $query2 = DB::table('users')->select('fname')->where('user_id', $id)->value();
            if( $uname == $query1 && $fname !== $query2 )
            $query = DB::table('users')->where('user_id', $id)->update(array('uname' => $uname));
            if($query){
                $success = 4;
            }
        } //if everything else does not apply
          else{
            $success = 0;
        }
        echo json_encode(["success" => $success]);
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
            if( password_verify( $passwd, $userqres[0]->password ) ) {
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
        $epartid = addslashes($req->epartid );
        $epartid = explode( ",", $epartid );
        $repeat = "None";
        if( $req->repeatwhen )
            $repeat = $req->repeatwhen;
  
        $success = 0;
        $error = "None";
        $id = DB::table( "appointments" )->insertGetId([
            "creator" => $creator,
            "name" => $ename,
            "desc" => $edesc,
            "date" => $date,
            "start_time" => $stime,
            "end_time" => $etime,
            "repeat" => $repeat
        ]);
        if( $id ) {
            if( $epartid[0] ) {
                foreach( $epartid as $x ) {
                    if( !intval($x) ) {
                        continue;  
                    }
                    $x = addslashes( $x );
                    $query = DB::table('users')->where('user_id', $x)->count();
                    if( $query ){
                        DB::table( "guests" )->insert([
                            "appointment_id" => $id,
                            "user_id" => $x,
                            "for_date" => date('Y-m-d'),
                            "created_at" => now()
                        ]);
                        $success = 1;
                    } else {
                        $error = $query;
                    }
                }
            } else {
                $success = 1;
            }
        }
        $json = [ "success" => $success, "error" => $error ];
        echo json_encode( $json );
    }

    public function Edit( Request $req ) {
        $id = addslashes( $req->id );
        $query = "
        select a.appointment_id, a.name, a.desc, a.date, a.start_time, a.end_time, a.repeat, b.user_id,c.fname from appointments a left join guests b on a.appointment_id = b.appointment_id join users c on b.user_id = c.user_id where a.appointment_id = $id
        ";
        $fname = "";
        $id = "";
        $data = DB::select( $query );
        foreach( $data as $info){
            if( $info->fname == null){ 
            } else{
                $fname .= $info->fname.",";
                $id .= $info->user_id.",";
            }
        }
        return view( "pages.Edit", [
            "data" => $data[0],
            "fname" => $fname,
            "id" => $id
        ]);
    }

    public function EditPost( Request $req ) {
        $id = addslashes( $req->id );
        $ename = addslashes( $req->ename );
        $edesc = addslashes( $req->edesc );
        $epartid = $req->epartid;
        $epartid = explode( ",", $epartid );
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
        $query = "update appointments set repeat = \"deleted\" where appointment_id=$id";
        $success = 0;

        if( DB::update( $query ) )
            $success = 1;
        $json = [ "success" => $success ];
        echo json_encode( $json );
    }

    public function SignUp( Request $req ) {
        return view('pages.SignUp');
    }

    public function SignUpPost( Request $req ) {
        $uname = addslashes( $req->username );
        $passwd = $req->password;
        $fname = $req->fname;
        $lname = $req->lname;
        $fb_id = addslashes( $req->fb_id );
        $full = addslashes($fname ." ". $lname );
        $passwd = addslashes(password_hash($passwd, PASSWORD_BCRYPT));

        $q = "
            insert into users(
                uname,
                password,
                facebook_id,
                fname,
                created_at
            ) values (
                \"$uname\",
                \"$passwd\",
                \"$fb_id\",
                \"$full\",
                now()
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
