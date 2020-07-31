<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class UsersController
 * This Controller is used to handle requests regarding the User
 *
 * @author Jason Marchalonis
 * @since 1.0
 * @property Controller $this
 */
class UsersController extends Controller
{
    /**
     * Get User Details
     * This function is used to return a requested users details
     *
     * @param Request $request
     * @return JsonResponse
     * @author Jason Marchalonis
     * @since 1.0
     */
    public function getUserDetails(Request $request)
    {
        return $this->setApiResponse(['user' => $request->user()]);
    }

}
