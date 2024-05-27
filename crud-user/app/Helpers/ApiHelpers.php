<?php

use Symfony\Component\HttpFoundation\Response;

function responseSuccess($data = null)
{
    $output = [
        'success' => true,
        'data' => $data,
        'errors' => null,
    ];

    return response()->json($output, Response::HTTP_OK);
}

function responseError($code, $errorCode, $message, $data = null)
{
    $output = [
        'success' => false,
        'data' => $data,
        'errors' => [
            'error_code' => $errorCode,
            'error_message' => $message,
        ],
    ];

    return response()->json($output, $code);
}

function responseCreated($data = null)
{
    $output = [
        'success' => true,
        'data' => $data,
        'errors' => null,
    ];

    return response()->json($output, Response::HTTP_CREATED);
}
