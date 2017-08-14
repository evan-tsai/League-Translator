<?php

namespace common\helpers;

use Yii;

class MailHelper
{
    public static function writeMail($body, $subject)
    {
        Yii::$app->mailer->compose()
            ->setFrom([Yii::$app->params['supportEmail'] => 'League Translate'])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->send();
    }
}