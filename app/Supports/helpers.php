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

if (! function_exists('trimHostFromUrls')) {
    /**
     * Trim the host and base URL from a list of URLs.
     */
    function trimHostFromUrls(array $urls, string $baseUrl): array
    {
        return array_map(function ($url) use ($baseUrl) {
            return str_replace($baseUrl, '', $url);
        }, $urls);
    }
}

if (! function_exists('is_customer')) {
    function is_customer(): bool
    {
        return auth()->user()?->role_id == 4;
    }
}

if (! function_exists('dateTimeFormat')) {
    function dateTimeFormat($date): string
    {
        return $date ? \Illuminate\Support\Carbon::parse($date)->format('Y-m-d h:i a') : '';
    }
}

if (! function_exists('dateFormat')) {
    function dateFormat($date): string
    {
        return $date ? \Illuminate\Support\Carbon::parse($date)->format('Y-m-d') : '';
    }
}

if (! function_exists('dateTimeFormat')) {
    function dateTimeFormat($date): string
    {
        return $date ? \Illuminate\Support\Carbon::parse($date)->format('Y-m-d h:i a') : '';
    }
}

if (! function_exists('amountFormat')) {
    function amountFormat($amount): string
    {
        return $amount ? number_format($amount, 2) : '';
    }
}
