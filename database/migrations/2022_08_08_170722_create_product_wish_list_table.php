<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customer_product_wish_list', function (Blueprint $table) {
            $table->foreignUuid('customer_id')->constrained('customers');
            $table->foreignUuid('product_id')->constrained('products');
            $table->timestamps();

            $table->primary(['customer_id', 'product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_product_wish_list');
    }
};
