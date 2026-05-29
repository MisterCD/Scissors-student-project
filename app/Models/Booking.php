<?php

namespace App\Models;

use App\Library\ValidationMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use const App\Library\VALIDATION;

class Booking extends Model
{
    use HasFactory;
    use ValidationMethods;
    protected $guarded = [];
    public $timestamps = false; 
    protected $table = "booking";
    public static function validate_rule(){
        VALIDATION->add("product_id",["required" => "Выберите услугу", 
                                "integer" => "id продукта должно быть числом"]);
        VALIDATION->add("date",      ["required" => "Поля даты обязаельно", 
                                  "date"     => "Поле должно быть датой"], 
                                 ["before" => "today"]);
        VALIDATION->add("description", ["max" => "Описание максимум может быть 200 символов"], ["max" => 200]);
    }
}
