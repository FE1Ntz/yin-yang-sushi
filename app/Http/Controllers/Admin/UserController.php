<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return Inertia::render('Admin/User/Index', ['users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user['id'])],
            'phone_number' => ['required', 'string', 'size:17', Rule::unique(User::class)->ignore($user['id']), function ($attribute, $value, $fail) {
                if (str_ends_with($value, '_')) {
                    $fail('Введіть валідний номер телефону.');
                }
            }],
        ]);

        $user->update($request->all());

        return redirect()->route('users.index');
    }
}
