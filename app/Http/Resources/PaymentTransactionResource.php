<?php

namespace App\Http\Resources;

use App\Models\PaymentTransaction;
use Illuminate\Http\Resources\Json\JsonResource;

final class PaymentTransactionResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var PaymentTransaction $this */
        return [
            'id'         => $this->id,
            'product_id' => $this->product_id,
            'type'       => $this->type,
            'status'     => $this->status,
            'amount'     => $this->amount,
            'created_at' => $this->created_at,
        ];
    }
}
