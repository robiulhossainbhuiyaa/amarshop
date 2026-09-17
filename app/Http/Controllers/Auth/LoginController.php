<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CookiesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Tblconfiguration;
use App\Models\UserOtp;
use App\Models\UserCookies;
use App\Models\Controlweb;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $session    =   session();
        if(session()->get('logged_in'))
        {
            $userid             =  $session->get('user_id');    
            $modelUser 			= new User();
            $hedardata          = $modelUser->getdatabyiduser($userid);

            
        }
        $page_data['hedardata'] 			= $hedardata ?? '';

        return view('dashboard.login.login', $page_data); 
        //return view('dashboard.login.login');
    }


    /*
    |--------------------------------------------------------------------------
    | USER LOGIN
    |--------------------------------------------------------------------------
    */

    public function user_Login(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Get Request Data
        |--------------------------------------------------------------------------
        */

        $email    = trim((string) $request->input('email'));
        $password = (string) $request->input('password');


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        if (empty($email)|| empty($password)) {
 

            return response()->json([
                'stts' => 'NOTOK',
                'msg'  => 'Email or Password are required!',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Find Active User
        |--------------------------------------------------------------------------
        */

        $data = User::where('email', $email) ->where('status', 1)  ->first();


        /*
        |--------------------------------------------------------------------------
        | User Not Found / Blocked
        |--------------------------------------------------------------------------
        */

        if (!$data) {

            return response()->json([
                'stts' => 'NOTOK',
                'msg'  => 'Email & Password blocked. Please contact support',
            ]);
        }

        


        /*
        |--------------------------------------------------------------------------
        | Password Verify
        |--------------------------------------------------------------------------
        */

        $verifyPass = Hash::check(
            $password,
            $data->password
        );


        if (!$verifyPass) {

            return response()->json([
                'stts' => 'NOTOK',
                'msg'  => 'Wrong Email Or Password',
            ]);
        }

        


        /*
        |--------------------------------------------------------------------------
        | USER TYPE = 5
        |--------------------------------------------------------------------------
        */

        if ((int) $data->user_type === 5) {

            /*
            |--------------------------------------------------------------------------
            | Session
            |--------------------------------------------------------------------------
            */

            session()->regenerate();

            session([
                'user_id'        => $data->id,
                'user_name'      => $data->username,
                'user_email'     => $data->email,
                'user_type'      => $data->user_type,
                'user_full_name' => $data->full_name,
                'logged_in'      => true,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Custom Cookies Controller
            |--------------------------------------------------------------------------
            */

            $this->createLoginCookies(
                $request,
                $data
            );


            /*
            |--------------------------------------------------------------------------
            | Controlweb
            |--------------------------------------------------------------------------
            */

            $mdelcon = new Controlweb();

            $dashboard = $mdelcon->getDashboard();


            /*
            |--------------------------------------------------------------------------
            | Login Success
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'stts'     => 'OK',
                'msg'      => 'Login Successfull',
                'redirect' => url('dashboardView'),
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | USER TYPE != 5
        |--------------------------------------------------------------------------
        */

        session([
            'user_name'  => $data->username,
            'user_email' => $data->email,
            'logged_in'  => false,
        ]);


        /*
        |--------------------------------------------------------------------------
        | OTP CONFIGURATION
        |--------------------------------------------------------------------------
        */

        $modelconfiguration = new Tblconfiguration();

        $userOTPVerification = $modelconfiguration
            ->where('setting', 'UserOTPVerification')
            ->value('value');


        /*
        |--------------------------------------------------------------------------
        | OTP ENABLED
        |--------------------------------------------------------------------------
        */

        if ($userOTPVerification === 'on') {

            /*
            |--------------------------------------------------------------------------
            | Generate OTP
            |--------------------------------------------------------------------------
            */

            $optcode = UserOtp::otpGenerate();


            /*
            |--------------------------------------------------------------------------
            | OTP Mail Data
            |--------------------------------------------------------------------------
            */

            $to = $data->email;

            $domain = $this->getDomain($request);

            $sub = $domain . ' OTP CODE';

            $fullname = '';

            $file = '';


            $message = "Hello {$data->username},
            <br><br>
            Your OTP Code is below to login to our portal.
            <br><br>
            OTP:: <b>{$optcode}</b>
            <br><br>
            Please don't share the OTP code with anyone.
            <br><br>
            Please use this OTP within 3 minutes or it will expire.
            <br><br>
            Thanks";


            /*
            |--------------------------------------------------------------------------
            | OTP Hash
            |--------------------------------------------------------------------------
            */

            $sval = UserOtp::secRet();

            $md5otp = md5(
                $sval . $optcode
            );


            /*
            |--------------------------------------------------------------------------
            | Remove Previous OTP
            |--------------------------------------------------------------------------
            */

            UserOtp::where(
                'username',
                $data->username
            )->delete();


            /*
            |--------------------------------------------------------------------------
            | Save New OTP
            |--------------------------------------------------------------------------
            */

            UserOtp::create([
                'username'   => $data->username,
                'otpcode'    => $md5otp,
                'status'     => 1,
                'createtime' => now(),
            ]);


            /*
            |--------------------------------------------------------------------------
            | Temporary OTP Session
            |--------------------------------------------------------------------------
            */

            session([
                'otp_user_id' => $data->id,
                'otp_username' => $data->username,
                'otp_email'    => $data->email,
                'logged_in'    => false,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Send OTP Mail
            |--------------------------------------------------------------------------
            */

            $usrCookies = new UserCookies();

            $usrCookies::sentMail( $to, $message, $sub, $domain,  $fullname, $file );


            /*
            |--------------------------------------------------------------------------
            | OTP Response
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'stts'     => 'OTP',
                'msg'      => 'Check Your Email to get OTP',
                'redirect' => url('user-otp-activation'),
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | OTP DISABLED
        |--------------------------------------------------------------------------
        */

        session()->regenerate();

        session([
            'user_id'        => $data->id,
            'user_name'      => $data->username,
            'user_email'     => $data->email,
            'user_type'      => $data->user_type,
            'user_domain_id' => $data->website,
            'user_full_name' => $data->full_name,
            'user_domain'    => $this->getDomain($request),
            'logged_in'      => true,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Custom Cookies Controller
        |--------------------------------------------------------------------------
        */

        $cookie = new CookiesController();
        $cookie->setValue( 'user_name', $data->username ); 
        $cookie->setValue( 'user_type',  $data->user_type ); 
        $cookie->setValue( 'user_id', $data->id );
        $cookie->setDomain( $this->getDomain($request) );
        $cookie->setSecure( $request->isSecure() );
        $cookie->setTime( '+15 days' );
        $cookie->setPath('/');
        //$cookie->create($request)
        $getvalue = $cookie->create($request);

        //$this->createLoginCookies( $request, $data );
        


        /*
        |--------------------------------------------------------------------------
        | Controlweb
        |--------------------------------------------------------------------------
        */

        $mdelcon = new Controlweb();

        $dashboard = $mdelcon->getDashboard();


        /*
        |--------------------------------------------------------------------------
        | Login Success
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'stts'     => 'OK',
            'msg'      => 'Login Successfull',
            'redirect' => url('dashboardView'),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE LOGIN COOKIES
    |--------------------------------------------------------------------------
    */

    private function createLoginCookies( Request $request, User $data ) 
    {
        $cookie = new CookiesController();

        /*
        |--------------------------------------------------------------------------
        | Cookie Name
        |--------------------------------------------------------------------------
        */

        $cookie->setName(
            $data->username
        );


        /*
        |--------------------------------------------------------------------------
        | Cookie Values
        |--------------------------------------------------------------------------
        */

        $cookie->setValue(
            'user_name',
            $data->username
        );

        $cookie->setValue(
            'user_type',
            $data->user_type
        );

        $cookie->setValue(
            'user_id',
            $data->id
        );


        /*
        |--------------------------------------------------------------------------
        | Domain
        |--------------------------------------------------------------------------
        */

        $cookie->setDomain(
            $this->getDomain($request)
        );


        /*
        |--------------------------------------------------------------------------
        | Secure
        |--------------------------------------------------------------------------
        */

        $cookie->setSecure(
            $request->isSecure()
        );


        /*
        |--------------------------------------------------------------------------
        | Expire
        |--------------------------------------------------------------------------
        */

        $cookie->setTime(
            '+15 days'
        );


        /*
        |--------------------------------------------------------------------------
        | Path
        |--------------------------------------------------------------------------
        */

        $cookie->setPath('/');


        /*
        |--------------------------------------------------------------------------
        | Create / Save
        |--------------------------------------------------------------------------
        */

        return $cookie->create($request);
    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Delete Session
        |--------------------------------------------------------------------------
        */

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        /*
        |--------------------------------------------------------------------------
        | Forget Browser Cookies
        |--------------------------------------------------------------------------
        */

        Cookie::queue(
            Cookie::forget('user_name')
        );

        Cookie::queue(
            Cookie::forget('user_type')
        );

        Cookie::queue(
            Cookie::forget('user_id')
        );

        Cookie::queue(
            Cookie::forget('domain')
        );


        /*
        |--------------------------------------------------------------------------
        | Login Page
        |--------------------------------------------------------------------------
        */
        return redirect()
        ->route('login_user')
        ->with('msg', 'successfully logout');
        
    }


    /*
    |--------------------------------------------------------------------------
    | GET DOMAIN
    |--------------------------------------------------------------------------
    */

    public function getDomain(Request $request)
    {
        $domain = $request->getHost();

        return str_replace(
            'www.',
            '',
            $domain
        );
    }
}