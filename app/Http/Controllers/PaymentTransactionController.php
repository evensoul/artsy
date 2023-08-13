<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\PaymentTransactionResource;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class PaymentTransactionController
{
    public function getByCustomer(Request $request): JsonResource
    {
        $transactionsQuery = PaymentTransaction::query()
            ->where('customer_id', $request->user()->id)
            ->orderBy('created_at', 'desc');

        return PaymentTransactionResource::collection($transactionsQuery->get());
    }
}
