<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SupportPosition */

$this->title = 'Support Positions | Update Support Position';
$this->params['breadcrumbs'][] = ['label' => 'Support Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Support Position';
?>

<div class="support-position-update">
	<div class="box box-info">
	 	<div class="box-header with-border">
	    	<h3 class="box-title">Update Support Position</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		    <?php $form = ActiveForm::begin(); ?>

		    <?= $form->field($model, 'position_name')->textInput(['maxlength' => true]) ?>

		    <div class="form-group">
		        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		    </div>

		    <?php ActiveForm::end(); ?>
		</div>
	</div>
</div>		