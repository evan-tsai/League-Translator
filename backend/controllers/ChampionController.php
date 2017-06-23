<?php

namespace backend\controllers;

use common\models\ChampionSpells;
use Yii;
use common\models\Champions;
use common\models\ChampionSearch;
use yii\web\NotFoundHttpException;

/**
 * ChampionController implements the CRUD actions for Champions model.
 */
class ChampionController extends AuthController
{
    /**
     * Lists all Champions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChampionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Champions model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $spellModel = new ChampionSpells();
        $spellData = $spellModel->findOne(['champion_id' => $id]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'spellData' => $spellData,
        ]);
    }

    /**
     * Finds the Champions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Champions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Champions::findOne(['champion_id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}