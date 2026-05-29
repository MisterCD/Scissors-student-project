<?php

namespace App\Models;

use App\Library\ValidationMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use const App\Library\VALIDATION;

class Rewiew extends Model
{
    use HasFactory;
    use ValidationMethods;
    protected $table = "rewiews";
    protected $guarded = []; 

    public $timestamps = false;

    public static function validate_rule(){
        VALIDATION->add("product_id", ["required" => "Выберите услугу", 
                                   "integer" => "id должно быть числом"]);
        VALIDATION->add("stars",      ["required" => "Поставьте звезды", 
                                   "integer" => "Звезды должны быть числом"]);
        VALIDATION->add("description",["required" => "Добавьте описание", 
                                   "max" => "Описание должно быть максимум 200 символов"], 
                                  ["max" => 200]);
    }
}
