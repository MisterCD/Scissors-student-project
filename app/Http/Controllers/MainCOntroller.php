<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MainCOntroller extends Controller
{
    
    private function getSingleData(string $table, $id){
        return DB::table($table)->where(["id" => $id])->get()->get(0);
    }    
    private function getLimitedData(string $table, string $oradername, string $ordertype, int $limit){
        return DB::table($table)->orderBy($oradername, $ordertype)->limit($limit)->get();
    }

    public function main_get(){
        $Products = self::getLimitedData("product", "popular", "desc", 4);
        $Workers = DB::table("workers")->orderBy("id", "desc")->limit(4)->join("users", "workers.user_id", "=", "users.id")->get();
        $News = self::getLimitedData("news", "id", "desc", 4);
        $Rewiews = DB::table("rewiews")->orderBy("id", "desc")->limit(3)->join("users", "rewiews.user_id", "=", "Users.id")->get();
        $stars = DB::table("rewiews")->select("stars")->get();
        return view("main", ["Products" => $Products, "Workers" => $Workers, "News" => $News, "Rewiews"=>$Rewiews, "stars"=>$stars]);
    }
    public function about_get(){
        $Workers = DB::table("workers")->join("users", "users.id", "=", "workers.user_id")->paginate(8);
        return view("about", ["Workers" => $Workers]);
    }
    public function worker_get(Request $request){
        $id = $request->get("id");
        $Worker = self::getSingleData("workers", $id);
        return view("worker-page", ["worker" => $Worker]);
    }
    public function product_get(Request $request){
        $id = $request->get("id");
        $Product = self::getSingleData("product", $id);
        return view("product-page", ["worker" => $Product]);
    }
    public function event_get(Request $request){
        $id = $request->get("id");
        $News = self::getSingleData("news", $id);
        return view("event", ["event" => $News]);
    }
    public function galary_get(){
        $types = DB::table("type")->get();
        $images = DB::table("images")->paginate(8);
        return view("galary", ["images" => $images, "types"=>$types]);
    }
    public function rewiews_get(){
        $types = DB::table("type")->get();
        $rewiews = DB::table("rewiews")->join("users", "rewiews.user_id", "=", "Users.id")->join("product", "rewiews.product_id", "=", "product.id")->paginate(6);
        $products = DB::table("product")->select("id", "name")->get();
        return view("rewiews", ["rewiews"=>$rewiews, "types"=>$types, "Products" => $products]);
    }
    public function menu_get(Request $request){
        $types = DB::table("type")->get();
        $Products = null;
        $type = $request->get("type");
        if($type != null){
            $Products = DB::table("product")->where(["type_id" => $type])->paginate(8);
        }else{
            $Products = DB::table("product")->paginate(8);
        }
        return view("menu", ["Products"=>$Products, "types" => $types]);
    }
    public function booking_get(){
        $workers = DB::table("workers")->join("users", "workers.user_id", "=", "users.id")->get();
        $products = DB::table("product")->get();
        return view("booking", ["workers" => $workers, "Products" => $products]);
    }
    public function contacts_get(){
        $contact = DB::table("contact")->get();
        return view("contacts", ["contact" => $contact->get(0)]);
    }

}
