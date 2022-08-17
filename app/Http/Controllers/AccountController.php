<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use App\Http\Resources\AccountResource;

class AccountController extends Controller
{
    public function addBalance(Request $request)
    {
        $validated = $request->validate([
            'value' => ['required', 'integer']
        ]);

        DB::beginTransaction();
        try {
            $account = new Account();
            $account->user_id = auth()->user()->id;
            $account->balance = $request->value;
            $account->save();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
        DB::commit();

        return (new AccountResource(Account::find($account->id)))->additional([
            'meta' => [
                'userBalance' => $this->getUserBalance(),
            ]
        ]);
    }
}
