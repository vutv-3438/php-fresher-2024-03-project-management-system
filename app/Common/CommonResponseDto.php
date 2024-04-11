<?php

namespace App\Common;

class CommonResponseDto
{
    public string $message;
    public bool $success;
    public int $statusCode;
    public array $errorDetails;
    public $data;

    public function __construct(
        bool $success,
        int $statusCode,
        string $message = '',
        array $errorDetails = [],
        $data = null
    ) {
        $this->success = $success;
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->errorDetails = $errorDetails;
        $this->data = $data;
    }
}
