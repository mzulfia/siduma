<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use kartik\password\PasswordInput;
use app\models\Role;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Users | Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create User';
?>

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Create User</h3>
  </div><!-- /.box-header -->
  <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>

	    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'password')->widget(PasswordInput::classname(), [
			    'pluginOptions' => [
			        'showMeter' => true,
			        'toggleMask' => false
			    ]
			])->hint('Min. 8 Characters') ?>

	    <?= $form->field($model, 'role_id')->dropDownList(ArrayHelper::map(Role::find()->all(), 'role_id', 'role_name'), ['prompt'=>'-Select Role-']) ?>

	    <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>
  </div>
</div>  


