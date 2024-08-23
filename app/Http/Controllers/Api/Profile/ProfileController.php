<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\Profile\GetProfileResource;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new GetProfileResource(Auth::user());
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request)
    {

        $user = Auth::user();
        $validate = $request->validated();

        $user->update([
            'name' => $validate['name'],
            'bio' => $validate['bio'],
            'email' => $validate['email'],
        ]);


        return new GetProfileResource($user);
    }
}
