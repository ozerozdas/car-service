<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getUserWithAccount()
    {
        return User::with('account')->where('id', auth()->user()->id)->first()->toArray();
    }

    public function getUserBalance()
    {
        $account = !empty($this->getUserWithAccount()['account']) ? $this->getUserWithAccount()['account'] : [];
        return !empty($account) ? array_sum(array_column($account, 'balance')) : 0;
    }
}
