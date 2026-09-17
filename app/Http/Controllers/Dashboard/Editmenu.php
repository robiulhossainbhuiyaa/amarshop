<?php
namespace App\Http\Controllers\Dashboard; 
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\DashboardMenu;

class Editmenu extends Controller
{
     
    public function index(Request $request)
    {
        $id = $request->get('rid');

        
        $menu = $this->getallMenu();
        
        $datarslt = $this->getDatabyid($id);

        
        return view('dashboard.editmenu', compact('datarslt', 'menu')); 

        
    }
    public function getDatabyid($id)
    {
        $model = new DashboardMenu();

        $data = $model->getDatabyid($id);

        return $data;
    }
    public function getallMenu()
    {
        $data = DashboardMenu::where('menu_type', 0) ->orderBy('menu_serial', 'asc') ->get();

        return $data;
    }

    public function saveNewtemp(Request $request)
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
 
            $rid = $request->get('rid');

            if (!$rid) {
                return response()->json([
                    'stts' => 'NOTOK',
                    'msg'  => 'Menu ID is required.'
                ], 422);
            }
 
            $menu = DashboardMenu::find($rid);

            if (!$menu) {
                return response()->json([
                    'stts' => 'NOTOK',
                    'msg'  => 'Menu not found.'
                ], 404);
            }

            // Update
            $menu->update([
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
                'msg'  => 'Successfully Updated! id: '.$menu->id,
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

   
    	 
 

    

    
}

 
 
 