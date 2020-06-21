<?php

namespace Ingelby\Appsuite\Minimal\Exceptions;

use ingelby\toolbox\constants\HttpStatus;
use yii\web\HttpException;

class AppsuiteMappedException extends BaseAppsuiteException
{
    protected array $appSuiteError = [];

    /**
     * @param array $appSuiteError
     * @param null  $previous
     */
    public function __construct(array $appSuiteError, $previous = null)
    {
        $this->appSuiteError = $appSuiteError;
        $message = 'Unknown';
        if (array_key_exists('error', $appSuiteError)) {
            $message = $appSuiteError['error'];
        }
        parent::__construct(HttpStatus::BAD_REQUEST, $message, 0, $previous);
    }

    /**
     * @return array
     */
    public function getAppSuiteError()
    {
        return $this->appSuiteError;
    }
}
