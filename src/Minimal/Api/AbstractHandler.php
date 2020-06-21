<?php

namespace Ingelby\Appsuite\Minimal\Api;

use common\helpers\SessionGuid;
use Ingelby\Appsuite\Minimal\Exceptions\AppsuiteClientException;
use Ingelby\Appsuite\Minimal\Exceptions\AppsuiteConfigurationException;
use Ingelby\Appsuite\Minimal\Exceptions\AppsuiteMappedException;
use Ingelby\Appsuite\Minimal\Exceptions\AppsuiteServerException;
use ingelby\toolbox\constants\HttpStatus;
use ingelby\toolbox\helpers\LoggingHelper;
use ingelby\toolbox\services\inguzzle\exceptions\InguzzleClientException;
use ingelby\toolbox\services\inguzzle\exceptions\InguzzleInternalServerException;
use ingelby\toolbox\services\inguzzle\exceptions\InguzzleServerException;
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
     * @return array
     * @throws AppsuiteClientException
     * @throws AppsuiteMappedException
     * @throws AppsuiteServerException
     */
    public function get($uri, array $queryParameters = [], array $additionalHeaders = [])
    {
        \Yii::info('Calling: ' . $uri);
        $defaultQueryParemeters = [
            'client' => $this->clientName,
        ];

        try {
            $response = parent::get(
                $uri,
                array_merge($defaultQueryParemeters, $queryParameters),
                $additionalHeaders
            );
        } catch (InguzzleClientException $exception) {
            throw new AppsuiteClientException($exception->statusCode, $exception->getMessage(), 0, $exception);
        } catch (InguzzleServerException | InguzzleInternalServerException $exception) {
            LoggingHelper::logException($exception);
            throw new AppsuiteServerException(
                HttpStatus::INTERNAL_SERVER_ERROR,
                'Unable to contact AppSuite: ' . SessionGuid::getShort(),
                0,
                $exception
            );
        }

        $this->responseValidator($response);
        return $response;
    }


    /**
     * @param array $response
     * @return array
     * @throws AppsuiteMappedException
     */
    private function responseValidator(array $response)
    {
        if (!array_key_exists('error', $response)) {
            return $response;
        }

        //@Todo, Map error codes and categories, for now keep it simple stupid...
        throw new AppsuiteMappedException($response);
    }

}
