<?php

namespace App\Traits\HandleApiJsonResponse;

use stdClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Illuminate\Validation\ValidationException;

trait  HandleApiJsonResponseTrait
{
    ###############################  START ERROR VALIDATE #############################
    public function errorValidate($validator):\Illuminate\Http\JsonResponse{
        return response()->json([
            'status' => false,
            'msg'    => $validator->errors()->first(),
            'data'   => new stdClass(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY); // 422
    }
    ###############################  END ERROR VALIDATE   #############################
    ###############################    START NOT FOUND    #############################
    public function errorNotFound(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'msg'    => __('api.not_found'),
            'data'   => new stdClass(),
        ], Response::HTTP_NOT_FOUND); // 404
    }
    ###############################    END NOT FOUND      #############################
    ###############################    START SUCCESS      #############################
    public function success($data, string $message = "Success"): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => true,
            'msg'    => $message,
            'data'   => (object)$data,
        ], Response::HTTP_OK); // 200
    }
    ###############################    END SUCCESS        #############################
    ###############################    START UNEXPECTED   #############################
    public function errorUnExpected($ex): \Illuminate\Http\JsonResponse
    {
        $statusCode = $this->getStatusCodeFromException($ex);
        return response()->json([
            'status' => false,
            'msg'    => $ex->getMessage(),
            'data'   => (object)[]
        ], $statusCode);
    }
    ###############################    END UNEXPECTED     #############################
    ###############################    START ERROR        #############################
    public function error($message, $code = Response::HTTP_BAD_REQUEST): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'msg'    => $message,
            'data'   => new stdClass(),
        ], $code);
    }
    ###############################    END ERROR          #############################
    ############################# START TO MANY REQUESTS  #############################
    public function manyRequests(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'msg'    => __('api.You have been blocked due to too many Request, try again later'),
            'data'   => new stdClass(),
        ], Response::HTTP_TOO_MANY_REQUESTS); // 429
    }
    ############################### END TO MANY REQUESTS  #############################
    ############################### START UNAUTHORIZED    #############################
    public function unauthorized(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'msg'    => __('api.Unauthorized'),
            'data'   => new stdClass(),
        ], Response::HTTP_UNAUTHORIZED); // 401;
    }
    ###############################  END UNAUTHORIZED     #############################
    ###############################   START FORBIDDEN     #############################
    public function forbidden(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'msg'    => __('api.forbidden'),
            'data'   => new stdClass(),
        ], Response::HTTP_FORBIDDEN); // 403;
    }
    ###############################    END FORBIDDEN      #############################

    ############################### START GET STATUS      #############################
    function getStatusCodeFromException(\Throwable $ex): int
    {
        // لو Exception يرث من HttpExceptionInterface (معظم Exceptions اللي تحدد status code)
        if ($ex instanceof HttpExceptionInterface) {
            return $ex->getStatusCode();
        }

        // استثناء التحقق (ValidationException) عادة ترجع 422
        if ($ex instanceof ValidationException) {
            return Response::HTTP_UNPROCESSABLE_ENTITY; // 422
        }

        // استثناء NotFound
        if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return Response::HTTP_NOT_FOUND; // 404
        }

        // استثناء Auth مثل Unauthorized
        if ($ex instanceof \Illuminate\Auth\AuthenticationException) {
            return Response::HTTP_UNAUTHORIZED; // 401
        }

        // استثناء Authorization مثل Forbidden
        if ($ex instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return Response::HTTP_FORBIDDEN; // 403
        }

        // غير ذلك: أخطاء السيرفر (Internal Server Error)
        return Response::HTTP_INTERNAL_SERVER_ERROR; // 500
    }
    ###############################  END GET STATUS       #############################

}