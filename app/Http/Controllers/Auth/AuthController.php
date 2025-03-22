<?php

namespace App\Http\Controllers\Auth;

use App\Events\RegisterUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (!Auth::attempt($validated)) {
            return $this->error('incorrect credentials', code: Response::HTTP_UNAUTHORIZED);
        }

        $token = $request->user()->createToken('auth_token')->plainTextToken;

        return $this->success(data: new AuthResource(['token' => $token]));
    }

    public function logout(): JsonResponse
    {
        request()->user()->tokens()->delete();

        return $this->success('logged out');
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        RegisterUser::dispatch($user);

        return $this->success('user registered');
    }
}
