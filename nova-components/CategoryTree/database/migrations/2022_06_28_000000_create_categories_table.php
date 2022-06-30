<?php

use Fereron\CategoryTree\MenuBuilder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('menu_id')->default(1);
            $table->json('title');
            $table->uuid('parent_id')->nullable();
            $table->tinyInteger('order');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('categories');
    }
};
