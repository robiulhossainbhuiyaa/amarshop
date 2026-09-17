<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tblconfiguration extends Model
{
    protected $table = 'tblconfiguration';

    protected $fillable = ['id', 'setting', 'value', 'created_at', 'updated_at', 'fields_type'];

    protected $casts = [
        'id'         => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getConfigrationdata()
    {
        $data = self::where('id', '>', 0)->get();

        return $data;
    } 
    
    public function updateConfigrationdata($clmn, $val, $upid){
        $model = self:: set($clmn, $val) ->where("id", "$upid") ->update();
        return true;
    }
    
    public function getConfigrationdatabySettings($data){ 
        $datas = self::where("setting", $data)->get()->getResult();
        foreach($datas as $rslt)
        return $rslt;
    }
    
    public function getConfigrationdatabyId($id){ 
        $datas =self::where("id", $id)->get()->getResult();
        foreach($datas as $rslt)
        return $rslt;
    }

    public function updateData($clmn, $val, $upid)
    {
        $updated = self::where('id', $upid) ->update([ $clmn => $val ]);

        return $updated;
    } 
}