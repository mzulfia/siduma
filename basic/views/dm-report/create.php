<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use kartik\widgets\FileInput;
use kartik\form\ActiveForm;

use app\models\ServiceFamily;
use app\models\User;
use app\models\SupportArea;

$this->title = 'DM Report | Create Report';
$this->params['breadcrumbs'][] = ['label' => 'Duty Manager Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create Report';
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
        
        <?php 
            for($i=0; $i < sizeof($service_family); $i++){
                $status = '['.$i.']status';
                $file = '['.$i.']file';
                $information = '['.$i.']information';
                echo '<h3><u>'. ServiceFamily::find()->where('service_family_id = :id', [':id' => $i+1])->one()->service_name .'</u></h3>';
                echo $form->field($service_family[$i], $status)->radioList(['2' => 'Normal', '1' => 'Warning', '0' => 'Critical']);
                echo $form->field($service_family[$i], $file)->widget(FileInput::classname(), [
                    'options' => ['accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'],
                ]);
                echo $form->field($service_family[$i], $information)->textArea();
            }    

        ?>  
        
       <div class="form-group">
             <div class="col-sm-offset-2 col-sm-9">
                <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>    	

    </div><!-- /.box-body -->
</div>
        



