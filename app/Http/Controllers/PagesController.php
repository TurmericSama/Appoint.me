<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
$sent = [];

class PagesController extends Controller
{
    public function __construct() {
        $this->middleware( "auth" )->except( "Login", "SignUp", "LoginPost", "SignUpPost", "Fetch", "FetchPost", "GetSent" );
    }

    public function tokenfieldget( Request $req ){
        $uid = $req->session()->get( "user" );
        $var = $req->name;
        $data = DB::table('users')->where('fname','like','%'.$var.'%')->where('user_id','!=',$uid)->select('fname as label','user_id as value')->get();
        $data = json_encode($data);
        echo $data;
    }
    
    //fetches all events today
    public function Fetch( Request $req ) {
        $query = DB::table('appointments')->join('users','=','');
        
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
                if (b.user_id=( c.user_id is not null, c.user_id, a.creator ))";
        $data = json_encode( DB::select( $query ) );
        echo $data;
    }

    //fetches all recorded events that are already sent
    public function GetSent( Request $req ){
        $ret = [];
        $data = DB::table('sent_notifs')->where('for_date',date(now()))->select('appointment_id','user_id')->get();
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
        $query = DB::table('sent_notifs')->insert([
            "appointment_id" => $req->aid,
            "user_id" => $req->uid,
            "date" => date( now())
        ]);

    }

    public function Dash( Request $req ){
        return view('pages.Dash');
    }

    public function info( Request $req){
        $id = $req->id;
        $query = DB::table('appointments')->where('appointment_id',$id)->select('name','desc','date','start_time','end_time')->get();
        $success = json_encode($query);
        echo $success;
    }

    public function DashFetch( Request $req ) {
        $uid = $req->session()->get( "user" );
        $query = DB::table('appointments')->where('repeat','!=','deleted')->where('date',now())->select('name','desc','date','start_time','end_time','repeat')->get();
        $pdata = [];
        foreach( $query as $row ) {
            $arr = [
                "id" => $row->appointment_id,
                "ename" => $row->name,
                "edate" => $row->date
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
        $id = $req->session()->get( "user" );
        $query = DB::table('appointments')->where('repeat','!=','deleted')->select(
        'appointment_id',
        'name',
        'desc',
        'date',
        'start_time',
        'end_time',
        'repeat'
    )->get();
        $data = json_encode($query);
        echo $data;
    }

    public function AddPerson( Request $req ) {
        return view('pages.AddUser');
    }

    public function AddPersonPost( Request $req ){
        $fname = $req->fname;
        $lname = $req->lname;
        $fname = $fname." ".$lname;
        $psid = $req->psid;
        $success = 0;
        if( DB::table('users')->insert(["fname" => $fname, "user_type" => 0, "facebook_id" => $psid ])){
            $success = 1;
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
        $userq = DB::table('users')->where('uname',$uname)->select('user_id','password')->first();
        $success = 0;
        if( $userq ) {
            if( password_verify( $passwd, $userq->password ) ) {
                $req->session()->put( "user", $userq->user_id );
                $success = 1;
            } else{
                $success = 0;
            }
        }

        $json = [ "success" => $success, "user_id" => $req->user, "password" => $passwd ];
        echo json_encode( $json );
    }

    public function Add( Request $req ) {
        return view('pages.Add');
    }

    public function AddPost( Request $req ) {
        $creator = $req->session()->get( "user" );
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

        $query = DB::table('appointments')->where('appointment_id', $id)->update(["name" => $ename, 
        "desc" => $edesc, 
        "date" => $date, 
        "start_time" => $stime, 
        "end_time" => $etime,
        "repeat" => $repeat
        ]);
        $query = "
            update appointments
                set
                    `name`=\"$ename\",
                    `desc`=\"$edesc\",
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
        $query = DB::table('appointments')->where('appointment_id', $id )->update(['repeat' => "deleted"]);
        $success = 0;
        if( $query ){
            $success = 1;
        } else{
            $success = 0;
        }
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

        $query = DB::table('users')->insert(["uname" => $uname, "password" => $passwd, "fname" => $full, "facebook_id" => $fb_id, "created_at" => now()]);
            if( $query ){
                $success = 1;
            } else{
                $success = 0;
            }
        $json = [ "success" => $success ];
        echo json_encode( $json );        
    }

    public function Logout( Request $req ) {
        $req->session()->forget( "user" );
        return redirect( "/login" );
    }
}
