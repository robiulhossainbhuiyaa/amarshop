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
        return view('dashboard.login.login');
    }


    /*
    |--------------------------------------------------------------------------
    | USER LOGIN
    |--------------------------------------------------------------------------
    */

    public function user_Login(Request $request)
    { 

        $modelconfiguration = new Tblconfiguration(); 
        $userOTPVerification = $modelconfiguration ->where('setting', 'UserOTPVerification') ->value('value');
 

        $email    = trim((string) $request->input('email'));
        $password = (string) $request->input('password');
  
        if (!empty($email) || !empty($password)) 
        {
  

            $data = User::getuservaliddata($email,$password);
   
            if ($data) 
            {   
                $pass = $data['password'];
                $virify_pass = User::passwordVerify($password, $pass); 
                if ($virify_pass) 
                {
 

                    /*
                    |--------------------------------------------------------------------------
                    | USER TYPE = 5
                    |--------------------------------------------------------------------------
                    */

                    if($data['user_type'] == "5") 
                    { 

                        session()->regenerate(); 
                        session([
                            'user_id'        => $data->id,
                            'user_name'      => $data->username,
                            'user_email'     => $data->email,
                            'user_type'      => $data->user_type,
                            'user_full_name' => $data->full_name,
                            'logged_in'      => true,
                        ]);
 
                        $this->createLoginCookies(
                            $request,
                            $data
                        );
 
                        $mdelcon = new Controlweb(); 
                        $dashboard = $mdelcon->getDashboard();
 
                        return response()->json([
                            'stts'     => 'OK',
                            'msg'      => 'Login Successfull',
                            'redirect' => url('dashboardView'),
                        ]);
                    }else
                    { 
                        session([
                            'user_name'  => $data->username,
                            'user_email' => $data->email,
                            'logged_in'  => false,
                        ]);
  
                        if ($userOTPVerification === 'on') {
 
                            $optcode = UserOtp::otpGenerate(); 
                            $to = $data->email; 
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

                            $domain = $this->getDomain($request); 
                            $sub = $domain . ' OTP CODE';
                            $fullname = ''; 
                            $file = ''; 
                            $sval = UserOtp::secRet(); 
                            $md5otp = md5( $sval . $optcode ); 
                            UserOtp::create([
                                'username'   => $data->username,
                                'otpcode'    => $md5otp,
                                'status'     => 1,
                                'createtime' => now(),
                            ]); 
                            session([
                                'otp_user_id' => $data->id,
                                'otp_username' => $data->username,
                                'otp_email'    => $data->email,
                                'logged_in'    => false,
                            ]); 
                            $usrCookies = new UserCookies(); 
                            $usrCookies::sentMail( $to, $message, $sub, $domain,  $fullname, $file ); 
                            return response()->json([
                                'stts'     => 'OTP',
                                'msg'      => 'Check Your Email to get OTP',
                                'redirect' => url('user-otp-activation'),
                            ]);
                        }else
                        { 
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
  
                            //$this->createLoginCookies( $request, $data ); 
                            $mdelcon = new Controlweb(); 
                            $dashboard = $mdelcon->getDashboard(); 
                            return response()->json([
                                'stts'     => 'OK',
                                'msg'      => 'Login Successfull',
                                'redirect' => url('dashboardView'),
                            ]);
                        }
                    
                    }

                }else
                {

                    return response()->json([
                        'stts' => 'NOTOK',
                        'msg'  => 'Wrong Email Or Password',
                    ]);
                }
            }else
            {

                return response()->json([
                    'stts' => 'NOTOK',
                    'msg'  => 'Email & Password blocked. Please contact support',
                ]);
            }

        }else
        {
            return response()->json([
                'stts' => 'NOTOK',
                'msg'  => 'Email or Password are required!',
            ], 422);

        }
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE LOGIN COOKIES
    |--------------------------------------------------------------------------
    */

    private function createLoginCookies( Request $request, User $data ) 
    {
        $cookie = new CookiesController();
 
        $cookie->setName(
            $data->username
        );
 
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
 
        $cookie->setDomain(
            $this->getDomain($request)
        );
 
        $cookie->setSecure(
            $request->isSecure()
        );
 
        $cookie->setTime(
            '+15 days'
        );
 
        $cookie->setPath('/');
 
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