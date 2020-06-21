<?php

namespace Ingelby\OxAppsuite\Minimal\Api;

use common\helpers\LoggingHelper;
use ingelby\toolbox\constants\HttpStatus;
use ingelby\toolbox\services\inguzzle\exceptions\InguzzleClientException;
use ingelby\toolbox\services\inguzzle\exceptions\InguzzleInternalServerException;
use ingelby\toolbox\services\inguzzle\exceptions\InguzzleServerException;
use ingelby\toolbox\services\inguzzle\InguzzleHandler;
use yii\caching\TagDependency;
use yii\helpers\Json;

class AbstractHandler extends InguzzleHandler
{
    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var int
     */
    protected $cacheTimeout = 600;

    /**
     * AbstractHandler constructor.
     *
     * @param string      $apiKey
     * @param string|null $baseUrl
     */
    public function __construct(array $oxConfig = [], array $clientConfig = [])
    {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;

        parent::__construct($this->baseUrl);
    }
}
