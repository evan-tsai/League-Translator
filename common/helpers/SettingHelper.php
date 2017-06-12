<?php

namespace common\helpers;

use common\models\Settings;

class SettingHelper {
    public static function getSetting($key, $format = '%s')
    {
        $setting = Settings::find()->byKey($key)->one();
        if($setting == NULL){
            throw new \ErrorException('Unable to find '.$key);
        }

        return sprintf($format, $setting->property_val);
    }
}