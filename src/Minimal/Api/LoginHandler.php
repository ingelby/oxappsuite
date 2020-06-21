<?php

namespace Ingelby\Appsuite\Minimal\Api;

use Ingelby\Appsuite\Minimal\Models\Login\Token;

class LoginHandler extends AbstractHandler
{
    /**
     * @param array $oxConfig
     * @param array $clientConfig
     * @throws \Ingelby\Appsuite\Minimal\Exceptions\AppsuiteConfigurationException
     */
    public function __construct(array $oxConfig = [], array $clientConfig = [])
    {
        $this->routeUri = '/appsuite/api/minimal/login';
        parent::__construct($oxConfig, $clientConfig);
    }

    public function token(string $session)
    {
        \Yii::info('Getting token for session: ' . $session);

        $token = new Token();
        $response = $this->get(
            $this->routeUri,
            [
                'session' => $session,
                'action'  => 'token',
            ]
        );

        var_dump($response);
        die();
        $token->setAttributes($response);

        return $token;
    }
}
