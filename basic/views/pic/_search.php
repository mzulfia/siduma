<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PicSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pic-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'pic_id') ?>

    <?= $form->field($model, 'pic_nip') ?>

    <?= $form->field($model, 'pic_name') ?>

    <?= $form->field($model, 'company') ?>

    <?= $form->field($model, 'no_hp') ?>

    <?php // echo $form->field($model, 'pic_position_id') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
