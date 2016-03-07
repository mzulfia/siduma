<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Service Families | Update Service Family';
$this->params['breadcrumbs'][] = ['label' => 'Service Families', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Service Family';
?>
<div class="service-family-update">
	<div class="box box-info">
	  <div class="box-header with-border">
	    <h3 class="box-title">Update Service Family</h3>
	  </div><!-- /.box-header -->
  	  <div class="box-body">
	    <?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($model, 'service_name')->textInput(['maxlength' => true]) ?>

	    <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>
	  </div>
	</div>    
</div>
