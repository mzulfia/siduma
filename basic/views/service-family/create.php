<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceFamily */

$this->title = 'Service Families | Create Service Family';
$this->params['breadcrumbs'][] = ['label' => 'Service Families', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create Service Family';
?>
<div class="service-family-create">
	<div class="box box-info">
	  <div class="box-header with-border">
	    <h3 class="box-title">Create Service Family</h3>
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
