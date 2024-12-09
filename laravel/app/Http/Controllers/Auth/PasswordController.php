<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdatePasswordRequest;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */

     public function create(Request $request)
     {
         return view('profile.partials.update-password-form', ['request' => $request]);
     }
    
    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        

        $request->user()->update([
            'password' => Hash::make($validatedData['password']),
        ]);
        
        session()->flash('success', 'Đổi mật khẩu thành công');
        return redirect()->route('profile.detail');
    }
}
