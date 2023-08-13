<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * @property string id
 * @property integer days
 * @property string price
 */
class VipPackage extends Model implements Sortable
{
    use Uuid, HasFactory, SortableTrait;
}
