<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Map */

$this->title = $model->english;
$this->params['breadcrumbs'][] = ['label' => 'Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'map_id',
            [
                'attribute' => 'status',
                'value' => ArrayHelper::getValue($model->getStatusLabels(), $model->status),
            ],
            'english',
            'taiwan',
            'china',
            'korea',
            'japan',
        ],
    ]) ?>

</div>