<?php

namespace backend\controllers;

use common\models\ItemTypeList;
use Yii;
use common\models\Items;
use common\models\ItemSearch;
use common\models\ItemSubtypeList;
use yii\web\NotFoundHttpException;

/**
 * ItemController implements the CRUD actions for Items model.
 */
class ItemController extends AuthController
{
    /**
     * Lists all Items models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        //$itemType = $params['ItemSearch']['item_type'];
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search($params);

        $list = ItemTypeList::find()->All();

        $subList = ItemSubtypeList::find()
            ->select(['subtype_id', 'type_id', 'english'])
            ->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'subList' => $subList,
            'list' => $list,
        ]);
    }

    /**
     * Displays a single Items model.
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
     * Finds the Items model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Items the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Items::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}