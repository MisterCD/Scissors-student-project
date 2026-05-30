<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->date("date");
            $table->time("time");
            $table->integer("worker_id")->nullable(true);
            $table->integer("user_id");
            $table->string("description")->nullable(true);
            $table->integer("product_id");
            $table->integer("status");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
