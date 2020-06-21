<?php

namespace Ingelby\Appsuite\Minimal\Models;

use yii\base\Model;

abstract class AbstractAppSuiteModel extends Model
{
    public const SCENARIO_GET = 'SCENARIO_GET';
    public const SCENARIO_POST = 'SCENARIO_POST';
    public const SCENARIO_PUT = 'SCENARIO_PUT';
}
