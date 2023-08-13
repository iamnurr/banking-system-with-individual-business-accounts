<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserStoreRequest;

class UserController extends Controller
{
    public function __invoke(UserStoreRequest $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'account_type' => $request->get('account_type'),
        ]);
        if ($user) {
            return redirect()->back()->with(RESPONSE_TYPE_SUCCESS, __('User Successfully created.'));
        }

        return redirect()->back()->with(RESPONSE_TYPE_WARNING, __('Failed to create'));
    }
}
