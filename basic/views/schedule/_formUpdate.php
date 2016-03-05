<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Shift;
use app\models\Support;
use app\models\Schedule;
use kartik\daterange\DateRangePicker;
use kartik\form\ActiveForm;
use kartik\widgets\FileInput;


/* @var $this yii\web\View */
/* @var $model app\models\Schedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">Update Schedule</h3>
    </div>
    <div class="box-body">
        <div class="row col-md-12">
            <?php $form = ActiveForm::begin([
                    'id' => 'update-manual', 
                ]); ?>

                 <?= $form->field($model, 'date', [
                        'addon'=>['prepend'=>['content'=>'<i class="glyphicon glyphicon-calendar"></i>']],
                        'options'=>['class'=>'drp-container form-group']
                    ])->widget(DateRangePicker::classname(), [
                    'useWithAddon'=>true,
                    'pluginOptions'=>[
                        'singleDatePicker'=>true,
                        'showDropdowns'=>true,
                    ]
                ]);
            ?>

                <?= $form->field($model, 'support_id')->dropDownList(ArrayHelper::map(Support::find()->all(), 'support_id', 'support_name'), ['prompt'=>'-Select Support-']) ?>

                <?= $form->field($model, 'shift_id')->dropDownList(ArrayHelper::map(Shift::find()->all(), 'shift_id', 'shift_name'), ['prompt'=>'-Select Shift-']) ?>

                <?= $form->field($model, 'is_dm')->dropDownList(['1' => 'Ya', '0' => 'Tidak'], ['prompt'=>'-Select Answer-']) ?>

                <p>
                    *Pagi: 07:00-15:00, Sore: 15:00-23:00, Malam : 23:00-07:00
                </p>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['name' => 'manual-button', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>    
