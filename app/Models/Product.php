<?php

namespace App\Models;


use App\Library\ValidationMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use const App\Library\VALIDATION;

const PRODUCT_NAME              = 0;
const PRODUCT_DESCRIPTION_TITLE = 1;
const PRODUCT_DESCRIPTION       = 2;
const PRODUCT_TIME              = 3;
const PRODUCT_COST              = 4;
const PRODUCT_TYPE              = 5;

class Product extends Model
{
    use HasFactory;
    use ValidationMethods;

    protected $table = "product";

    protected $guarded = []; 
    public $timestamps = false;
    public static function validate_rule(int $type = 100){
        switch ($type) {
            case PRODUCT_NAME:
                VALIDATION->add("name",
                    ["required" => "Поле имени обязательно", "max" => "Название может быть максимум 120 символов"],
                    ["max" => "120"]);
                break;
            case PRODUCT_DESCRIPTION:
                VALIDATION->add("description", ["required" => "Разметка описания обязательна"]);
                break;
            case PRODUCT_DESCRIPTION_TITLE:
                VALIDATION->add("description_title",
                    ["required" => "Краткое описание обязательно", "max" => "Краткое описание не более 200 символов"],
                    ["max" => "200"]);
                break;
            case PRODUCT_TIME:
                VALIDATION->add("time", ["required" => "Поле времени обязательно", "numeric" => "Указано не число"]);
                break;
            case PRODUCT_COST:
                VALIDATION->add("cost", ["required" => "Поле цены обязательно", "numeric" => "Указано не число"]);
                break;
            case PRODUCT_TYPE:
                VALIDATION->add("type_id", ["required" => "Тип обязателен", "numeric" => "Указано не число"]);
                break;
            default:
                VALIDATION->add("name",
                    ["required" => "Поле имени обязательно", "max" => "Название может быть максимум 120 символов"],
                    ["max" => "120"]);
                VALIDATION->add("description", ["required" => "Разметка описания обязательна"]);
                VALIDATION->add("description_title",
                    ["required" => "Краткое описание обязательно", "max" => "Краткое описание не более 200 символов"],
                    ["max" => "200"]);
                VALIDATION->add("time", ["required" => "Поле времени обязательно", "numeric" => "Указано не число"]);
                VALIDATION->add("cost", ["required" => "Поле цены обязательно", "numeric" => "Указано не число"]);
                VALIDATION->add("type_id", ["required" => "Тип обязателен", "numeric" => "Указано не число"]);
            break;
        }
    }
}
