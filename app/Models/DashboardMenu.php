<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;   
use App\Models\User;  

class DashboardMenu extends Model 
{
    protected $table = 'dashboard_menus';

    protected $fillable = [
        'id',
        'menu_name',
        'menu_link',
        'menu_icon',
        'menu_type',
        'menu_serial',
        'menu_for',
        'sub_menu_serial',
        'status',
        'view_action',
    ];

    public function getDatabyid($id)
    {
        
        
        $data = self::where('id', $id) ->orderBy('id', 'asc')->get();
        //echo '<pre>'; print_r($data); echo '</pre>'; exit;
        return $data;
    }

    public function updateData($clmn, $val, $upid)
    {
        $updated = DashboardMenu::where('id', $upid) ->update([ $clmn => $val ]);

        return $updated > 0;
    }    

    public function getallMenu()
    {
        $data = self::orderBy('id', 'desc')->get(); 
        return $data;
    }
    public function getSidebarallMenu()
    {
        return self::where('menu_type', 0)  ->where('view_action', 1) ->orderBy('id', 'asc')  ->get();
    }

    public function getMenuTitle($menu_link){ 
        $data = self::where('menu_link',$menu_link)->first();
        return $data['menu_name'] ?? 'N/A';
    }

    public function getMenupageIcon($menu_link){ 
        $data = self::where('menu_link',$menu_link)->first();
        return $data['menu_icon'] ?? 'N/A';
    }

    public function getparentMenuTitle($menu_link){ 
        $data = self::where('menu_link',$menu_link)->first();
        $pmenuid = $data['menu_for'] ?? '';
        return $this->getMenuNamebyId($pmenuid);
    }

    public function getMenuNamebyId($pmenuid){
	 
        $data = self::where('id',$pmenuid)->first();
 
		if ($data) {
			return $data['menu_name'];
		} else {
			return ""; 
		}
	}



    public function getparentMenuIcon($menu_link){ 
        $data = self::where('menu_link',$menu_link)->first();
        $pmenuid = $data['menu_for'] ?? 'N/A';
        return $this->getMenuIconbyId($pmenuid);
    }
    

    public function getMenuIconbyId($pmenuid){
	 
        $data = self::where('id',$pmenuid)->first();
 
		if ($data) {
			return $data['menu_icon'];
		} else {
			return ""; 
		}
	}

    //done
    public function getLogType(){
        $session = session();
        $userid = $session->get('user_id');
        $modeluser = new User();
        $logtype = $modeluser->getUserType($userid);
        return $logtype;
    }
	
    //done 
    public function getMenu(){ 
        if($this->getLogType() == "1"){
         $wherearray = array('menu_type'=>'0');
        }else{
         $wherearray = array('menu_type'=>'0', 'status'=>'1');  
        }
        $data = self::where($wherearray)->orderby('menu_serial', 'asc')->get();
        return $data;
    }
    
    
    public function checkSubmenu($uid){ 
        if($this->getLogType() == "1"){
            $wherearray = array('menu_type'=>'1', 'menu_for'=>$uid);
        }else{
            $wherearray = array('menu_type'=>'1', 'menu_for'=>$uid, 'status'=>'1');
        }
        $data = self::where($wherearray)->count();
        return $data;
    }
    
    public function getSubmenu($uid){ 
        if($this->getLogType() == "1"){
        $wherearray = array('menu_type'=>'1', 'menu_for'=>$uid);
        }else{
         $wherearray = array('menu_type'=>'1', 'menu_for'=>$uid, 'status'=>'1');   
        }
        $data = self::where($wherearray)->orderby('sub_menu_serial', 'asc')->get();
        return $data;
    }
    

    
}