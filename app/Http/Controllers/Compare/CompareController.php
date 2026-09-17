<?php
namespace App\Http\Controllers\Compare; 
use App\Http\Controllers\Controller;

class CompareController extends Controller
{
    public function index()
    {
        return view('compare.compare'); 
    }
    
}

?>