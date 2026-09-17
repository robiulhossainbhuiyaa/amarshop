<?php
namespace App\Http\Controllers\Dashboard; 
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;  
use App\Models\Webtemplates; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EditeWebsite extends Controller
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
  
        $dashboard_view =   'dashboard.editewebsite';
        //echo '<pre>'; print_r($dashboard_view); echo '</pre>'; exit;
        return view($dashboard_view, $page_data); 
    }
    public function getDatabyid($id) 
    {
        $model = new Webtemplates();

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
        $model = Webtemplates::find($idr); 
        if (!$model) { 
            return response()->json([
                'stts' => 'NOTOK',
                'msg'  => 'Website template not found.',
            ]);
        } 

        $rules = [ 
            'com_name' => [ 'required', 'min:6', 'max:150', 'unique:web_templates,com_name,' . $idr, ], 
            'webaddress' => [ 'required', 'min:6', 'max:150', 'unique:web_templates,domain,' . $idr,  ], 
            'templates' => [ 'required', 'min:3', 'max:50', ], 
            'logoUpload' => [ 'nullable', 'image', 'mimes:jpg,jpeg,gif,png', 'max:12288', ], 
            'iconUpload' => [ 'nullable', 'image', 'mimes:jpg,jpeg,gif,png', 'max:12288', ],
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
 
        $rid = 0; 
        $file = ['', '']; 
        $files = ['', ''];  
        $avatar = $request->file('logoUpload'); 
        $avatar1 = $request->file('iconUpload'); 
        $data = [

            'com_name' => $request->input('com_name'), 
            'domain' => $request->input('webaddress'), 
            'template' => $request->input('templates'),
        ]; 
        if ($avatar) { 
            $file = $this->fileUpload( 'logoUpload', $rid, $request ); 
            if ($file[0] === 'NOTOK') { 
                return response()->json([ 'stts' => 'NOTOK', 'msg'  => 'Logo Upload ' . ($file[1] ?? ''), ]);
            } 
            $data['logo'] = $file[1];
        } 
        if ($avatar1) {

            $files = $this->fileUpload( 'iconUpload', $rid, $request );  
            if ($files[0] === 'NOTOK') { 
                return response()->json([ 'stts' => 'NOTOK', 'msg'  => 'Icon Upload ' . ($files[1] ?? ''), ]);
            } 
            $data['icon'] = $files[1];
        }
 
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

    public function fileUpload($filename, $rid, Request $request)
    {
        $msg = [ '', '', ]; 
        $avatar = $request->file($filename); 
        if ($avatar && $avatar->getClientOriginalName() != '') { 
            $validator = Validator::make( $request->all(), 
            [ $filename => [ 'required', 'image', 'mimes:jpg,jpeg,gif,png', 'max:12288', ], ] ); 
            $msg[0] = 'NOTOK'; 
            if ($validator->passes()) { 
                $avatar = $request->file($filename);  
                $filenewname = $avatar->hashName(); 
                $uploadPath = public_path( 'assets/images/uploads' );
                if (!is_dir($uploadPath)) { 
                    mkdir( $uploadPath, 0755, true );
                } 
                try { 
                    $avatar->move( $uploadPath, $filenewname ); 
                    $msg[0] = 'OK'; 
                    $msg[1] = $filenewname; 
                } catch (\Throwable $e) { 
                    $msg[0] = 'NOTOK'; 
                    $msg[1] = 'FIle not copy to upload directory';
                }

            } else { 
                $msg[0] = 'NOTOK'; 
                $msg[1] =  $filename . ' ' . implode( '<br>',  $validator->errors()->all()  );
            }
        } 
        return $msg;
    }

   

     

    
}

 
 
 