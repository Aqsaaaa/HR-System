<?php

namespace App\Exceptions;

class BusinessRuleException extends BaseException
{
    protected string $errorCode = 'BUSINESS_RULE_ERROR';

    public function __construct(string $message, array $context = [])
    {
        parent::__construct($message, 422, $this->errorCode, null, $context);
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
