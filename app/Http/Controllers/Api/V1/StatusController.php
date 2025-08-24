<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\CacheKeys;
use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke()
    {
        $statuses = Cache::rememberForever(CacheKeys::STATUSES, function () {
            return Status::get();
        });
        return $this->returnData($statuses, 'Statuses');
    }

}
