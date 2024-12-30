<?php

if (! function_exists('apiResponse')) {
    function apiResponse($message, $code = 200, $data = [])
    {
        return response()->json([
            'success' => ! ($code >= 300),
            'message' => $message,
            $code >= 300 ? 'error' : 'data' => $data,
        ], $code);
    }
}

if (! function_exists('successResponse')) {
    function successResponse($message = 'Operation successful', $code = 200, $data = []): \Illuminate\Http\JsonResponse
    {
        return apiResponse($message, $code, $data);
    }
}

if (! function_exists('errorResponse')) {
    function errorResponse($message = 'An error occurred', $code = 400, $errors = []): \Illuminate\Http\JsonResponse
    {
        return apiResponse($message, $code, $errors);
    }
}

if (! function_exists('unauthorizedResponse')) {
    function unauthorizedResponse($message = 'You are not authorized to do this action.', $code = 401): \Illuminate\Http\JsonResponse
    {
        return apiResponse($message, $code);
    }
}

if (! function_exists('getRelativeUrl')) {
    function getRelativeUrl($url): string
    {
        return str_replace(config('app.media_url'), '', $url);
    }
}

if (! function_exists('endsWith')) {
    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if (! $length) {
            return true;
        }

        return substr($haystack, -$length) === $needle;
    }
}
