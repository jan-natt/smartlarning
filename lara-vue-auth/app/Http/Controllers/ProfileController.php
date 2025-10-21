<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
  public function update(Request $request)
  {
    $user = $request->user();
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|string|email|unique:users,email,'.$user->id
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    return response(
        [
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
  }

}
