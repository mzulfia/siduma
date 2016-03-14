<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use kartik\widgets\FileInput;
use kartik\form\ActiveForm;

use app\models\ServiceFamily;
use app\models\User;
use app\models\SupportArea;

$this->title = 'DM Reports | Update Report';
$this->params['breadcrumbs'][] = ['label' => 'Duty Manager Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Report';
?>
<div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">Evaluation Form - Duty Manager</h3>
    </div>
    <div class="box-body">
       <?php 
            $form = ActiveForm::begin([
                    'id' => 'login-form-inline-1',
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'options' => ['enctype' => 'multipart/form-data']
            ]);
        ?>

        <?= $form->field($model, 'service_family_id')->dropDownList(ArrayHelper::map(ServiceFamily::find()->all(), 'service_family_id', 'service_name'), ['prompt'=>'-Select Service-', 'disabled'=>'disabled']) ?>

        <?= $form->field($model, 'status')->radioList(['2' => 'Normal', '1' => 'Warning', '0' => 'Critical']) ?>

        <?= $form->field($model, 'file')->widget(FileInput::classname(), [
                    'pluginOptions' => [
                         'showCaption' => true,
                         'showRemove' => false,
                         'showUpload' => false,
                     ],
            ]); 
        ?>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-9">
            <p>Max Size: 1 MB</p>
          </div>  
        </div>  
        
        <?= $form->field($model, 'information')->textArea() ?>

        <div class="form-group">
             <div class="col-sm-offset-2 col-sm-9">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>   

    </div><!-- /.box-body -->
</div>
        


