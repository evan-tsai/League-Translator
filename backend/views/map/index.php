<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Maps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'map_id',
            [
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', $model->getStatusLabels(), ['class' => 'form-control', 'prompt' => 'All']),
                'value' => function ($model) {
                    return ArrayHelper::getValue($model->getStatusLabels(), $model->status);
                }
            ],
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