<?php

namespace App\Models;

class Web
{
    /*
    |--------------------------------------------------------------------------
    | base64url_encode
    |--------------------------------------------------------------------------
    */
    public function base64url_encode($data)
    {
        return rtrim(
            strtr(base64_encode($data), '+/', '-_'),
            '='
        );
    }


    /*
    |--------------------------------------------------------------------------
    | base64url_decode
    |--------------------------------------------------------------------------
    */
    public function base64url_decode($data)
    {
        return base64_decode(
            str_pad(
                strtr($data, '-_', '+/'),
                strlen($data) % 4,
                '=',
                STR_PAD_RIGHT
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | getDomain()
    |--------------------------------------------------------------------------
    */
    public function getDomain()
    {
        $host = request()->getHost();

        $domain = str_replace('www.', '', $host);

        $explodedo = explode('.', $domain);

        if (count($explodedo) == 2) {
            return $domain;
        }

        if (count($explodedo) == 3) {
            return $explodedo[1] . '.' . $explodedo[2];
        }

        return $domain;
    }


    /*
    |--------------------------------------------------------------------------
    | getUserIP
    |--------------------------------------------------------------------------
    */
    public static function getUserIP()
    {
        $client  = request()->header('HTTP_CLIENT_IP');
        $forward = request()->header('HTTP_X_FORWARDED_FOR');
        $remote  = request()->ip();

        if ($client && filter_var($client, FILTER_VALIDATE_IP)) {

            $ip = $client;

        } elseif ($forward && filter_var($forward, FILTER_VALIDATE_IP)) {

            // X-Forwarded-For একাধিক IP হতে পারে
            $ipList = explode(',', $forward);
            $ip = trim($ipList[0]);

            if (!filter_var($ip, FILTER_VALIDATE_IP)) {
                $ip = $remote;
            }

        } else {

            $ip = $remote;
        }

        return $ip;
    }


    /*
    |--------------------------------------------------------------------------
    | getBrowser
    |--------------------------------------------------------------------------
    */
    public static function getBrowser()
    {
        $u_agent = request()->userAgent() ?? '';

        $bname    = 'Unknown';
        $platform = 'Unknown';
        $version  = '';

        /*
        |--------------------------------------------------------------------------
        | Platform
        |--------------------------------------------------------------------------
        */

        if (preg_match('/linux/i', $u_agent)) {

            $platform = 'linux';

        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {

            $platform = 'mac';

        } elseif (preg_match('/windows|win32/i', $u_agent)) {

            $platform = 'windows';
        }


        /*
        |--------------------------------------------------------------------------
        | Browser Name
        |--------------------------------------------------------------------------
        */

        $ub = '';

        if (
            preg_match('/MSIE/i', $u_agent)
            && !preg_match('/Opera/i', $u_agent)
        ) {

            $bname = 'Internet Explorer';
            $ub = 'MSIE';

        } elseif (preg_match('/Firefox/i', $u_agent)) {

            $bname = 'Mozilla Firefox';
            $ub = 'Firefox';

        } elseif (preg_match('/Chrome/i', $u_agent)) {

            $bname = 'Google Chrome';
            $ub = 'Chrome';

        } elseif (preg_match('/Safari/i', $u_agent)) {

            $bname = 'Apple Safari';
            $ub = 'Safari';

        } elseif (preg_match('/Opera/i', $u_agent)) {

            $bname = 'Opera';
            $ub = 'Opera';

        } elseif (preg_match('/Netscape/i', $u_agent)) {

            $bname = 'Netscape';
            $ub = 'Netscape';
        }


        /*
        |--------------------------------------------------------------------------
        | Browser Version
        |--------------------------------------------------------------------------
        */

        $known = ['Version', $ub, 'other'];

        $pattern = '#(?<browser>'
            . implode('|', array_filter($known))
            . ')[/ ]+'
            . '(?<version>[0-9.|a-zA-Z.]*)#';

        $matches = [];

        preg_match_all(
            $pattern,
            $u_agent,
            $matches
        );


        $versionMatches = $matches['version'] ?? [];

        $i = count($matches['browser'] ?? []);


        if ($i != 1) {

            if (
                strripos($u_agent, 'Version') !== false
                && $ub !== ''
                && strripos($u_agent, $ub) !== false
            ) {

                if (
                    strripos($u_agent, 'Version')
                    < strripos($u_agent, $ub)
                ) {

                    $version = $versionMatches[0] ?? '';

                } else {

                    $version = $versionMatches[1] ?? '';
                }

            } else {

                $version = $versionMatches[0] ?? '';
            }

        } else {

            $version = $versionMatches[0] ?? '';
        }


        /*
        |--------------------------------------------------------------------------
        | Unknown Version
        |--------------------------------------------------------------------------
        */

        if ($version === null || $version === '') {
            $version = '?';
        }


        /*
        |--------------------------------------------------------------------------
        | Return
        |--------------------------------------------------------------------------
        */

        return [
            'name'      => $bname,
            'version'   => $version,
            'userAgent' => $u_agent,
            'platform'  => $platform,
            'pattern'   => $pattern,
        ];
    }
}