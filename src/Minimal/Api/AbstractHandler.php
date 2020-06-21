<?php

namespace Ingelby\Appsuite\Minimal\Api;

use Ingelby\Appsuite\Minimal\Exceptions\AppsuiteConfigurationException;
use ingelby\toolbox\services\inguzzle\InguzzleHandler;

abstract class AbstractHandler extends InguzzleHandler
{
    protected const DEFAULT_TIMEOUT = 10;

    protected ?string $baseUrl;
    protected ?string $clientName;
    protected string $routeUri = '';
    protected int $cacheTimeout = 600;

    /**
     * @param string[] $oxConfig
     * @param array    $clientConfig
     * @throws AppsuiteConfigurationException
     */
    public function __construct(array $oxConfig = [], array $clientConfig = [])
    {
        if (!array_key_exists('baseUrl', $oxConfig)) {
            throw new AppsuiteConfigurationException('Missing baseUrl');
        }
        if (!array_key_exists('clientName', $oxConfig)) {
            throw new AppsuiteConfigurationException('Missing clientName');
        }

        $this->baseUrl = $oxConfig['baseUrl'];
        $this->clientName = $oxConfig['clientName'];

        $defaultClientConfig = [
            'timeout' => self::DEFAULT_TIMEOUT,
        ];

        parent::__construct(
            $this->baseUrl,
            '',
            null,
            null,
            array_merge($defaultClientConfig, $clientConfig)
        );
    }

    /**
     * @param string $uri
     * @param array  $queryParameters
     * @param array  $additionalHeaders
     * @return array|null
     * @throws \ingelby\toolbox\services\inguzzle\exceptions\InguzzleClientException
     * @throws \ingelby\toolbox\services\inguzzle\exceptions\InguzzleInternalServerException
     * @throws \ingelby\toolbox\services\inguzzle\exceptions\InguzzleServerException
     */
    public function get(string $uri, array $queryParameters = [], array $additionalHeaders = [])
    {
        \Yii::info('Calling: ' . $uri);
        $defaultQueryParemeters = [
            'client' => $this->clientName,
        ];

        return parent::get(
            $uri,
            array_merge($defaultQueryParemeters, $queryParameters),
            $additionalHeaders
        );
    }

}
