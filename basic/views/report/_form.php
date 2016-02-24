<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use kartik\form\ActiveForm;
use app\models\ServiceFamily;

/* @var $this yii\web\View */
/* @var $model app\models\Report */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-form">


    <?php 

        $form = ActiveForm::begin([
                'id' => 'login-form-inline-1',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'options' => ['enctype' => 'multipart/form-data']
        ]);
    ?>
        
        <h3>ERP</h3>
        
        <?= $form->field($erp, '[1]status')->radioList(['1' => 'Ok', '0' => 'Tidak']) ?>

        <?= $form->field($erp, '[1]file')->fileInput() ?>

        <?= $form->field($erp, '[1]information')->textArea() ?>


        <h3>Email dan Jaringan Data</h3>
        
        <?= $form->field($email, '[2]status')->radioList(['1' => 'Ok', '0' => 'Tidak']) ?>

        <?= $form->field($email, '[2]file')->fileInput() ?>

        <?= $form->field($email, '[2]information')->textArea() ?>

        <h3>AP2T</h3>
        
        <?= $form->field($ap2t, '[3]status')->radioList(['1' => 'Ok', '0' => 'Tidak']) ?>

        <?= $form->field($ap2t, '[3]file')->fileInput() ?>

        <?= $form->field($ap2t, '[3]information')->textArea() ?>

        <h3>P2APST</h3>
        
        <?= $form->field($p2apst, '[4]status')->radioList(['1' => 'Ok', '0' => 'Tidak']) ?>

        <?= $form->field($p2apst, '[4]file')->fileInput() ?>

        <?= $form->field($p2apst, '[4]information')->textArea() ?>

         <h3>BBO</h3>
        
        <?= $form->field($bbo, '[5]status')->radioList(['1' => 'Ok', '0' => 'Tidak']) ?>

        <?= $form->field($bbo, '[5]file')->fileInput() ?>

        <?= $form->field($bbo, '[5]information')->textArea() ?>

        <h3>APKT</h3>
        
        <?= $form->field($apkt, '[6]status')->radioList(['1' => 'Ok', '0' => 'Tidak']) ?>

        <?= $form->field($apkt, '[6]file')->fileInput() ?>

        <?= $form->field($apkt, '[6]information')->textArea() ?>

        <h3>ITSM</h3>
        
        <?= $form->field($itsm, '[7]status')->radioList(['1' => 'Ok', '0' => 'Tidak']) ?>

        <?= $form->field($itsm, '[7]file')->fileInput() ?>

        <?= $form->field($itsm, '[7]information')->textArea() ?>

        <div class="form-group">
             <div class="col-sm-offset-2 col-sm-9">
                <?= Html::submitButton(($erp->isNewRecord && $email->isNewRecord && $ap2t->isNewRecord && $p2apst->isNewRecord && $bbo->isNewRecord && $apkt->isNewRecord && $itsm->isNewRecord)? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>   

</div>
