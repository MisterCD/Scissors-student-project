<?php

namespace App\Models;

use App\Library\ValidationMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use const App\Library\VALIDATION;
use DB;
use Hash;

const USERNAME = 0;
const EMAIL    = 1;
const PASSWORD = 2;
const TELEFON  = 3;

class User extends Model
{
    use HasFactory;
    use ValidationMethods;

    protected $table = "users";
    public $timestamps = false;
    protected $guarded = []; 
    public static function validate_rule(int $type = 100){
        switch ($type) {
            case USERNAME:
                VALIDATION->add(
                    "username",
                    [
                        "required" => "Поле имени обязательно",
                        "min"      => "Имя должно быть не менее 5 символов",
                        "max"      => "Имя должно быть не более 60 символов",
                    ],
                    ["min" => "5", "max" => "60"]
                );
                break;

            case EMAIL:
                VALIDATION->add(
                    "email",
                    [
                        "required" => "Поле почты обязательно",
                        "email"    => "Неверный формат почты",
                    ]
                );
                break;

            case PASSWORD:
                VALIDATION->add(
                    "password",
                    [
                        "required" => "Поле пароля обязательно",
                        "min"      => "Пароль должен содержать минимум 6 символов",
                        "max"      => "Пароль должен содержать максимум 100 символов",
                    ],
                    ["min" => "6", "max" => "100"]
                );
                break;

            case TELEFON:
                VALIDATION->add(
                    "tel",
                    [
                        "required" => "Поле телефона обязательно",
                        "regex"    => "Неверный формат номера. Пример: 7-999-12-34-567",
                    ],
                    ["regex" => "/^\+7-[0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{3}$/"]
                );
                break;
            default:
                VALIDATION->add(
                    "username",
                    [
                        "required" => "Поле имени обязательно",
                        "min"      => "Имя должно быть не менее 5 символов",
                        "max"      => "Имя должно быть не более 60 символов",
                    ],
                    ["min" => "5", "max" => "60"]
                );
                VALIDATION->add(
                    "email",
                    [
                        "required" => "Поле почты обязательно",
                        "email"    => "Неверный формат почты",
                    ]
                );
                VALIDATION->add(
                    "password",
                    [
                        "required" => "Поле пароля обязательно",
                        "min"      => "Пароль должен содержать минимум 6 символов",
                        "max"      => "Пароль должен содержать максимум 100 символов",
                    ],
                    ["min" => "6", "max" => "100"]
                );
                VALIDATION->add(
                    "tel",
                    [
                        "required" => "Поле телефона обязательно",
                        "regex"    => "Неверный формат номера. Пример: 7-999-12-34-567",
                    ],
                    ["regex" => "/^\+7-[0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{3}$/"]
                );
            break;
        }
    }
    public static function change(int $type){
        $id   = session("user_id");
        $successMessage = "";
        $errorMessage   = "";
        if ($type === PASSWORD) {
            VALIDATION->add(
                "password_old",
                [
                    "required" => "Введите текущий пароль",
                    "min"      => "Текущий пароль должен быть минимум 6 символов",
                    "max"      => "Текущий пароль должен быть максимум 100 символов",
                ],
                ["min" => "6", "max" => "100"]
            );
        }
        $result        = VALIDATION->validate_and_clear();
        switch ($type) {
            case USERNAME:
                DB::table("users")->where("id", $id)->update(["username" => $result["username"]]);
                $successMessage = "Имя пользователя успешно изменено";
                break;

            case EMAIL:
                
                $exists = DB::table("users")
                    ->where("email", $result["email"])
                    ->where("id", "!=", $id)
                    ->exists();

                if ($exists) {
                    $errorMessage = "Этот email уже занят другим пользователем";
                } else {
                    DB::table("users")->where("id", $id)->update(["email" => $result["email"]]);
                    $successMessage = "Email успешно изменён";
                }
                break;

            case PASSWORD:
                
                $currentHash = DB::table("users")->where("id", $id)->value("password");

                if (!Hash::check($result["password_old"], $currentHash)) {
                    $errorMessage = "Текущий пароль введён неверно";
                } else {
                    DB::table("users")->where("id", $id)->update([
                        "password" => Hash::make($result["password"]),
                    ]);
                    $successMessage = "Пароль успешно изменён";
                }
                break;

            case TELEFON:
                DB::table("users")->where("id", $id)->update(["tel" => $result["tel"]]);
                $successMessage = "Телефон успешно изменён";
                break;

            default:
                $errorMessage = "Неизвестный тип изменения";
                break;
        }
        return ["success" => $successMessage, "error" => $errorMessage];
    }
}
