<?php
namespace App\Http\Controllers\Dashboard; 
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;  
use App\Models\Webtemplates; 
use Illuminate\Support\Facades\Validator;

class Addwebsite extends Controller 
{ 
      
    public function index() 
    { 
        return view('dashboard.addwebsite'); 
    }



    public function saveNewtemp(Request $request)
    {
        $rules = [
            'com_name' => ['required','min:6','max:150','unique:web_templates,com_name',],
            'webaddress' => ['required','min:6','max:150','unique:web_templates,domain', ],
            'templates' => ['required','min:3','max:50',],
            'logoUpload' => ['required','image','mimes:jpg,jpeg,gif,png',],
            'iconUpload' => ['required','image','mimes:jpg,jpeg,gif,png',],
        ]; 
        $validator = Validator::make(  $request->all(), $rules ); 
        if ($validator->passes()) { 
            $model = new Webtemplates(); 
            $rid = 0;  
            $file = ['', ''];
            $files = ['', '']; 
            $avatar = $request->file('logoUpload');
            $avatar1 = $request->file('iconUpload');  
            // if ( empty($avatar?->getClientOriginalName()) && !empty($avatar1?->getClientOriginalName()) ) 
            // { 
            //     $files = $this->fileUpload( 'iconUpload', $rid, $request ); 
            //     $data = [
            //         'com_name' => $request->input('com_name'), 
            //         'domain' => $request->input('webaddress'), 
            //         'template' => $request->input('templates'), 
            //         'icon' => $files[1],
            //         'status'   => 1,
            //     ];
            // }elseif ( !empty($avatar?->getClientOriginalName()) && empty($avatar1?->getClientOriginalName()) ) 
            // { 
            //     $file = $this->fileUpload( 'logoUpload', $rid,  $request ); 
            //     $data = [
            //         'com_name' => $request->input('com_name'), 
            //         'domain' => $request->input('webaddress'), 
            //         'template' => $request->input('templates'), 
            //         'logo' => $file[1],
            //         'status'   => 1,
            //     ];
            // }else
            
            if ( !empty($avatar?->getClientOriginalName()) && !empty($avatar1?->getClientOriginalName()) ) 
            { 
                $file = $this->fileUpload( 'logoUpload', $rid, $request ); 
                $files = $this->fileUpload( 'iconUpload', $rid, $request ); 
                $data = [
                    'com_name' => $request->input('com_name'), 
                    'domain' => $request->input('webaddress'), 
                    'template' => $request->input('templates'), 
                    'logo' => $file[1], 
                    'icon' => $files[1],
                    'status'   => 1,
                ];
            } else {

                $data = [
                    'com_name' => $request->input('com_name'), 
                    'domain' => $request->input('webaddress'), 
                    'template' => $request->input('templates'),
                    'status'   => 1,
                ];
            }
 
            $error = 0; 
            $status = 'NOTOK';
            $message = ''; 
            if ( isset($file[0]) && $file[0] == 'NOTOK' ) 
            { 
                if (!empty($avatar?->getClientOriginalName())) { 
                    $error = 1; 
                    $status = 'NOTOK'; 
                    $message = 'Logo Upload ' . ($file[1] ?? '');
                }
            }
 
            if ( isset($files[0]) && $files[0] == 'NOTOK' ) 
            { 
                if (!empty($avatar1?->getClientOriginalName())) { 
                    $error = 1; 
                    $status = 'NOTOK'; 
                    $message .= ' Icon Upload ' . ($files[1] ?? '');
                }
            } 
            /*
            |--------------------------------------------------------------------------
            | Save Data
            |--------------------------------------------------------------------------
            */

            if ($error == 0) { 
                $model->create($data); 
                $status = 'OK'; 
                $message = 'Successfully Added!';
            }

        } else { 
            $status = 'NOTOK'; 
            $message = implode( '<br>', $validator->errors()->all() );
        }
 
        return response()->json([ 'stts' => $status, 'msg' => $message ]);
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

 
 
 