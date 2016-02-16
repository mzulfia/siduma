<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use app\models\Support;
use app\models\Schedule;

/* @var $this yii\web\View */
/* @var $model app\models\SupportSchedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="support-schedule-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'support_id')->dropDownList(ArrayHelper::map(Support::find()->all(), 'support_id', 'support_name'), ['prompt'=>'-Select Support-']) ?>

    

    <?= $form->field($model, 'is_pic')->dropDownList(['0' => 'Ya', '1' => 'Tidak'], ['prompt'=>'-Select Answer-']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
