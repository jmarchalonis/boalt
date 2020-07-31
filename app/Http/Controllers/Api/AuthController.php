<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class AuthController
 * This Class is used to handle the API authentication endpoints
 *
 * @property Controller $this
 * @author Jason Marchalonis
 * @since 1.0
 */
class AuthController extends Controller
{
    /**
     * Register
     * This function is used to register a new user in our system. Based on validate requirements
     * we create the user and return a authentication token
     *
     * @param Request $request
     * @return JsonResponse
     * @author Jason Marchalonis
     * @since 1.0
     */
    public function register(Request $request)
    {
        // Validate the payload data
        $data = $request->validate([
            'name' => 'required|max:85',
            'email' => 'email|required|unique:users|max:255',
            'password' => 'required|confirmed'
        ]);

        $data['password'] = bcrypt($request->password);

        // Generate the user and send the access token and return it to the requester
        $user = User::create($data);
        $token = $user->createToken('authToken')->accessToken;

        $payload = [
            'user' => auth()->user(),
            'auth_token' => $token
        ];

        return $this->setApiResponse($payload);
    }

    /**
     * Login
     * This function is used to handle a user login request. If valid, we return an access token.
     *
     * @param Request $request
     * @return JsonResponse
     * @author Jason Marchalonis
     * @since 1.0
     */
    public function login(Request $request)
    {
        // Validate the payload data
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        // The the request is not valid, we return a error message
        if (!auth()->attempt($loginData)) {
            return response(['message' => __('Login Invalid Credentials')]);
        }

        // Generate a access token and return it to the requester
        $token = auth()->user()->createToken('authToken')->accessToken;

        $payload = [
            'data' => [
                'user' => auth()->user(),
                'auth_token' => $token
            ]
        ];

        return $this->setApiResponse($payload);

    }

}
