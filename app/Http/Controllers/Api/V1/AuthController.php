<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AuthRequest;
use App\Http\Resources\V1\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $service)
    {
    }


    /**
     * Store a newly created resource in storage.
     */
    public function login(AuthRequest $request)
    {
        $result = $this->service->login($request->only(['email','password']));
        if (!$result) {
            return $this->errorMessage('Invalid credentials',401);
        }
        return $this->returnData([
            'token' => $result['token'],
            'user' => new UserResource($result['user'])
        ],'Logged in successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function logout()
    {
       $this->service->logout();
        return $this->successMessage('Logged out successfully');
    }
}
