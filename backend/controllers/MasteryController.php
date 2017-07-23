<?php

namespace backend\controllers;

use Yii;
use common\models\Masteries;
use common\models\MasterySearch;
use common\models\MasteryType;
use yii\web\NotFoundHttpException;

/**
 * MasteryController implements the CRUD actions for Masteries model.
 */
class MasteryController extends AuthController
{
    /**
     * Lists all Masteries models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MasterySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Masteries model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Masteries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Masteries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Masteries::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}