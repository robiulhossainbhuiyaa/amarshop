<?php
namespace App\Http\Controllers\Dashboard; 
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\DashboardMenu;
use App\Models\Controlweb;
use App\Models\User;

class DashboardController extends Controller
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
		    $dashboard_view = "dashboard.dashboard";
		    $footer			= 'footer';
		 
			
		}else
		{
		    $dashboard_view = "dashboard.dashboard".$dashboard;
		    $footer			= 'footer'.$dashboard;
		 
		}

        $userid             =  $session->get('user_id');    
        $modelUser 			= new User();
        $hedardata          = $modelUser->getdatabyiduser($userid);



        $modelmenu 			= new DashboardMenu();
		$currentPage		= trim(request()->path(), '/');
		$menutitle			= $modelmenu->getMenuTitle($currentPage);
		$pageIcon			= $modelmenu->getMenupageIcon($currentPage);
		$getparentMenuTitle	= $modelmenu->getparentMenuTitle($currentPage);
        $getparentMenuIcon	= $modelmenu->getparentMenuIcon($currentPage);

        $page_data = $data;
		$page_data['dashboard'] 			= $dashboard;  
		$page_data['pageTitle'] 			= $menutitle;
		$page_data['pageIcon'] 				= $pageIcon;
		$page_data['menuIcon'] 				= $getparentMenuIcon;
		$page_data['getparentMenuTitle'] 	= $getparentMenuTitle;
		$page_data['currentPage'] 			= $currentPage;
		$page_data['hedardata'] 			= $hedardata;


 
        $menuData           = $this->getallMenu();
        $sidebarmenuData    = $this->getSidebarallMenu(); 
        foreach ($sidebarmenuData as $menu) 
        {
            $menu->subMenus = $modelmenu::where('menu_type', 1) 
            ->where('menu_for', $menu->id)  ->where('view_action', 1)  ->get(); 
        }
  
 


        

        $page_data['menuData'] 			= $menuData ;
        $page_data['sidebarmenuData'] 	= $sidebarmenuData ; 


        return view($dashboard_view, $page_data);
        //return view('dashboard.dashboard', compact('menuData','sidebarmenuData')); 
    }

    public function getDomain(Request $request)
    {
        $domain = $request->getHost();

        return str_replace('www.', '', $domain);
    }
    
    public function allusers()
    {
        $menuData           = $this->getallMenu();
        $sidebarmenuData    = $this->getSidebarallMenu();
        foreach ($sidebarmenuData as $menu) {
            $menu->subMenus = DashboardMenu::
            where('menu_type', 1)
            ->where('menu_for', $menu->id) 
            ->where('view_action', 1) 
            ->get();
        }
        return view('dashboard.dashboard', compact('menuData','sidebarmenuData')); 
    }
    
    public function adduser()
    {
        $menuData           = $this->getallMenu();
        $sidebarmenuData    = $this->getSidebarallMenu();
        foreach ($sidebarmenuData as $menu) {
            $menu->subMenus = DashboardMenu::
            where('menu_type', 1)
            ->where('menu_for', $menu->id) 
            ->where('view_action', 1) 
            ->get();
        }
        return view('dashboard.dashboard', compact('menuData','sidebarmenuData')); 
    }
    
    
    public function addDashboardMenu()
    {
        return view('dashboard.addDashboardMenu');
        //return view('front.pages.about_us');
    }













    public function getallMenu()
    {
        $model = new DashboardMenu();

        $data = $model->getallMenu();

        return $data;
    }

    public function getallsubMenus()
    {
        $sidebarmenuData    = $this->getSidebarallMenu();
        foreach ($sidebarmenuData as $menu) {
        $data =  $menu = DashboardMenu::where('menu_type', 1) ->where('menu_for', $menu->id)  ->where('view_action', 1)  ->get(); }
  
        return $data;
    }

    public function getSidebarallMenu()
    {
        $model = new DashboardMenu();
        $data = $model->getSidebarallMenu();

        return $data;
    }
     
}

?>