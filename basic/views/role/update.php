<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->title = 'Roles | Update Role';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Role';
?>
<div class="role-update">
	<div class="box box-info">
	 	<div class="box-header with-border">
	    	<h3 class="box-title">Update Role</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		    <?php $form = ActiveForm::begin(); ?>

		    <?= $form->field($model, 'role_name')->textInput(['maxlength' => true]) ?>

		    <div class="form-group">
		        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		    </div>

		    <?php ActiveForm::end(); ?>
		</div>
	</div>
</div>		