<?php

namespace App\Http\Controllers;

use App\Models\UserCookies;
use App\Models\DuplicateCookies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CookiesController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */
   
    private string $name = 'empty';

    private array $value = [];

    private int $time = 0;

    private ?string $domain = null;

    private string $path = '/';

    private bool $secure = false;

    private $Web = null;

    private $UserCookies = null;


    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    */

    public function __construct()
    {
        $this->UserCookies = new UserCookies();
 
        $this->Web = new \App\Models\Web();  
    }


    /*
    |--------------------------------------------------------------------------
    | 1. setName
    |--------------------------------------------------------------------------
    */

    public function setName($cook)
    {
        $this->name = $cook;

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 2. setValue
    |--------------------------------------------------------------------------
    */

    public function setValue($key, $value)
    {
        if ($key !== null) {
            $this->value[$key] = $value;
        }

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 3. setDomain
    |--------------------------------------------------------------------------
    */

    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 4. setSecure
    |--------------------------------------------------------------------------
    */

    public function setSecure($secure)
    {
        $this->secure = (bool) $secure;

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 5. setTime
    |--------------------------------------------------------------------------
    */

    public function setTime($time)
    {
        $date = now();

        $date->modify($time);

        $this->time = $date->timestamp;

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 6. setPath
    |--------------------------------------------------------------------------
    */

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }


    /*
    |--------------------------------------------------------------------------
    | 7. create
    |--------------------------------------------------------------------------
    */

    public function create(Request $request)
    {
        $usrid = $this->value['user_name'] ?? null;

        $oldname = str_replace('.', '_', $this->getName());

        $oldcooki = $this->get($request);

        $dbnum = $this->checkMysqlcookies(
            $usrid,
            $this->getName()
        );

        $browserInfo = $this->getBrowserInfo($request);

        $browser_ip       = $browserInfo['browser_ip'];
        $browser_name     = $browserInfo['browser_name'];
        $browser_version  = $browserInfo['browser_version'];
        $browser_agent    = $browserInfo['browser_agent'];
        $browser_platform = $browserInfo['browser_platform'];
        $browser_pattern  = $browserInfo['browser_pattern'];

        $entryCook = $this->getName();

        /*
        |--------------------------------------------------------------------------
        | UserCookies Model Instance
        |--------------------------------------------------------------------------
        */

        $userCookies = new UserCookies();


        /*
        |--------------------------------------------------------------------------
        | Get Domain
        |--------------------------------------------------------------------------
        */

        if ($this->getDatavalue($request) !== false) {

            $datavalue = $this->getDatavalue($request);

            $domain = $datavalue->domain ?? $this->getDomain();

        } else {

            $domain = $this->getDomain();
        }


        /*
        |--------------------------------------------------------------------------
        | Old Cookie Exists + Database Exists
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists($oldname, $oldcooki)
            && $dbnum > 0
        ) {

            $datavalue = $this->getDatavalue($request);

            if (
                $datavalue !== false
                && $datavalue !== null
                && $usrid == $datavalue->user_name
            ) {

                $cookieRow = UserCookies::find(
                    $datavalue->database_id
                );

                if ($cookieRow) {

                    $cookieRow->update([
                        'visit_time'       => now(),
                        'user_online'      => 1,
                        'last_visit_time'  => now(),
                        'browser_ip'       => $browser_ip,
                        'browser_name'     => $browser_name,
                        'browser_version'  => $browser_version,
                        'browser_agent'    => $browser_agent,
                        'browser_platform' => $browser_platform,
                        'browser_pattern'  => $browser_pattern,
                    ]);
                }

                $this->checkMultiplecookies($oldname);


                /*
                |--------------------------------------------------------------------------
                | Send Old Cookie Notification
                |--------------------------------------------------------------------------
                */

                $mail = $userCookies->sentNotification(
                    $usrid,
                    'old',
                    $dbnum,
                    $domain
                );


                return [
                    'stts'    => $mail,
                    'message' => 'UPDATE COOKIES',
                ];

            } else {

                $stts = 1;

                $ins_id = $this->entryCookiesinDatabase(
                    $entryCook,
                    $stts,
                    $request
                );


                if (
                    is_numeric($ins_id)
                    && $ins_id > 0
                ) {

                    $strtcook = $this->startCookies(
                        $ins_id,
                        $oldname
                    );

                } else {

                    $strtcook = 'not sent cookies';
                }


                /*
                |--------------------------------------------------------------------------
                | Send New Cookie Notification
                |--------------------------------------------------------------------------
                */

                $mail = $userCookies->sentNotification(
                    $usrid,
                    'new',
                    $dbnum,
                    $domain
                );


                return [
                    'stts' => $mail,
                    'message' =>
                        "returninserid: {$ins_id} / " .
                        "returnmail: {$mail} / " .
                        "msg: new cookies insert / " .
                        "returncookies: {$strtcook}",
                ];
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Cookie Exists But Database Does Not
        |--------------------------------------------------------------------------
        */

        elseif (
            array_key_exists($oldname, $oldcooki)
            && $dbnum == 0
        ) {

            $stts = 1;

            $ins_id = $this->entryCookiesinDatabase(
                $entryCook,
                $stts,
                $request
            );


            if (
                is_numeric($ins_id)
                && $ins_id > 0
            ) {

                $strtcook = $this->startCookies(
                    $ins_id,
                    $oldname
                );

            } else {

                $strtcook = 'not sent cookies';
            }


            /*
            |--------------------------------------------------------------------------
            | Send New Cookie Notification
            |--------------------------------------------------------------------------
            */

            $mail = $userCookies->sentNotification(
                $usrid,
                'new',
                $dbnum,
                $domain
            );


            return [
                'stts' => $mail,
                'message' =>
                    "returninserid: {$ins_id} / " .
                    "returnmail: {$mail} / " .
                    "msg: new cookies insert / " .
                    "returncookies: {$strtcook}",
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | No Cookie Exists
        |--------------------------------------------------------------------------
        */

        else {

            $stts = 1;

            if ($dbnum == 1) {
                $stts = 2;
            }


            $ins_id = $this->entryCookiesinDatabase(
                $entryCook,
                $stts,
                $request
            );


            if (
                is_numeric($ins_id)
                && $ins_id > 0
            ) {

                $strtcook = $this->startCookies(
                    $ins_id,
                    $oldname
                );

            } else {

                $strtcook = 'not sent cookies';
            }


            /*
            |--------------------------------------------------------------------------
            | Send New Cookie Notification
            |--------------------------------------------------------------------------
            */

            $mail = $userCookies->sentNotification(
                $usrid,
                'new',
                $dbnum,
                $domain
            );


            return [
                'stts' => $mail,
                'message' =>
                    "returninserid: {$ins_id} / " .
                    "returnmail: {$mail} / " .
                    "msg: new cookies insert / " .
                    "returncookies: {$strtcook}",
            ];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 7. getName
    |--------------------------------------------------------------------------
    */

    public function getName()
    {
        return $this->name;
    }


    /*
    |--------------------------------------------------------------------------
    | 8. get
    |--------------------------------------------------------------------------
    */

    public function get(Request $request)
    {
        return $request->cookies->all();
    }


    /*
    |--------------------------------------------------------------------------
    | 9. checkMysqlcookies
    |--------------------------------------------------------------------------
    */

    public function checkMysqlcookies($usrid, $oldname)
    {
        return UserCookies::where('cookies_name', $oldname) ->where('register_user', $usrid) ->count();
    }


    /*
    |--------------------------------------------------------------------------
    | 10. Constructor is already handled above
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | 11. getDatavalue
    |--------------------------------------------------------------------------
    */

    public function getDatavalue(Request $request)
    {
        $getoldcookies = $this->getOldCookies($request);

        if ($getoldcookies !== 'NOTOK') {

            $cookieData = $getoldcookies['data'] ?? null;

            if (
                is_array($cookieData)
                && isset($cookieData[0])
            ) {
                return (object) $cookieData[0];
            }
        }

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | 12. getOldCookies
    |--------------------------------------------------------------------------
    */

    public function getOldCookies(Request $request)
    {
        $cookieget = $this->get($request);

        if (!empty($cookieget)) {

            $oldname = str_replace(
                '.',
                '_',
                $this->getName()
            );


            if (array_key_exists($oldname, $cookieget)) {

                $oldcal = $cookieget[$oldname];

                $oldcookies = json_decode(
                    $oldcal,
                    true
                );


                return $oldcookies ?: 'NOTOK';
            }


            return 'NOTOK';
        }


        return 'NOTOK';
    }


    /*
    |--------------------------------------------------------------------------
    | 13. getDomain
    |--------------------------------------------------------------------------
    */

    public function getDomain()
    {
        return $this->domain;
    }


    /*
    |--------------------------------------------------------------------------
    | 14. checkMultiplecookies
    |--------------------------------------------------------------------------
    */

    public function checkMultiplecookies($usrid)
    {
        $oldcookies = request()->cookies->all();

        if (count($oldcookies) > 2) {

            $this->entryUserduplicatecookies($usrid);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | 15. entryUserduplicatecookies
    |--------------------------------------------------------------------------
    */

    public function entryUserduplicate_cookies($usrid)
    {
        $dupCookies = new DuplicateCookies();

  
        /*
        | Delete old duplicate records
        */

        DuplicateCookies::where(
            'current_usr',
            $usrid
        )->delete();


        /*
        | Get current browser cookies
        */

        $oldcookies = request()->cookies->all();


        /*
        | Save all cookies
        */

        foreach ($oldcookies as $key => $value) {

            $dupCookies->create([
                'dupl_user'    => $key,
                'dupli_usr_val'=> $value,
                'current_usr'  => $usrid,
                'entry_date'   => now(),
            ]);
        }
    }


    public function entryUserduplicatecookies($usrid)
    { 
        DuplicateCookies::where(
            'current_usr',
            $usrid
        )->delete();

         
        $oldcookies = request()->cookies->all();

        foreach ($oldcookies as $key => $value) {
 
            if ($value === null) {
                $value = '';
            }
 
            if (is_array($value) || is_object($value)) {
                $value = json_encode($value);
            }

            DuplicateCookies::create([
                'dupl_user'     => $key,
                'dupli_usr_val' => (string) $value,
                'current_usr'   => $usrid,
                'entry_date'    => now(),
            ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | 16. entryCookiesinDatabase
    |--------------------------------------------------------------------------
    */

    public function entryCookiesinDatabase(
        $entryCook,
        $dbnum,
        Request $request
    ) {

        /*
        |--------------------------------------------------------------------------
        | Browser Information
        |--------------------------------------------------------------------------
        */

        $browserInfo = $this->getBrowserInfo($request);

        $browser_ip       = $browserInfo['browser_ip'];
        $browser_name     = $browserInfo['browser_name'];
        $browser_version  = $browserInfo['browser_version'];
        $browser_agent    = $browserInfo['browser_agent'];
        $browser_platform = $browserInfo['browser_platform'];
        $browser_pattern  = $browserInfo['browser_pattern'];


        if (!empty($entryCook)) {

            /*
            |--------------------------------------------------------------------------
            | JSON Cookie Data
            |--------------------------------------------------------------------------
            */

            $jsondata = $this->makeJsondata();


            /*
            |--------------------------------------------------------------------------
            | Database Data
            |--------------------------------------------------------------------------
            */

            $data = [
                'cookies_name'        => $entryCook,
                'cookies_value'       => $jsondata,

                'cookies_entry_time'  => now(),
                'cookies_expire_time' => now()->setTimestamp(
                    $this->getTime()
                ),

                'visit_time'          => now(),
                'last_visit_time'     => $dbnum,

                'register_user'       =>  $this->value['user_name'] ?? null,

                'user_online'         => 1,
                'status'              => $dbnum,

                'browser_ip'          => $browser_ip,
                'browser_name'        => $browser_name,
                'browser_version'     => $browser_version,
                'browser_agent'       => $browser_agent,
                'browser_platform'   => $browser_platform,
                'browser_pattern'    => $browser_pattern,
            ];


            /*
            |--------------------------------------------------------------------------
            | Insert
            |--------------------------------------------------------------------------
            */

            return UserCookies::create($data)->id;
        }


        return 'COOKIE ENTRY IN DATABASE NOT OK';
    }


    /*
    |--------------------------------------------------------------------------
    | 17. makeJsondata
    |--------------------------------------------------------------------------
    */

    public function makeJsondata()
    {
        $expiry = $this->getTime();


        $data = [
            $this->getValue()
        ];


        $cookieData = [
            'data'   => $data,
            'expiry' => $expiry,
        ];


        return json_encode(
            $cookieData,
            JSON_UNESCAPED_SLASHES
        );
    }


    /*
    |--------------------------------------------------------------------------
    | 18. getValue
    |--------------------------------------------------------------------------
    */

    public function getValue()
    {
        return $this->value;
    }


    /*
    |--------------------------------------------------------------------------
    | 19. startCookies
    |--------------------------------------------------------------------------
    */

    public function startCookies($ins_id, $oldname)
    {
        if (
            $ins_id > 0
            && !empty($oldname)
        ) {

            /*
            | Add database ID to cookie data
            */

            $this->setValue(
                'database_id',
                $ins_id
            );


            /*
            |--------------------------------------------------------------------------
            | Cookie lifetime in minutes
            |--------------------------------------------------------------------------
            */

            $minutes = max(
                1,
                (int) ceil(
                    ($this->getTime() - now()->timestamp) / 60
                )
            );


            /*
            |--------------------------------------------------------------------------
            | Create Laravel Cookie
            |--------------------------------------------------------------------------
            */

            Cookie::queue(
                Cookie::make(
                    $oldname,
                    $this->makeJsondata(),
                    $minutes,
                    $this->getPath(),
                    $this->getDomain() ?: null,
                    $this->getSecure(),
                    true,
                    false,
                    'lax'
                )
            );


            $return = 'OK';
        }

        else {

            $return = 'SET COOKIE NOTOK';
        }


        $this->checkMultiplecookies($oldname);

        return $return;
    }


    /*
    |--------------------------------------------------------------------------
    | 20. getTime
    |--------------------------------------------------------------------------
    */

    public function getTime()
    {
        return $this->time;
    }


    /*
    |--------------------------------------------------------------------------
    | 21. getSecure
    |--------------------------------------------------------------------------
    */

    public function getSecure()
    {
        return $this->secure;
    }


    /*
    |--------------------------------------------------------------------------
    | 22. getPath
    |--------------------------------------------------------------------------
    */

    public function getPath()
    {
        return $this->path;
    }


    /*
    |--------------------------------------------------------------------------
    | 23. delete
    |--------------------------------------------------------------------------
    */

    public function delete($name)
    {
        Cookie::queue(
            Cookie::forget($name)
        );

        return true;
    }


    /*
    |--------------------------------------------------------------------------
    | 24. getmyCookiesdata
    |--------------------------------------------------------------------------
    */

    public function getmyCookiesdata(
        $colm,
        $usr,
        $stts = ''
    ) {

        $query = UserCookies::where(
            'register_user',
            $usr
        );


        if (!empty($stts)) {

            $query->where(
                'status',
                $stts
            );
        }


        $check = $query->get();


        $num = [];

        foreach ($check as $val) {

            $value = $val->{$colm} ?? null;

            if (
                empty($num)
                || end($num) != $value
            ) {

                $num[] = $value;
            }
            else {

                $num[] = '';
            }
        }


        return $num;
    }


    /*
    |--------------------------------------------------------------------------
    | Browser Detection Helper
    |--------------------------------------------------------------------------
    */

    private function getBrowserInfo(Request $request)
    {
        $userAgent = $request->userAgent() ?? ''; 
        $browserName = 'Unknown';
        $browserVersion = null;
        $platform = 'Unknown'; 
        if (
            preg_match(
                '/Edg\/([0-9.]+)/i',
                $userAgent,
                $matches
            )
        ) {

            $browserName = 'Edge';
            $browserVersion = $matches[1];
        } 
        elseif (
            preg_match(
                '/Chrome\/([0-9.]+)/i',
                $userAgent,
                $matches
            )
        ) {

            $browserName = 'Chrome';
            $browserVersion = $matches[1];
        }  
        elseif (
            preg_match(
                '/Firefox\/([0-9.]+)/i',
                $userAgent,
                $matches
            )
        ) {

            $browserName = 'Firefox';
            $browserVersion = $matches[1];
        }
 
        elseif (
            preg_match(
                '/Version\/([0-9.]+).*Safari\//i',
                $userAgent,
                $matches
            )
        ) {

            $browserName = 'Safari';
            $browserVersion = $matches[1];
        } 
        elseif (
            preg_match(
                '/OPR\/([0-9.]+)/i',
                $userAgent,
                $matches
            )
        ) {

            $browserName = 'Opera';
            $browserVersion = $matches[1];
        } 

        if (preg_match('/Windows NT/i', $userAgent)) {

            $platform = 'Windows';
        } 
        elseif (preg_match('/Android/i', $userAgent)) {

            $platform = 'Android';
        }

        elseif (
            preg_match('/iPhone/i', $userAgent)
            || preg_match('/iPad/i', $userAgent)
            || preg_match('/iPod/i', $userAgent)
        ) {

            $platform = 'iPhone/iOS';
        }

        elseif (
            preg_match('/Macintosh|Mac OS X/i', $userAgent)
        ) {

            $platform = 'Mac';
        }

        elseif (preg_match('/Linux/i', $userAgent)) {

            $platform = 'Linux';
        }


        return [
            'browser_ip'       => $request->ip(),
            'browser_name'     => $browserName,
            'browser_version'  => $browserVersion,
            'browser_agent'    => $userAgent,
            'browser_platform' => $platform,
            'browser_pattern'  => $userAgent,
        ];
    }
}