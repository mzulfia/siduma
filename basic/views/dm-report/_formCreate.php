<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use kartik\widgets\FileInput;
use kartik\form\ActiveForm;

use app\models\ServiceFamily;
use app\models\User;
use app\models\SupportArea;

/* @var $this yii\web\View */
/* @var $model app\models\Report */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">Evaluation Form - Duty Manager</h3>
    </div>
    <div class="box-body">
     	<?php 

        $form = ActiveForm::begin([
                'id' => 'dm-report-form-inline-1',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'options' => ['enctype' => 'multipart/form-data']
        ]);
    ?>
        
        <h3>ERP</h3>
        
        <?= $form->field($erp, '[1]status')->radioList(['2' => 'Normal', '1' => 'Caution', '0' => 'Bad']) ?>

        <?= $form->field($erp, '[1]file')->widget(FileInput::classname(), [
            'options' => ['accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'],
        ]); ?>

        <?= $form->field($erp, '[1]information')->textArea() ?>


        <h3>Email dan Jaringan Data</h3>
        
        <?= $form->field($email, '[2]status')->radioList(['2' => 'Normal', '1' => 'Caution', '0' => 'Bad']) ?>

        <?= $form->field($email, '[2]file')->widget(FileInput::classname()) ?>

        <?= $form->field($email, '[2]information')->textArea() ?>

        <h3>AP2T</h3>
        
        <?= $form->field($ap2t, '[3]status')->radioList(['2' => 'Normal', '1' => 'Caution', '0' => 'Bad']) ?>

        <?= $form->field($ap2t, '[3]file')->widget(FileInput::classname()) ?>

        <?= $form->field($ap2t, '[3]information')->textArea() ?>

        <h3>P2APST</h3>
        
        <?= $form->field($p2apst, '[4]status')->radioList(['2' => 'Normal', '1' => 'Caution', '0' => 'Bad']) ?>

        <?= $form->field($p2apst, '[4]file')->widget(FileInput::classname()) ?>

        <?= $form->field($p2apst, '[4]information')->textArea() ?>

         <h3>BBO</h3>
        
        <?= $form->field($bbo, '[5]status')->radioList(['2' => 'Normal', '1' => 'Caution', '0' => 'Bad']) ?>

        <?= $form->field($bbo, '[5]file')->widget(FileInput::classname()) ?>

        <?= $form->field($bbo, '[5]information')->textArea() ?>

        <h3>APKT</h3>
        
        <?= $form->field($apkt, '[6]status')->radioList(['2' => 'Normal', '1' => 'Caution', '0' => 'Bad']) ?>

        <?= $form->field($apkt, '[6]file')->widget(FileInput::classname()) ?>

        <?= $form->field($apkt, '[6]information')->textArea() ?>

        <h3>ITSM</h3>
        
        <?= $form->field($itsm, '[7]status')->radioList(['2' => 'Normal', '1' => 'Caution', '0' => 'Bad']) ?>

        <?= $form->field($itsm, '[7]file')->widget(FileInput::classname()) ?>

        <?= $form->field($itsm, '[7]information')->textArea() ?>

        <div class="form-group">
             <div class="col-sm-offset-2 col-sm-9">
                <?= Html::submitButton(($erp->isNewRecord && $email->isNewRecord && $ap2t->isNewRecord && $p2apst->isNewRecord && $bbo->isNewRecord && $apkt->isNewRecord && $itsm->isNewRecord)? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>    	

    </div><!-- /.box-body -->
</div>
        


