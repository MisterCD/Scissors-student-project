<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainCOntroller;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// GET - name_get
// POST - name_post

class RouteObject {
    private $classname;
    public string $routePath;
    public string $namesp;
    public function __construct($classname, string $route = "/", $namesp = ""){
        $this->classname = $classname;
        $this->routePath = $route;
        $this->namesp = $namesp;

    }

    public function get(string $route, string $method_get, string $name){
        Route::get($this->routePath.$route, [$this->classname, $method_get."_get"])->name($this->namesp.$name);
    }
    public function get_by_name(string $name){
        Route::get($this->routePath.$name, [$this->classname, $name."_get"])->name($this->namesp.$name);
    }
    public function post_by_name(string $name){
        Route::post($this->routePath.$name, [$this->classname, $name."_post"])->name($this->namesp.$name);
    }

    public function post(string $route, string $method_post, string $name){
        Route::post($this->routePath.$route, [$this->classname, $method_post."_post"])->name($this->namesp.$name);
    }

}

$Main = new RouteObject(MainCOntroller::class);
$Admin = new RouteObject(AdminController::class, "/admin/", "admin:");
$Auth = new RouteObject(RegisterController::class, "/auth/");

$Main->get("", "main", "main");
$Main->get_by_name("about");
$Main->get_by_name("worker");
$Main->get_by_name("event");
$Main->get_by_name("product");
$Main->get_by_name("galary");
$Main->get_by_name("menu");
$Main->get_by_name("rewiews");
$Main->get_by_name("booking");
$Main->get_by_name("contacts");
$Auth->get_by_name("login");
$Auth->post_by_name("createUser");
$Auth->post_by_name("createRewiew");
$Auth->post_by_name("loginUser");
$Auth->get_by_name("logoutUser");
$Auth->get_by_name("user");
$Auth->get_by_name("login");
$Admin->get_by_name("admin");
$Admin->post_by_name("createProduct");
$Admin->post_by_name("deleteProduct");
$Admin->post_by_name("changeProduct");
$Admin->post_by_name("changeType");
$Admin->post_by_name("deleteType");
$Admin->post_by_name("createType");
$Admin->post_by_name("createWorker");
$Admin->post_by_name("deleteWorker");
$Admin->post_by_name("changeWorker");
$Admin->post_by_name("allowRewiew");
$Admin->post_by_name("deleteRewiew");
$Admin->post_by_name("allowBooking");
$Admin->post_by_name("cancelBooking");
$Admin->post_by_name("deleteBooking");
$Admin->post_by_name("changeUserRole");
$Admin->post_by_name("deleteUser");
$Admin->post_by_name("uploadImage");
$Admin->post_by_name("addImageUrl");
$Admin->post_by_name("deleteImage");
$Admin->post_by_name("createNews");
$Admin->post_by_name("deleteNews");
