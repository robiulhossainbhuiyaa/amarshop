<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usertypes extends Model
{
    protected $table = 'user_type';  
    public $timestamps = false;

    protected $fillable = [
        'id',
        'type_name',
        'type_value',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | Get All Data
    |--------------------------------------------------------------------------
    */

    public function getData()
    {
        return self::where('id', '>', 0)->get();
    }


    /*
    |--------------------------------------------------------------------------
    | Get User Type Name / Data By ID
    |--------------------------------------------------------------------------
    */

    public function getUtypeName($id)
    {
        return self::where('id', $id)->first();
    }


    /*
    |--------------------------------------------------------------------------
    | Get Data By ID
    |--------------------------------------------------------------------------
    */

    public function getDatabyid($id)
    {
        return self::where('id', $id)->get();
    }


    /*
    |--------------------------------------------------------------------------
    | Update Data
    |--------------------------------------------------------------------------
    */

    public function updateData($clmn, $val, $upid)
    {
        self::where('id', $upid)->update([
            $clmn => $val,
        ]);

        return true;
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Data
    |--------------------------------------------------------------------------
    */

    public function deleteData($val, $uid)
    {
        if ($val == 'del') {

            self::where('id', $uid)->delete();
        }

        return true;
    }
}