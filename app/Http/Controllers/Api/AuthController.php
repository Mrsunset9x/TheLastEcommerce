<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\AuthRequest;
Use App\Models\User;

class AuthController extends Controller
{
    public function register(AuthRequest $request)
    {
        $params = $request->only('email', 'name', 'password', 'address','phone');
        $user = new User();
        $user->name = $params['name'];
        $user->email = $params['email'];
        $user->address = $params['address'];
        $user->phone    = $params['phone'];
        $user->password = bcrypt($params['password']);
        $user->save();

        return response()->json($user, Response::HTTP_OK);
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
