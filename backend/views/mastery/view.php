<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Masteries */

$this->title = $model->english;
$this->params['breadcrumbs'][] = ['label' => 'Masteries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masteries-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'mastery_id',
            'type',
            'english',
            'taiwan',
            'china',
            'korea',
            'japan',
        ],
    ]) ?>

</div>