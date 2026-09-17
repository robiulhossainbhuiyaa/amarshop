<?php
namespace App\Http\Controllers\Dashboard; 
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;  
use App\Models\Usertypes; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class Edit_user_type extends Controller    
{ 
      
    public function index(Request $request) 
    { 
        $domain = $this->getDomain($request);
        $data = [
			'domain' => $domain,
			'log_In' => session('logged_in') 
		];

        $rid=   $request->get('rid');

        $page_data['menuData'] 			= $data ; 
        $page_data['rid'] 			    = $rid ; 
	    $page_data['pagedata'] 			= $this->getDatabyid($rid);  
  
        $dashboard_view =   'dashboard.edit_user_type';
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



    public function saveEdittemp(Request $request)
    {
        $idr = $request->input('rid');  
        $model = Usertypes::find($idr); 
        if (!$model) { 
            return response()->json([
                'stts' => 'NOTOK',
                'msg'  => 'Website template not found.',
            ]);
        } 

        $rules = [  

            'type_name' => [ 'required', 'min:6', 'max:20', 'unique:user_type,type_name,' . $idr, ], 
            'type_value' => [ 'required', 'min:1', 'max:10', 'unique:user_type,type_value,' . $idr, ], 
        ]; 
        $validator = Validator::make( $request->all(),  $rules  ); 
        if ($validator->fails()) {

            return response()->json([
                'stts' => 'NOTOK',
                'msg'  => implode(
                    '<br>',
                    $validator->errors()->all()
                ),
            ]);
        } 
        $data = [

            'type_name' => $request->input('type_name'), 
            'type_value' => $request->input('type_value'),  
        ]; 
         
 
        try {

            $model->update($data);


            return response()->json([
                'stts' => 'OK',
                'msg'  => 'Successfully Update!',
            ]);

        } catch (\Throwable $e) {

            Log::error('Web template update failed', [

                'id' => $idr,

                'error' => $e->getMessage(),

            ]);


            return response()->json([
                'stts' => 'NOTOK',
                'msg'  => 'Unable to update website template.',
            ]);
        }
    }

    
       

    
}

 
 
 