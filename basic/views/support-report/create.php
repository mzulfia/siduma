<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use kartik\widgets\FileInput;
use kartik\form\ActiveForm;

use app\models\ServiceFamily;
use app\models\User;
use app\models\SupportArea;


/* @var $this yii\web\View */
/* @var $model app\models\ReportSupport */

$this->title = 'Support Reports | Create Report';
$this->params['breadcrumbs'][] = ['label' => 'Support Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">Evaluation Form - Support</h3>
    </div>
    <div class="box-body">
       <?php 
            $form = ActiveForm::begin([
                    'id' => 'login-form-inline-1',
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'options' => ['enctype' => 'multipart/form-data']
            ]);
        ?>

        <?php
            if(User::getRoleId(\Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR){
                echo $form->field($model, 'service_family_id')->dropDownList(ArrayHelper::map(ServiceFamily::find()->all(), 'service_family_id', 'service_name'), ['prompt'=>'-Select Service-']);
            } else{
                echo $form->field($model, 'service_family_id')->dropDownList(ArrayHelper::map(SupportArea::find()->where('support_id = :support_id', [':support_id' => User::getSupportId(\Yii::$app->user->getId())])->all(), 'service_family_id', 'serviceFamily.service_name'), ['prompt'=>'-Select Service-']);
            }
        ?>
        
        <?= $form->field($model, 'file')->widget(FileInput::classname()) ?>

        <?= $form->field($model, 'information')->textArea() ?>

        <div class="form-group">
             <div class="col-sm-offset-2 col-sm-9">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>   

    </div><!-- /.box-body -->
</div>
        
