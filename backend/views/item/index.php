<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-3">
            <?= $this->render('_search', ['model' => $searchModel, 'list' => $list]); ?>
        </div>
        <div class="col-md-9">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'item_id',
                    [
                        'attribute' => 'english',
                        'format' => 'raw',
                        'value' => function($data) {
                            return Html::a($data->english, ['view' ,'id' => $data->id]);
                        }
                    ],
                    'taiwan',
                ],
            ]); ?>
        </div>
    </div>
</div>