<?php
namespace App\Http\Controllers\Dashboard; 
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\DashboardMenu;

class AddDashboardMenu extends Controller
{
     
    public function index()
    {
        $menu = $this->getallMenu();
        return view('dashboard.addDashboardMenu', compact('menu')); 
    }

     

    /* */
    public function addMenu(Request $request)
    {
        try {

            $validated = $request->validate([
                'menu_name'       => 'required|string|max:255',
                'menu_link'       => 'nullable|string|max:255',
                'menu_icon'       => 'nullable|string|max:255',
                'menu_type'       => 'required|in:0,1',
                'menu_serial'     => 'required|integer',
                'menu_for'        => 'required|string|max:100',
                'sub_menu_serial' => 'nullable|integer',
                'status'          => 'required|in:0,1',
                'view_action'     => 'required|in:0,1',
            ]);

            $menu = DashboardMenu::create([
                'menu_name'       => $validated['menu_name'],
                'menu_link'       => $validated['menu_link'] ?? null,
                'menu_icon'       => $validated['menu_icon'] ?? null,
                'menu_type'       => $validated['menu_type'],
                'menu_serial'     => $validated['menu_serial'],
                'menu_for'        => $validated['menu_for'],
                'sub_menu_serial' => $validated['sub_menu_serial'] ?? 0,
                'status'          => $validated['status'],
                'view_action'     => $validated['view_action'],
            ]);

            return response()->json([
                'stts' => 'OK',
                'msg'  => 'Successfully Added!',
                'id'   => $menu->id,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            $errors = $e->validator->errors()->all();

            return response()->json([
                'stts' => 'NOTOK',
                'msg'  => implode('<br>', $errors),
            ], 422);

        } catch (\Throwable $e) {

            return response()->json([
                'stts' => 'NOTOK',
                'msg'  => $e->getMessage(),
            ], 500);
        }
    } 


  
 
    	 


    public function getLserial(Request $request)
    {
        $menutype = $request->input('menu');
        $submenu  = $request->input('smenu');

        if ($menutype == "0") {

            $queryclm = 'menu_serial'; 
            $data = DashboardMenu::where('menu_type', '0') ->orderBy($queryclm, 'desc') ->first();

        } elseif ($menutype == "1") {

            $queryclm = 'sub_menu_serial'; 
            $data = DashboardMenu::where('menu_for', $submenu) ->orderBy($queryclm, 'desc') ->first();

        } else {

            return response()->json([
                'msg' => 0
            ]);
        }


        if ($data) {

            $returnValue = $data->$queryclm + 1;

        } else {

            $returnValue = 1;

        }


        return response()->json([
            'msg' => $returnValue
        ]);
    }

    
    public function getallMenu()
    {
        $data = DashboardMenu::where('menu_type', 0) ->orderBy('menu_serial', 'asc') ->get();

        return $data;
    }

    
}

 
 
 