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



<script>
    function showForm(obj){
        if(obj == "manual"){
            document.getElementById('input-manual').style.display='block'; 
            document.getElementById('input-automatic').style.display='none'; 
            document.getElementById('setdm').style.display='none'; 
            return false;
        } 
        else if(obj == "automatic")
        {
            document.getElementById('input-automatic').style.display='block'; 
            document.getElementById('input-manual').style.display='none';
            document.getElementById('setdm').style.display='none'; 
            return false;
        }
        else
        {
            document.getElementById('input-automatic').style.display='none'; 
            document.getElementById('input-manual').style.display='none';
            document.getElementById('setdm').style.display='block'; 
            return false;   
        }
    }
</script>

<?= Html::button('Manual', ['class' => 'btn btn-warning input-manual', 'title' => 'Manual', 'value' => 'manual','onclick' => 'showForm(this.value)']) ?>

<?= Html::button('Upload Excel', ['class' => 'btn btn-warning input-automatic', 'title' => 'Upload Excel', 'value' => 'automatic', 'onclick' => 'showForm(this.value)']) ?>

<?= Html::button('Set DM', ['class' => 'btn btn-warning setdm', 'title' => 'Set DM', 'value' => 'setdm', 'onclick' => 'showForm(this.value)']) ?>

<div class="schedule-form">

    <div class="row col-md-12" id="input-automatic" style="display: block">
        <br>

        <?php $form = ActiveForm::begin([
            'id' => 'input-automatic', 
            'options' => ['enctype' => 'multipart/form-data'
            ]]
        ); ?>

        <?= $form->field($model, 'file')->widget(FileInput::classname(), [
            'options' => ['accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'],
        ]); ?>
        <p>Accepted File: xlsx, xls</p>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['name' => 'automatic-button', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    
    <div class="row col-md-12" id="input-manual" style="display: none">
        <br>

        <?php $form = ActiveForm::begin([
            'id' => 'input-manual', 
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

    <div class="row col-md-12" id="setdm" style="display: none">
        <br>

         <?php $form = ActiveForm::begin([
            'id' => 'setdm',
            'type' => ActiveForm::TYPE_INLINE

        ]); ?>

    <?= $form->field($model, 'date[1]', [
                'addon'=>['prepend'=>['content'=>'<i class="glyphicon glyphicon-calendar"></i>']],
                'options'=>['class'=>'drp-container form-group']
            ])->widget(DateRangePicker::classname(), [
            'useWithAddon'=>true
        ]);
    ?>

    <?= $form->field($model, 'shift_id')->dropDownList(ArrayHelper::map(Shift::find()->all(), 'shift_id', 'shift_name'), ['prompt'=>'-Select Shift-']) ?>


    <?= Html::submitButton('Set', ['name' => 'setdm-button', 'class' => 'btn btn-success']) ?>
    
        <?php ActiveForm::end(); ?>
    </div>    
</div>
