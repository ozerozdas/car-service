<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Cars;
use App\Http\Resources\CarsResource;

class CarsController extends Controller
{
    public function index(Request $request)
    {
        $page = !empty($request->page) ? $request->page : 1;
        // Cache::forget('cars.page_' . $page);
        $data = Cache::remember('cars.page_' . $page, 60 * 30, function () {
            return Cars::paginate(100);
        });
        return CarsResource::collection($data)->additional([
            'meta' => [
                'userBalance' => $this->getUserBalance(),
            ]
        ]);
    }
}
