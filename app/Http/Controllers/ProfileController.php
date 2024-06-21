<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): Response
    {
        $user_id = Auth::id();
        $userAddresses = DB::table('user_address')
            ->where('user_id', $user_id)
            ->get()
            ->toArray();

        $likedProductsIds = DB::table('product_user')
            ->where('user_id', $user_id)
            ->pluck('product_id')
            ->toArray();

        $likedProducts = Product::whereIn('id', $likedProductsIds)->with(['ingredients', 'category'])->get()->toArray();

        $likedProducts = array_map(function($product) use ($likedProducts) {
            $product['isLiked'] = true;
            return $product;
        }, $likedProducts);

        $orders = Order::query()->where('user_id', $user_id)->with('products')->get()->toArray();

        return Inertia::render('Profile/Index', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'userAddresses' => $userAddresses,
            'likedProducts' => $likedProducts,
            'orders' => $orders,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function storeAddress(Request $request)
    {
        DB::table('user_address')->insert([
            'user_id' => auth()->user()->id,
            'address' => $request->input('address'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    public function updateAddress(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
        ]);

        DB::table('user_address')
            ->where('id', $request->input('id'))
            ->update([
                'address' => $validated['address'],
                'updated_at' => Carbon::now(),
            ]);
    }

    public function deleteAddress(Request $request)
    {
        DB::table('user_address')->delete($request->input('id'));
    }
}
