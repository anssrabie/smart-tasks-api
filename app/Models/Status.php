<?php

namespace App\Models;

use App\Constants\CacheKeys;
use App\Traits\AutoFlushCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory,AutoFlushCache;
    protected array $cacheKeys= [CacheKeys::STATUSES];

    public $timestamps = false;
    protected $fillable = ['name','value'];
}
