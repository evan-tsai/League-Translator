<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$headJS = <<<JS
$(document).on('ready pjax:success', function() {
    $(".modalButton").on('click', function(){
        $("#modal").modal("show")
                   .find("#modalContent")
                   .load($(this).parent('a').attr('href'));
        return false;   
   });
});
JS;
$this->registerJs($headJS);

$this->title = 'Maps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-index">
    <?php
    Modal::begin([
        'header' => '<h4>Update Status</h4>',
        'id' => 'modal',
        'size' => 'modal-sm',
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
    ?>

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
            'english',
            'taiwan',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil modalButton"></span>', $url, [
                            'title' => Yii::t('app', 'Update'),
                        ]);
                    },
                    'delete' => function() {},
                ],
            ],
        ],
    ]); ?>
</div>