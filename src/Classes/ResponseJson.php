<?php

namespace Mahmoudmhamed\LaravelHelpers\Classes;

use Illuminate\Support\Facades\Lang;

/**
 * used to get and handle response format.
 * @author Mahmoud Mohamed <mahmoud-mhamed@github.com>
 */
class ResponseJson
{
    public static function error($errors, $use_response_key = null, $code = 500, $message = null): \Illuminate\Http\JsonResponse
    {
        $message = $message ?? trans('helpers::LaravelHelper.error_response_message');
        return response()->json(array_merge(["message" => $message], self::getResponse($errors, $use_response_key)), $code);
    }

    public static function success($response = [], $use_response_key = null, $code = 200, $message = null): \Illuminate\Http\JsonResponse
    {
        $message = $message ?? trans('helpers::LaravelHelper.success_response_message');
        return response()->json(array_merge(["message" => $message], self::getResponse($response, $use_response_key)), $code);
    }

    public static function cantAccess($code = 403, $message = null): \Illuminate\Http\JsonResponse
    {
        $message = $message ?? Lang::get('message.cant_access');
        return response()->json([
            "message" => $message,
        ], $code);
    }

   /* public static function validationError($errors = [], $code = 422, $message = null): \Illuminate\Http\JsonResponse
    {
        $message = $message ?? Lang::get('message.cant_access');
        return response()->json([
            "message" => $message,
            'errors' => $errors
        ], $code);
    }*/

    private static function getResponse($response = [], $use_response_key = null)
    {
        $use_response_key == null && $use_response_key = config('helpers.ResponseJson.default-use-response-key', true);
        if ($use_response_key && $response) {
            return ['response' => $response];
        } else {
            return $response;
        }
    }
}
