<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 *
 * @author Jason Marchalonis
 * @since 1.0
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var array
     */
    private $data = [];

    /**
     * Set Data
     * This function is used as a setter for data
     *
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Get Data
     * This function is used as a getter for data
     *
     * @param $data
     * @return array
     * @author Jason Marchalonis
     * @since 1.0
     */
    public function getData($data)
    {
        return $this->data;
    }

    /**
     * Set Api Response
     * This function is used to set a standardise response format for the api
     *
     * @param $payload
     * @return JsonResponse
     * @author Jason Marchalonis
     * @since 1.0
     */
    public function setApiResponse($payload)
    {

        $response = [
            'data' => $payload
        ];

        return response()->json($response);
    }
}
