<?php

namespace Ingelby\Appsuite\Minimal\Models\Login;

use Ingelby\Appsuite\Minimal\Models\AbstractAppSuiteModel;

class Token extends AbstractAppSuiteModel
{
    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [],
            self::SCENARIO_GET     => [
            ],
            self::SCENARIO_POST    => [],
            self::SCENARIO_PUT     => [],
        ];
    }
}
