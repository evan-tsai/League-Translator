<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Champions */
/* @var $spellData common\models\ChampionSpells */

$this->title = $model->english.' ID:'.$model->champion_id;
$this->params['breadcrumbs'][] = ['label' => 'Champions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="champions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-striped table-bordered">
        <tr>
            <th>Language</th>
            <th>Name</th>
            <th>Title</th>
            <th>Q</th>
            <th>W</th>
            <th>E</th>
            <th>R</th>
        </tr>
        <?php foreach(Yii::$app->params['languages'] as $value): ?>
        <tr>
            <td><?= ucfirst($value); ?></td>
            <td><?= $model->$value; ?></td>
            <td><?= $model->{$value.'_title'}; ?></td>
            <td><?= $spellData->{$value.'_q'}; ?></td>
            <td><?= $spellData->{$value.'_w'}; ?></td>
            <td><?= $spellData->{$value.'_e'}; ?></td>
            <td><?= $spellData->{$value.'_r'}; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>