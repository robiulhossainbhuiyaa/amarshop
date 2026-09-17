<?php

namespace App\Http\Controllers\Fronted; 
use App\Http\Controllers\Controller;

use App\Models\User;

class WellcomeController extends Controller
{
    public function index()
    {
        $session    =   session();
        if(session()->get('logged_in'))
        {
            $userid             =  $session->get('user_id');    
            $modelUser 			= new User();
            $hedardata          = $modelUser->getdatabyiduser($userid);

            
        }
        $page_data['hedardata'] 			= $hedardata ?? '';

        return view('welcome', $page_data);  
    }

    public function loginManage()
    {
        return view('dashboard.login.login'); 
    }

    public function aboutus()
    {
        return view('front.pages.about_us'); 
    }
    

    public function contactus()
    {
        return view('front.pages.contact_us'); 
    }

    public function productsus()
    {
        return view('front.products.products'); 
    }

    public function single_product()
    {
        return view('front.products.singleProduct'); 
    }

    
}