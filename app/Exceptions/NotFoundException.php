<?php

namespace App\Exceptions;

class NotFoundException extends BaseException
{
    protected string $errorCode = 'NOT_FOUND';

    public function __construct(string $message = 'Resource not found')
    {
        parent::__construct($message, 404);
    }

    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'code' => $this->getErrorCode(),
        ], $this->getCode());
    }
}
