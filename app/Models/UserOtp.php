<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOtp extends Model
{
    protected $table = 'user_otp';

    public $timestamps = false;

    protected $fillable = [
        'username',
        'otpcode',
        'status',
        'createtime',
    ];

    protected $casts = [
        'id' => 'integer',
        'status' => 'integer',
        'createtime' => 'datetime',
    ];

    public static function otpGenerate(){
        $characters = '123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= rand(0, $charactersLength - 1);
        }
        $pin=$randomString;
        return $pin;
    }

    public static function otpGenerate1()
    {
        return (string) random_int(100000, 999999);
    }

    public static function secRet(){
        $secret = 'visualhdotp';
        return  $secret;
	}
    
    public static function otpVerify($username, $optcode, $otp, $recordtime){
        $sval = self::secRet();
        $md5otp = md5($sval . $optcode);
        $currtime = date('Y-m-d H:i:s');
        $timediff = self::datetimeDiff($recordtime, $currtime);
        
        if($md5otp == $otp && $timediff->min <= 5) return 1;
        else if($timediff->min > 5) return 2;
        else return false;
	}
}