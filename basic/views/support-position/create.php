<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SupportPosition */

$this->title = 'Support Positions | Create Support Position';
$this->params['breadcrumbs'][] = ['label' => 'Support Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create Support Position';
?>

<div class="support-position-create">
	<div class="box box-info">
	 	<div class="box-header with-border">
	    	<h3 class="box-title">Create Support Position</h3>
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