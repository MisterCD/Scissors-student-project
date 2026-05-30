<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Rewiew;
use App\Models\User;
use Date;
use DB;
use Hash;
use Illuminate\Http\Request;
use const App\Library\VALIDATION;
use const App\Models\EMAIL;
use const App\Models\PASSWORD;
















class RegisterController extends Controller
{

    public function __construct()
    {
        
    }

    
    private function checkAuth(): mixed
    {
        if (session("user_id", null) === null) {
            return redirect()->route("login");
        }
        return null;
    }
    public function login_get()
    {
        
        if (session("user_id", null) !== null) {
            return redirect()->route("user");
        }
        return view("login");
    }

    
    public function user_get()
    {
        $redirect = $this->checkAuth();
        if ($redirect !== null) {
            return $redirect;
        }

        $userId = session("user_id");
        $user   = DB::table("users")->where("id", $userId)->first();

        if ($user === null) {
            session()->forget("user_id");
            return redirect()->route("login");
        }

        
        $bookings = DB::table("booking")
            ->join("product", "booking.product_id", "=", "product.id")
            ->join("workers", "booking.worker_id",  "=", "workers.id")
            ->join("users as wu", "workers.user_id", "=", "wu.id")
            ->where("booking.user_id", $userId)
            ->select(
                "booking.*",
                "product.name  as product_name",
                "product.cost  as product_cost",
                "wu.username   as worker_name"
            )
            ->orderBy("booking.date", "desc")
            ->get();

        
        $rewiews = DB::table("rewiews")
            ->join("product", "rewiews.product_id", "=", "product.id")
            ->join("users", "rewiews.user_id", "=", "users.id")
            ->where("rewiews.user_id", $userId)
            ->select("rewiews.*", "product.name as product_name", "users.username", "users.avatar")
            ->orderBy("rewiews.date", "desc")
            ->get();
        $notifications = DB::table("notifications")->where("user_id", $userId)->get();
        if($notifications->count() > 8){
            DB::table("notifications")->delete($notifications->last()->id);
        }
        return view("user", [
            "user"          => $user,
            "bookings"      => $bookings,
            "rewiews"       => $rewiews,
            "notifications" => $notifications,
        ]);
    }
    public function createUser_post(Request $request)
    {
        User::validate_rule();

        $result = User::validate();

        
        $result["password"]  = Hash::make($result["password"]);
        $result["status_id"] = 0; 
        $result["avatar"]    = ""; 

        
        $exists = DB::table("users")->where("email", $result["email"])->exists();
        if ($exists) {
            return back()
                ->withErrors(["email" => "Пользователь с таким email уже зарегистрирован"])
                ->withInput($request->except("password"));
        }

        try {
            User::create($result);
        } catch (\Throwable $th) {
            return back()
                ->withErrors(["email" => "Ошибка при регистрации: " . $th->getMessage()])
                ->withInput($request->except("password"));
        }

        
        $user = DB::table("users")->where("email", $result["email"])->first();
        session(["user_id" => $user->id]);

        return redirect()->route("user");
    }
    public function loginUser_post(Request $request)
    {
        
        User::validate_rule(EMAIL);
        User::validate_rule(PASSWORD);

        $result = User::validate();

        $user = DB::table("users")->where("email", $result["email"])->first();

        if ($user === null) {
            return back()
                ->withErrors(["email" => "Пользователь с таким email не найден"])
                ->withInput($request->only("email"));
        }

        if (!Hash::check($result["password"], $user->password)) {
            return back()
                ->withErrors(["password" => "Неверный пароль"])
                ->withInput($request->only("email"));
        }

        session(["user_id" => $user->id]);

        return redirect()->route("user");
    }
    public function logoutUser_get()
    {
        session()->forget("user_id");
        return redirect()->route("login");
    }
    public function changeUser_post(Request $request)
    {
        $redirect = $this->checkAuth();
        if ($redirect !== null) {
            return $redirect;
        }

        $type = (int) $request->get("type");
        $id   = session("user_id");
        User::validate_rule($type);
        $result = User::change($type);
        $user = DB::table("users")->where("id", $id)->first();

        return view("user", [
            "user"            => $user,
            "success_message" => $result['success'],
            "error_message"   => $result['error'],
        ]);
    } 
    public function deleteUser_post(Request $request)
    {
        $redirect = $this->checkAuth();
        if ($redirect !== null) {
            return $redirect;
        }

        $id = session("user_id");

        User::validate_rule(PASSWORD);
        $result = User::validate();

        $currentHash = DB::table("users")->where("id", $id)->value("password");

        if ($currentHash === null) {
            session()->forget("user_id");
            return redirect()->route("login");
        }

        if (!Hash::check($result["password"], $currentHash)) {
            $user = DB::table("users")->where("id", $id)->first();
            return view("user", [
                "user"          => $user,
                "error_message" => "Неверный пароль. Удаление аккаунта отменено.",
            ]);
        }

        try {
            
            DB::table("booking")->where("user_id", $id)->delete();
            DB::table("rewiews")->where("user_id", $id)->delete();

            $worker = DB::table("workers")->where("user_id", $id)->first();
            if ($worker !== null) {
                DB::table("booking")->where("worker_id", $worker->id)->delete();
                DB::table("workers")->where("user_id", $id)->delete();
            }
            
            DB::table("users")->where("id", $id)->delete();
        } catch (\Throwable $th) {
            $user = DB::table("users")->where("id", $id)->first();
            return view("user", [
                "user"          => $user,
                "error_message" => "Ошибка при удалении аккаунта: " . $th->getMessage(),
            ]);
        }

        session()->forget("user_id");
        return redirect()->route("login");
    }
    public function changeAvatar_post(Request $request)
    {
        $redirect = $this->checkAuth();
        if ($redirect !== null) {
            return $redirect;
        }

        $id = session("user_id");

        if (!$request->hasFile("avatar")) {
            return back()->withErrors(["avatar" => "Файл не выбран"]);
        }

        $file    = $request->file("avatar");
        $allowed = ["jpg", "jpeg", "png", "webp", "gif"];

        if (!in_array(strtolower($file->getClientOriginalExtension()), $allowed)) {
            return back()->withErrors([
                "avatar" => "Недопустимый формат. Разрешены: " . implode(", ", $allowed),
            ]);
        }

        if ($file->getSize() > 5 * 1024 * 1024) {
            return back()->withErrors(["avatar" => "Файл слишком большой. Максимум: 5 MB"]);
        }

        try {
            
            $oldAvatar = DB::table("users")->where("id", $id)->value("avatar");
            if ($oldAvatar && !str_starts_with($oldAvatar, "http")) {
                \Storage::disk("public")->delete($oldAvatar);
            }

            $path = $file->store("avatars", "public");
            DB::table("users")->where("id", $id)->update(["avatar" => $path]);
        } catch (\Throwable $th) {
            return back()->withErrors(["avatar" => "Ошибка загрузки: " . $th->getMessage()]);
        }

        $user = DB::table("users")->where("id", $id)->first();
        return view("user", [
            "user"            => $user,
            "success_message" => "Аватар успешно обновлён",
        ]);
    }
    public function createBooking_post(){
        $redirect = $this->checkAuth();
        if ($redirect !== null) {
            return $redirect;
        }
        $id = session("user_id");
        if(request("worker_id") != "any"){
            VALIDATION->add("worker_id", ["required" => "Выберите мастера", 
                                  "integer"  => "id должно быть числом"]);
        }
        Booking::validate_rule();
        $result = Booking::validate();
        $result["user_id"] = $id;
        $result["status"] = 0;
        Booking::insert($result);
        return redirect()->route("user");
    }
    public function createRewiew_post(){
        $redirect = $this->checkAuth();
        if ($redirect !== null) {
            return $redirect;
        }
        $id = session("user_id");
        Rewiew::validate_rule();
        $result = Rewiew::validate();
        $result["allowed"] = 0;
        $result["user_id"] = $id;
        $result["date"] = Date::now();
        Rewiew::insert($result);
        return redirect()->route("rewiews");
    }
}
