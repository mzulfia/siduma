<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use kartik\form\ActiveForm;
use kartik\widgets\FileInput;
use app\models\SupportPosition;
use app\models\ServiceFamily;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Management */

if(User::getRoleId(\Yii::$app->user->getId()) == User::ROLE_ADMINISTRATOR){
	$this->title = 'Supervisors | Update Supervisor';
	$this->params['breadcrumbs'][] = ['label' => 'Supervisors', 'url' => ['index']];
	$this->params['breadcrumbs'][] = 'Update Profile';
} else{
	$this->title = 'Supervisors | Update Supervisor';
	$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['view', 'id' => $model->supervisor_id]];
	$this->params['breadcrumbs'][] = 'Update Profile';
}
?>
<div class="supervisor-update">
	<div class="box box-info">
	    <div class="box-header with-border">
	      <h3 class="box-title">Update Profile</h3>
	    </div>
	    <div class="box-body">

	        <?php $form = ActiveForm::begin([
	            'id' => 'supervisor-form', 
	            'options' =>[ 
	                'enctype' => 'multipart/form-data',
	            ],
	        ]); ?>

	        <?=
	            $form->field($model, 'file')->widget(FileInput::classname(),[ 
	                     'pluginOptions' => [
	                         'showCaption' => false,
	                         'showRemove' => false,
	                         'showUpload' => false,
	                         'browseClass' => 'btn btn-primary btn-block',
	                         'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
	                         'browseLabel' =>  'Select Photo',
	                         'allowedFileExtensions'=>['jpg','png'],
	                      ],
	                     'options' => ['accept' => 'image/*'],
	                 ]);
	            ?>
	        <p>Accepted File: jpg, png; Max File Size: 200KB; Pixel Size: 225x225 px</p>
	        

	        <?= $form->field($model, 'spv_name')->textInput(['maxlength' => true]) ?>

	        <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

	        <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true]) ?>

	        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
	        
	        <div class="form-group">
	            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	        </div>

	        <?php ActiveForm::end(); ?>
	    </div>
	</div>   
</div> 
    