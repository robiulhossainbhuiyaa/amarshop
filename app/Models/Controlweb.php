<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Controlweb extends Model
{
    protected $table = 'control_web';  
    public $timestamps = false;

    protected $fillable = [
        'id',
        'domain',
        'usd_rate',
        'ref_com',
        'shipping_charge',
        'con_email',
        'com_email',  
        'con_no',
        'sent_to',
        'skype_contact',
        'other_contact',
        'con_address',
        'terms',
        'notice',
        'facebook_link',
        'twiter_link',
        'google_link',
        'policy_of_privacy',
        'payment_method',
        'network_and_datacenter',
        'link4',
        'link5',
        'link6',
        'link7',
        'link8',
        'link9',
        'link10',
        'chat_link',
        'smtp_host',
        'smtp_port',
        'smtp_user',
        'smtp_pass',
        'smtp_secure',
        'dashboard',
    ];
 

    public function updateData($clmn, $val, $upid)
    {
        //echo '<pre>'; print_r($clmn); echo '</pre>'; exit;
        $updated = self::where('id', $upid)->update([ $clmn => $val ]);

        return $updated > 0;
    }   


    public function getDashboard()
    {
        return Controlweb::where('id', 1)->value('dashboard');
    }
    public function getDashboardIdByData()
    {
        $data = self::where('id','>', 0)->get(); 
        return $data;
    }
}