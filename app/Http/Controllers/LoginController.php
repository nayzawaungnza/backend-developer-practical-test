<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    
    public function login(LoginRequest $request)
    {
        try {
            $validated = $request->validated();

            if (!Auth::guard('ctj-api')->attempt($validated)) {
                throw new AuthenticationException('The provided credentials are incorrect.');
            }

            $user = Auth::guard('ctj-api')->user();
            $token = $user->createToken('ctj-api')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user'  => new UserResource($user),
            ], Response::HTTP_OK);
            
        } catch (AuthenticationException $e) {
            return response()->json([
                'status'  => Response::HTTP_UNAUTHORIZED,
                'message' => $e->getMessage(),
            ], Response::HTTP_UNAUTHORIZED);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status'  => Response::HTTP_NOT_FOUND,
                'message' => 'Model not found.',
            ], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Internal server error.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
}