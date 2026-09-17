<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile; 

use App\Http\Controllers\Fronted\WellcomeController;


//Route::get('/', function () {   return view('welcome'); }); 
Route::get('home',[WellcomeController::class, 'index']); 
Route::get('/', [WellcomeController::class, 'index']);
Route::get('about', [WellcomeController::class, 'aboutus']);
Route::get('contact', [WellcomeController::class, 'contactus']);
Route::get('about', [WellcomeController::class, 'aboutus']);
Route::get('products', [WellcomeController::class, 'productsus']); 
Route::get('single-product', [WellcomeController::class, 'single_product'])->name('single-product');
 
use App\Http\Controllers\Auth\LoginController;
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::get('login-user', [LoginController::class, 'index'])->name('login_user');
Route::post('login_submit', [LoginController::class,'user_Login'])->name('login_submit');
Route::get('logout', [LoginController::class,'logout'])->name('logout');

use App\Http\Controllers\Wishlist\WishlistController; 
Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist');

 

use App\Http\Controllers\Compare\CompareController; 
Route::get('compare', [CompareController::class, 'index'])->name('compare');
 
use App\Http\Controllers\Cart\CartController; 
Route::get('cart', [CartController::class, 'index'])->name('cart');
   
 
use App\Http\Controllers\Dashboard\DashboardController;  
Route::get('dashboardView', [DashboardController::class, 'index'])->middleware('myauth')->name('dashboard');

Route::get('all_users', [DashboardController::class, 'allusers'])->middleware('myauth')->name('all_users');
Route::get('add_user', [DashboardController::class, 'adduser'])->middleware('myauth')->name('add_user');


use App\Http\Controllers\Dashboard\DashboardMenuManage;
Route::get('menu_manager', [DashboardMenuManage::class, 'index'])->middleware('myauth');
Route::post('menu_Active', [DashboardMenuManage::class, 'updateDatas'])->middleware('myauth')->name('menu_Active'); 
Route::post('menuView', [DashboardMenuManage::class, 'updateviewDatas'])->middleware('myauth')->name('menuView'); 
Route::post('menuDelete', [DashboardMenuManage::class, 'deleteDatas'])->middleware('myauth')->name('menuDelete'); 
Route::post('menuserialUpdate', [DashboardMenuManage::class, 'updateserialDatas'])->middleware('myauth')->name('menuserialUpdate'); 



use App\Http\Controllers\Dashboard\AddDashboardMenu;
Route::get('addDashboardMenu', [AddDashboardMenu::class, 'index'])->middleware('myauth');
Route::post('/add-menu', [AddDashboardMenu::class, 'addMenu'])->middleware('myauth')->name('dashboard.menu.store'); 
Route::get('/get-lserial', [AddDashboardMenu::class, 'getLserial'])->middleware('myauth')->name('dashboard.menu.last.serial');

use App\Http\Controllers\Dashboard\Editmenu;
Route::get('edit_menu', [Editmenu::class, 'index'])->middleware('myauth'); 
Route::post('/editMenu', [Editmenu::class, 'saveNewtemp'])->middleware('myauth')->name('dashboard.menu.editMenu'); 


use App\Http\Controllers\Dashboard\Managedashboard;
Route::get('general_settings', [Managedashboard::class, 'index'])->middleware('myauth');
Route::post('updateSettings', [Managedashboard::class, 'updateDatas'])->middleware('myauth')->name('updateSettings');

use App\Http\Controllers\Dashboard\ManageWebsiteSettings;
Route::get('website_settings', [ManageWebsiteSettings::class, 'index'])->middleware('myauth')->name('website_settings');
Route::post('updatespmtdata', [ManageWebsiteSettings::class, 'updateSMTPData'])->middleware('myauth')->name('updatespmtdata');
Route::post('menu_Active', [ManageWebsiteSettings::class, 'updateActBlo'])->middleware('myauth')->name('menu_Active');
Route::post('webDelete', [ManageWebsiteSettings::class, 'deleteDatas'])->middleware('myauth')->name('webDelete'); 

use App\Http\Controllers\Dashboard\Addwebsite; 
Route::get('add_website', [Addwebsite::class, 'index'])->middleware('myauth')->name('add_website');
Route::post('/add-web', [Addwebsite::class, 'saveNewtemp'])->middleware('myauth')->name('dashboard.web.store'); 

use App\Http\Controllers\Dashboard\EditeWebsite; 
Route::get('edite_website', [EditeWebsite::class, 'index'])->middleware('myauth')->name('edite_website');
Route::post('edite-web', [EditeWebsite::class, 'saveEdittemp'])->middleware('myauth')->name('dashboard.edite_web.store'); 
 
use App\Http\Controllers\Dashboard\ManageWebsiteThemeSettings;
Route::get('theme_settings', [ManageWebsiteThemeSettings::class, 'index'])->middleware('myauth')->name('theme_settings');
Route::post('changeThemes', [ManageWebsiteThemeSettings::class, 'updateserialDatas'])->middleware('myauth')->name('changeThemes');

use App\Http\Controllers\Dashboard\User_permissions;
Route::get('permissions', [User_permissions::class, 'index'])->middleware('myauth')->name('permissions');
Route::post('menu_ActiveUp', [User_permissions::class, 'updateAcivetBlock'])->middleware('myauth')->name('menu_ActiveUp');
Route::post('deleteup', [User_permissions::class, 'deleteDatas'])->middleware('myauth')->name('deleteup'); 
 
use App\Http\Controllers\Dashboard\Add_user_type; 
Route::get('add_user_type', [Add_user_type::class, 'index'])->middleware('myauth')->name('add_user_type');
Route::post('/added-user', [Add_user_type::class, 'saveNewtemp'])->middleware('myauth')->name('dashboard.added.user'); 
 
use App\Http\Controllers\Dashboard\Edit_user_type; 
Route::get('edit_utype', [Edit_user_type::class, 'index'])->middleware('myauth')->name('edit_utype');
Route::post('edite-utype', [Edit_user_type::class, 'saveEdittemp'])->middleware('myauth')->name('dashboard.edit_utype.store'); 


use App\Http\Controllers\Dashboard\View_permission_user; 
Route::get('view_permission', [View_permission_user::class, 'index'])->middleware('myauth')->name('view_permission');
Route::post('dashboard.add_user_permision', [View_permission_user::class, 'saveNewtemp'])->middleware('myauth')->name('dashboard.add_user_permision'); 


















