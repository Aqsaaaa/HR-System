<?php

namespace App\Exceptions;

use Exception;

abstract class BaseException extends Exception
{
    protected string $errorCode;
    protected mixed $errors;
    protected array $context;

    public function __construct(
        string $message = 'An error occurred',
        int $code = 400,
        ?string $errorCode = null,
        mixed $errors = null,
        array $context = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->errorCode = $errorCode ?? 'GENERAL_ERROR';
        $this->errors = $errors;
        $this->context = $context;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getErrors(): mixed
    {
        return $this->errors;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    abstract public function render(): \Illuminate\Http\JsonResponse;
}
