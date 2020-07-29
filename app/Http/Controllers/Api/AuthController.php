<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\AuthRequest;
Use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(AuthRequest $request)
    {
        $now = Carbon::now();

         $request->only('email', 'name', 'password', 'address','phone');
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->address = $request->address;
        $user->phone    = $request->phone;
        $user->created_at = $now->diffInDays($user->created_at);
        $user->updated_at = now()->toDateString();
        $user->save();

        $credentials = $request->only('email', 'password');
        $token = Auth::guard()->attempt($credentials);


        return $this->respondWithToken($token,$user);
    }
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            $token = Auth::guard()->attempt($credentials);
            if (!$token) {
                return response()->json([
                    'errors' => [
                        'status'  => false,
                        'code'    => Response::HTTP_UNAUTHORIZED,
                        'message' => 'Unauthorized',
                    ]
                ]);
            }
            $user = Auth::user();
            return $this->respondWithToken($token,$user);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => [
                    'status'  => false,
                    'code'    => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'message' => $e->getMessage(),
                ]
            ]);
        }
    }
    public function me()
    {
        return response()->json(Auth::guard()->user());
    }

    public function logout()
    {
        try {
            auth()->logout();
            return response()->json([
                'status'  => true,
                'code'    => Response::HTTP_OK,
                'message' => 'Logout successfully',
            ]);
        }catch (\Exception $e)
        {
            return response()->json([
                'errors' => [
                    'status'  => false,
                    'code'    => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'message' => $e->getMessage(),
                ]
            ]);
        }

    }

//    public function refresh()
//    {
//        return $this->respondWithToken(Auth::guard()->refresh());
//    }


    protected function respondWithToken($token,$user)
    {
        return response()->json([
            'status'=>true,
            'code'    => Response::HTTP_OK,
            'jwt' => $token,
            'token_type' => 'bearer',
            'user'        => $user
            //'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    public function guard()
    {
        return Auth::guard();
    }
}
