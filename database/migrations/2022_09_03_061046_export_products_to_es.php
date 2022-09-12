<?php

use App\Models\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Product::query()
//            ->where('status', ProductStatus::ACTIVE)
//            ->searchable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
