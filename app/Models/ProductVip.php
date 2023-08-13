<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Uuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string id
 * @property string product_id
 * @property Carbon start_date
 * @property Carbon end_date
 */
class ProductVip extends Model
{
    use Uuid;

    protected $table = 'product_vip';
    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
