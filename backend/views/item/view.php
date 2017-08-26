<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Items */

$this->title = $model->english;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'item_id',
            'english',
            [
                'label' => 'Item Type',
                'visible' => !empty($subType) ? true : false,
                'value' => $subType,
            ],
            'taiwan',
            'china',
            'korea',
            'japan',
        ],
    ]) ?>

</div>