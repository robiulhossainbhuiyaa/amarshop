<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webtemplates extends Model
{
    protected $table = 'web_templates';

    protected $fillable = [
        'id',
        'domain',
        'com_name',
        'template',
        'logo',
        'icon',
        'status',
    ];

    public $timestamps = false;
    public function getDatabyid($id)
    { 
        $data = self::where('id', $id) ->orderBy('id', 'asc')->get();
        //echo '<pre>'; print_r($data); echo '</pre>'; exit;
        return $data;
    }

    public function updateData($clmn, $val, $upid)
    {
        $updated = self::where('id', $upid) ->update([ $clmn => $val ]);

        return $updated > 0;
    }


    /**
     * Get all web template data
     */
    public function getWebtempdata()
    {
        $count = self::where('id', '>', 0)->count();

        if ($count > 0) {

            $data = self::where('id', '>', 0)->get();

            return $data;

        } else {

            return false;
        }
    }
  


    /**
     * Get web template data by ID
     */
    public function getWebtempdatasvalue($id)
    {
        $count = self::where('id', $id)->count();

        if ($count > 0) {

            $data = self::where('id', $id)->get();

            foreach ($data as $rst) {
                return $rst;
            }

        } else {

            return false;
        }

        return false;
    }


    /**
     * Get first web template ID
     */
    public function getWebtempdatasid()
    {
        $count = self::where('id', '>', 0)->count();

        if ($count > 0) {

            $data = self::where('id', '>', 0)
                ->orderBy('id', 'ASC')
                ->limit(1)
                ->get();

            foreach ($data as $rst) {
                return $rst->id;
            }

        } else {

            return 0;
        }

        return 0;
    }


    /**
     * Get web template by domain or ID
     */
    public function getWebtempdatabyDomain($domain)
    {
        $count = self::where('domain', $domain)
            ->orWhere('id', $domain)
            ->count();

        if ($count > 0) {

            $data = self::where('domain', $domain)
                ->orWhere('id', $domain)
                ->get();

            foreach ($data as $rst) {
                return $rst;
            }

        } else {

            return false;
        }

        return false;
    }


    /**
     * Update web template data
     */
    public function updateWebtempdata($clmn, $val, $upid)
    {
        self::where('id', $upid)
            ->update([
                $clmn => $val
            ]);

        return true;
    }


    /**
     * Delete web template data
     */
    public function deleteWebtempdata($val, $uid)
    {
        if ($val == "del") {

            self::where('id', $uid)->delete();
        }

        return true;
    }


    /**
     * Get current domain
     */
    public function getDomain()
    {
        $url = request()->url();

        $url_parts = parse_url($url);

        $domain = str_replace('www.', '', $url_parts['host'] ?? '');

        $explodedo = explode(".", $domain);

        return $domain;
    }
}