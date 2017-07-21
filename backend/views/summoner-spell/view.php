<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SummonerSpells */

$this->title = $model->english;
$this->params['breadcrumbs'][] = ['label' => 'Summoner Spells', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="summoner-spells-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'spell_id',
            'english',
            'taiwan',
            'china',
            'korea',
            'japan',
        ],
    ]) ?>

</div>