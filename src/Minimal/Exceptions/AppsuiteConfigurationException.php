<?php

namespace Ingelby\Appsuite\Minimal\Exceptions;

use ingelby\toolbox\constants\HttpStatus;
use yii\web\HttpException;

class AppsuiteConfigurationException extends BaseAppsuiteException
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct(HttpStatus::INTERNAL_SERVER_ERROR, $message, $code, $previous);
    }
}