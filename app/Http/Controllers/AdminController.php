<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Worker;
use DB;
use Illuminate\Http\Request;
use const App\Library\VALIDATION;







const USER_STATUS_USER   = 0;
const USER_STATUS_MASTER = 1;
const USER_STATUS_ADMIN  = 2;

class AdminController extends Controller
{
    

    public function __construct()
    {
        
    }

    private function getPage(string $type, $args = null)
    {
        $views = [
            "rewiews"  => "admin/admin-rewiews",
            "users"    => "admin/admin-users",
            "bookings" => "admin/admin-bookings",
            "products" => "admin/admin-products",
            "workers"  => "admin/admin-workers",
            "gallery"  => "admin/admin-gallery",
            "news"     => "admin/admin-news",
            "types"    => "admin/admin-types",
        ];

        $viewName = $views[$type] ?? null;

        if ($viewName === null) {
            abort(404, "Раздел администратора не найден");
        }

        return $args === null ? view($viewName) : view($viewName, $args);
    }

    private function checkAdmin()
    {
        $userId = session("user_id", null);

        if ($userId === null) {
            return redirect()->route("login");
        }

        $user = DB::table("users")->where("id", $userId)->first();
        /*
        if ($user === null || $user->status_id !== USER_STATUS_ADMIN) {
            return redirect()->route("main");
        }
        */
        return null;
    }

    // =================== ADMIN GET ===================

    public function admin_get(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        $type = $request->get("type", "products");

        switch ($type) {

            case "products":
                $products = DB::table("product")
                    ->join("type", "product.type_id", "=", "type.id")
                    ->select("product.*", "type.name as type_name")
                    ->get();
                $types = DB::table("type")->get();
                return $this->getPage("products", ["products" => $products, "types" => $types]);

            case "types":
                $types = DB::table("type")
                    ->select("type.*", DB::raw("COUNT(product.id) as product_count"))
                    ->leftJoin("product", "product.type_id", "=", "type.id")
                    ->groupBy("type.id", "type.name")
                    ->get();
                return $this->getPage("types", ["types" => $types]);

            case "users":
                $filter = $request->get("filter", "all");
                $search = $request->get("search", "");
                $query  = DB::table("users");
                if ($filter !== "all") {
                    $statusMap = ["user" => USER_STATUS_USER, "master" => USER_STATUS_MASTER, "admin" => USER_STATUS_ADMIN];
                    if (isset($statusMap[$filter])) $query->where("status_id", $statusMap[$filter]);
                }
                if ($search !== "") {
                    $query->where(function ($q) use ($search) {
                        $q->where("username", "like", "%{$search}%")->orWhere("email", "like", "%{$search}%");
                    });
                }
                $users = $query->get();
                return $this->getPage("users", ["users" => $users, "filter" => $filter, "search" => $search]);

            case "workers":
                $workers = DB::table("workers")
                    ->join("users", "workers.user_id", "=", "users.id")
                    ->select("workers.*", "users.username", "users.email", "users.avatar")
                    ->get();
                $masterUsers = DB::table("users")->where("status_id", USER_STATUS_MASTER)->get();
                return $this->getPage("workers", ["workers" => $workers, "masterUsers" => $masterUsers]);

            case "rewiews":
                $filter = $request->get("filter", "all");
                $query  = DB::table("rewiews")
                    ->join("users",   "rewiews.user_id",    "=", "users.id")
                    ->join("product", "rewiews.product_id", "=", "product.id")
                    ->select("rewiews.*", "users.username", "users.avatar", "product.name as product_name");
                if ($filter === "pending")  $query->where("rewiews.allowed", 0);
                if ($filter === "approved") $query->where("rewiews.allowed", 1);
                $rewiews = $query->orderBy("rewiews.date", "desc")->get();
                return $this->getPage("rewiews", ["rewiews" => $rewiews, "filter" => $filter]);

            case "bookings":
                $filter = $request->get("filter", "all");
                $query  = DB::table("booking")
                    ->join("users",   "booking.user_id",    "=", "users.id")
                    ->join("workers", "booking.worker_id",  "=", "workers.id")
                    ->join("users as wu", "workers.user_id", "=", "wu.id")
                    ->join("product", "booking.product_id", "=", "product.id")
                    ->select(
                        "booking.*",
                        "users.username as client_name",
                        "users.email    as client_email",
                        "wu.username    as worker_name",
                        "product.name   as product_name",
                        "product.cost   as product_cost"
                    );
                if ($filter !== "all") $query->where("booking.status", $filter);
                $bookings = $query->orderBy("booking.date", "desc")->get();
                return $this->getPage("bookings", ["bookings" => $bookings, "filter" => $filter]);

            case "gallery":
                $filter = $request->get("filter", "all");
                $query  = DB::table("images")
                    ->join("type", "images.type_id", "=", "type.id")
                    ->select("images.*", "type.name as type_name");
                if ($filter !== "all") $query->where("images.type_id", $filter);
                $images = $query->get();
                $types  = DB::table("type")->get();
                return $this->getPage("gallery", ["images" => $images, "types" => $types, "filter" => $filter]);

            case "news":
                $news  = DB::table("news")
                    ->join("type", "news.type_id", "=", "type.id")
                    ->select("news.*", "type.name as type_name")
                    ->orderBy("news.date", "desc")
                    ->get();
                $types = DB::table("type")->get();
                return $this->getPage("news", ["news" => $news, "types" => $types]);

            default:
                return redirect()->route("admin", ["type" => "products"]);
        }
    }

    // =================== PRODUCTS ===================

    public function createProduct_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        Product::validate_rule();

        $result = Product::validate();
        $result["popular"] = 0;

        try {
            DB::table("product")->insert($result);
        } catch (\Throwable $th) {
            $types = DB::table("type")->get();
            $products = DB::table("product")->join("type","product.type_id","=","type.id")->select("product.*","type.name as type_name")->get();
            return $this->getPage("products", ["error_message" => "Ошибка при создании: " . $th->getMessage(), "products" => $products, "types" => $types]);
        }

        return redirect()->route("admin:admin", ["type" => "products"])->with("success_message", "Услуга успешно создана");
    }

    public function deleteProduct_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        $id = $request->get("id", null);
        if ($id === null) return redirect()->route("admin", ["type" => "products"])->with("error_message", "ID не передан");

        try {
            DB::table("rewiews")->where("product_id", $id)->delete();
            DB::table("booking")->where("product_id", $id)->delete();
            DB::table("product")->where("id", $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route("admin", ["type" => "products"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin", ["type" => "products"])->with("success_message", "Услуга удалена");
    }

    public function changeProduct_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        $id    = $request->get("id", null);

        if ($id === null) return redirect()->route("login");

        Product::validate_rule();
        $updateData = Product::validate();
        try {
            DB::table("product")->where("id", $id)->update($updateData);
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "products"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "products"])->with("success_message", "Услуга обновлена");
    }

    public function createType_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        VALIDATION->add("name", ["required" => "Название обязательно", "max" => "Не более 120 символов"], ["max" => "120"]);
        $result = VALIDATION->validate_and_clear();

        try {
            DB::table("type")->insert(["name" => $result["name"]]);
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "types"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "types"])->with("success_message", "Тип создан");
    }

    public function deleteType_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        $id = $request->get("id", null);
        if ($id === null) return redirect()->route("admin:admin", ["type" => "types"])->with("error_message", "ID не передан");

        $productCount = DB::table("product")->where("type_id", $id)->count();
        if ($productCount > 0) {
            return redirect()->route("admin:admin", ["type" => "types"])->with("error_message", "Нельзя удалить: есть услуги этого типа ({$productCount} шт.)");
        }

        try {
            DB::table("images")->where("type_id", $id)->delete();
            DB::table("news")->where("type_id", $id)->delete();
            DB::table("type")->where("id", $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "types"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "types"])->with("success_message", "Тип удалён");
    }

    public function changeType_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        $id = $request->get("id", null);
        if ($id === null) return redirect()->route("admin:admin", ["type" => "types"])->with("error_message", "ID не передан");

        VALIDATION->add("name", ["required" => "Название обязательно", "max" => "Не более 120 символов"], ["max" => "120"]);
        $result = VALIDATION->validate_and_clear();

        try {
            DB::table("type")->where("id", $id)->update(["name" => $result["name"]]);
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "types"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "types"])->with("success_message", "Тип обновлён");
    }

    // =================== WORKERS ===================

    public function createWorker_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        
        Worker::validate_rule();

        $result = Worker::validate();

        $user = DB::table("users")->where("id", $result["user_id"])->first();
        if ($user === null) return redirect()->route("admin:admin", ["type" => "workers"])->with("error_message", "Пользователь не найден");

        $exists = DB::table("workers")->where("user_id", $result["user_id"])->exists();
        if ($exists) return redirect()->route("admin:admin", ["type" => "workers"])->with("error_message", "Этот пользователь уже мастер");

        try {
            DB::table("workers")->insert($result);
            DB::table("users")->where("id", $result["user_id"])->update(["status_id" => USER_STATUS_MASTER]);
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "workers"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "workers"])->with("success_message", "Мастер добавлен");
    }

    public function deleteWorker_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        $id = $request->get("id", null);
        if ($id === null) return redirect()->route("admin:admin", ["type" => "workers"])->with("error_message", "ID не передан");

        try {
            $worker = DB::table("workers")->where("id", $id)->first();
            if ($worker === null) return redirect()->route("admin:admin", ["type" => "workers"])->with("error_message", "Мастер не найден");

            DB::table("users")->where("id", $worker->user_id)->update(["status_id" => USER_STATUS_USER]);
            DB::table("booking")->where("worker_id", $id)->delete();
            DB::table("workers")->where("id", $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "workers"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "workers"])->with("success_message", "Мастер удалён");
    }

    public function changeWorker_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        $id    = $request->get("id", null);
        $type = $request->get("type", null);

        if ($id === null) return redirect()->route("admin:admin", ["type" => "workers"])->with("error_message", "ID не передан");

        Worker::validate_rule($type);
        $updateData = Worker::validate();

        try {
            DB::table("workers")->where("id", $id)->update($updateData);
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "workers"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "workers"])->with("success_message", "Данные мастера обновлены");
    }

    public function allowRewiew_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        $id = $request->get("id", null);
        if ($id === null) return redirect()->route("admin:admin", ["type" => "rewiews"])->with("error_message", "ID не передан");

        try {
            $updated = DB::table("rewiews")->where("id", $id)->update(["allowed" => 1]);
            if ($updated === 0) return redirect()->route("admin:admin", ["type" => "rewiews"])->with("error_message", "Отзыв не найден");
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "rewiews"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "rewiews"])->with("success_message", "Отзыв опубликован");
    }

    public function deleteRewiew_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        $id = $request->get("id", null);
        if ($id === null) return redirect()->route("admin:admin", ["type" => "rewiews"])->with("error_message", "ID не передан");

        try {
            DB::table("rewiews")->where("id", $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "rewiews"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "rewiews"])->with("success_message", "Отзыв удалён");
    }

    // =================== BOOKINGS ===================

    public function allowBooking_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        $id = $request->get("id", null);
        if ($id === null) return redirect()->route("admin:admin", ["type" => "bookings"])->with("error_message", "ID не передан");

        try {
            DB::table("booking")->where("id", $id)->update(["status" => "confirmed"]);
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "bookings"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "bookings"])->with("success_message", "Запись подтверждена");
    }

    public function cancelBooking_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        $id = $request->get("id", null);
        if ($id === null) return redirect()->route("admin:admin", ["type" => "bookings"])->with("error_message", "ID не передан");

        try {
            DB::table("booking")->where("id", $id)->update(["status" => "cancelled"]);
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "bookings"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "bookings"])->with("success_message", "Запись отменена");
    }

    public function deleteBooking_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        $id = $request->get("id", null);
        if ($id === null) return redirect()->route("admin:admin", ["type" => "bookings"])->with("error_message", "ID не передан");

        try {
            DB::table("booking")->where("id", $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "bookings"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "bookings"])->with("success_message", "Запись удалена");
    }

    // =================== USERS ===================

    public function changeUserRole_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        $id   = $request->get("id", null);
        $role = $request->get("role", null);

        if ($id === null || $role === null) return redirect()->route("admin:admin", ["type" => "users"])->with("error_message", "Не переданы параметры");

        $statusMap = ["user" => USER_STATUS_USER, "master" => USER_STATUS_MASTER, "admin" => USER_STATUS_ADMIN];

        if (!isset($statusMap[$role])) return redirect()->route("admin:admin", ["type" => "users"])->with("error_message", "Неверная роль");

        try {
            $updated = DB::table("users")->where("id", $id)->update(["status_id" => $statusMap[$role]]);
            if ($updated === 0) return redirect()->route("admin:admin", ["type" => "users"])->with("error_message", "Пользователь не найден");

            if ($role !== "master") {
                DB::table("workers")->where("user_id", $id)->delete();
            }
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "users"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "users"])->with("success_message", "Роль изменена");
    }

    public function deleteUser_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        $id = $request->get("id", null);
        if ($id === null) return redirect()->route("admin:admin", ["type" => "users"])->with("error_message", "ID не передан");

        if (session("user_id") == $id) return redirect()->route("admin:admin", ["type" => "users"])->with("error_message", "Нельзя удалить свой аккаунт");

        try {
            DB::table("booking")->where("user_id", $id)->delete();
            DB::table("rewiews")->where("user_id", $id)->delete();

            $worker = DB::table("workers")->where("user_id", $id)->first();
            if ($worker !== null) {
                DB::table("booking")->where("worker_id", $worker->id)->delete();
                DB::table("workers")->where("user_id", $id)->delete();
            }

            $deleted = DB::table("users")->where("id", $id)->delete();
            if ($deleted === 0) return redirect()->route("admin:admin", ["type" => "users"])->with("error_message", "Пользователь не найден");
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "users"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "users"])->with("success_message", "Пользователь удалён");
    }

    // =================== GALLERY ===================

    public function uploadImage_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        VALIDATION->add("type_id", ["required" => "Тип обязателен", "numeric" => "Тип должен быть числом"]);
        $result = VALIDATION->validate_and_clear();

        if (!$request->hasFile("image")) return redirect()->route("admin:admin", ["type" => "gallery"])->with("error_message", "Файл не выбран");

        $file    = $request->file("image");
        $allowed = ["jpg", "jpeg", "png", "webp", "gif"];
        if (!in_array(strtolower($file->getClientOriginalExtension()), $allowed)) {
            return redirect()->route("admin:admin", ["type" => "gallery"])->with("error_message", "Недопустимый формат");
        }
        if ($file->getSize() > 10 * 1024 * 1024) {
            return redirect()->route("admin:admin", ["type" => "gallery"])->with("error_message", "Файл слишком большой (макс. 10 МБ)");
        }

        try {
            $path = $file->store("gallery", "public");
            DB::table("images")->insert(["path" => $path, "type_id" => $result["type_id"]]);
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "gallery"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "gallery"])->with("success_message", "Изображение загружено");
    }

    public function addImageUrl_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        VALIDATION->add("path",    ["required" => "Ссылка обязательна", "url" => "Некорректная ссылка"]);
        VALIDATION->add("type_id", ["required" => "Тип обязателен",      "numeric" => "Тип должен быть числом"]);
        $result = VALIDATION->validate_and_clear();

        try {
            DB::table("images")->insert(["path" => $result["path"], "type_id" => $result["type_id"]]);
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "gallery"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "gallery"])->with("success_message", "Изображение добавлено");
    }

    public function deleteImage_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        $id = $request->get("id", null);
        if ($id === null) return redirect()->route("admin:admin", ["type" => "gallery"])->with("error_message", "ID не передан");

        try {
            $image = DB::table("images")->where("id", $id)->first();
            if ($image === null) return redirect()->route("admin:admin", ["type" => "gallery"])->with("error_message", "Изображение не найдено");

            if (!str_starts_with($image->path, "http")) {
                \Storage::disk("public")->delete($image->path);
            }
            DB::table("images")->where("id", $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "gallery"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "gallery"])->with("success_message", "Изображение удалено");
    }

    // =================== NEWS ===================

    public function createNews_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        VALIDATION->add("name",              ["required" => "Заголовок обязателен", "max" => "Не более 200 символов"], ["max" => "200"]);
        VALIDATION->add("description_title", ["required" => "Краткое описание обязательно", "max" => "Не более 200 символов"], ["max" => "200"]);
        VALIDATION->add("description",       ["required" => "Текст новости обязателен"]);
        VALIDATION->add("type_id",           ["required" => "Тип обязателен", "numeric" => "Тип должен быть числом"]);

        $result = VALIDATION->validate_and_clear();
        $result["date"] = now()->toDateString();

        if ($request->hasFile("title_image")) {
            $result["title_image_path"] = $request->file("title_image")->store("news", "public");
        } else {
            $result["title_image_path"] = "";
        }

        try {
            DB::table("news")->insert($result);
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "news"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "news"])->with("success_message", "Новость создана");
    }

    public function deleteNews_post(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect !== null) return $redirect;

        $id = $request->get("id", null);
        if ($id === null) return redirect()->route("admin:admin", ["type" => "news"])->with("error_message", "ID не передан");

        try {
            $news = DB::table("news")->where("id", $id)->first();
            if ($news === null) return redirect()->route("admin:admin", ["type" => "news"])->with("error_message", "Новость не найдена");

            if ($news->title_image_path !== "" && !str_starts_with($news->title_image_path, "http")) {
                \Storage::disk("public")->delete($news->title_image_path);
            }
            DB::table("news")->where("id", $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route("admin:admin", ["type" => "news"])->with("error_message", "Ошибка: " . $th->getMessage());
        }

        return redirect()->route("admin:admin", ["type" => "news"])->with("success_message", "Новость удалена");
    }
}
