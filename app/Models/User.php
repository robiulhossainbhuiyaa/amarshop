<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;  

    protected $table = 'users';

    protected $fillable = [
        'email',
        'username',
        'password',
        'showpass',
        'balance',
        'online',
        'active',
        'rtime',
        'user_type',
        'full_name',
        'com_name',
        'present_address',
        'district',
        'city',
        'country',
        'sex',
        'cellno',
        'joindate',
        'website',
        'ref_id',
        'secu_com',
        'logout_com',
        'baned_com',
        'browsing_mode',
        'currency',
        'user_images',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'id'       => 'integer',
        'balance'  => 'decimal:2',
        'online'   => 'integer',
        'active'   => 'integer',
        'rtime'    => 'datetime',
        'user_type'=> 'integer',
        'joindate' => 'datetime',
        'ref_id'   => 'integer',
    ];

    public function getdatabyiduser($userid)
    { 
        $data = self::where('id', $userid)->first();
        return $data;
    }
    public function getUserType($userid){
 
		$data = self::select('user_type')->where('id', $userid)->first();

        if ($data) {
			return $data['user_type'];
		} else {
			return ""; 
		}
  
	}

    public function getuservaliddata($email,$password)
    {  
        $data = self::where('email', $email) ->where('status', 1)  ->first();
        return $data;
    }
    public static function passwordVerify($password, $pass) {
        return Hash::check( $password, $pass );
		//return password_verify($password, $pass);
	}
}