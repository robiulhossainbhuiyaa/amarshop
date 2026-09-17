<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tblsmtpconfig extends Model
{
    protected $table = 'tblsmtpconfig';

    protected $fillable = [
        'id',
        'website_id',
        'SMTPHost',
        'SMTPUsername',
        'SMTPPassword',
        'SMTPPort',
        'SMTPSSL',
    ];

    public $timestamps = false;

    public function updateData($clmn, $val, $upid)
    {
        $updated = self::where('website_id', $upid) ->update([ $clmn => $val ]);

        return $updated > 0;
    }


    /**
     * Get all SMTP configuration data
     */
    public function getConfigrationdata()
    {
        $data = self::where('id', '>', 0)->get();

        return $data;
    }


    /**
     * Get SMTP configuration by ID
     */
    public function getConfigrationdatabyId($id)
    {
        $data = self::where('id', $id)->get();

        foreach ($data as $rslt) {
            return $rslt;
        }

        return null;
    }


    /**
     * Get SMTP configuration by Website ID
     */
    public function getConfigrationdatabyWeb($webid)
    {
        $data = self::where('website_id', $webid)->get();

        foreach ($data as $rslt) {
            return !empty($rslt) ? $rslt : null;
        }

        return null;
    }

     


    /**
     * Get SMTP configuration count by Website ID
     */
    public function getConfigrationdatabyWebCount($webid)
    {
        return self::where('website_id', $webid)->count();
    }


    /**
     * Get complete SMTP configuration count by Website ID
     */
    public function getSMTPdatabyWebCount($webid)
    {
        $wherearr = [
            ['website_id', '=', $webid],
            ['SMTPHost', '!=', null],
            ['SMTPPort', '!=', null],
            ['SMTPSSL', '!=', null],
            ['SMTPUsername', '!=', null],
            ['SMTPPassword', '!=', null],
        ];

        $data = self::where($wherearr)->count();

        return $data;
    }


    /**
     * Get a specific SMTP setting by Website ID
     */
    public function getConfigrationdatabySettings($data, $webid)
    {
        $datas = self::where('website_id', $webid)->get();

        foreach ($datas as $rslt) {
            return $rslt->$data ?? null;
        }

        return null;
    }


    /**
     * Update SMTP configuration
     */
    public function updateConfigrationdata($clmn, $val, $upid)
    {
        self::where('website_id', $upid)
            ->update([
                $clmn => $val
            ]);

        return true;
    }


    /**
     * Insert SMTP configuration
     */
    public function insertConfigrationdata($clmn, $val, $uid)
    {
        $data = [
            'website_id' => $uid,
            $clmn        => $val,
        ];

        self::create($data);

        return true;
    }
}