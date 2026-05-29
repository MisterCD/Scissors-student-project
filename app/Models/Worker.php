<?php

namespace App\Models;

use App\Library\ValidationMethods;
use const App\Library\VALIDATION;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

const WORKER_USER_ID            = 0;
const WORKER_SPECIALIZATION     = 1;
const WORKER_DESCRIPTION_TITLE  = 2;

class Worker extends Model
{
    use HasFactory;
    use ValidationMethods;
    protected $table = "workers";
    protected $guarded = []; 
    public $timestamps = false;
    public static function validate_rule(int $type = 100){
        switch ($type) {
            case WORKER_USER_ID:
                VALIDATION->add("user_id", ["required" => "Поле user_id обязательно", "numeric" => "Указано не число"]);
                break;
            case WORKER_SPECIALIZATION:
                VALIDATION->add("specilization",
                    ["required" => "Специализация обязательна", "max" => "Специализация не более 100 символов"],
                    ["max" => "100"]);
                break;
            case WORKER_DESCRIPTION_TITLE:
                VALIDATION->add("description_title",
                    ["required" => "Краткое описание обязательно", "max" => "Не более 200 символов"],
                    ["max" => "200"]);
                break;
            default:
                VALIDATION->add("user_id", ["required" => "Поле user_id обязательно", "numeric" => "Указано не число"]);
                VALIDATION->add("specilization",
                    ["required" => "Специализация обязательна", "max" => "Специализация не более 100 символов"],
                    ["max" => "100"]);
                VALIDATION->add("description_title",
                    ["required" => "Краткое описание обязательно", "max" => "Не более 200 символов"],
                    ["max" => "200"]); 
            break;
        }
    }
}
