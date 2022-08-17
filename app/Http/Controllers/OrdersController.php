<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Services;
use App\Models\Cars;
use App\Models\Orders;
use App\Http\Resources\OrdersResource;

class OrdersController extends Controller
{
    public function getOrders(Request $request)
    {
        $columns = ['service_id', 'car_id'];
        $filter = ['user_id' => auth()->user()->id];

        foreach($columns as $column){
            if($request->{$column}){
                $filter[$column] = $request->{$column};
            }
        }
        $data = Orders::with('cars')->with('services:id,name')->where($filter)->get();
        // $userId = auth()->user()->id;
        // Cache::forget('orderList.user_' . $userId);
        // $data = Cache::remember('orderList.user_' . $userId, 60 * 5, function () {
        //     return Orders::where([
        //         'user_id' => auth()->user()->id
        //     ])->get();
        // });
        return OrdersResource::collection($data)->additional([
            'meta' => [
                'userBalance' => $this->getUserBalance(),
            ]
        ]);
    }

    public function setOrder(Request $request)
    {
        $validated = $request->validate([
            'service' => 'required|exists:services,name',
            'car_model' => 'required|exists:cars,model'
        ]);

        DB::beginTransaction();
        try {
            $order = new Orders();
            $order->user_id = auth()->user()->id;
            $order->service_id = Services::where(['name' => $request->service])->pluck('id')->first();
            $order->car_id = Cars::where(['model' => $request->car_model])->pluck('id')->first();
            $order->save();
        } catch (Exception $e) {
            DB::rollBack();
            throw new \ErrorException('Error found');
        }
        DB::commit();

        return (new OrdersResource(Orders::with('cars')->with('services:id,name')->find($order->id)))->additional([
            'meta' => [
                'userBalance' => $this->getUserBalance(),
            ]
        ]);
    }
}
