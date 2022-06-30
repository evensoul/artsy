<?php

use App\Models\Enums\ProductStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status')->default(ProductStatus::MODERATION->value);
            $table->string('title');
            $table->string('description', 1000);
            $table->decimal('price', 16)->unsigned();
            $table->tinyInteger('discount')->unsigned()->nullable();
            $table->tinyInteger('rating')->unsigned()->default(0);
            $table->boolean('is_preorder');
            $table->timestamps();
            $table->timestamp('published_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
