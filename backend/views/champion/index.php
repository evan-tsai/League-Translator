<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ChampionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Champions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="champions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'champion_id',
            [
                'attribute' => 'english',
                'format' => 'raw',
                'value' => function($data) {
                    return Html::a($data->english, ['view' ,'id' => $data->champion_id]);
                }
            ],
            'taiwan',
            'china',
            'korea',
            'japan',
        ],
    ]); ?>
</div>