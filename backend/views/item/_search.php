<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;

$url = Url::to(['item/index']);
$headJS = <<<JS
$('.cbx').on('change', function() {
    $('#w0').submit();
});

$('#resetBtn').on('click', function() {
    window.location.href = '$url';
});

$("document").ready(function(){ 
    $("#search-form").on("pjax:end", function() {
        $.pjax.reload({container:"#w1"});  //Reload GridView
    });
});
JS;
$this->registerJs($headJS);
?>

<div class="item-type-search">
    <div class="form-group">
        <?= Html::button('All Items', ['id' => 'resetBtn','class' => 'btn-xs btn-primary float-right']) ?>
    </div>
    <?php Pjax::begin(['id' => 'search-form']); ?>
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => true],
    ]); ?>

    <?php foreach ($list as $item): ?>
        <h4><?= $item->english; ?></h4>
        <?php foreach ($subList as $subItem): ?>
            <?php if ($subItem->type_id === $item->type_id): ?>
                <?php
                    $check = '';
                    $itemTypes = !empty($model->item_type) ? $model->item_type : [];
                    if (in_array($subItem->subtype_id, $itemTypes)) $check = 'checked';
                ?>
                <span>
                    <label>
                        <input type="checkbox" id="itemType<?= $subItem->subtype_id; ?>" name="ItemSearch[item_type][]" value="<?= $subItem->subtype_id; ?>" class="cbx" <?= $check; ?>>
                        <?= $subItem->english; ?>
                    </label>
                </span>
                <br />
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</div>