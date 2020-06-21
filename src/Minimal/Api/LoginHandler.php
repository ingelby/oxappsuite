<?php

namespace Ingelby\Appsuite\Minimal\Api;

use Ingelby\Appsuite\Minimal\Models\Login\Token;

class LoginHandler extends AbstractHandler
{
    protected $routeUri = '/appsuite/api/minimal/login';


    public function token(string $session)
    {
        Yii::info('Getting token for session: ' . $session);

        $token = new Token();
        $response = $this->get(
            $this->routeUri,
            [
                'session' => $session,
                'action'  => 'token',
            ]
        );

        $token->setAttributes($response);

        return $token;
    }
}
