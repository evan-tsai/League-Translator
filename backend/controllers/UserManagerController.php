<?php
namespace backend\controllers;

use Yii;
use common\models\UserSearch;
use yii\web\Controller;
use common\models\User;

class UserManagerController extends Controller
{
    public function actionIndex()
    {
        $model = new User();
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'model' => $model,
        ]);
    }
}
