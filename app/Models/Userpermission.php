<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userpermission extends Model
{
    protected $table = 'user_permission';

    protected $fillable = [
        'id',
        'permission_name',
        'permission_cmd',
        'permission_for_user_type',
        'permission_for_user',
    ];

    public $timestamps = false;

    /**
     * Get all permission data
     */
    public function getData()
    {
        return self::where('id', '>', 0)->get();
    }

    /**
     * Get permission by ID
     */
    public function getPermissionName($id)
    {
        return self::where('id', $id)->first();
    }

    /**
     * Get permission command by user type
     */
    public function getPermissionCmd($uforid)
    {
        return self::where('permission_for_user_type', $uforid)->first();
    }

    /**
     * Update permission data
     */
    public function updateData($clmn, $val, $upid)
    {
        self::where('id', $upid)->update([
            $clmn => $val,
        ]);

        return true;
    }
   
   
   
}