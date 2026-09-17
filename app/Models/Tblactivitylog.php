<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tblactivitylog extends Model
{
    protected $table = 'tblactivitylog';

    protected $fillable = [
        'id',
        'date',
        'description',
        'user',
        'userid',
        'user_id',
        'admin_id',
        'ipaddr',
        'activity_type',
        'status',
        'date_time',
        'activity_status',
    ];

    public $timestamps = false;


    /**
     * Get activity notification data by user ID
     */
    public function getactiviyByuserid($userid)
    {
        $rslt = self::where('user_id', $userid)
            ->where('status', 0)
            ->get();

        $active_type = [];

        $newRegister = 0;
        $newOrder = 0;
        $newPayment = 0;
        $newOthers = 0;
        $baladd = 0;
        $balreturn = 0;

        $i = 0;

        foreach ($rslt as $rstind) {

            $i++;

            if (!in_array($rstind->activity_type, $active_type)) {
                $active_type[] = $rstind->activity_type;
            }

            if ($rstind->activity_type == 1) {
                $newRegister++;
            }

            if ($rstind->activity_type == 2) {
                $newOrder++;
            }

            if ($rstind->activity_type == 3) {
                $newPayment++;
            }

            if ($rstind->activity_type == 4) {
                $newOthers++;
            }

            if ($rstind->activity_type == 5) {
                $baladd++;
            }

            if ($rstind->activity_type == 6) {
                $balreturn++;
            }
        }

        $returndata = [];

        $returndata['notification_num'] = $i;

        if ($i > 1) {
            $returndata['notification'] = "$i Notifications";
        } else {
            $returndata['notification'] = "$i Notification";
        }

        if ($newRegister > 0) {
            $returndata['registerlogs'] =
                $newRegister . " New clients registered";
        }

        if ($newOrder > 0) {
            $returndata['orderlogs'] =
                $newOrder . " New Order Found";
        }

        if ($newPayment > 0) {
            $returndata['paymentlogs'] =
                $newPayment . " New Payment Received";
        }

        if ($newOthers > 0) {
            $returndata['newOthers'] =
                $newOthers . " New Dashboard Manage Activities";
        }

        if ($baladd > 0) {
            $returndata['baladd'] =
                $baladd . " New Payment Added Activities";
        }

        if ($balreturn > 0) {
            $returndata['balreturn'] =
                $balreturn . " New Balance deducted for service renew";
        }

        return $returndata;
    }


    /**
     * Get searching activity data
     */
    public function getSerchingData(
        $perpage,
        $page,
        $filter,
        $clientid
    ) {
        $query = self::query();

        // Date filter
        if (
            isset($filter['fromdate']) &&
            isset($filter['todate'])
        ) {
            $fromdate = $filter['fromdate'] . ' 00:00:00';
            $todate = $filter['todate'] . ' 23:59:59';

            $query->whereBetween('date', [
                $fromdate,
                $todate
            ]);
        }

        // Client filter
        $query->where('userid', $clientid);

        // Order
        $query->orderBy('id', 'desc');

        // Pagination
        if ($page != 1) {
            $offset = ($page - 1) * $perpage;
        } else {
            $offset = 0;
        }

        if ($perpage != -1) {

            return $query
                ->offset($offset)
                ->limit($perpage)
                ->get();

        } else {

            return $query->get();
        }
    }


    /**
     * Get total searching activity
     */
    public function getSerchingDataTotal(
        $perpage,
        $page,
        $filter,
        $clientid
    ) {
        $query = self::query();

        // Date filter
        if (
            isset($filter['fromdate']) &&
            isset($filter['todate'])
        ) {
            $fromdate = $filter['fromdate'] . ' 00:00:00';
            $todate = $filter['todate'] . ' 23:59:59';

            $query->whereBetween('date', [
                $fromdate,
                $todate
            ]);
        }

        $query->where('userid', $clientid);

        return $query->count();
    }


    /**
     * Get activity details
     */
    public function getDetails(
        $perpage,
        $page,
        $clientid
    ) {
        $query = self::where('userid', $clientid)
            ->orderBy('id', 'desc');

        // Pagination
        if ($page != 1) {
            $offset = ($page - 1) * $perpage;
        } else {
            $offset = 0;
        }

        if ($perpage != -1) {

            return $query
                ->offset($offset)
                ->limit($perpage)
                ->get();

        } else {

            return $query->get();
        }
    }


    /**
     * Get total activity details
     */
    public function getDetailsTotal(
        $perpage,
        $page,
        $clientid
    ) {
        return self::where('userid', $clientid)->count();
    }


    /**
     * Add activity by user
     */
    public function addActivitybyuser(
        $description,
        $activity_type,
        $sendto
    ) {
        $session = session();

        $date = now();

        $user = $session->get('user_name');
        $userid = $session->get('user_id');

        // Get user IP
        $ipaddres = request()->ip();

        $data = [
            'date'            => $date,
            'user'            => $user,
            'description'     => $description,
            'userid'          => $userid,
            'user_id'         => $sendto,
            'ipaddr'          => $ipaddres,
            'activity_type'   => $activity_type,
            'date_time'       => $date,
            'status'          => 0,
            'activity_status' => 1,
        ];

        self::create($data);

        return true;
    }


    /**
     * Get all activity data
     */
    public function getData()
    {
        return self::where('id', '>', 0)->get();
    }


    /**
     * Get activity data by ID
     */
    public function getDatabyId($id)
    {
        return self::where('id', $id)->first();
    }


    /**
     * Update activity data
     */
    public function updateData(
        $clmn,
        $val,
        $upid
    ) {
        self::where('id', $upid)->update([
            $clmn => $val,
        ]);

        return true;
    }
}