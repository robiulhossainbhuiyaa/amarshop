<?php
namespace App\Http\Controllers\Dashboard; 
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\DashboardMenu;
use App\Models\Tblsmtpconfig;
use App\Models\Controlweb;
use App\Models\User;
use App\Models\Usertypes;
use App\Models\Webtemplates;

class User_permissions extends Controller 
{ 
      
	public function index(Request $request)
    {
        $session    =   session();
        if(!session()->get('user_name') || empty(session()->get('user_name')) || session()->get('logged_in') == False)
		{ 
            return redirect()
            ->route('login')
            ->with(
                'msg',
                'Session Expired Please login again'
            );
			 
		}
 
        $domain = $this->getDomain($request);
        $data = [
			'domain' => $domain,
			'log_In' => session('logged_in'),
			'menu_item' => 'dashboard' 
		];


        $modelControl	= new Controlweb();
		$dashboard		= $modelControl->getDashboard();
		if($dashboard == 0)
		{
		    $dashboard_view = "dashboard.user_permissions";
		    $footer			= 'footer';
		 
			
		}else
		{
		    $dashboard_view = "dashboard.user_permissions";
		    $footer			= 'footer'.$dashboard;
		 
		}

        $userid             =  $session->get('user_id');    
        $modelUser 			= new User();
        $hedardata          = $modelUser->getdatabyiduser($userid);



        $modelmenu 							= new DashboardMenu();
		$currentPage						= trim(request()->path(), '/');
		$menutitle							= $modelmenu->getMenuTitle($currentPage);
		$pageIcon							= $modelmenu->getMenupageIcon($currentPage);
		$getparentMenuTitle					= $modelmenu->getparentMenuTitle($currentPage);
		$getparentMenuIcon					= $modelmenu->getparentMenuIcon($currentPage);

        $page_data 							= $data;  
		$page_data['pageTitle'] 			= $menutitle;
		$page_data['pageIcon'] 				= $pageIcon;
		$page_data['getparentMenuTitle'] 	= $getparentMenuTitle;
		$page_data['menuIcon'] 				= $getparentMenuIcon;
		$page_data['currentPage'] 			= $currentPage;
		$page_data['hedardata'] 			= $hedardata;

		//echo '<pre>'; print_r($hedardata); echo '</pre>'; exit;


 
        $menuData           				= $this->getallMenu();
        $sidebarmenuData    				= $this->getSidebarallMenu(); 
        foreach ($sidebarmenuData as $menu) 
        {
            $menu->subMenus = $modelmenu::where('menu_type', 1) 
            ->where('menu_for', $menu->id)  ->where('view_action', 1)  ->get(); 
        }
  
 


        

        $page_data['menuData'] 			= $menuData ;
        $page_data['sidebarmenuData'] 	= $sidebarmenuData ; 
		$page_data['pagedata'] 			= $this->getDatas(); 


        return view($dashboard_view, $page_data); 
    }
	
	public function getDatas(){  
		$model = new Usertypes();
	    $data = $model->getData();
	    return $data;
	}
	
    public function getDomain(Request $request)
    {
        $domain = $request->getHost();

        return str_replace('www.', '', $domain);
    }

    public function getallMenu()
    {
        $model = new DashboardMenu();

        $data = $model->getallMenu();

        return $data;
    }

    public function getSidebarallMenu()
    {
        $model = new DashboardMenu();
        $data = $model->getSidebarallMenu();

        return $data;
    }


    public function updateAcivetBlock(Request $request){
	    $clmn="status";
	    $val= $request->get('val');
	    $uid= $request->get('checked_order_id_list'); 
		//echo '<pre>'; print_r($val); echo '</pre>'; exit; 
	    $uidexplode = explode(",",$uid);
	    $model = new Usertypes();
	    if(!empty($clmn) && !empty($uid)){
	        if(count($uidexplode) > 1){
	            foreach($uidexplode as $rslt){
	                $model->updateData($clmn, $val, $rslt);
	            }
	        }else{ 
	            $model->updateData($clmn, $val, $uid);
	        }
	        $datamsg = "OK";
	        $msg = "UPDATED";
	    }else{
	        $datamsg = "NOTOK";
	        $msg = "NOT UPDATED= $uid / $val";
	    }
	    echo json_encode(array("stts"=>$datamsg, "msg"=>$msg));
	} 

	public function deleteDatas(Request $request)
	{
		$uid = $request->input('removeids'); 
		if (empty($uid)) {
			return response()->json([ 'stts' => 'NOTOK', 'msg'  => 'No ID selected!' ], 422);
		} 
		$uidexplode = array_filter( explode(',', $uid), fn ($id) => is_numeric($id) );

		if (empty($uidexplode)) {
			return response()->json([ 'stts' => 'NOTOK', 'msg'  => 'Invalid ID selected!' ], 422);
		} 
		 
		Usertypes::whereIn('id', $uidexplode)->delete(); 
		return response()->json([
			'stts' => 'OK',
			'msg'  => 'Deleted successfully!'
		]);
	}
    
     
}

?>