<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

$this->title = 'User Manager';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?= $this->title; ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'username',
            'email',
            [
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->getStatusLabels(), ['class' => 'form-control', 'prompt' => 'All']),
                'value' => function($model) {
                    return ArrayHelper::getValue($model->getStatusLabels(), $model->status);
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ]
    ]);
    ?>
</div>
