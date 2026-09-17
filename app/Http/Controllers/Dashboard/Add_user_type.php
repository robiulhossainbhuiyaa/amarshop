<?php
namespace App\Http\Controllers\Dashboard; 
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;  
use App\Models\Usertypes; 
use Illuminate\Support\Facades\Validator;

class Add_user_type extends Controller  
{ 
      
    public function index() 
    { 
        return view('dashboard.add_user_type'); 
    }



    public function saveNewtemp(Request $request)
    {
        $rules = [ 
            'type_name' => ['required','min:6','max:20','unique:user_type,type_name',],
            'type_value' => ['required','min:1','max:10','unique:user_type,type_value',], 
        ]; 
        $validator = Validator::make(  $request->all(), $rules ); 
        if ($validator->passes()) { 
            $model = new Usertypes(); 
              
            $data = [
                'type_name' => $request->input('type_name'), 
                'type_value' => $request->input('type_value'),  
                'status'   => 1,
            ];
              
            $model->create($data); 
            $status = 'OK'; 
            $message = 'Successfully Added!';
            

        } else {  
            $status = 'NOTOK'; 
            $message = implode( '<br>', $validator->errors()->all() );
        }
 
        return response()->json([ 'stts' => $status, 'msg' => $message ]);
    }

    
       

    
}

 
 
 