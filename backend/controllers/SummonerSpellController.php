<?php

namespace backend\controllers;

use Yii;
use common\models\SummonerSpells;
use common\models\SummonerSpellSearch;
use yii\web\NotFoundHttpException;

/**
 * SummonerSpellController implements the CRUD actions for SummonerSpells model.
 */
class SummonerSpellController extends AuthController
{
    /**
     * Lists all SummonerSpells models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SummonerSpellSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SummonerSpells model.
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
     * Finds the SummonerSpells model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SummonerSpells the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SummonerSpells::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}