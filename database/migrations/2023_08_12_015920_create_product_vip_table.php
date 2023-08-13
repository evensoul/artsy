<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_vip', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')->constrained('products');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_vip');
    }
};
