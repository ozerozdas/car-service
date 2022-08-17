<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Http\Resources\AccountResource;

class AccountController extends Controller
{
    public function addBalance(Request $request)
    {
        $validated = $request->validate([
            'value' => ['required', 'integer']
        ]);

        $account = new Account();
        $account->user_id = auth()->user()->id;
        $account->balance = $request->value;
        $account->save();

        return (new AccountResource(Account::find($account->id)))->additional([
            'meta' => [
                'userBalance' => $this->getUserBalance(),
            ]
        ]);
    }
}
