<?php
namespace App\Http\Controllers\Dashboard; 
use App\Http\Controllers\Controller; 

use Illuminate\Http\Request;  
use App\Models\Usertypes; 
use App\Models\DashboardMenu;  
use App\Models\Tblactivitylog;  
use App\Models\Userpermission; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class View_permission_user extends Controller   
{ 
      
    public function index(Request $request) 
    { 
        $domain = $this->getDomain($request);
        $data = [
			'domain' => $domain,
			'log_In' => session('logged_in') 
		];
        $modelmenu = new DashboardMenu(); 
		$modelutype = new Usertypes(); 
		$modeluper = new Userpermission(); 

		$menudata = $modelmenu->getMenu();

        $rid=   $request->get('rid');

        $page_data['menuData'] 			= $data ; 
        $page_data['rid'] 			    = $rid ; 
	    $page_data['page_data'] 	    = $this->getDatabyid($rid);  
	    $page_data['pagedata'] 			= $menudata;  
  
        $dashboard_view =   'dashboard.view_permission_user';
        //echo '<pre>'; print_r($dashboard_view); echo '</pre>'; exit;
        return view($dashboard_view, $page_data); 

          
    }
    public function getDatabyid($id)
    {
        $model = new Usertypes();

        $data = $model->getDatabyid($id);

        return $data;
    }
    public function getDomain(Request $request)
    {
        $domain = $request->getHost();

        return str_replace('www.', '', $domain);
    }



	public function saveNewtemp(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'checked_order_id_list' => [
                'required',
                'min:2',
                'max:500',
            ],

            'permission_name' => [
                'required',
                'min:1',
                'max:65',
            ],

            'permission_for_user_type' => [
                'required',
                'min:1',
                'max:250',
            ],
        ]);


        // Validation failed
        if ($validator->fails()) {

            return response()->json([
                'stts' => 'NOK',
                'msg'  => implode('<br>', $validator->errors()->all()),
            ]);
        }


        // Request data
        $existid = $request->input('permission_for_user_type');
        $pername = $request->input('permission_name');

        $model = new Userpermission();
        $modelactvity = new Tblactivitylog();


        // Data
        $data = [
            'permission_cmd'           => $request->input('checked_order_id_list'),
            'permission_name'          => $pername,
            'permission_for_user_type' => $existid,
        ];


        // Check existing permission for user type
        if ($this->checkExistforType($existid) == "0") {

            // Insert new permission
            $model->create($data);

            // Activity log
            $modelactvity->addActivitybyuser(
                "Added new permission rules for $pername",
                '4',
                '1'
            );

            $status = "OK";
            $message = "Successfully Added!";

        } else {

            // Update existing permission
            $model->where(
                'permission_for_user_type',
                $existid
            )->update($data);

            // Activity log
            $modelactvity->addActivitybyuser(
                "Updated permission rules for $pername",
                '4',
                '1'
            );

            $status = "OK";
            $message = "Successfully Updated!";
        }


        // JSON response
        return response()->json([
            'stts' => $status,
            'msg'  => $message,
        ]);
    }
    public function checkExistforType($existid)
    {
        return Userpermission::where(
            'permission_for_user_type',
            $existid
        )->count();
    }

    
       

    
}

 
 
 