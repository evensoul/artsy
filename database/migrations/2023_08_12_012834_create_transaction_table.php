<?php

use App\Models\Enums\PaymentTransactionType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')->constrained('products');
            $table->foreignUuid('customer_id')->constrained('customers');
            $table->string('type')->default(PaymentTransactionType::PRODUCT_PREMIUM->value);
            $table->decimal('amount');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
