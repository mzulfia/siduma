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

$this->title = 'Schedules | Create Schedule';
$this->params['breadcrumbs'][] = ['label' => 'Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create Schedule';
?>

<script>
    function showForm(obj){
        if(obj == "manual")
        {
            document.getElementById('input-manual').style.display='block'; 
            document.getElementById('input-automatic').style.display='none'; 
            return false;
        } 
        else
        {
            document.getElementById('input-automatic').style.display='block'; 
            document.getElementById('input-manual').style.display='none';
            return false;
        }
    }
</script>

<div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Create Schedule</h3>
    </div>
    <div class="box-body">
        <?= Html::button('Manual', ['class' => 'btn btn-warning input-manual', 'value' => 'manual','onclick' => 'showForm(this.value)']) ?>

        <?= Html::button('Upload Excel', ['class' => 'btn btn-warning input-automatic', 'value' => 'automatic', 'onclick' => 'showForm(this.value)']) ?>

            <div class="row col-md-12" id="input-automatic" style="display: block">
                <br>

                <?php $form = ActiveForm::begin([
                    'id' => 'input-automatic', 
                    'options' => ['enctype' => 'multipart/form-data'
                    ]]
                ); ?>

                <?= $form->field($model, 'file')->widget(FileInput::classname(), [
                    'pluginOptions' => [
                         'showCaption' => true,
                         'showRemove' => false,
                         'showUpload' => false,
                         'allowedFileExtensions'=>['xlsx','xls']
                     ],
                    'options' => ['accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'],
                ]); ?>
                <p>Accepted File: xlsx, xls; Max File Size: 1 MB</p>

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
                    *Pagi: 07:00-16:00, Sore: 16:00-23:00, Malam : 23:00-07:00
                </p>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['name' => 'manual-button', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
        </div>    
    </div>
</div>    
