<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SummonerSpellSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Summoner Spells';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="summoner-spells-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'spell_id',
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