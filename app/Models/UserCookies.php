<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Support\Facades\Config;

use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
 
 
use App\Models\User;
use App\Models\Controlweb;   

use Illuminate\Support\Facades\Log;

class UserCookies extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    */
 
    protected $table = 'user_cookies'; 
    public $timestamps = false;


    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'cookies_name',
        'cookies_value',
        'cookies_entry_time',
        'cookies_expire_time',
        'visit_time',
        'last_visit_time',
        'register_user',
        'user_online',
        'status',
        'browser_ip',
        'browser_name',
        'browser_version',
        'browser_agent',
        'browser_platform',
        'browser_pattern',
    ];


    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'id'                  => 'integer',
        'cookies_entry_time'  => 'datetime',
        'cookies_expire_time' => 'datetime',
        'visit_time'          => 'datetime',
        'last_visit_time'     => 'datetime',
        'register_user'       => 'integer',
        'user_online'         => 'integer',
        'status'              => 'integer',
    ];


    /*
    |--------------------------------------------------------------------------
    | sentNotification 
    |--------------------------------------------------------------------------
    */

    public function sentNotification( $usr, $commnd, $dbnum, $domain ) 
    { 
        $userData = User::where(  'username',  $usr  )->first();  
        $userEmail = $userData->email;
        $browserIp = request()->ip(); 
        $browserAgent = request()->userAgent() ?? 'Unknown'; 
        $domainc = strtoupper(  str_replace( '.com', '',  str_replace( 'www.', '', $domain  ) ) );
 
        if ( $commnd === 'new'  && (int) $dbnum === 1 ) 
        {

            $sub = $domainc . ':: New login activities found in your account from another computer';

            $message =
            "Hello, {$usr}, <br><br>" .
            "We have found new login activities from " .
            "IP ({$browserIp}) via {$browserAgent}. " .
            "If you don't recognize this computer or IP " .
            "{$browserIp}, please contact us as soon as possible. " .
            "Someone may be controlling your account.<br><br>" .
            "Thanks<br>" .
            "{$domainc} SUPPORT TEAM";
        }
 
        else {

            $sub =  $domainc .  ':: Login activities found in your account from your computer';

            $message =
            "Hello, {$usr}, <br><br>" .
            "We have found login activities from your computer " .
            "via IP ({$browserIp}) and Browser ({$browserAgent}). " .
            "If you don't recognize this login, please contact us " .
            "as soon as possible.<br><br>" .
            "Thanks<br>" .
            "{$domainc} SUPPORT TEAM";
        }  
        $fullname = $userData->full_name ?? ''; 
        $file = ''; 
        return self::sentMail( $userEmail, $message, $sub,  $domain, $fullname, $file );
    }

 


    /*
    |--------------------------------------------------------------------------
    | sentMail
    |--------------------------------------------------------------------------
    */

    public static function sentMail($to, $message, $sub, $domain, $fullname, $file)
    {
        $modelConfig = new \App\Models\Tblsmtpconfig();
        $modelTemplate = new \App\Models\Webtemplates();  

        $webtempdata = $modelTemplate->getWebtempdatabyDomain($domain);

        $websiteid = $webtempdata->id ?? "Website not found for domain: $domain";

        $config = [
            'protocol'   => 'smtp',
            'SMTPHost'   => $modelConfig->getConfigrationdatabySettings('SMTPHost', $websiteid),
            'SMTPPort'   => (int) $modelConfig->getConfigrationdatabySettings('SMTPPort', $websiteid),
            'SMTPUser'   => $modelConfig->getConfigrationdatabySettings('SMTPUsername', $websiteid),
            'SMTPCrypto' => $modelConfig->getConfigrationdatabySettings('SMTPSSL', $websiteid),
            'SMTPPass'   => $modelConfig->getConfigrationdatabySettings('SMTPPassword', $websiteid),
        ];

        // print_r($config);

        $domain = str_replace("www.", "", $domain);

        $from = "support@$domain";
        $from_name = "SUPPORT $domain";

        try {

            /*
            |--------------------------------------------------------------------------
            | SMTP Encryption
            |--------------------------------------------------------------------------
            |
            | CodeIgniter-এর SMTPSSL value অনুযায়ী encryption নির্ধারণ করা হচ্ছে।
            |
            */

            $encryption = null;

            if (!empty($config['SMTPCrypto'])) {

                $crypto = strtolower(trim($config['SMTPCrypto']));

                if ($crypto === 'ssl' || $crypto === 'smtps') {
                    $encryption = 'ssl';
                } elseif ($crypto === 'tls' || $crypto === 'starttls') {
                    $encryption = 'tls';
                }
            }

            /*
            |--------------------------------------------------------------------------
            | SMTP Transport
            |--------------------------------------------------------------------------
            */

            $transport = new EsmtpTransport(
                $config['SMTPHost'],
                $config['SMTPPort'],
                $encryption === 'ssl'
            );

            /*
            |--------------------------------------------------------------------------
            | SMTP Authentication
            |--------------------------------------------------------------------------
            */

            if (!empty($config['SMTPUser'])) {
                $transport->setUsername($config['SMTPUser']);
            }

            if (!empty($config['SMTPPass'])) {
                $transport->setPassword($config['SMTPPass']);
            }

            /*
            |--------------------------------------------------------------------------
            | Laravel Mailer
            |--------------------------------------------------------------------------
            */

            $mailer = new Mailer($transport);

            /*
            |--------------------------------------------------------------------------
            | Create Email
            |--------------------------------------------------------------------------
            */

            $email = (new Email())
                ->from($from_name . ' <' . $from . '>')
                ->to($to)
                ->subject($sub)
                ->html($message);

            /*
            |--------------------------------------------------------------------------
            | Attachment
            |--------------------------------------------------------------------------
            */

            if (!empty($file)) {

                if (file_exists($file)) {
                    $email->attachFromPath($file);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Send Mail
            |--------------------------------------------------------------------------
            */

            $mailer->send($email);

            return 1;

        } catch (\Throwable $e) {

            /*
            |--------------------------------------------------------------------------
            | Mail Sending Failed
            |--------------------------------------------------------------------------
            */

            Log::error('Mail sending failed', [
                'to'      => $to,
                'subject' => $sub,
                'domain'  => $domain,
                'error'   => $e->getMessage(),
            ]);
 
            return 0;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | senttextMail
    |--------------------------------------------------------------------------
    */

    public static function senttextMail( $to, $message, $sub, $domain, $fullname = '',  $file = '' ) 
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | SMTP Data
            |--------------------------------------------------------------------------
            */

            $smtpData = self::getSmtpdata();


            /*
            |--------------------------------------------------------------------------
            | SMTP Config
            |--------------------------------------------------------------------------
            */

            if (!empty($smtpData)) {

                Config::set(
                    'mail.default',
                    'smtp'
                );

                Config::set(
                    'mail.mailers.smtp.host',
                    $smtpData[0] ?? null
                );

                Config::set(
                    'mail.mailers.smtp.port',
                    (int) ($smtpData[1] ?? 587)
                );

                Config::set(
                    'mail.mailers.smtp.username',
                    $smtpData[2] ?? null
                );

                Config::set(
                    'mail.mailers.smtp.password',
                    $smtpData[3] ?? null
                );

                Config::set(
                    'mail.mailers.smtp.encryption',
                    $smtpData[4] ?? null
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Domain
            |--------------------------------------------------------------------------
            */

            $domain = str_replace(
                'www.',
                '',
                $domain
            );


            /*
            |--------------------------------------------------------------------------
            | From
            |--------------------------------------------------------------------------
            */

            $from = 'support@' . $domain;

            $fromName = 'SUPPORT ' . $domain;


            /*
            |--------------------------------------------------------------------------
            | Send
            |--------------------------------------------------------------------------
            */

            Mail::send(
                [],
                [],
                function ($mail) use (
                    $to,
                    $message,
                    $sub,
                    $from,
                    $fromName,
                    $file
                ) {

                    $mail->from(
                        $from,
                        $fromName
                    );

                    $mail->to($to);

                    $mail->subject($sub);

                    $mail->html($message);

                    if (!empty($file) && file_exists($file)) {

                        $mail->attach($file);
                    }
                }
            );


            return 1;
        }


        catch (\Throwable $e) {

            \Illuminate\Support\Facades\Log::error(
                'UserCookies::sentMail Error',
                [
                    'message' => $e->getMessage(),
                ]
            );

            return 0;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | getSmtpdata
    |--------------------------------------------------------------------------
    */

    public static function getSmtpdata()
    {
        $balance = [];

        /*
        |--------------------------------------------------------------------------
        | Controlweb
        |--------------------------------------------------------------------------
        */

        $row = Controlweb::where(
            'id',
            1
        )->first();


        if ($row) {

            $balance[0] = $row->smtp_host;
            $balance[1] = $row->smtp_port;
            $balance[2] = $row->smtp_user;
            $balance[3] = $row->smtp_pass;
            $balance[4] = $row->smtp_secure;
        }


        return $balance;
    }
}