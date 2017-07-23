<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\MasteryType;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MasterySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Masteries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masteries-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'mastery_id',
            [
                'attribute' => 'type',
                'filter' => Html::activeDropDownList($searchModel, 'type', ArrayHelper::map(MasteryType::find()->all(), 'type_id', 'english'), ['class' => 'form-control', 'prompt' => 'All']),
                'value' => 'masteryType.english',
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