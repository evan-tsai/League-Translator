<?php
/**
 * Created by PhpStorm.
 * User: Evan
 * Date: 6/24/2017
 * Time: 1:36 AM
 */

namespace backend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class AuthController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

}